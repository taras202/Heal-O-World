<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\RoleSelectionController;
use App\Http\Controllers\auth\PatientRedirectController;
use App\Http\Controllers\auth\DoctorRedirectController;
use Illuminate\Support\Facades\Route;

    Route::get('/select-role', [RoleSelectionController::class, 'index'])->name('auth.select-role');

    Route::prefix('auth/doctor')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.doctor.login.form')->defaults('role', 'doctor');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.doctor.login');
        
        Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.doctor.register.form')->defaults('role', 'doctor');
        Route::post('/register', [AuthController::class, 'register'])->name('auth.doctor.register');
    });
    
    Route::prefix('auth/patient')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.patient.login.form')->defaults('role', 'patient');
        Route::post('/login/{role}', [AuthController::class, 'login'])->name('auth.patient.login');
        
        Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.patient.register.form')->defaults('role', 'patient');
        Route::post('/register/{role}', [AuthController::class, 'register'])->name('auth.patient.register');

    });
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/doctor-redirect', [DoctorRedirectController::class, 'index'])->name('doctor.redirect');
    Route::get('/patient-redirect', [PatientRedirectController::class, 'index'])->name('patient.redirect');