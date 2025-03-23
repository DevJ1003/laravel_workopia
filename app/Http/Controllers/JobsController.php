<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobNature;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function detail($id)
    {
        $job = Job::where([
            'id' => $id,
            'status' => 1
        ])->with(['jobNature', 'category'])->first();

        if ($job == null) {
            abort(404);
        }

        // dd($job);

        return view('front.jobDetail', [
            'job' => $job,
        ]);
    }

    public function applyJob(Request $request, $id)
    {

        $id = $request->id;
        $job = Job::where('id', $id)->first();

        // If job not found in db
        if ($job == null) {
            return redirect('jobs')->with('error', 'Job does not exist!');
        }

        // you can't apply to own job
        $employer_id = $job->user_id;
        if ($employer_id == Auth::user()->id) {
            return redirect('jobs')->with('error', "You can't apply to your own job!");
        }

        // to check if user already applied for a job
        if (JobApplication::where('user_id', Auth::user()->id)->where('job_id', $id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied to this job.');
        }

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();

        // Send notification email to employer
        $employer = User::where('id', $employer_id)->first();
        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job
        ];
        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

        return redirect('jobs')->with('success', 'You have successfully applied!');
    }
}
