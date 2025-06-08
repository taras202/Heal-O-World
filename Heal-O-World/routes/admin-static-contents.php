<?php

use App\Http\Controllers\admin\StaticContentController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/static-contents/edit', [StaticContentController::class, 'edit'])->name('static-contents.edit');
    Route::put('/static-contents/update', [StaticContentController::class, 'update'])->name('static-contents.update');
});


