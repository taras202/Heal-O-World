<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;

    Route::prefix('doctor')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/{id}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::get('/doctors/filter', [DoctorController::class, 'filter'])->name('doctors.filter'); 
    });
