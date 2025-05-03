<?php


namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\MyOfficeDoctor;
use App\Models\MyOfficePatient;
use DB;
use Illuminate\Http\Request;

class PatientAdminController extends Controller
{


public function index(Request $request)
{
    $patients = MyOfficePatient::all();  
    $doctors = MyOfficeDoctor::all();
    
    $consultations = DB::table('consultations')
        ->select(DB::raw("MONTH(appointment_date) as month"), DB::raw("COUNT(*) as count"))
        ->whereYear('appointment_date', now()->year)
        ->groupBy(DB::raw("MONTH(appointment_date)"))
        ->orderBy(DB::raw("MONTH(appointment_date)"))
        ->get();

    $months = $consultations->pluck('month');
    $consultationsData = $consultations->pluck('count');

    $monthNames = ["Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", 
                    "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень"];
    
    $monthsFormatted = $months->map(function($month) use ($monthNames) {
        return $monthNames[$month - 1];  
    });

    return view('admin.patient.index', compact('patients', 'doctors', 'monthsFormatted', 'consultationsData'));
}


    public function create()
    {
        return view('admin.patient.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|string|max:15',
        ]);

        MyOfficePatient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт створений!');
    }

    public function show(MyOfficePatient $patient)
    {
        return view('admin.patient.show', compact('patient'));
    }

    public function edit(MyOfficePatient $patient)
    {
        return view('admin.patient.edit', compact('patient'));
    }

    public function update(Request $request, MyOfficePatient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:15',
        ]);

        $patient->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт оновлений!');
    }

    public function destroy(MyOfficePatient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт видалений!');
    }
}
