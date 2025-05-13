<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MyOfficePatientRequest;
use App\Models\MyOfficePatient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PatientAdminController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $patientsQuery = MyOfficePatient::with('consultations', 'consultations.doctor');

        $patientName = $request->get('patient_name');
        if ($patientName) {
            $patientsQuery->where('first_name', 'like', '%' . $patientName . '%')
                          ->orWhere('last_name', 'like', '%' . $patientName . '%');
        }

        if ($doctorId) {
            $patientsQuery->whereHas('consultations', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            });
        }

        $patients = $patientsQuery->get();

        $patientChartLabels = [];
        $patientChartDatasets = [];

        foreach ($patients as $patient) {
            foreach ($patient->consultations as $consultation) {
                $month = $consultation->created_at->format('Y-m');
                if (!in_array($month, $patientChartLabels)) {
                    $patientChartLabels[] = $month;
                }
            }
        }

        $patientChartLabels = array_values(array_unique($patientChartLabels));

        $patientChartDatasets = [
            [
                'label' => 'Кількість консультацій по пацієнтах',
                'data' => array_fill(0, count($patientChartLabels), 0),
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1
            ]
        ];

        return view('admin.patient.index', compact('patients', 'patientChartLabels', 'patientChartDatasets'));
    }

    public function create()
    {
        $users = User::all(); 
        return view('admin.patient.create', compact('users'));
    }

    public function store(MyOfficePatientRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 'patient', 
            ]);

            $validated = $request->validated();
            $validated['user_id'] = $user->id;

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('uploads/patients', 'public');
                $validated['photo'] = $photoPath;
            }

            MyOfficePatient::create($validated);

            DB::commit();

            return redirect()->route('admin.patients.index')->with('status', 'Пацієнт створений!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Помилка при створенні пацієнта: ' . $e->getMessage()]);
        }
    }


    public function show(MyOfficePatient $patient)
    {
        $users = User::all(); 
        return view('admin.patient.show', compact('patient', 'users'));
    }

    public function edit(MyOfficePatient $patient)
    {
        $users = User::all(); 
        return view('admin.patient.edit', compact('patient', 'users'));
    }

    public function update(MyOfficePatientRequest $request, MyOfficePatient $patient)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            if ($request->hasFile('photo')) {
                if ($patient->photo && Storage::disk('public')->exists($patient->photo)) {
                    Storage::disk('public')->delete($patient->photo);
                }

                $photoPath = $request->file('photo')->store('uploads/patients', 'public');
                $validated['photo'] = $photoPath;
            }

            $patient->update($validated);

            $user = $patient->user;

            if ($user && $user->role !== 'admin') {
                $user->email = $request->input('email');

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->input('password'));
                }

                $user->save();
            }

            DB::commit();

            return redirect()->route('admin.patients.index')->with('status', 'Пацієнт оновлений!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Помилка при оновленні пацієнта: ' . $e->getMessage()]);
        }
    }

    public function destroy(MyOfficePatient $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт видалений!');
    }
}
