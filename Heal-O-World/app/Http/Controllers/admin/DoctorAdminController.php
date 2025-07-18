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
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            $doctor = MyOfficeDoctor::create([
                'user_id' => $user->id,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'gender' => $request->input('gender'),
                'contact' => $request->input('contact'),
                'time_zone' => $request->input('time_zone'),
                'bio' => $request->input('bio'), 
                'photo' => $this->savePhoto($request->file('photo')), 
            ]);

            if ($request->has('specialties') && is_array($request->input('specialties'))) {
                foreach ($request->input('specialties') as $specialty) {
                    if (isset($specialty['id'], $specialty['experience'], $specialty['price'])) {
                        $doctor->specialties()->attach($specialty['id'], [
                            'experience' => $specialty['experience'],
                            'price' => $specialty['price'],
                        ]);
                    }
                }
            }

            if ($request->has('educations') && is_array($request->input('educations'))) {
                foreach ($request->input('educations') as $education) {
                    if (isset($education['institution'], $education['degree'], $education['start_year'], $education['end_year'])) {
                        $doctor->educations()->create($education);
                    }
                }
            }

            if ($request->has('place_of_work') && is_array($request->input('place_of_work'))) {
                $doctor->placeOfWork()->create($request->input('place_of_work'));
            }

            DB::commit();
            return redirect()->route('admin.doctors.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating doctor: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Щось пішло не так. Спробуйте ще раз.']);
        }
    }

    private function saveEducations(Request $request, MyOfficeDoctor $doctor, array $data)
    {
        if (!empty($data['educations'])) {
            foreach ($data['educations'] as $index => $educationData) {
                foreach (['diploma_photo_1', 'diploma_photo_2', 'diploma_photo_3'] as $photoField) {
                    if ($request->hasFile("educations.{$index}.$photoField")) {
                        $educationData[$photoField] = $this->savePhoto($request->file("educations.{$index}.$photoField"), 'diplomas');
                    }
                }
                
                $doctor->educations()->create($educationData);
            }
        }
    }

    private function saveSpecialties(Request $request, MyOfficeDoctor $doctor, array $data)
    {
        if (!empty($data['specialties'])) {
            foreach ($data['specialties'] as $index => $specialtyId) {
                $pivotData = $data['specialty_data'][$index] ?? [];
                $doctor->specialties()->attach($specialtyId, [
                    'experience' => $pivotData['experience'] ?? null,
                    'price' => $pivotData['price'] ?? null,
                ]);
            }
        }
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
