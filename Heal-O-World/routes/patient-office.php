<?php

use App\Http\Controllers\officePatient\MyConsultationController;
use App\Http\Controllers\officePatient\MyOfficePatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/patient/office', [MyOfficePatientController::class, 'index'])->name('patient.office');

    Route::post('/patient/store', [MyOfficePatientController::class, 'store'])->name('patient.store');
    Route::put('/patient/update', [MyOfficePatientController::class, 'update'])->name('patient.update');

    Route::post('/patient/update-phone', [MyOfficePatientController::class, 'updatePhone']);
    Route::post('/patient/update-email', [MyOfficePatientController::class, 'updateEmail']);

    Route::get('/office/consultations', [MyConsultationController::class, 'myConsultations'])->name('patient.office.consultations');
    Route::get('/office/consultations/{id}', [MyConsultationController::class, 'showConsultation'])->name('consultation.view');
    Route::post('/office/consultations/{id}/cancel', [MyConsultationController::class, 'cancelConsultation'])->name('consultation.cancel');
});
