<?php

namespace Database\Seeders;

use App\Models\MyOfficeDoctor;
use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;

class WorkScheduleSeeder extends Seeder
{
    public function run()
    {
        // Отримуємо список лікарів
        $doctors = MyOfficeDoctor::all();

        if ($doctors->isEmpty()) {
            // Якщо немає лікарів, вивести повідомлення
            $this->command->info('Немає лікарів у базі даних!');
        }

        foreach ($doctors as $doctor) {
            // Вивести лікаря, для якого ми додаємо години
            $this->command->info('Додаємо години для лікаря: ' . $doctor->fullName());

            // Додаємо кілька годин для кожного лікаря
            WorkSchedule::create([
                'doctor_id' => $doctor->id,
                'appointment_date' => now()->addDays(rand(1, 30)), // Додаємо випадкову дату протягом місяця
                'consultation_time' => now()->setTime(rand(8, 18), rand(0, 59)), // Випадковий час між 8:00 та 18:00
            ]);
        }
    }
}
