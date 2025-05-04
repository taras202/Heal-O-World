<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MyOfficeDoctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = $request->input('doctor_id');

        $doctorsQuery = MyOfficeDoctor::with('consultations');

        if ($doctorId) {
            $doctorsQuery->where('id', $doctorId);
        }

        $doctors = $doctorsQuery->get();

        $doctorChartLabels = [];
        $doctorChartDatasets = [];
        $doctorChartRatingDatasets = [];

        foreach ($doctors as $doctor) {
            $monthlyConsultations = [];
            $monthlyRatings = [];

            foreach ($doctor->consultations as $consultation) {
                $month = Carbon::parse($consultation->date)->format('Y-m');

                $monthlyConsultations[$month] = ($monthlyConsultations[$month] ?? 0) + 1;

                if (!is_null($consultation->rating)) {
                    $monthlyRatings[$month][] = $consultation->rating;
                }
            }

            $doctorChartLabels = array_merge($doctorChartLabels, array_keys($monthlyConsultations));

            $doctorChartDatasets[] = [
                'label' => $doctor->first_name . ' ' . $doctor->last_name,
                'data' => array_values($monthlyConsultations),
                'borderColor' => '#' . substr(md5($doctor->id . '_consult'), 0, 6),
                'fill' => false,
            ];

            $monthlyAverageRatings = [];
            foreach ($monthlyRatings as $month => $ratings) {
                $monthlyAverageRatings[] = round(array_sum($ratings) / count($ratings), 1);
            }

            $doctorChartRatingDatasets[] = [
                'label' => $doctor->first_name . ' ' . $doctor->last_name,
                'data' => $monthlyAverageRatings,
                'borderColor' => '#' . substr(md5($doctor->id . '_rating'), 0, 6),
                'fill' => false,
            ];
        }

        $doctorChartLabels = array_values(array_unique($doctorChartLabels));
        sort($doctorChartLabels);

        return view('admin.doctor.analytics', [
            'doctors' => $doctors,
            'doctorChartLabels' => $doctorChartLabels,
            'doctorChartDatasets' => $doctorChartDatasets,
            'doctorChartRatingDatasets' => $doctorChartRatingDatasets,
        ]);
    }
}
