<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobNature;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    // This method is used to display jobs page
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobNatures = JobNature::where('status', 1)->get();

        $jobs = Job::where('status', 1);

        // Search using keyword
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keyword . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }

        // Search using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        // Search using category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        $jobNatureArray = [];
        // Search using jobNature
        if (!empty($request->jobNature)) {
            // 1,2,3
            $jobNatureArray = explode(',', $request->jobNature);
            $jobs = $jobs->whereIn('job_nature_id', $jobNatureArray);
        }

        // Search using experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }

        $jobs = $jobs->paginate(9);

        return view('front.jobs', [
            'categories' => $categories,
            'jobNatures' => $jobNatures,
            'jobs' => $jobs,
            'jobNatureArray' => $jobNatureArray
        ]);
    }
}
