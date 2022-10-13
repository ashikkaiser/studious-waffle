<?php

use App\Models\AppliedJob;
use App\Models\Category;
use App\Models\Jobs;
use App\Models\SiteSetting;

function checkIsApplied($jobId)
{
    $applied = AppliedJob::where('job_id', $jobId)->where('user_id', auth()->user()->id)->first();
    if ($applied) {
        return true;
    }
    return false;
}


function site()
{
    return SiteSetting::first();
}


function allCats()
{
    return Category::where('parent_id', null)->get();
}


function reviewCount($company)
{

    $reviews = $company->reviews->count();
    return "<p class='reviews'>$reviews <span>($reviews reviews)</span></p>";
}


function getblogimage($content)
{

    $regexp = '<img[^>]+src=(?:\"|\')\K(.[^">]+?)(?=\"|\')';
    $images = new \Illuminate\Support\Collection();
    if (preg_match_all("/$regexp/", $content, $matches, PREG_SET_ORDER)) {
        return $matches[0][0] ?? "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/681px-Placeholder_view_vector.svg.png";
    } else {
        return "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/681px-Placeholder_view_vector.svg.png";
    }
}


function creditCalculation()
{
    $perMonthFree = auth()->user()->company->packages->credit;
    $perMonthUsed = AppliedJob::where('company_id', auth()->user()->company->id)->where('created_at', '>=', now()->subMonth())->count();
    $perMonthLeft = $perMonthFree - $perMonthUsed;

    return auth()->user()->company->credit;
}
