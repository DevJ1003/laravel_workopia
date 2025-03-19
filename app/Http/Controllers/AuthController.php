<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobNature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // This method will show user registration page
    public function registration()
    {
        return view('front.account.registration');
    }

    // This method is used to perform user registration
    public function processRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to login page after successful registration
        return redirect()->route('account.login')->with('success', 'Registration successful! Please log in.');
    }


    // This method will show user login page
    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error', 'Either Email/Password in incorrect!');
            }
        } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {

        $request->validate([
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email,' . Auth::id(),
            'designation' => 'nullable',
            'phone' => 'nullable|regex:/^[\d\+\-]+$/',
        ]);

        $user = User::find(Auth::id());
        if (!$user) {
            return redirect()->route('account.profile')->with('error', 'User not found.');
        }

        $user->name = $request->name;
        // $user->email = $request->email;
        $user->designation = $request->designation;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully!');
    }

    public function updateProfilePic(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        // check user with id, if not found redirected to profile
        $user = User::find(Auth::id());
        if (!$user) {
            return redirect()->route('account.profile')->with('error', 'User not found.');
        }

        // Delete old image if it exists
        $oldImagePath = public_path('assets/images/profile_images/' . $user->image);
        if ($user->image && file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('assets/images/profile_images'), $imageName);

        $user->image = $imageName;
        $user->save();

        return redirect()->route('account.profile')->with('success', 'Profile pic updated successfully!');
    }

    public function indexJob()
    {
        return view('front.account.job.index');
    }

    public function createJob(Request $request)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $job_natures = JobNature::orderBy('name', 'ASC')->get();

        return view('front.account.job.create', [
            'categories' => $categories,
            'job_natures' => $job_natures
        ]);
    }

    public function saveJob(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'job_nature_id' => 'required',
            'vacancy' => 'required|integer|min:1',
            'salary' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'benefits' => 'nullable|string',
            'responsibility' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'experience' => 'nullable|string|max:255',
            'keywords' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_location' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255|url',
        ]);

        Job::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'job_nature_id' => $request->job_nature_id,
            'vacancy' => $request->vacancy,
            'salary' => $request->salary,
            'location' => $request->location,
            'description' => $request->description,
            'benefits' => $request->benefits,
            'responsibility' => $request->responsibility,
            'qualifications' => $request->qualifications,
            'experience' => $request->experience,
            'keywords' => $request->keywords,
            'company_name' => $request->company_name,
            'company_location' => $request->company_location,
            'website' => $request->website,
        ]);

        return redirect()->route('account.indexJob')->with('success', 'Job created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        if (!$request->expectsJson()) {
            return route('account.login'); // Fix redirect route
        }
    }
}
