<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\MyOfficeDoctorRequest;
use App\Models\Education;
use App\Models\Language;
use App\Models\MyOfficeDoctor;
use App\Models\Specialty;
use App\Models\TimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    
        $availableLanguages = Language::pluck('name', 'code')->toArray();
    
        $selectedLanguages = $doctor->languages()->pluck('code')->toArray();
    
        return view('doctor.doctor-activation.personal', compact('doctor', 'timeZones', 'availableLanguages', 'selectedLanguages'));
    }    

    public function updatePersonalData(MyOfficeDoctorRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        $request->validate([
            'languages' => 'nullable|array',
            'languages.*' => 'in:uk,ru,en',
        ]);

        $doctor = MyOfficeDoctor::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        if ($request->hasFile('photo')) {
            if ($doctor->photo && Storage::disk('public')->exists($doctor->photo)) {
                Storage::disk('public')->delete($doctor->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $doctor->update(['photo' => $path]);
        }

        if ($request->filled('languages')) {
            $languageCodes = $request->input('languages');
            $languageIds = Language::whereIn('code', $languageCodes)->pluck('id')->toArray();
            $doctor->languages()->sync($languageIds);
        } else {
            $doctor->languages()->detach();
        }

        if ($request->filled(['workplace', 'position', 'country_of_residence', 'city_of_residence'])) {
            $doctor->placeOfWork()->updateOrCreate(
                ['doctor_id' => $doctor->id],
                [
                    'workplace' => $request->input('workplace'),
                    'position' => $request->input('position'),
                    'country_of_residence' => $request->input('country_of_residence'),
                    'city_of_residence' => $request->input('city_of_residence'),
                ]
            );
        } else {
            if ($doctor->placeOfWork) {
                $doctor->placeOfWork()->delete();
            }
        }

        return redirect()->route('activation.specialties')->with('success', 'Персональні дані збережено');
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
            'specialties' => 'required|array',
            'specialties.*.specialty_id' => 'required|exists:specialties,id',
            'specialties.*.experience' => 'required|string|max:255',
            'specialties.*.price' => 'required|numeric|min:0',
        ]);

        $specialties = collect($request->input('specialties'))
            ->mapWithKeys(fn($spec) => [
                $spec['specialty_id'] => [
                    'experience' => $spec['experience'],
                    'price' => $spec['price'],
                ]
            ])->toArray();

        $doctor->specialties()->sync($specialties);

        return redirect()->route('activation.education')->with('success', 'Спеціальності збережено');
    }

    public function editEducation()
    {
        $doctor = $this->getDoctor();

        return view('doctor.doctor-activation.education', compact('doctor'));
    }

    public function updateEducation(EducationRequest $request)
    {
        $data = $request->validated();

        $doctor = $this->getDoctor();
        $data['doctor_id'] = $doctor->id;

        foreach ([1, 2, 3] as $index) {
        $key = "diploma_photo_$index";
        if ($request->hasFile($key)) {
            $data[$key] = $request->file($key)->store("diploma_photos_$index", 'public');
        }
        }

        $education = Education::updateOrCreate(
            ['doctor_id' => $doctor->id],
            $data
        );

        return redirect()->route('doctor.office')->with('success', 'Освіта збережена');
    }


    public function showDoctorDashboard()
    {
        $user = auth()->user();

        if (is_null($user->doctor)) {
            return redirect()->route('activation.personal');
        }

        if (is_null($user->doctor->first_name) || is_null($user->doctor->last_name) || is_null($user->doctor->contact)) {
            return redirect()->route('activation.personal');
        }

        if ($user->doctor->specialties->isEmpty()) {
            return redirect()->route('activation.specialties');
        }

        if ($user->doctor->educations->isEmpty()) {
            return redirect()->route('activation.education');
        }

        return view('doctor.office-doctor.doctor-office', compact('user'));
    }
}
