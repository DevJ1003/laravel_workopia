<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // This method used to render our home page
    public function index()
    {
        return view('front.home');
    }
}
