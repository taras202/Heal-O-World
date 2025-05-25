<?php

namespace App\Http\Controllers\officeDoctor\chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorChatController extends Controller
{
    public function index()
    {
        $doctorId = auth()->user()->doctor->id ?? null;
        $chats = Chat::where('doctor_id', $doctorId)
            ->with('patient.user')
            ->get();

        return view('doctor.chat.doctor-chat', compact('chats')); 
    }

    public function show(Chat $chat)
    {
        abort_unless($chat->doctor_id === auth()->id() || $chat->patient_id === auth()->user()->patient?->id, 403);

        if (auth()->user()->isDoctor()) {
            return view('doctor.chat.show', compact('chat'));
        } elseif (auth()->user()->isPatient()) {
            return view('office-patient.chat.show', compact('chat'));
        } else {
            abort(403, 'Невідома роль користувача');
        }
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        if ($chat->doctor_id !== auth()->id()) {
            abort(403, 'Доступ заборонено');
        }

        $chat->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('chat.show', $chat->id)->with('success', 'Повідомлення надіслано!');
    }
}
