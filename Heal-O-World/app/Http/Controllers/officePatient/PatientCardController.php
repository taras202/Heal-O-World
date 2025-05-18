<?php

namespace App\Http\Controllers\officePatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientCardRequest;
use App\Models\PatientCard;
use App\Models\Diagnosis;
use App\Models\ListAllergicReaction;
use App\Models\ListChronicDisease;
use App\Models\ListDiagnosis;
use App\Models\ListOfDisease;

class PatientCardController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;
    
        if (!$patient) {
            return redirect()->route('home')->with('error', 'Пацієнт не знайдений');
        }
    
        $patientCard = PatientCard::where('patient_id', $patient->id)->first() ?? null;
    
        $lists = [
            'allergic_reactions' => ListAllergicReaction::all(),
            'chronic_diseases' => ListChronicDisease::all(),
            'diseases' => ListOfDisease::all(),
            'diagnoses' => ListDiagnosis::all(),
        ];
    
        $sections = [
            'allergic_reactions' => 'Алергічні реакції',
            'chronic_diseases' => 'Хронічні захворювання',
            'diseases' => 'Захворювання',
            'diagnoses' => 'Діагнози',
        ];
    
        return view('office-patient.patient-card.index', compact('patient', 'patientCard', 'lists', 'sections'));
    }    

    public function store(PatientCardRequest $request)
    {
        $validated = $request->validated();

        $patientCard = PatientCard::create([
            'patient_id' => $validated['patient_id'],
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        $this->storeRelations($patientCard, $validated);

        return redirect()->route('patient-cards.show', $patientCard->id)
            ->with('success', 'Пацієнтську карту створено успішно.');
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

        $patientCard->diagnoses()->delete();
        $patientCard->chronicDiseases()->delete();
        $patientCard->diseases()->delete();
        $patientCard->allergicReactions()->delete();

        $this->storeRelations($patientCard, $validated);

        return redirect()->route('patient-cards.show', $patientCard->id)
            ->with('success', 'Пацієнтську карту оновлено успішно.');
    }

    private function storeRelations(PatientCard $patientCard, array $validated)
    {
        if (!empty($validated['diagnoses'])) {
            foreach ($validated['diagnoses'] as $item) {
                $patientCard->diagnoses()->create([
                    'list_diagnoses_id' => $item['list_diagnoses_id'],
                ]);                
            }
        }

        if (!empty($validated['chronic_diseases'])) {
            foreach ($validated['chronic_diseases'] as $item) {
                $patientCard->chronicDiseases()->create([
                    'list_chronic_diseases_id' => $item['list_chronic_diseases_id'],
                ]);
            }
        }

        if (!empty($validated['diseases'])) {
            foreach ($validated['diseases'] as $item) {
                $patientCard->diseases()->create([
                    'list_of_diseases_id' => $item['list_of_diseases_id'],
                ]);
            }
        }

        if (!empty($validated['allergic_reactions'])) {
            foreach ($validated['allergic_reactions'] as $item) {
                $patientCard->allergicReactions()->create([
                    'list_allergic_reactions_id' => $item['list_allergic_reactions_id'],
                ]);
            }
        }
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

    public function edit($id)
    {
        $patientCard = PatientCard::with([
            'diagnoses',
            'chronicDiseases',
            'diseases',
            'allergicReactions',
        ])->findOrFail($id);
    
        $patient = $patientCard->patient;
    
        $lists = [
            'allergic_reactions' => ListAllergicReaction::all(),
            'chronic_diseases' => ListChronicDisease::all(),
            'diseases' => ListOfDisease::all(),
            'diagnoses' => ListDiagnosis::all(),
        ];
    
        $sections = [
            'allergic_reactions' => 'Алергічні реакції',
            'chronic_diseases' => 'Хронічні захворювання',
            'diseases' => 'Захворювання',
            'diagnoses' => 'Діагнози',
        ];
    
        return view('office-patient.patient-card.index', compact('patient', 'patientCard', 'lists', 'sections'));
    }    

    public function destroy($id)
    {
        $patientCard = PatientCard::findOrFail($id);

        $patientCard->diagnoses()->delete();
        $patientCard->chronicDiseases()->delete();
        $patientCard->diseases()->delete();
        $patientCard->allergicReactions()->delete();

        $patientCard->delete();

        return response()->json(['message' => 'Пацієнтську карту та пов’язані дані видалено.']);
    }
}
