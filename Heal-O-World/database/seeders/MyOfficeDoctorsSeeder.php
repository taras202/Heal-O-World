<?php

namespace Database\Seeders;

use App\Models\MyOfficeDoctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;

class MyOfficeDoctorsSeeder extends Seeder
{
    public function run(): void
    {
        // Створення спеціальностей
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

        foreach ($specialties as $specialtyName) {
            Specialty::firstOrCreate(['name' => $specialtyName]);
        }

        // Дані для лікарів
        $doctors = [
            [
                'first_name' => 'Іван',
                'last_name' => 'Іваненко',
                'bio' => 'Досвідчений терапевт із понад 10 роками практики.',
                'gender' => 'чоловік',
                'photo' => null,
                'contact' => '+380501234567',
                'time_zone' => 2,
                'user_email' => 'ivan@example.com', // Додано для створення користувача
            ],
            [
                'first_name' => 'Марія',
                'last_name' => 'Петренко',
                'bio' => 'Сімейний лікар із досвідом роботи 8 років.',
                'gender' => 'жінка',
                'photo' => null,
                'contact' => '+380501234568',
                'time_zone' => 2,
                'user_email' => 'maria@example.com', // Додано для створення користувача
            ],
            // Інші лікарі...
        ];

        foreach ($doctors as $doctorData) {
            // Створення користувача для лікаря
            $user = User::create([
                'email' => $doctorData['user_email'],
                'phone' => null,
                'status' => 'active',
                'password' => bcrypt('secret'), // Встановити пароль для користувача
                'role' => 'doctor',
            ]);

            // Створення лікаря і прив'язка користувача до лікаря
            $doctor = MyOfficeDoctor::create([
                'user_id' => $user->id,  // Прив'язка користувача до лікаря
                'first_name' => $doctorData['first_name'],
                'last_name' => $doctorData['last_name'],
                'bio' => $doctorData['bio'],
                'gender' => $doctorData['gender'],
                'photo' => $doctorData['photo'],
                'contact' => $doctorData['contact'],
                'time_zone' => $doctorData['time_zone'],
            ]);

            // Призначення спеціальностей для лікаря
            $specialties = Specialty::inRandomOrder()->take(rand(1, 3))->pluck('id');

            foreach ($specialties as $specialtyId) {
                $doctor->specialties()->attach($specialtyId, [
                    'experience' => '7 років',
                    'price' => rand(200, 2000),
                ]);
            }
        }
    }
}
