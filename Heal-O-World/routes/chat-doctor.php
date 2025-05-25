<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\officeDoctor\chat\DoctorChatController;


Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/my/chat', [DoctorChatController::class, 'index'])->name('doctor.chat');
    Route::get('/doctor/chat/{chat}', [DoctorChatController::class, 'show'])->name('chat.show');
    Route::post('/doctor/chat/{chat}/send', [DoctorChatController::class, 'sendMessage'])->name('doctor.chat.send');
});

