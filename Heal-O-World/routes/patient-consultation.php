<?php

use App\Http\Controllers\officePatient\MyConsultationController;
use Illuminate\Support\Facades\Route;

Route::name('patient.consultations.')->group(function () {
    Route::get('/consultations', [MyConsultationController::class, 'index'])->name('index');
    Route::get('/consultations/{id}', [MyConsultationController::class, 'show'])->name('show');
    Route::post('/consultations/{id}/cancel', [MyConsultationController::class, 'cancelConsultation'])->name('cancel');
});
