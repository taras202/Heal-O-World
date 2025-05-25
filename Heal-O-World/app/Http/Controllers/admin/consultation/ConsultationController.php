<?php

namespace App\Http\Controllers\admin\consultation;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\MyOfficePatient;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $patientId = $request->query('patient');
    
        $consultations = Consultation::with(['patient.user', 'doctor'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($patientId, fn($q) => $q->where('patient_id', $patientId))
            ->latest()
            ->paginate(12);
    
        $patients = MyOfficePatient::with('user')->get(); 
    
        return view('admin.patient.consultation.patient-consultations', compact('consultations', 'status', 'patients'));
    }    

    public function show($id)
    {
        $consultation = Consultation::with(['patient.user', 'doctor'])->findOrFail($id);

        return view('admin.patient.consultation.patient-consultations-show', compact('consultation'));
    }

    public function cancelConsultation($id)
    {
        $consultation = Consultation::where('status', '!=', 'cancelled')->findOrFail($id);

        $consultation->status = 'cancelled';
        $consultation->save();

        return redirect()->route('admin.patient.patient-consultation.index')
            ->with('success', 'Консультацію скасовано.');
    }
}
