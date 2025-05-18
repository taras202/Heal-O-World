<?php

use App\Http\Controllers\admin\CardController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('patient-cards/{id}', [CardController::class, 'show'])->name('patient-cards.show');
});
