<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConsultationSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['pending', 'completed', 'cancelled'];

        for ($i = 0; $i < 5; $i++) {
            DB::table('consultations')->insert([
                'patient_id' => 1,
                'doctor_id' => 1,
                'google_meet_link' => 'https://meet.google.com/' . Str::random(10),
                'appointment_date' => now()->addDays(rand(1, 10))->format('Y-m-d'),
                'consultation_time' => rand(9, 17) . ':00',
                'diagnosis' => 'Фіктивний діагноз ' . ($i + 1),
                'prescription' => 'Фіктивне лікування ' . ($i + 1),
                'status' => $statuses[array_rand($statuses)],
                'treatment' => 'Фіктивна терапія ' . ($i + 1),
                'notes' => 'Примітка до консультації №' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
