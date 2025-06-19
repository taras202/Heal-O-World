<?php

use App\Http\Controllers\admin\auth\AuthAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthAdminController::class, 'showLoginForm'])->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthAdminController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthAdminController::class, 'login'])->name('login');
    Route::post('/logout', [AuthAdminController::class, 'logout'])->name('logout');
});
