<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyOfficeDoctor;
use App\Models\Specialty;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $specialtyFilter = $request->query('specialty');
        $specialties = Specialty::orderBy('name')->get();
    
        $doctors = MyOfficeDoctor::with('specialties')
            ->when($specialtyFilter && strtolower($specialtyFilter) !== 'all', function ($query) use ($specialtyFilter) {
                $query->whereHas('specialties', function ($q) use ($specialtyFilter) {
                    $q->where('name', $specialtyFilter);
                });
            })
            ->get();
    
        return view('doctor.open-view.index', compact('doctors', 'specialties', 'specialtyFilter'));
    }    

    public function show($id)
    {
        $doctor = MyOfficeDoctor::with('placeOfWork')->findOrFail($id);
        return view('doctor.open-view.show', compact('doctor'));
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
    
        return view('components.doctor-list', compact('doctors'));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $doctors = MyOfficeDoctor::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'first_name', 'last_name']);

        return response()->json($doctors);
    }

    public function searchBySpecialty(Request $request)
    {
        $query = $request->query('q');
    
        $doctors = MyOfficeDoctor::with('specialties')
            ->whereHas('specialties', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->get();
    
        return view('doctor.open-view.index', compact('doctors'));
    }    
}
