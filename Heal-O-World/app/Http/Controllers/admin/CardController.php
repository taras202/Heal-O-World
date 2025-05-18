<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientCard;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function show($id)
    {
        $patientCard = PatientCard::with([
            'patient',
            'diagnoses',
            'chronicDiseases',
            'diseases',
            'allergicReactions',
        ])->findOrFail($id);

        return view('admin.patient.card.show', compact('patientCard'));
    }
}