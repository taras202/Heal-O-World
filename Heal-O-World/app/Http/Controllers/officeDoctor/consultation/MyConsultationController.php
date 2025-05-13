<?php

namespace App\Http\Controllers\officeDoctor\consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultationRequest;
use App\Models\Consultation;
use App\Models\MyOfficeDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyConsultationController extends Controller
{
    public function index(Request $request)
    {
        $doctor = MyOfficeDoctor::where('user_id', Auth::id())->firstOrFail();
    
        $query = $doctor->consultations()->with('patient');
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $sort = $request->input('sort', 'desc');

        $consultations = $query
            ->orderBy('appointment_date', $sort)
            ->orderBy('consultation_time', $sort)
            ->paginate(12)
            ->appends($request->only(['status', 'sort']));
        
        return view('doctor.consultation.consultation-index', compact('consultations', 'doctor'));
    }    

    public function show($id)
    {
        $doctor = MyOfficeDoctor::where('user_id', auth()->id())->firstOrFail();

        $consultation = $doctor->consultations()
            ->with('patient')
            ->findOrFail($id);

        return view('doctor.consultation.consultation-show', compact('consultation', 'doctor'));
    }

    public function completeConsultation($id)
    {
        $doctor = MyOfficeDoctor::where('user_id', auth()->id())->firstOrFail();

        $consultation = $doctor->consultations()
            ->where('status', 'pending')
            ->findOrFail($id);

        $consultation->update(['status' => 'completed']);

        return redirect()->route('doctor.consultations.index')->with('success', 'Консультацію завершено.');
    }

    public function cancelConsultation($id)
    {
        $doctor = MyOfficeDoctor::where('user_id', auth()->id())->firstOrFail();

        $consultation = $doctor->consultations()
            ->where('status', '!=', 'cancelled')
            ->findOrFail($id);

        $consultation->update(['status' => 'cancelled']);

        return redirect()->route('doctor.consultations.index')->with('success', 'Консультацію скасовано.');
    }
}
