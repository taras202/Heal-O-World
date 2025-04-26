<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Models\Education;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorActivationController extends Controller
{
    private function getDoctor()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            return redirect()->route('activation.personal')->with('error', 'Ви ще не створили профіль лікаря!');
        }

        return $doctor;
    }

    public function editPersonalData()
    {
        $doctor = $this->getDoctor(); 
        return view('doctor-activation.personal', compact('doctor'));
    }

    public function updatePersonalData(Request $request)
    {
        $user = Auth::user();
    
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'bio'        => 'nullable|string',
            'gender'     => 'nullable|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'country_of_residence' => 'required|string|max:255',
            'city_of_residence'    => 'required|string|max:255',
            'contact'    => 'nullable|string|max:255',
            'workplace'  => 'nullable|string|max:255',
            'position'   => 'nullable|string|max:255',
            'time_zone'  => 'required|integer',
        ]);
    
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('doctors');
        }
    
        $user->doctor()->updateOrCreate(
            ['user_id' => $user->id], 
            $data
        );
    
        return redirect()->route('activation.specialties');
    }
    

    public function editSpecialties()
    {
        $specialties = Specialty::all();
        $doctor = $this->getDoctor(); 
        return view('doctor-activation.specialties', compact('specialties', 'doctor'));
    }

    public function updateSpecialties(Request $request)
    {
        $doctor = $this->getDoctor(); 
        
        $request->validate([
            'specialties.*.specialty_id' => 'required|exists:specialties,id',
            'specialties.*.experience' => 'required|string|max:255',
            'specialties.*.price' => 'required|numeric|min:0',
        ]);
        
        $specialties = collect($request->input('specialties', []))
            ->mapWithKeys(fn($spec) => [
                $spec['specialty_id'] => [
                    'experience' => $spec['experience'],
                    'price' => $spec['price'],
                ]
            ]);

        $doctor->specialties()->sync($specialties);
        
        return redirect()->route('activation.education');
    }

    public function editEducation()
    {
        $doctor = $this->getDoctor();
        return view('doctor-activation.education', compact('doctor'));
    }

    public function updateEducation(EducationRequest $request)
    {
        $data = $request->validated(); 
    
        $data['doctor_id'] = auth()->user()->doctor->id;
    
        foreach (['diploma_photo_1', 'diploma_photo_2', 'diploma_photo_3'] as $key) {
            if ($request->hasFile($key)) {
                $data[$key] = $request->file($key)->store('diplomas');
            }
        }

        if (!isset($data['institution'])) {
            dd('institution missing', $data);
        }
    
        Education::create($data);
    
        return redirect()->route('doctor.office')->with('success', 'Освіта збережена');
    }
    
    
    public function showDoctorDashboard()
    {
        $user = auth()->user();
    
        if (is_null($user->doctor)) {
            return redirect()->route('activation.personal'); 
        }
    
        if (is_null($user->first_name) || is_null($user->last_name) || is_null($user->country_of_residence)) {
            return redirect()->route('activation.personal'); 
        }
    
        if ($user->specialties->isEmpty()) {
            return redirect()->route('activation.specialties');
        }
    
        if ($user->educations->isEmpty()) {
            return redirect()->route('activation.education');
        }
    
        return view('office-doctor.doctor-office', compact('user'));
    }
}
