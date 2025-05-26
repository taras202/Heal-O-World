<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/payments', [PaymentController::class, 'createPayment'])->name('payments.create');

Route::post('/payments/release/{appointment}', [PaymentController::class, 'releasePayment'])->name('payments.release');

