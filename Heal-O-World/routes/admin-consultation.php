<?php

use App\Http\Controllers\admin\consultation\ConsultationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultation.index');
        Route::get('/consultations/{id}', [ConsultationController::class, 'show'])->name('consultation.show');
    });
});
