<?php

use App\Http\Controllers\officeDoctor\consultation\ConsultationController;
use App\Http\Controllers\officeDoctor\consultation\WorkScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/work-schedule', [WorkScheduleController::class, 'index'])->name('work-schedule.index');
    Route::get('doctor/work-schedule/create', [WorkScheduleController::class, 'create'])->name('work-schedule.create');
    Route::post('doctor/work-schedule', [WorkScheduleController::class, 'store'])->name('work-schedule.store');
    Route::delete('doctor/work-schedule/{workSchedule}', [WorkScheduleController::class, 'destroy'])->name('work-schedule.destroy');
    Route::get('/doctor/{doctorId}/free-times', [WorkScheduleController::class, 'getFreeTimes']);
    Route::post('doctor/work-schedule/book', [ConsultationController::class, 'book'])->name('consultations.book');
});