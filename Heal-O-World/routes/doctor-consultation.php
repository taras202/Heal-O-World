<?php

use App\Http\Controllers\officeDoctor\consultation\MyConsultationController;
use Illuminate\Support\Facades\Route;

Route::name('doctor.consultations.')->group(function () {
    Route::get('/doctor/my/consultations', [MyConsultationController::class, 'index'])->name('index');
    Route::get('/doctor/consultations/{id}', [MyConsultationController::class, 'show'])->name('show');
    Route::get('/doctor/consultations/create', [MyConsultationController::class, 'create'])->name('create');
    Route::post('/doctor/consultations', [MyConsultationController::class, 'store'])->name('store');
    Route::get('/doctor/consultations/{id}/edit', [MyConsultationController::class, 'edit'])->name('edit');
    Route::put('/doctor/consultations/{id}', [MyConsultationController::class, 'update'])->name('update');
    Route::post('/doctor/consultations/{id}/complete', [MyConsultationController::class, 'completeConsultation'])->name('complete');
    Route::post('/doctor/consultations/{id}/cancel', [MyConsultationController::class, 'cancelConsultation'])->name('cancel');
});
