<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Jobs;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;

class AuthController extends Controller
{
    public function step1(Request $request)
    {
        if ($request->method() === 'POST') {

            $request->validate([
                'business_name' => 'required',
                'business_email' => 'required',
                'business_phone' => 'required',
                'business_url' => 'required',
                // 'business_postal_address' => 'required',
                'business_type' => 'required',
                'business_employee_size' => 'required',
                'business_category' => 'required',
                'business_subcategory' => 'required',

            ]);

            Session::put('step1', $request->all());
            return redirect()->route('tasker.register.step2');
        }
        $categories = Category::whereNull('parent_id')->get();
        return view('frontend.register.step1', compact('categories'));
    }

    public function getSubCategory(Request $request)
    {

        if ($request->id === 'all') {
            $subcategories = Category::whereNull('parent_id')->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name,
                    'slug' => $item->slug,
                ];
            });
            return response()->json($subcategories);
        } else {
            $categeory = Category::where('slug', $request->id)->first();
            if (!$categeory) {
                $categeory = Category::find($request->id);
            }
            $subcats = Category::where('parent_id', $categeory->id)->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name,
                ];
            });
            return response()->json($subcats);
        }
    }
    public function step2(Request $request)
    {
        if ($request->method() === 'POST') {

            $request->validate([
                'package_id' => 'required',
            ]);

            Session::put('step2', $request->all());
            return redirect()->route('tasker.register.step3');
        }
        $packages = Package::all();
        return view('frontend.register.step2', compact('packages'));
    }
    public function step3(Request $request)
    {
        if ($request->method() === 'POST') {
            // dd($request->all());
            $request->validate([
                'business_address1' => 'required',
                'business_town' => 'required',
                'business_country' => 'required',
                'business_postal_code' => 'required',

            ]);

            Session::put('step3', $request->all());
            return redirect()->route('tasker.register.step4');
        }
        return view('frontend.register.step3');
    }

    public function step4(Request $request)
    {
        if ($request->method() === 'POST') {

            $request->validate([
                'title' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
            ]);

            Session::put('step4', $request->all());
            return redirect()->route('tasker.register.step5');
        }
        return view('frontend.register.step4');
    }
    public function step5()
    {
        $session = (object) Session::all();
        if (isset($session->step1) && isset($session->step2) && isset($session->step3) && isset($session->step4)) {
            $package  = Package::find($session->step2['package_id']);
            $category = Category::find($session->step1['business_category']);
            return view('frontend.register.step5', compact('session', 'package', 'category'));
        } else {
            return redirect()->route('tasker.register.step1');
        }
    }

    public function store(Request $request)
    {
        $session = (object) Session::all();
        try {
            $package = Package::find($session->step2['package_id']);
            $company = new CompanyProfile();
            $company->business_name =  $session->step1['business_name'];
            $company->business_email =  $session->step1['business_email'];
            $company->business_phone =  $session->step1['business_phone'];
            $company->business_type =  $session->step1['business_type'];
            $company->business_employee_size =  $session->step1['business_employee_size'];
            $company->business_category =  $session->step1['business_category'];
            $company->business_url =  $session->step1['business_url'];
            $company->business_subcategory =  json_encode($session->step1['business_subcategory']);
            $company->business_address1 =  $session->step3['business_address1'];
            $company->business_address2 =  $session->step3['business_address2'];
            $company->business_town =  $session->step3['business_town'];
            $company->business_country =  $session->step3['business_country'];
            $company->business_postal_code =  $session->step3['business_postal_code'];
            $company->business_latitude =  $session->step3['business_latitude'];
            $company->business_longitude =  $session->step3['business_longitude'];
            $company->title =  $session->step4['title'];
            $company->first_name =  $session->step4['first_name'];
            $company->last_name =  $session->step4['last_name'];
            $company->date_of_birth =  $session->step4['date_of_birth'];
            $company->package_id =  $session->step2['package_id'];
            $company->credit =  $package->credit;
            if ($package->price === 0) {
            } else {
                $company->expiry_date =  Carbon::now()->addDays(10);
                $company->payment_date =  Carbon::now();
            }

            if ($company->save()) {
                $user = new User();
                $user->name = $company->first_name . ' ' . $company->last_name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->role = 'company';
                $user->stripe_id = $session->customer_id;
                $user->save();
                $company->user_id = $user->id;
                $company->save();
                $tr = Transaction::find($session->transaction);
                $tr->company_id = $company->id;
                $tr->save();
                Session::flush();
                $details = [
                    'user' => $user,
                    'title' => 'New User Registration',
                    'body' => "A new user $user->name has signup as a homeowner"
                ];

                $userx = User::where('role', 'admin')->first();
                dispatch(new \App\Jobs\RegistrationNotification($userx, $details));
                dispatch(new \App\Jobs\RegistrationNotification($user, [
                    'user' => $user,
                    'title' => 'Welcome to ' . config('app.name'),
                    'body' => "Welcome to " . config('app.name') . " your account has been created successfully. We are glad to have you on board. your accoount will be activated once verified by our team. Thank you for choosing us."
                ]));
                return redirect()->route('login')->with('success', 'Tasker Registration Successful');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function profile()
    {
        $company = CompanyProfile::where('user_id', auth()->user()->id)
            ->first();
        return view('frontend.tasker.profile.index', compact('company'));
    }

    public function onboarding(Request $request)
    {
        if ($request->method() === 'POST') {
            // dd($request->all());
            $request->validate([
                'logo' => 'required',
                'business_description' => 'required',
                'images' => 'required',
            ]);
            $company = CompanyProfile::where('user_id', auth()->user()->id)
                ->first();
            $company->business_description = $request->business_description;
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo')->store('uploads/company/' . $company->id);
                $company->logo = $logo;
            }
            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $name = $image->store('uploads/company/' . $company->id);
                    $images[] = $name;
                }
            }
            $company->images = json_encode($images);
            // dd($company);
            $company->save();
            return redirect()->route('tasker.dashboard');
        }
        $company = CompanyProfile::where('user_id', auth()->user()->id)
            ->first();
        return view('frontend.register.onboarding', compact('company'));
    }
}
