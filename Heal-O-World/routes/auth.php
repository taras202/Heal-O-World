<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthDoctorController;
use App\Http\Controllers\AuthPatientController;



    Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    });
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::middleware(['guest'])->group(function () {
        Route::get('/select-role', function () {
            return view('auth.select-role');
        })->name('select_role');
    });

    Route::prefix('doctor')->middleware('guest')->group(function () {
        Route::get('/register', [AuthDoctorController::class, 'showRegisterForm'])->name('doctor.register');
        Route::post('/register', [AuthDoctorController::class, 'register']);
        Route::get('/login', [AuthDoctorController::class, 'showLoginForm'])->name('doctor.login');
        Route::post('/login', [AuthDoctorController::class, 'login']);
    });

    Route::prefix('patient')->middleware('guest')->group(function () {
        Route::get('/register', [AuthPatientController::class, 'showRegisterForm'])->name('patient.register');
        Route::post('/register', [AuthPatientController::class, 'register']);
        Route::get('/login', [AuthPatientController::class, 'showLoginForm'])->name('patient.login');
        Route::post('/login', [AuthPatientController::class, 'login']);
        Route::post('/logout', [AuthPatientController::class, 'logout'])->name('patient.logout');
    });

