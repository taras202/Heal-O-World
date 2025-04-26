<?php

namespace App\Http\Controllers\officePatient;

use App\Http\Controllers\Controller;
use App\Models\MyOfficePatient;
use Illuminate\Http\Request;

class MyConsultationController extends Controller
{
    public function myConsultations(Request $request)
    {
        $user = auth()->user();
        $status = $request->query('status');
    
        $patient = $user->patient;
    
        if (!$patient) {
            return redirect()->route('patient.office')->withErrors('Пацієнт не знайдений.');
        }
    
        $consultations = $patient->consultations()
            ->when($status, fn($q) => $q->where('status', $status))
            ->with('doctor')
            ->latest()
            ->get();
    
        return view('office-patient.consultation.patient-consultations', compact('consultations', 'status'));
    }    

    public function showConsultation($id)
    {
        $user = auth()->user();
    
        $patient = MyOfficePatient::where('user_id', $user->id)->firstOrFail();
    
        $consultation = $patient->consultations()->with('doctor')->findOrFail($id);
    
        return view('office-patient.consultation.consultation-details', compact('consultation'));
    }
    

    public function cancelConsultation($id)
    {
        $user = auth()->user();
    
        $patient = MyOfficePatient::where('user_id', $user->id)->firstOrFail();
    
        $consultation = $patient->consultations()
            ->where('status', '!=', 'cancelled')
            ->findOrFail($id);
    
        $consultation->status = 'cancelled';
        $consultation->save();
    
        return redirect()->route('patient.office.consultations')->with('success', 'Консультацію скасовано.');
    }
}