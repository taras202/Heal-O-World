<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyOfficeDoctor;

class DoctorController extends Controller
{
    /**
     * Вивести список усіх лікарів.
     */
    public function index()
    {
        $doctors = MyOfficeDoctor::all();
        return view('doctor.index', compact('doctors'));
    }

    /**
     * Вивести сторінку конкретного лікаря.
     */
    public function show($id)
    {
        $doctor = MyOfficeDoctor::findOrFail($id);
        return view('doctor.show', compact('doctor'));
    }
}
