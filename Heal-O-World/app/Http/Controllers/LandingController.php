<?php

namespace App\Http\Controllers;

use App\Models\MyOfficeDoctor;
use App\Models\Specialty;

class LandingController extends Controller
{
    public function landing()
    {
        $specialties = Specialty::all();
        $doctors = MyOfficeDoctor::with('specialties')->get();
        return view('landing.landing', compact('specialties', 'doctors'));
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
