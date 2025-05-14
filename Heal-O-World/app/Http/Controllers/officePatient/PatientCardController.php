<?php

namespace App\Http\Controllers\officePatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientCardRequest;
use App\Models\PatientCard;
use App\Models\Diagnosis;
use App\Models\ListAllergicReaction;
use App\Models\ListChronicDisease;
use App\Models\ListOfDisease;

class PatientCardController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            return redirect()->route('home')->with('error', 'Пацієнт не знайдений');
        }

        $patientCard = PatientCard::where('patient_id', $patient->id)->first();

        if (!$patientCard) {
            $patientCard = new PatientCard(); 
        }

        $lists = [
            'allergic_reactions' => ListAllergicReaction::all(),
            'chronic_diseases' => ListChronicDisease::all(),
            'diseases' => ListOfDisease::all(),
            'diagnoses' => Diagnosis::all(),
        ];

        if (!$patient) {
            return view('office-patient.patient-card.index')->with('error', 'Пацієнт не знайдений');
        }

        return view('office-patient.patient-card.index', compact('patient', 'patientCard', 'lists'));
    }

    public function store(PatientCardRequest $request) 
    {
        $validated = $request->validated();

        $validated['height'] = $validated['height'] ?? null; 
        $validated['weight'] = $validated['weight'] ?? null; 

        $patientCard = PatientCard::create($validated);

        if ($request->has('diagnoses')) {
            foreach ($validated['diagnoses'] as $diagnosis) {
                $patientCard->diagnoses()->create([
                    'title' => $diagnosis['title'],
                ]);
            }
        }

        if ($request->has('chronic_diseases')) {
            foreach ($validated['chronic_diseases'] as $chronicDisease) {
                $patientCard->chronicDiseases()->create([
                    'title' => $chronicDisease['title'],
                ]);
            }
        }

        if ($request->has('diseases')) {
            foreach ($validated['diseases'] as $disease) {
                $patientCard->diseases()->create([
                    'title' => $disease['title'],
                ]);
            }
        }

        if ($request->has('allergic_reactions')) {
            foreach ($validated['allergic_reactions'] as $reaction) {
                $patientCard->allergicReactions()->create([
                    'title' => $reaction['title'],
                ]);
            }
        }

        return redirect()->route('patient-cards.show', $patientCard->id);
    }

    public function show($id)
    {
        $patientCard = PatientCard::with([
            'patient',  
            'diagnoses',
            'chronicDiseases',
            'diseases',
            'allergicReactions',
        ])->findOrFail($id);   

        return view('office-patient.patient-card.show', compact('patientCard'));   
    }


    public function update(PatientCardRequest $request, $id) 
    {
        $patientCard = PatientCard::findOrFail($id);
        $validated = $request->validated(); 

        $patientCard->update([
            'height' => $validated['height'] ?? null, 
            'weight' => $validated['weight'] ?? null,  
            'notes' => $validated['notes'] ?? null,    
        ]);

        if ($request->has('diagnoses')) {
            $patientCard->diagnoses()->delete();  
            foreach ($validated['diagnoses'] as $diagnosis) {
                $patientCard->diagnoses()->create([
                    'title' => $diagnosis['title'],
                ]);
            }
        }

        if ($request->has('chronic_diseases')) {
            $patientCard->chronicDiseases()->delete();  
            foreach ($validated['chronic_diseases'] as $chronicDisease) {
                $patientCard->chronicDiseases()->create([
                    'title' => $chronicDisease['title'],
                ]);
            }
        }

        if ($request->has('diseases')) {
            $patientCard->diseases()->delete();  
            foreach ($validated['diseases'] as $disease) {
                $patientCard->diseases()->create([
                    'title' => $disease['title'],
                ]);
            }
        }

        if ($request->has('allergic_reactions')) {
            $patientCard->allergicReactions()->delete();  
            foreach ($validated['allergic_reactions'] as $reaction) {
                $patientCard->allergicReactions()->create([
                    'title' => $reaction['title'],
                ]);
            }
        }

        return redirect()->route('patient-cards.show', $patientCard->id);
    }

    public function edit($id)
    {
        $patientCard = PatientCard::with([
            'diagnoses',
            'chronicDiseases',
            'diseases',
            'allergicReactions',
        ])->findOrFail($id);

        $lists = [
            'allergic_reactions' => ListAllergicReaction::all(),  
            'chronic_diseases' => ListChronicDisease::all(),      
            'diseases' => ListOfDisease::all(),                     
            'diagnoses' => Diagnosis::all(),                  
        ];

        return view('office-patient.patient-card.edit', compact('patientCard', 'lists'));
    }


    public function destroy($id)
    {
        $patientCard = PatientCard::findOrFail($id);

        $patientCard->diagnoses()->delete();
        $patientCard->chronicDiseases()->delete();
        $patientCard->diseases()->delete();
        $patientCard->allergicReactions()->delete();

        $patientCard->delete();

        return response()->json(['message' => 'Patient card and related data deleted successfully']);
    }
}
