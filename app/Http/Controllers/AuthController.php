<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // This method will show user registration page
    public function registration()
    {
        return view('front.account.registration');
    }

    // This method is used to perform user registration
    public function processRegistration(Request $request) {}

    // This method will show user login page
    public function login()
    {
        return view('front.account.login');
    }
}
