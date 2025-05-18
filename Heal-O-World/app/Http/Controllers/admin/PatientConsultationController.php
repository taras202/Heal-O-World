<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class PatientConsultationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $consultations = Consultation::with(['patient.user', 'doctor'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(12);

        return view('admin.patient.consultation.patient-consultation', compact('consultations', 'status'));
    }

    public function show($id)
    {
        $consultation = Consultation::with(['patient.user', 'doctor'])->findOrFail($id);

        return view('admin.patient.patient-consultation.show', compact('consultation'));
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
