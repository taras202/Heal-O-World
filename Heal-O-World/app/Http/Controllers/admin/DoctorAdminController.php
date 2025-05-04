<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\MyOfficeDoctorRequest;
use Illuminate\Support\Facades\DB;
use App\Models\MyOfficeDoctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class DoctorAdminController extends Controller
{

    public function index(Request $request)
    {
        $doctorId = $request->input('doctor_id');

        $doctorsQuery = MyOfficeDoctor::with(['user', 'specialties', 'educations', 'placeOfWork', 'consultations']);

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

    public function store(MyOfficeDoctorRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->savePhoto($request->file('photo'), 'doctors');
        }

        $doctor = MyOfficeDoctor::create($data);

        if (!empty($data['educations'])) {
            foreach ($data['educations'] as $educationData) {
                foreach (['diploma_photo_1', 'diploma_photo_2', 'diploma_photo_3'] as $photoField) {
                    if ($request->hasFile("educations.{$loop->index}.$photoField")) {
                        $educationData[$photoField] = $this->savePhoto($request->file("educations.{$loop->index}.$photoField"), 'diplomas');
                    }
                }
                $doctor->educations()->create($educationData);
            }
        }

        if (!empty($data['specialties'])) {
            foreach ($data['specialties'] as $index => $specialtyId) {
                $pivotData = $data['specialty_data'][$index] ?? [];
                $doctor->specialties()->attach($specialtyId, [
                    'experience' => $pivotData['experience'] ?? null,
                    'price' => $pivotData['price'] ?? null,
                ]);
            }
        }

        if (!empty($data['place_of_work'])) {
            $doctor->placeOfWork()->create($data['place_of_work']);
        }

        return redirect()->route('admin.doctors.index')->with('status', 'Лікар створений!');
    }

    private function savePhoto($file, $folder)
    {
        return $file->store("photos/$folder", 'public');
    }
    
    public function show(MyOfficeDoctor $doctor)
    {
        $users = User::all();
        return view('admin.doctor.show', compact('doctor', 'users'));
    }

    public function edit(MyOfficeDoctor $doctor)
    {
        $users = User::all();
        return view('admin.doctor.edit', compact('doctor', 'users'));
    }
    

    public function update(MyOfficeDoctorRequest $request, MyOfficeDoctor $doctor)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->savePhoto($request->file('photo'), 'doctors');
        }

        $doctor->update($data);

        if (!empty($data['place_of_work'])) {
            $doctor->placeOfWork()->updateOrCreate(['doctor_id' => $doctor->id], $data['place_of_work']);
        }

        $doctor->specialties()->detach();
        if (!empty($data['specialties'])) {
            foreach ($data['specialties'] as $index => $specialtyId) {
                $pivotData = $data['specialty_data'][$index] ?? [];
                $doctor->specialties()->attach($specialtyId, [
                    'experience' => $pivotData['experience'] ?? null,
                    'price' => $pivotData['price'] ?? null,
                ]);
            }
        }

        $doctor->educations()->delete();
        if (!empty($data['educations'])) {
            foreach ($data['educations'] as $i => $educationData) {
                foreach (['diploma_photo_1', 'diploma_photo_2', 'diploma_photo_3'] as $photoField) {
                    if ($request->hasFile("educations.{$i}.$photoField")) {
                        $educationData[$photoField] = $this->savePhoto($request->file("educations.{$i}.$photoField"), 'diplomas');
                    }
                }
                $doctor->educations()->create($educationData);
            }
        }

        return redirect()->route('admin.doctors.index')->with('status', 'Інформацію про лікаря оновлено!');
    }
    

    public function destroy(MyOfficeDoctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('status', 'Лікаря видалено!');
    }
}
