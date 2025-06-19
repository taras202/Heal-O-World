<?php

namespace App\Http\Controllers\officePatient;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\MyOfficePatient;
use App\Models\TimeZone;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MyOfficePatientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patient = MyOfficePatient::where('contact', $user->email)->first();
        $timeZones = TimeZone::all();
    
        return view('office-patient.patient-office', compact('user', 'patient', 'timeZones'));
    }    
    
    public function store(StorePatientRequest $request)
    {
        $user = auth()->user();
    
        MyOfficePatient::create([
            'user_id' => $user->id,
            'contact' => $user->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'has_insurance' => $request->has_insurance,
            'country_of_residence' => $request->country_of_residence,
            'city_of_residence' => $request->city_of_residence,
            'notes' => $request->notes,
        ]);
    
        return redirect()->route('patient.office')->with('success', 'Пацієнта створено.');
    }

    public function update(UpdatePatientRequest $request)
    {
        $user = auth()->user();
        $patient = MyOfficePatient::where('user_id', $user->id)->firstOrFail();

        $patient->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'has_insurance' => $request->has_insurance,
            'country_of_residence' => $request->country_of_residence,
            'city_of_residence' => $request->city_of_residence,
            'notes' => $request->notes,
            'contact' => $user->email,
            'time_zone_id' => $request->time_zone_id,
        ]);

        return redirect()->route('patient.office')->with('success', 'Профіль оновлено.');
    }
    
    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->phone = $request->phone;
        $user->save();

        return response()->json(['message' => 'Телефон оновлено.']);
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore(auth()->id())
            ]
        ]);

        $user = auth()->user();
        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'E-mail оновлено.']);
    }
}