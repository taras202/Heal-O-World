<?php

use App\Http\Controllers\review\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/doctors/{doctor}/reviews/create/{consultation}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/doctors/{doctor}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
