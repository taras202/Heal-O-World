<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MyOfficePatient;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PatientAnalyticsController extends Controller
{
    public function index(Request $request)
{
    $patientId = $request->input('patient_id');

    $patientsQuery = MyOfficePatient::with(['consultations.doctor']);
    if ($patientId) {
        $patientsQuery->where('id', $patientId);
    }
    $patients = $patientsQuery->get();

    $monthlyPatientData = DB::table('consultations')
        ->selectRaw('patient_id, DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
        ->groupBy('patient_id', 'month');
    if ($patientId) {
        $monthlyPatientData->where('patient_id', $patientId);
    }
    $monthlyPatientData = $monthlyPatientData->get()->groupBy('patient_id');

    $patientChartLabels = [];
    $patientChartDatasets = [];
    foreach ($patients as $patient) {
        $data = collect($monthlyPatientData[$patient->id] ?? []);
        $months = $data->pluck('month')->unique()->sort()->values();
        $patientChartLabels = array_merge($patientChartLabels, $months->all());

        $dataset = [
            'label' => $patient->first_name . ' ' . $patient->last_name,
            'data' => $months->map(fn($month) => $data->firstWhere('month', $month)?->total ?? 0),
            'fill' => false,
            'borderColor' => '#' . substr(md5($patient->id), 0, 6),
        ];

        $patientChartDatasets[] = $dataset;
    }
    $patientChartLabels = array_values(array_unique($patientChartLabels));

    $years = \App\Models\Consultation::selectRaw('YEAR(created_at) as year')
                ->groupBy('year')
                ->orderByDesc('year')
                ->pluck('year');

    return view('admin.patient.analytics', compact('patients', 'patientChartLabels', 'patientChartDatasets', 'years'));
}

}
