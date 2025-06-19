<?php

namespace App\Http\Controllers\officePatient\chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientChatController extends Controller
{
    public function index()
    {
        $patientId = auth()->user()->patient->id ?? null;
        $chats = Chat::where('patient_id', $patientId)
            ->with('doctor.user')
            ->get();

        return view('office-patient.chat.patient-chat', compact('chats')); 
    }

    public function show(Chat $chat)
    {
        abort_unless($chat->doctor_id === auth()->id() || $chat->patient_id === auth()->user()->patient?->id, 403);

        if (auth()->user()->isDoctor()) {
            return view('chat.doctor.show', compact('chat'));
        } elseif (auth()->user()->isPatient()) {
            return view('chat.patient.show', compact('chat'));
        } else {
            abort(403, 'Невідома роль користувача');
        }
    }
    
    public function sendMessage(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        if ($chat->patient_id !== Auth::user()->patient->id) {
            abort(403, 'Доступ заборонено');
        }

        $chat->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('chat.show', $chat->id)->with('success', 'Повідомлення надіслано!');
    }
}
