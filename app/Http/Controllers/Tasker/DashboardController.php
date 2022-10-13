<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\JobMail;
use App\Models\AppliedJob;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Jobs;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {


        $jobs = Jobs::where('company_id', auth()->user()->company->id)
            ->orWhere('company_id', null)
            ->get()->map(function ($job) {
                $company =
                    CompanyProfile::find(auth()->user()->company->id)
                    ->whereJsonContains('business_subcategory', "$job->subcategory_id")->first();


                if ($company) {
                    return $job;
                } else {
                    return null;
                }
            })->filter();

        return view('frontend.tasker.dashboard.index', compact('jobs'));
    }

    public function account(Request $request)
    {
        $company = auth()->user()->company;
        $package = Package::find($company->package_id);
        if ($request->method() === 'POST') {
            // dd($request->all());
            $c = CompanyProfile::find(Auth::user()->company->id);
            $c->business_name = $request->business_name;
            $c->business_email = $request->business_email;
            $c->business_phone = $request->business_phone;
            $c->business_description = $request->business_description;
            $c->business_email = $request->business_email;
            $c->business_type = $request->business_type;
            $c->business_employee_size = $request->business_employee_size;
            $c->business_address1 = $request->business_address1;
            $c->business_address2 = $request->business_address2;
            $c->business_town = $request->business_town;
            $c->business_country = $request->business_country;
            $c->business_postal_code = $request->business_postal_code;
            $c->title = $request->title;
            $c->first_name = $request->first_name;
            $c->last_name = $request->last_name;
            $c->date_of_birth = $request->date_of_birth;
            $images = $request->old_images;
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $name = $image->store('uploads/company/' . $c->id);
                    $images[] = $name;
                }
            }
            if ($request->hasFile('logo')) {

                $logo = $request->file('logo')->store('uploads/company/' . $c->id);
                $c->logo = $logo;
            }
            $c->images = json_encode($images);
            $c->save();
            return redirect()->back()->with('success', 'Account updated successfully');
        }


        return view('frontend.tasker.dashboard.account', compact('company', 'package'));
    }
    public function membership()
    {
        $company = auth()->user()->company;
        $package = Package::find($company->package_id);

        return view('frontend.tasker.dashboard.membership', compact('package'));
    }
    public function skills(Request $request)
    {
        $company = auth()->user()->company;
        $subcategories = Category::all();
        if ($request->method() === 'POST') {
            // dd($request->subcategories);
            $oldSubcategories = json_decode($company->business_subcategory);
            $newSubcategories = $request->subcategories;
            array_push($oldSubcategories, $newSubcategories);
            $company->business_subcategory = json_encode($oldSubcategories);
            $company->save();
            return redirect()->route('tasker.skills')->with('success', 'Skills added successfully');
        }
        return view('frontend.tasker.dashboard.skills', compact('company', 'subcategories'));
    }


    public function removeSkill($id)
    {
        $company = auth()->user()->company;
        $oldSubcategories = json_decode($company->business_subcategory);
        $newSubcategories = array_diff($oldSubcategories, [$id]);
        $company->business_subcategory = json_encode($newSubcategories);
        $company->save();
        return redirect()->route('tasker.skills')->with('success', 'Skill removed successfully');
    }


    public function jobs()
    {

        $jobs = Jobs::where('company_id', auth()->user()->company->id)
            ->orWhere('company_id', null)
            ->get()->map(function ($job) {
                $company =
                    CompanyProfile::find(auth()->user()->company->id)
                    ->whereJsonContains('business_subcategory', "$job->subcategory_id")->first();


                if ($company) {
                    return $job;
                } else {
                    return null;
                }
            })->filter();
        return view('frontend.tasker.dashboard.jobs', compact('jobs'));
    }
    public function credits()
    {

        $company = auth()->user()->company;
        $transactions = Transaction::where('company_id', $company->id)->get();
        return view('frontend.tasker.dashboard.credits', compact('company', 'transactions'));
    }
    public function saveJob()
    {
        return view('frontend.tasker.dashboard.saveJob');
    }
    public function applyJob(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
            'cover_letter' => 'required',
        ]);
        $job = Jobs::find($request->job_id);
        $checkJob = AppliedJob::where('job_id', $request->job_id)->where('company_id', auth()->user()->company->id)->first();
        if ($checkJob) {
            return  response()->json(['success' => 'You have already applied for this job']);
        }
        $appliedJob = new AppliedJob();
        $appliedJob->job_id = $request->job_id;
        $appliedJob->user_id = auth()->user()->company->user_id;
        $appliedJob->company_id = auth()->user()->company->id;
        $appliedJob->cover_letter = $request->cover_letter;
        $appliedJob->save();
        $company = CompanyProfile::find(auth()->user()->company->id);
        $company->credit = $company->credit - site()->credit_per_job_post;
        $company->save();
        // $company = CompanyProfile::find(auth()->user()->company->id);
        // $company->credits = $company->credits - $job->credits;

        $data = [
            'user' => $job->user,
            'company' => auth()->user()->company,
            'cover_letter' => $request->cover_letter,
        ];
        // dd($data);
        SendEmailJob::dispatch($data);
        // Mail::to('ashikkaiser@gmail.com')->send(new \App\Mail\JobMail());
        // $details['email'] = 'ashikkaiser@gmail.com';
        // dispatch(new App\Jobs\SendEmailJob($details));


        return response()->json([
            'success' => 'Job applied successfully',
            'redirect' => route('tasker.dashboard')
        ]);
    }
}
