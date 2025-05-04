<?php

use App\Http\Controllers\admin\DoctorAdminController;
use App\Http\Controllers\admin\DoctorAnalyticsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/doctors', [DoctorAdminController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/create', [DoctorAdminController::class, 'create'])->name('doctors.create');
    Route::post('/doctors', [DoctorAdminController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{doctor}', [DoctorAdminController::class, 'show'])->name('doctors.show');
    Route::get('/doctors/{doctor}/edit', [DoctorAdminController::class, 'edit'])->name('doctors.edit');
    Route::put('/doctors/{doctor}', [DoctorAdminController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorAdminController::class, 'destroy'])->name('doctors.destroy');
    Route::get('/doctors-analytics', [DoctorAnalyticsController::class, 'index'])->name('doctors.analytics');
});

