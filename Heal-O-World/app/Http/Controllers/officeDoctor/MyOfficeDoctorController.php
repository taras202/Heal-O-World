<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyOfficeDoctorController extends Controller
{
    public function index()
    {  
        $user = Auth::user();

        return view('office-doctor.doctor-office', ['user' => Auth::user()]);
    }
}
