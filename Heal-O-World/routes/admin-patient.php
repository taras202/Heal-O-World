<?php

use App\Http\Controllers\PatientAdminController;
use App\Http\Controllers\Admin\PatientAnalyticsController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/patients', [PatientAdminController::class, 'index'])->name('patients.index');

    Route::get('/patients/create', [PatientAdminController::class, 'create'])->name('patients.create');

    Route::post('/patients', [PatientAdminController::class, 'store'])->name('patients.store');

    Route::get('/patients/{patient}', [PatientAdminController::class, 'show'])->name('patients.show');

    Route::get('/patients/{patient}/edit', [PatientAdminController::class, 'edit'])->name('patients.edit');

    Route::put('/patients/{patient}', [PatientAdminController::class, 'update'])->name('patients.update');

    Route::delete('/patients/{patient}', [PatientAdminController::class, 'destroy'])->name('patients.destroy');

    Route::get('admin/analytics', [PatientAnalyticsController::class, 'showAnalytics'])->name('admin.analytics');

});

