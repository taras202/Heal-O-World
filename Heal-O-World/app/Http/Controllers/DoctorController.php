<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyOfficeDoctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = MyOfficeDoctor::with('specialties')->get();
        return view('doctor.index', compact('doctors'));
    }

    public function show($id)
    {
        $doctor = MyOfficeDoctor::findOrFail($id);
        return view('doctor.show', compact('doctor'));
    }

    public function filter(Request $request)
    {
        $specialty = $request->query('specialty');
    
        $doctors = MyOfficeDoctor::with('specialties')
            ->when($specialty && $specialty !== 'all', function ($query) use ($specialty) {
                $query->whereHas('specialties', function ($q) use ($specialty) {
                    $q->where('name', $specialty);
                });
            })
            ->get();
    
        return view('partials.doctor-list', compact('doctors'));
    }
    
}
