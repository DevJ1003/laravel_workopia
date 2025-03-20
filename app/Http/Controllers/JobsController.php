<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobNature;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    // This method is used to display jobs page
    public function index()
    {
        $categories = Category::where('status', 1)->get();
        $jobNatures = JobNature::where('status', 1)->get();

        $jobs = Job::where('status', 1)->orderBy('created_at', 'DESC')->paginate(9);

        return view('front.jobs', [
            'categories' => $categories,
            'jobNatures' => $jobNatures,
            'jobs' => $jobs,
        ]);
    }
}
