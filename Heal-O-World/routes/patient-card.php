<?php

use App\Http\Controllers\officePatient\PatientCardController;
use Illuminate\Support\Facades\Route;

Route::get('/patient-cards', [PatientCardController::class, 'index'])->name('patient-cards.index');

Route::post('/patient-cards', [PatientCardController::class, 'store'])->name('patient-cards.store');

Route::get('/patient-cards/{id}', [PatientCardController::class, 'show'])->name('patient-cards.show');

Route::put('/patient-cards/{id}', [PatientCardController::class, 'update'])->name('patient-cards.update');

Route::delete('/patient-cards/{id}', [PatientCardController::class, 'destroy'])->name('patient-cards.destroy');
