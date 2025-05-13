<?php

namespace App\Http\Controllers\officeDoctor\consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkScheduleRequest;
use App\Models\Consultation;
use App\Models\MyOfficeDoctor;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function index()
    {
        $doctor = MyOfficeDoctor::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return back()->withErrors(['error' => 'Лікар не знайдений.']);
        }

        $schedules = WorkSchedule::where('doctor_id', $doctor->id)
            ->orderBy('appointment_date')
            ->orderBy('consultation_time')
            ->paginate(10);

        return view('doctor.consultation.consultation-create', compact('schedules'));
    }

    public function create()
    {
        $doctor = MyOfficeDoctor::where('user_id', Auth::id())->first();
    
        if (!$doctor) {
            return back()->withErrors(['error' => 'Лікар не знайдений.']);
        }
    
        $schedules = WorkSchedule::where('doctor_id', $doctor->id)
            ->orderBy('appointment_date')
            ->orderBy('consultation_time')
            ->paginate(10);
    
        return view('doctor.consultation.consultation-create', compact('schedules'));
    }    

    public function store(WorkScheduleRequest $request)
    {
        $doctor = MyOfficeDoctor::where('user_id', Auth::id())->first();
    
        if (!$doctor) {
            return back()->withErrors(['error' => 'Лікар не знайдений.']);
        }
    
        $existing = WorkSchedule::where('doctor_id', $doctor->id)
            ->where('appointment_date', $request->appointment_date)
            ->where('consultation_time', $request->consultation_time)
            ->first();
    
        if ($existing) {
            return back()->withErrors(['error' => 'Ця година вже існує у вашому графіку.']);
        }
    
        WorkSchedule::create([
            'doctor_id' => $doctor->id,
            'appointment_date' => $request->appointment_date,
            'consultation_time' => $request->consultation_time,
        ]);
    
        return redirect()->route('work-schedule.create')->with('success', 'Година консультації успішно додана!');
    }    

    public function destroy($id)
    {
        $doctor = MyOfficeDoctor::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return back()->withErrors(['error' => 'Лікар не знайдений.']);
        }

        $schedule = WorkSchedule::findOrFail($id);

        if ($schedule->doctor_id != $doctor->id) {
            abort(403, 'У вас немає доступу до цього запису.');
        }

        $schedule->delete();

        return back()->with('success', 'Година консультації успішно видалена.');
    }
    public function getFreeTimes($doctorId, Request $request)
    {
        $appointmentDate = $request->input('appointment_date');
        
        $freeTimes = WorkSchedule::where('doctor_id', $doctorId)
            ->where('appointment_date', $appointmentDate)
            ->whereDoesntHave('consultations') 
            ->get();
    
        if ($freeTimes->isEmpty()) {
            return response()->json(['message' => 'Немає доступних годин на обрану дату'], 404);
        }
    
        return response()->json($freeTimes->map(function ($schedule) {
            return [
                'time' => $schedule->consultation_time,
            ];
        }));
    }
}
