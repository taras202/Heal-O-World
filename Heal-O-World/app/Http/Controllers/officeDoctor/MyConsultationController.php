<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class MyConsultationController extends Controller
{
    public function edit($id)
    {
        $consultation = Consultation::with('patient')->findOrFail($id);

        return view('office-doctor.consultation.consultation-edit', compact('consultation'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $consultation = Consultation::findOrFail($id);
        $consultation->update($request->only('status', 'diagnosis', 'prescription', 'treatment', 'notes'));

        return redirect()->route('doctor.consultation.edit', $consultation->id)->with('success', 'Консультацію оновлено.');
    }
}