<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MyOfficeDoctor;
use Illuminate\Http\Request;

class DoctorAdminController extends Controller
{

    public function index()
    {
        $doctors = MyOfficeDoctor::all();
        return view('admin.doctor.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors',
            'specialization' => 'required|string|max:255',
        ]);

        MyOfficeDoctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('admin.doctors.index')->with('status', 'Лікар створений!');
    }

    public function show(MyOfficeDoctor $doctor)
    {
        return view('admin.doctor.show', compact('doctor'));
    }

    public function edit(MyOfficeDoctor $doctor)
    {
        return view('admin.doctor.edit', compact('doctor'));
    }

    public function update(Request $request, MyOfficeDoctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'specialization' => 'required|string|max:255',
        ]);

        $doctor->update([
            'name' => $request->name,
            'email' => $request->email,
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('admin.doctors.index')->with('status', 'Інформацію про лікаря оновлено!');
    }

    public function destroy(MyOfficeDoctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('status', 'Лікаря видалено!');
    }
}
