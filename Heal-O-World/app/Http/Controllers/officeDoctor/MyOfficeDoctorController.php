<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\MyOfficeDoctorRequest;
use App\Models\DoctorLanguage;
use App\Models\Education;
use App\Models\MyOfficeDoctor;
use App\Models\PlaceOfWork;
use App\Models\TimeZone;
use Google\Service\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyOfficeDoctorController extends Controller
{
    public function index()
    {  
        $user = Auth::user();

        $doctor = MyOfficeDoctor::with([
            'specialties', 
            'educations', 
            'placeOfWork', 
            'languages'
        ])
        ->where('user_id', $user->id)
        ->first();

        if (!$doctor) {
            abort(404, 'Доктор не знайдений');
        }

        $photoUrl = $doctor->photo ? asset('storage/' . $doctor->photo) : null;
        $timeZones = TimeZone::all();
        $languages = DoctorLanguage::all();

        return view('doctor.office-doctor.doctor-office', [
            'user' => $user,
            'doctor' => $doctor,
            'photoUrl' => $photoUrl,
            'timeZones' => $timeZones,
            'languages' => $languages,
        ]);
    }

    public function update(MyOfficeDoctorRequest $request)
    {
        $user = Auth::user();
        $doctor = MyOfficeDoctor::where('user_id', $user->id)->firstOrFail();
    
        $doctor->update($request->only([
            'first_name',
            'last_name',
            'bio',
            'gender',
            'contact',
        ]));
    
        if ($request->hasFile('photo')) {
            if ($doctor->photo && Storage::disk('public')->exists($doctor->photo)) {
                Storage::disk('public')->delete($doctor->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $doctor->update(['photo' => $path]);
        }
    
        if ($request->filled('language')) {
            $languages = collect($request->input('language'))->map(fn($lang) => ['language' => $lang])->toArray();
            $doctor->languages()->delete();
            $doctor->languages()->createMany($languages);
        } else {
            $doctor->languages()->delete();
        }
    
        if ($request->filled('specialties') && $request->filled('specialty_data')) {
            $specialties = $request->input('specialties');
            $specialtyData = $request->input('specialty_data');
    
            foreach ($specialties as $index => $specialtyId) {
                if ($doctor->specialties->contains($specialtyId)) {
                    $experience = $specialtyData[$index]['experience'] ?? null;
                    $price = $specialtyData[$index]['price'] ?? null;
    
                    $doctor->specialties()->updateExistingPivot($specialtyId, [
                        'experience' => $experience,
                        'price' => $price,
                    ]);
                }
            }
        }
    
        if ($request->filled('educations')) {
            foreach ($request->input('educations') as $eduData) {
                if (!empty($eduData['id'])) {
                    $education = Education::where('id', $eduData['id'])
                        ->where('doctor_id', $doctor->id)
                        ->first();
                    if ($education) {
                        $education->update([
                            'institution' => $eduData['institution'] ?? $education->institution,
                            'degree' => $eduData['degree'] ?? $education->degree,
                            'start_year' => $eduData['start_year'] ?? $education->start_year,
                            'end_year' => $eduData['end_year'] ?? $education->end_year,
                        ]);
                    }
                }
            }
        }
    
        $placeData = $request->input('place_of_work', []);
        if (!empty($placeData)) {
            $place = $doctor->placeOfWork ?: new PlaceOfWork(['doctor_id' => $doctor->id]);
            $place->fill($placeData);
            $place->doctor_id = $doctor->id;
            $place->save();
        } else {
            if ($doctor->placeOfWork) {
                $doctor->placeOfWork()->delete();
            }
        }
    
        return redirect()->back()->with('success', 'Профіль оновлено успішно.');
    }
}
