<?php

use App\Http\Controllers\officeDoctor\DoctorActivationController;
use App\Http\Controllers\officeDoctor\MyOfficeDoctorController;
use App\Http\Controllers\officeDoctor\ProgressBarController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/my/office', [MyOfficeDoctorController::class, 'index'])->name('doctor.office');
    Route::put('/doctor/profile/update', [MyOfficeDoctorController::class, 'update'])->name('doctor.profile.update');


    Route::get('/activation/personal-data', [DoctorActivationController::class, 'editPersonalData'])->name('activation.personal');
    Route::post('/activation/personal-data', [DoctorActivationController::class, 'updatePersonalData']);

    Route::get('/activation/specialties', [DoctorActivationController::class, 'editSpecialties'])->name('activation.specialties');
    Route::post('/activation/specialties', [DoctorActivationController::class, 'updateSpecialties']);

    Route::get('/activation/education', [DoctorActivationController::class, 'editEducation'])->name('activation.education');
    Route::post('/activation/education', [DoctorActivationController::class, 'updateEducation']);

    Route::get('/activation/step/{step}', [ProgressBarController::class, 'step'])->name('activation.step');
});
