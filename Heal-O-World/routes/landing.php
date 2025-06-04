<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/landing', [LandingController::class, 'landing'])->name('landing');
Route::get('/about',[LandingController::class, 'about'])->name('about');
Route::get('/contact',[LandingController::class, 'contact'])->name('contact');

