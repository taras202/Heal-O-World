<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class MyOfficeDoctorsSeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            'Терапевт',
            'Кардіолог',
            'Невролог',
            'Хірург',
            'Педіатр',
            'Ендокринолог',
            'Гінеколог',
            'Офтальмолог',
            'Дерматолог',
            'Стоматолог'
        ];

        foreach ($specialties as $name) {
            Specialty::firstOrCreate(['name' => $name]);
        }

    }
}
