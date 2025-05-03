<?php

namespace App\Http\Controllers\officeDoctor;

use App\Http\Controllers\Controller;

class ProgressBarController extends Controller
{
    public function step($step)
    {
        $steps = [
            1 => 'Персональні дані',
            2 => 'Спеціалізація',
            3 => 'Освіта',
        ];

        if (!isset($steps[$step])) {
            abort(404); 
        }

        return view('doctor.doctor-activation.' . strtolower($steps[$step]), compact('step'));
    }
}
