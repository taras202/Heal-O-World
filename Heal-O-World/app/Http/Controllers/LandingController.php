<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function landing()
    {
        return view('landing.landing');
    }

    public function about()
    {
        return view('landing.about');
    }

    public function contact()
    {
        return view('landing.contact');
    }
}
