<?php

namespace App\Http\Controllers\officeDoctor\consultation;

use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultationRequest;
use App\Models\Chat;
use App\Models\MyOfficeDoctor;
use App\Models\MyOfficePatient;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();
        $consultations = Consultation::where('doctor_id', $doctorId)
            ->orderBy('appointment_date')
            ->orderBy('consultation_time')
            ->get();

        return view('doctor.consultation.consultation-create', compact('consultations'));
    }

    public function create()
    {
        $doctorId = Auth::id();
        $consultations = Consultation::where('doctor_id', $doctorId)
            ->orderBy('appointment_date')
            ->orderBy('consultation_time')
            ->get();

        return view('doctor.consultation.consultation-create', compact('consultations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'consultation_time' => 'required|string',
        ]);
    
        $doctor = auth()->user()->doctor;
    
        if (!$doctor) {
            return back()->withErrors(['doctor_id' => 'Лікар не знайдений для цього користувача.']);
        }
    
        Consultation::create([
            'doctor_id' => $request->input('doctor_id'),
            'patient_id' => $request->input('patient_id'),
            'appointment_date' => $request->input('appointment_date'),
            'consultation_time' => $request->input('consultation_time'),
            'notes' => $request->input('notes'),
        ]);        
    
        return redirect()->back()->with('success', 'Консультація успішно додана!');
    }    
    public function book(Request $request)
    {
        $patient_id = $request->input('patient_id');
        $doctor_id = $request->input('doctor_id');
        $consultation_time = $request->input('consultation_time');
        $appointment_date = $request->input('appointment_date');
    
        $schedule = WorkSchedule::where('doctor_id', $doctor_id)
            ->where('consultation_time', $consultation_time)
            ->where('appointment_date', $appointment_date)
            ->first();
    
        if (!$schedule) {
            return back()->withErrors(['error' => 'Вибраний час недоступний або відсутній в графіку лікаря.']);
        }
    
        $consultation = Consultation::create([
            'patient_id' => $patient_id,
            'doctor_id' => $doctor_id,
            'consultation_time' => $consultation_time,
            'appointment_date' => $appointment_date,
            'status' => 'pending', 
        ]);
        
        $consultation->createGoogleMeetLink();
        
        $chat = Chat::firstOrCreate(
            ['doctor_id' => $doctor_id, 'patient_id' => $patient_id],
            ['status' => 'active']
        );
        
        if ($chat->wasRecentlyCreated) {
            $chat->messages()->create([
                'sender_id' => $patient_id ? MyOfficePatient::find($patient_id)->user_id : null,
                'message' => 'Пацієнт записався на консультацію. Можете почати спілкування тут.',
            ]);
        }
        
        return redirect()->route('doctor.index')->with('success', 'Консультація була успішно записана!');
    }    

    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);

        if ($consultation->doctor_id != auth()->user()->doctor->id) {
            abort(403, 'У вас немає доступу до цього запису.');
        }

        $consultation->delete();

        return back()->with('success', 'Консультацію видалено.');
    }
}
