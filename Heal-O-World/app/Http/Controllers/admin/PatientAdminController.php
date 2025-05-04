<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MyOfficePatientRequest;
use App\Models\MyOfficeDoctor;
use App\Models\MyOfficePatient;
use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;

        MyOfficePatient::create($validated);

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт створений!');
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
        $validated = $request->validated();

        
        $patient->update($validated);

        $user = User::findOrFail($patient->user_id);
        $user->email = $request->input('email');
        $user->save();

        if ($request->hasFile('photo')) {
            if ($patient->photo && Storage::disk('public')->exists($patient->photo)) {
                Storage::disk('public')->delete($patient->photo);
            }
    
            $photoPath = $request->file('photo')->store('uploads/patients', 'public');
            $validated['photo'] = $photoPath;
        }

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт оновлений!');
    }

    public function destroy(MyOfficePatient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт видалений!');
    }
}
