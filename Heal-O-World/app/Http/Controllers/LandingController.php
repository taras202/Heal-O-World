<?php

namespace App\Http\Controllers;

use App\Models\MyOfficeDoctor;
use App\Models\Specialty;
use App\Models\StaticContent;

class LandingController extends Controller
{
    public function landing()
    {
        $specialties = Specialty::all();
        $doctors = MyOfficeDoctor::with('specialties')->get();
        $content = StaticContent::first();

        return view('landing.landing', compact('specialties', 'doctors', 'content'));
    }

    public function about()
    {
        return view('landing.about');
    }

    public function contact()
    {
        return view('landing.contact');
    }

    public function index()
    {
        $content = StaticContent::first(); 
        return view('landing.index', compact('content'));
    }


}
