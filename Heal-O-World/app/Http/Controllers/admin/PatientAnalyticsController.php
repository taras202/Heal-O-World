<?php

namespace App\Http\Controllers\admin;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MyOfficePatient;

class PatientAnalyticsController extends Controller
{
    public function showAnalytics()
    {
        $totalPatients = MyOfficePatient::count();
        
        $insuredPatients = MyOfficePatient::where('has_insurance', true)->count();
        
        $malePatients = MyOfficePatient::where('gender', 'male')->count();
        $femalePatients = MyOfficePatient::where('gender', 'female')->count();
        $otherPatients = MyOfficePatient::where('gender', 'other')->count();
        
        $ageGroupUnder18 = MyOfficePatient::where('date_of_birth', '>=', now()->subYears(18))->count();
        $ageGroup19to40 = MyOfficePatient::whereBetween('date_of_birth', [now()->subYears(40), now()->subYears(19)])->count();
        $ageGroup41to60 = MyOfficePatient::whereBetween('date_of_birth', [now()->subYears(60), now()->subYears(41)])->count();
        $ageGroupOver60 = MyOfficePatient::where('date_of_birth', '<=', now()->subYears(60))->count();

        $months = ['Січень', 'Лютий', 'Березень', 'Квітень'];
        $consultationsData = [20, 25, 30, 40]; 

        $patientsWithConsultations = MyOfficePatient::with('consultations')->get();

        return view('admin.analytics', compact(
            'totalPatients', 'insuredPatients', 'malePatients', 'femalePatients', 'otherPatients',
            'ageGroupUnder18', 'ageGroup19to40', 'ageGroup41to60', 'ageGroupOver60', 
            'months', 'consultationsData', 'patientsWithConsultations'
        ));
    }

    public function showPatients()
{
    $totalPatients = MyOfficePatient::count();
    $insuredPatients = MyOfficePatient::where('has_insurance', true)->count();
    $malePatients = MyOfficePatient::where('gender', 'male')->count();
    $femalePatients = MyOfficePatient::where('gender', 'female')->count();
    $otherPatients = MyOfficePatient::where('gender', 'other')->count();
    $ageGroupUnder18 = MyOfficePatient::where('date_of_birth', '>=', now()->subYears(18))->count();
    $ageGroup19to40 = MyOfficePatient::whereBetween('date_of_birth', [now()->subYears(40), now()->subYears(19)])->count();
    $ageGroup41to60 = MyOfficePatient::whereBetween('date_of_birth', [now()->subYears(60), now()->subYears(41)])->count();
    $ageGroupOver60 = MyOfficePatient::where('date_of_birth', '<=', now()->subYears(60))->count();

    $months = ['Січень', 'Лютий', 'Березень', 'Квітень'];  
    $consultationsData = [20, 25, 30, 40];  

    $patientsWithConsultations = MyOfficePatient::with('consultations')->get();

    return view('admin.patients.index', compact(
        'totalPatients', 'insuredPatients', 'malePatients', 'femalePatients', 'otherPatients',
        'ageGroupUnder18', 'ageGroup19to40', 'ageGroup41to60', 'ageGroupOver60', 'months', 'consultationsData', 'patientsWithConsultations'
    ));
}

    public function index()
    {
        $patients = MyOfficePatient::all();

        $months = ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень'];
        $consultationsData = [12, 18, 9, 24, 15];

        return view('admin.patients.index', compact('patients', 'months', 'consultationsData'));
    }

}
