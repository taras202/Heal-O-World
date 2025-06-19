<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\officePatient\chat\PatientChatController;

Route::middleware(['auth'])->group(function () {
    Route::get('/patient/chat', [PatientChatController::class, 'index'])->name('patient.chat');
    Route::get('/patient/chat/{chat}', [PatientChatController::class, 'show'])->name('chat.show');
    Route::post('/patient/chat/{chat}/send', [PatientChatController::class, 'sendMessage'])->name('patient.chat.send');
});
