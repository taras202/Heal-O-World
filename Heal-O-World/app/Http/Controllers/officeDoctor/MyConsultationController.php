<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\MyOfficeDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyConsultationController extends Controller
{
    public function index(Request $request)
    {
        $doctor = auth()->user();
        $status = $request->query('status');
    
        $consultations = Consultation::with('patient')
            ->where('doctor_id', $doctor->id)
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('appointment_date')
            ->paginate(10);
    
        return view('doctor.consultation.consultation-index', compact('consultations'));
    }

    public function show($id)
    {
        $user = auth()->user();

        $doctor = MyOfficeDoctor::where('user_id', $user->id)->firstOrFail();

        $consultation = $doctor->consultations()
            ->with('patient')
            ->findOrFail($id);

        return view('doctor.consultation.consultation-show', compact('consultation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:my_office_doctors,id',
            'appointment_date' => 'required|date',
            'consultation_time' => 'required',
            'diagnosis' => 'required|string|max:255',
        ]);

        $consultation = Consultation::create([
            'doctor_id'         => $request->doctor_id,
            'patient_id'        => Auth::guard('patient')->id(), 
            'appointment_date'  => $request->appointment_date,
            'consultation_time' => $request->consultation_time,
            'diagnosis'         => $request->diagnosis,
            'notes'             => $request->notes,
            'status'            => 'запланована',
        ]);

        return redirect()->route('doctor.consultations.index')->with('success', 'Консультацію заплановано успішно!');
    }

    public function edit($id)
    {
        $consultation = Consultation::with('patient')->findOrFail($id);

        return view('doctor.consultation.consultation-edit', compact('consultation'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $consultation = Consultation::findOrFail($id);
        $consultation->update($request->only('status', 'diagnosis', 'prescription', 'treatment', 'notes'));

        return redirect()->route('doctor.consultation.edit', $consultation->id)->with('success', 'Консультацію оновлено.');
    }

    public function completeConsultation($id)
    {
        $user = auth()->user();

        $doctor = MyOfficeDoctor::where('user_id', $user->id)->firstOrFail();

        $consultation = $doctor->consultations()
            ->where('status', 'pending')
            ->findOrFail($id);

        $consultation->status = 'completed';
        $consultation->save();

        return redirect()->route('doctor.consultations.index')->with('success', 'Консультацію завершено.');
    }

    public function cancelConsultation($id)
    {
        $user = auth()->user();

        $doctor = MyOfficeDoctor::where('user_id', $user->id)->firstOrFail();

        $consultation = $doctor->consultations()
            ->where('status', '!=', 'cancelled')
            ->findOrFail($id);

        $consultation->status = 'cancelled';
        $consultation->save();

        return redirect()->route('doctor.consultations.index')->with('success', 'Консультацію скасовано.');
    }
}
