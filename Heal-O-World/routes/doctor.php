<?php

use App\Http\Controllers\Api\SpecialtyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;

    Route::prefix('doctor')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/doctors/filter', [DoctorController::class, 'filter'])->name('doctors.filter'); 
    Route::get('/search-doctors', [DoctorController::class, 'search'])->name('doctor.search');
    Route::get('/search-by-specialty', [DoctorController::class, 'searchBySpecialty']);
    Route::get('/{id}', [DoctorController::class, 'show'])->where('id', '[0-9]+')->name('doctor.show');
});

    Route::get('/api/specialties', [SpecialtyController::class, 'index']);
