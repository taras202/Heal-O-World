<?php

use Illuminate\Support\Facades\Route;

Route::get('/landing', function () {return view('landing.landing');})->name('landing');
Route::get('/about', function () {return view('landing.about');})->name('about');
Route::get('/contact', function () {return view('landing.contact');})->name('contact');

