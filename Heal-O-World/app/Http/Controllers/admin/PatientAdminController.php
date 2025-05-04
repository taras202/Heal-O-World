<?php


namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MyOfficeDoctor;
use App\Models\MyOfficePatient;
use Illuminate\Http\Request;

class PatientAdminController extends Controller
{
    public function index(Request $request)
    {
        $doctors = MyOfficeDoctor::all();

        $patientName = $request->get('patient_name');
        
        $patientsQuery = MyOfficePatient::with('consultations', 'consultations.doctor');

        if ($patientName) {
            $patientsQuery = $patientsQuery->where('first_name', 'like', '%' . $patientName . '%')
                                        ->orWhere('last_name', 'like', '%' . $patientName . '%');
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

        return view('admin.patient.index', compact('patients', 'doctors', 'patientChartLabels', 'patientChartDatasets'));
    }

    public function create()
    {
        return view('admin.patient.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|string|max:15',
        ]);

        MyOfficePatient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт створений!');
    }

    public function show(MyOfficePatient $patient)
    {
        return view('admin.patient.show', compact('patient'));
    }

    public function edit(MyOfficePatient $patient)
    {
        return view('admin.patient.edit', compact('patient'));
    }

    public function update(Request $request, MyOfficePatient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:15',
        ]);

        $patient->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт оновлений!');
    }

    public function destroy(MyOfficePatient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт видалений!');
    }
}
