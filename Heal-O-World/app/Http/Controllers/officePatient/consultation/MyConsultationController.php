<?php

namespace App\Http\Controllers\officePatient\consultation;

use App\Http\Controllers\Controller;
use App\Models\MyOfficePatient;
use Illuminate\Http\Request;

class MyConsultationController extends Controller
{
    public function index(Request $request)
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
            ->paginate(12);
    
        return view('office-patient.consultation.patient-consultations', compact('consultations', 'status'));
    }    

    public function show($id)
    {
        $user = auth()->user();
    
        $patient = MyOfficePatient::where('user_id', $user->id)->firstOrFail();
    
        $consultation = $patient->consultations()->with('doctor')->findOrFail($id);
    
        return view('office-patient.consultation.consultation-show', compact('consultation'));
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
    
        return redirect()->route('patient.consultations.index')->with('success', 'Консультацію скасовано.');
    }
}
