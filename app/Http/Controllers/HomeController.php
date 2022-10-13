<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Page;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = \App\Models\Category::whereNull('parent_id')->get();
        $companies = \App\Models\CompanyProfile::all();
        return view('welcome', compact('categories', 'companies'));
    }

    public function company(Request $request, $slug)
    {

        $company = CompanyProfile::find($request->id);

        return view('company', compact('company'));
    }



    public function search(Request $request)
    {

        if ($request->method() == 'POST') {
            $request->session()->put('search', $request->all());
            return redirect()->route('search', ['categoryId' => $request->c, 'location' => $request->postal_code]);
        }
        if ($request->s) {

            $request->session()->put(
                'search',
                array_replace($request->session()->get('search'), ['s' => $request->s])
            );
        }


        $session = (object) $request->session()->get('search');
        // dd($session);
        $category = Category::where('slug', $session->c)->first();
        $subcats = Category::where('parent_id', $category->id)->get();
        $companies = CompanyProfile::query();

        $companies->whereJsonContains('business_subcategory', "$session->s");


        $companies->where('business_category', $category->id);

        $companies->distance($session->lng, $session->lat);
        $companies = $companies->get();

        return view('search.index', compact('companies', 'category', 'subcats', 'session'));
    }

    public function recursive_array_replace($find, $replace, $array)
    {
        if (!is_array($array)) {
            return str_replace($find, $replace, $array);
        }

        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$key] = $this->recursive_array_replace($find, $replace, $value);
        }
        return $newArray;
    }

    public function page($slug)
    {

        $page = Page::where('slug', $slug)->first();
        return view('page', compact('page'));
    }

    public function saveCompany(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'user') {
            $company = CompanyProfile::find($request->id);
            $saveJob = new SavedJob();
            $saveJob->user_id = Auth::user()->id;
            $saveJob->company_id = $company->id;
            $saveJob->save();
            return response()->json([
                'success' => true,
                'message' => 'Company saved successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Please Login First',
                'success' => false
            ]);
        }
    }

    public function blogs()
    {

        $blogs = \App\Models\Blog::all();
        return view('blogs.index', compact('blogs'));
    }

    public function singleBlog($slug)
    {

        $blog = \App\Models\Blog::where('slug', $slug)->first();
        return view('blogs.show', compact('blog'));
    }
}
