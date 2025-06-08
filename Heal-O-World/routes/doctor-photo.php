<?php

use App\Http\Controllers\officeDoctor\MyOfficeDoctorController;
use Illuminate\Support\Facades\Route;


Route::delete('/doctor/photo/delete', [MyOfficeDoctorController::class, 'deletePhoto'])->name('doctor.photo.delete');


