<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\MyOfficeDoctor;
use App\Models\PlaceOfWork;
use App\Models\TimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyOfficeDoctorController extends Controller
{
    public function index()
    {  
        $user = Auth::user();
        $doctor = MyOfficeDoctor::with(['specialties', 'educations', 'placeOfWork'])
                    ->where('user_id', $user->id)
                    ->first();
        
        $photoUrl = $doctor->photo ? asset('storage/' . $doctor->photo) : null;

        $timeZones = TimeZone::all();

        return view('doctor.office-doctor.doctor-office', [
            'user' => $user,
            'doctor' => $doctor,
            'photoUrl' => $photoUrl,
            'timeZones' => $timeZones,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $doctor = MyOfficeDoctor::where('user_id', $user->id)->firstOrFail();
    
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'time_zone_id' => 'nullable|exists:time_zones,id',
        ]);
        
        $doctor->update($request->only([
            'first_name',
            'last_name',
            'bio',
            'gender',
            'contact',
            'time_zone_id',  
        ]));
        
    
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photo', 'public');
            $doctor->photo = $path;
            $doctor->save();
        }
    
        if ($request->has('specialties') && $request->has('specialty_data')) {
            $specialties = $request->input('specialties'); 
            $specialtyData = $request->input('specialty_data'); 
        
            foreach ($specialties as $index => $specialtyId) {
                $experience = $specialtyData[$index]['experience'] ?? null;
                $price = $specialtyData[$index]['price'] ?? null;
        
                $doctor->specialties()->updateExistingPivot($specialtyId, [
                    'experience' => $experience,
                    'price' => $price,
                ]);
            }
        }        
    
        if ($request->has('educations')) {
            foreach ($request->input('educations') as $eduData) {
                if (isset($eduData['id'])) {
                    $education = Education::where('id', $eduData['id'])->where('doctor_id', $doctor->id)->first();
                    if ($education) {
                        $education->update([
                            'institution' => $eduData['institution'] ?? '',
                            'degree' => $eduData['degree'] ?? '',
                            'start_year' => $eduData['start_year'] ?? '',
                            'end_year' => $eduData['end_year'] ?? '',
                        ]);
                    }
                }
            }
        }
    
        $place = $doctor->placeOfWork;
        if (!$place) {
            $place = new PlaceOfWork(['doctor_id' => $doctor->id]);
        }
    
        $place->fill($request->input('place_of_work', []));
        $place->doctor_id = $doctor->id;
        $place->save();
    
        return redirect()->back()->with('success', 'Профіль оновлено успішно.');
    }    
}
