<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Jobs;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function dashboard()
    {
        $jobs = Jobs::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        $categories = Category::all();
        return view('user.dashboard', compact('jobs', 'categories'));
    }

    public function fetchjob(request $request)
    {
        $job = Jobs::find($request->id);
        return view('user.job-details', compact('job'));
    }

    public function reviews()
    {

        $reviews = Review::where('user_id', auth()->user()->id)->get();
        return view('user.reviews', compact('reviews'));
    }
    public function profile(Request $request)
    {

        if ($request->isMethod('post')) {

            if ($request->has('updateProfile')) {

                $user = User::find(auth()->user()->id);
                $user->name = $request->first_name . ' ' . $request->last_name;
                $user->phone = $request->phone;
                $user->post_code = $request->post_code;
                $user->save();
                return redirect()->back()->with('success', 'Profile updated successfully');
            }
        }

        return view('user.profile');
    }


    //
    public function postJob(Request $request)
    {
        if ($request->method() === "POST") {
            $job = new Jobs();
            $job->user_id = auth()->user()->id;
            $job->company_id = $request->company_id;
            $job->description = $request->description;
            $job->category_id = Category::find($request->subcategory_id)->parent_id;
            $job->subcategory_id = $request->subcategory_id;
            $job->start_time = $request->start_time;
            $job->name = $request->name;
            $job->email = $request->email;
            $job->phone = $request->phone;
            $job->post_code = $request->post_code;
            $job->save();
            return redirect()->route('user.dashboard')->with('success', 'Job Posted Successfully');
        }

        $company = CompanyProfile::find($request->company);

        return view('frontend.post-job', compact('company'));
    }
    public function cat_subcat(Request $request)
    {


        $subcat = Category::whereNotNull('parent_id')->where('name', 'like', "%$request->q%")->groupBy('parent_id')->get()->map(function ($item) {
            return [
                'text' => $item->parent->name,
                'children' => [
                    ['id' => $item->id,  'text' => $item->name,]
                ]
            ];
        });
        return response()->json($subcat);
    }



    public function giveFeedback(Request $request)
    {
        return view('user.review');
    }

    public function ajaxCompany(Request $request)
    {
        $company = CompanyProfile::where('business_name', 'like', "%$request->q%")->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => "$item->business_name ($item->id) - $item->business_town"
            ];
        });
        return response()->json($company);
    }
    public function giveFeedbackCompany(Request $request, $id)
    {
        $company = companyProfile::find($request->id);
        return view('user.review-company', compact('company'));
    }


    public function storeReview(Request $request)
    {

        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->company_id = $request->company_id;
        $review->phone = $request->phone;
        $review->carried_out = $request->carried_out;
        if ($request->carried_out === 'Yes') {
            $review->category_id = $request->yes_category;
            $review->job_name = $request->yes_job_name;
            $review->completed_at = $request->yes_completed_at;
            $review->review = $request->yes_review;
            $review->workmanship = $request->workmanship;
            $review->tidiness = $request->tidiness;
            $review->reliability = $request->timekeeping;
            $review->courtesy = $request->courtesy;
        } else {
            $review->overall = $request->review;
            $review->review = $request->no_review;
            $review->review_title = $request->no_review_title;
        }

        $review->save();
        return redirect()->route('user.dashboard')->with('success', 'Review Submitted Successfully');
    }
}
