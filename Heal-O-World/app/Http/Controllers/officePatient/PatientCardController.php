<?php

namespace App\Http\Controllers\officePatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientCardRequest;
use App\Models\PatientCard;
use App\Http\Requests\StorePatientCardRequest; // Додано використання запиту

class PatientCardController extends Controller
{
    // Отримати всі картки пацієнтів з діагнозами, хронічними захворюваннями, захворюваннями та алергічними реакціями
    public function index()
    {
        $patientCards = PatientCard::with([
            'patient', 
            'diagnoses', 
            'chronicDiseases', 
            'diseases', 
            'allergicReactions'
        ])->get();

        return response()->json($patientCards);
    }

    // Створити нову картку пацієнта з діагнозами, хронічними захворюваннями, захворюваннями, алергічними реакціями
    public function store(PatientCardRequest $request) // Замінили тут
    {
        $validated = $request->validated(); // Використовуємо валідацію з FormRequest

        // Створити картку пацієнта
        $patientCard = PatientCard::create($validated);

        // Додати діагнози
        if ($request->has('diagnoses')) {
            foreach ($validated['diagnoses'] as $diagnosis) {
                $patientCard->diagnoses()->create([
                    'title' => $diagnosis['title'],
                ]);
            }
        }

        // Додати хронічні захворювання
        if ($request->has('chronic_diseases')) {
            foreach ($validated['chronic_diseases'] as $chronicDisease) {
                $patientCard->chronicDiseases()->create([
                    'title' => $chronicDisease['title'],
                ]);
            }
        }

        // Додати захворювання
        if ($request->has('diseases')) {
            foreach ($validated['diseases'] as $disease) {
                $patientCard->diseases()->create([
                    'title' => $disease['title'],
                ]);
            }
        }

        // Додати алергічні реакції
        if ($request->has('allergic_reactions')) {
            foreach ($validated['allergic_reactions'] as $reaction) {
                $patientCard->allergicReactions()->create([
                    'title' => $reaction['title'],
                ]);
            }
        }

        return response()->json($patientCard, 201);
    }

    // Отримати конкретну картку пацієнта з усіма даними
    public function show($id)
    {
        $patientCard = PatientCard::with([
            'patient',
            'diagnoses',
            'chronicDiseases',
            'diseases',
            'allergicReactions',
        ])->findOrFail($id);

        return response()->json($patientCard);
    }

    // Оновити картку пацієнта та пов'язані дані
    public function update(StorePatientCardRequest $request, $id) // Замінили тут
    {
        $patientCard = PatientCard::findOrFail($id);

        $validated = $request->validated(); // Використовуємо валідацію з FormRequest

        // Оновити дані картки пацієнта
        $patientCard->update($validated);

        // Оновити діагнози
        if ($request->has('diagnoses')) {
            $patientCard->diagnoses()->delete();
            foreach ($validated['diagnoses'] as $diagnosis) {
                $patientCard->diagnoses()->create([
                    'title' => $diagnosis['title'],
                ]);
            }
        }

        // Оновити хронічні захворювання
        if ($request->has('chronic_diseases')) {
            $patientCard->chronicDiseases()->delete();
            foreach ($validated['chronic_diseases'] as $chronicDisease) {
                $patientCard->chronicDiseases()->create([
                    'title' => $chronicDisease['title'],
                ]);
            }
        }

        // Оновити захворювання
        if ($request->has('diseases')) {
            $patientCard->diseases()->delete();
            foreach ($validated['diseases'] as $disease) {
                $patientCard->diseases()->create([
                    'title' => $disease['title'],
                ]);
            }
        }

        // Оновити алергічні реакції
        if ($request->has('allergic_reactions')) {
            $patientCard->allergicReactions()->delete();
            foreach ($validated['allergic_reactions'] as $reaction) {
                $patientCard->allergicReactions()->create([
                    'title' => $reaction['title'],
                ]);
            }
        }

        return response()->json($patientCard);
    }

    // Видалити картку пацієнта разом з усіма даними
    public function destroy($id)
    {
        $patientCard = PatientCard::findOrFail($id);

        // Видалити всі пов'язані записи
        $patientCard->diagnoses()->delete();
        $patientCard->chronicDiseases()->delete();
        $patientCard->diseases()->delete();
        $patientCard->allergicReactions()->delete();

        // Видалити саму картку пацієнта
        $patientCard->delete();

        return response()->json(['message' => 'Patient card and related data deleted successfully']);
    }
}
