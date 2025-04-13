<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/landing', function () {return view('landing.landing');})->name('landing');
Route::get('/about', [LandingController::class, 'about']);
Route::get('/contact', [LandingController::class, 'contact']);

