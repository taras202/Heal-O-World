<?php

use App\Http\Controllers\officePatient\MyOfficePatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/patient/office', [MyOfficePatientController::class, 'index'])->name('patient.office');

    Route::post('/patient/store', [MyOfficePatientController::class, 'store'])->name('patient.store');
    Route::put('/patient/update', [MyOfficePatientController::class, 'update'])->name('patient.update');

    Route::post('/patient/update-phone', [MyOfficePatientController::class, 'updatePhone']);
    Route::post('/patient/update-email', [MyOfficePatientController::class, 'updateEmail']);
});