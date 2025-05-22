<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\MyOfficeDoctorRequest;
use App\Models\Education;
use App\Models\MyOfficeDoctor;
use App\Models\Specialty;
use App\Models\TimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorActivationController extends Controller
{
    private function getDoctor()
    {
        return Auth::user()->doctor;
    }

    public function editPersonalData()
    {
        $doctor = $this->getDoctor();
    
        if (!$doctor) {
            $doctor = new MyOfficeDoctor();
        }
    
        $timeZones = TimeZone::all();
    
        return view('doctor.doctor-activation.personal', compact('doctor', 'timeZones'));
    }

    public function updatePersonalData(MyOfficeDoctorRequest $request)
    {
        $user = Auth::user();
        
        $data = $request->validated(); 
    
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path; 
        }
    
        $doctor = $user->doctor()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );
    
        if ($request->has(['workplace', 'position', 'country_of_residence', 'city_of_residence'])) {
            $doctor->placeOfWork()->updateOrCreate(
                ['doctor_id' => $doctor->id], 
                [
                    'workplace' => $request->input('workplace'),
                    'position' => $request->input('position'),
                    'country_of_residence' => $request->input('country_of_residence'),
                    'city_of_residence' => $request->input('city_of_residence'),
                ]
            );
        }
    
        return redirect()->route('activation.specialties');
    }
    
    public function editSpecialties()
    {
        $specialties = Specialty::all();
        $doctor = $this->getDoctor(); 
        return view('doctor.doctor-activation.specialties', compact('specialties', 'doctor'));
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
        return view('doctor.doctor-activation.education', compact('doctor'));
    }

    public function updateEducation(EducationRequest $request)
    {
        $data = $request->validated(); 
    
        $data['doctor_id'] = auth()->user()->doctor->id;
    
        if ($request->hasFile('diploma_photo_1')) {
            $path = $request->file('diploma_photo_1')->store('diploma_photos_1', 'public');
            $validated['diploma_photo_1'] = $path;
        }
        if ($request->hasFile('diploma_photo_2')) {
            $path = $request->file('diploma_photo_2')->store('diploma_photos_2', 'public');
            $validated['diploma_photo_2'] = $path;
        }
        if ($request->hasFile('diploma_photo_3')) {
            $path = $request->file('diploma_photo_3')->store('diploma_photos_3', 'public');
            $validated['diploma_photo_3'] = $path;
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
    
        return view('doctor.office-doctor.doctor-office', compact('user'));
    }
}
