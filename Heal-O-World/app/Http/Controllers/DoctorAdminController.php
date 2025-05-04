<?php

namespace App\Http\Controllers;

use App\Http\Requests\MyOfficeDoctorRequest;
use Illuminate\Support\Facades\DB;
use App\Models\MyOfficeDoctor;
use Illuminate\Http\Request;

class DoctorAdminController extends Controller
{

    public function index(Request $request)
    {
        $doctorId = $request->input('doctor_id');

        $doctorsQuery = MyOfficeDoctor::with(['specialties', 'educations', 'placeOfWork', 'consultations']);

        if ($doctorId) {
            $doctorsQuery->where('id', $doctorId);
        }

        $doctors = $doctorsQuery->get();

        $monthlyDoctorData = DB::table('consultations')
            ->when($doctorId, fn($q) => $q->where('doctor_id', $doctorId))
            ->selectRaw('doctor_id, DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->groupBy('doctor_id', 'month')
            ->get()
            ->groupBy('doctor_id');

        $doctorChartLabels = [];
        $doctorChartDatasets = [];

        foreach ($doctors as $doctor) {
            $data = collect($monthlyDoctorData[$doctor->id] ?? []);
            $months = $data->pluck('month')->unique()->sort()->values();
            $doctorChartLabels = array_merge($doctorChartLabels, $months->all());

            $dataset = [
                'label' => $doctor->first_name . ' ' . $doctor->last_name,
                'data' => $months->map(function ($month) use ($data) {
                    return $data->firstWhere('month', $month)?->total ?? 0;
                }),
                'fill' => false,
                'borderColor' => '#' . substr(md5($doctor->id), 0, 6),
            ];

            $doctorChartDatasets[] = $dataset;
        }

        $doctorChartLabels = array_values(array_unique($doctorChartLabels));

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

    public function update(MyOfficeDoctorRequest $request, MyOfficeDoctor $doctor)
    {
        
        $doctor->update([
            'name' => $request->first_name . ' ' . $request->last_name, 
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
