<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\MyOfficeDoctor;
use Illuminate\Http\Request;

class DoctorAdminController extends Controller
{

    public function index()
{
    $doctors = MyOfficeDoctor::with(['specialties', 'educations', 'placeOfWork'])->get();

    $monthlyDoctorData = DB::table('consultations')
    ->selectRaw('doctor_id, DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
    ->groupBy('doctor_id', 'month')
    ->get()
    ->groupBy('doctor_id');



    $doctorChartLabels = [];
    $doctorChartDatasets = [];

    foreach ($doctors as $doctor) {
        $data = collect($monthlyDoctorData[$doctor->id] ?? []);
        $months = $data->pluck('month')->unique()->sort()->values();
        $doctorChartLabels = $doctorChartLabels + $months->all(); 

        $dataset = [
            'label' => $doctor->first_name . ' ' . $doctor->last_name,
            'data' => [],
        ];

        foreach ($doctorChartLabels as $month) {
            $value = $data->firstWhere('month', $month)->total ?? 0;
            $dataset['data'][] = $value;
        }

        $doctorChartDatasets[] = $dataset;
    }

    return view('admin.doctor.index', compact('doctors', 'doctorChartLabels', 'doctorChartDatasets'));
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
