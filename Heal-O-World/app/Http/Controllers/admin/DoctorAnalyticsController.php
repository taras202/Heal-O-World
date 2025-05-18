<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MyOfficeDoctor;
use App\Models\Consultation;
use App\Models\MyOfficePatient;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $year = $request->input('year');
        $month = $request->input('month');

        $doctorsQuery = MyOfficeDoctor::with('consultations');

        if ($doctorId) {
            $doctorsQuery->where('id', $doctorId);
        }

        if ($year) {
            $doctorsQuery->whereHas('consultations', function ($query) use ($year) {
                $query->whereYear('appointment_date', $year);
            });
        }

        if ($month) {
            $doctorsQuery->whereHas('consultations', function ($query) use ($month) {
                $query->whereMonth('appointment_date', $month);
            });
        }

        $doctors = $doctorsQuery->get();

        $doctorChartLabels = [];
        $doctorChartDatasets = [];
        $doctorChartRatingDatasets = [];
        $doctorNames = [];
        $doctorConsultationCounts = [];

        foreach ($doctors as $doctor) {
            $monthlyConsultations = [];
            $monthlyRatings = [];

            foreach ($doctor->consultations as $consultation) {
                $month = Carbon::parse($consultation->appointment_date)->format('Y-m');

                $monthlyConsultations[$month] = ($monthlyConsultations[$month] ?? 0) + 1;

                $ratings = Review::where('doctor_id', $doctor->id)
                    ->whereNotNull('rating')
                    ->pluck('rating');

                if ($ratings->isNotEmpty()) {
                    $monthlyRatings[$month] = array_merge($monthlyRatings[$month] ?? [], $ratings->toArray());
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
            foreach ($doctorChartLabels as $month) {
                if (!empty($monthlyRatings[$month])) {
                    $monthlyAverageRatings[] = round(array_sum($monthlyRatings[$month]) / count($monthlyRatings[$month]), 1);
                } else {
                    $monthlyAverageRatings[] = null;
                }
            }

            $doctorChartRatingDatasets[] = [
                'label' => $doctor->first_name . ' ' . $doctor->last_name,
                'data' => $monthlyAverageRatings,
                'borderColor' => '#' . substr(md5($doctor->id . '_rating'), 0, 6),
                'fill' => false,
            ];

            $doctorNames[] = $doctor->first_name . ' ' . $doctor->last_name;
            $doctorConsultationCounts[] = $doctor->consultations->count();
        }

        $doctorChartLabels = array_values(array_unique($doctorChartLabels));
        sort($doctorChartLabels);

        $totalDoctors = MyOfficeDoctor::count();
        $totalConsultations = Consultation::count();
        $totalPatients = Consultation::distinct('patient_id')->count('patient_id');
        $averageRating = round(Review::whereNotNull('rating')->avg('rating'), 1);
        $averageDuration = round(Consultation::avg('consultation_time'), 1);

        $years = Consultation::selectRaw('YEAR(appointment_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.doctor.analytics', [
            'doctors' => $doctors,
            'doctorChartLabels' => $doctorChartLabels,
            'doctorChartDatasets' => $doctorChartDatasets,
            'doctorChartRatingDatasets' => $doctorChartRatingDatasets,
            'doctorNames' => $doctorNames,
            'doctorConsultationCounts' => $doctorConsultationCounts,
            'totalDoctors' => $totalDoctors,
            'totalConsultations' => $totalConsultations,
            'totalPatients' => $totalPatients,
            'averageRating' => $averageRating,
            'averageDuration' => $averageDuration,
            'years' => $years,
        ]);
    }
    public function analytics(Request $request)
    {
        $doctors = MyOfficeDoctor::all();
        $years = Consultation::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');
        $totalPatients = MyOfficePatient::count();  
        $totalDoctors = MyOfficeDoctor::count();
        $totalConsultations = Consultation::count();
        $averageDuration = Consultation::avg('consultation_time');
        $averageRating = Consultation::avg('rating');

        return view('admin.doctor.analytics', compact(
            'doctors', 'years', 'totalPatients', 'totalDoctors', 'totalConsultations', 'averageDuration', 'averageRating'
        ));
    }
}
