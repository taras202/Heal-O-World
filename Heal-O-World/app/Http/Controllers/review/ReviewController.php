<?php

namespace App\Http\Controllers\review;

use App\Models\Review;
use App\Models\MyOfficeDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Consultation;

class ReviewController extends Controller
{
    public function store(Request $request, $doctorId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $patient = Auth::user()->patient; 

        $hadConsultation = Consultation::where('doctor_id', $doctorId)
            ->where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->exists();

        if (! $hadConsultation) {
            return back()->withErrors(['message' => 'Ви можете залишити відгук лише після завершеної консультації.']);
        }

        $alreadyReviewed = Review::where('doctor_id', $doctorId)
            ->where('patient_id', $patient->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('patient.consultations.index')
                ->withErrors(['message' => 'Ви вже залишили відгук для цього лікаря.']);
        }
            
        Review::create([
            'doctor_id' => $doctorId,
            'patient_id' => $patient->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Відгук успішно додано!');
    }

    public function create($doctorId, $consultationId)
    {
        $patient = Auth::user()->patient;

        $consultation = Consultation::where('id', $consultationId)
            ->where('doctor_id', $doctorId)
            ->where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->firstOrFail();

        $alreadyReviewed = Review::where('doctor_id', $doctorId)
            ->where('patient_id', $patient->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->withErrors(['message' => 'Ви вже залишили відгук для цього лікаря.']);
        }

        return view('office-patient.review.create', compact('doctorId', 'consultationId'));
    }
}
