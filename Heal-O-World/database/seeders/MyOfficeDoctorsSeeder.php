<?php

namespace Database\Seeders;

use App\Models\MyOfficeDoctor;
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

        foreach ($specialties as $specialtyName) {
            Specialty::create(['name' => $specialtyName]);
        }

        $doctors = [
            [
                'first_name' => 'Іван',
                'last_name' => 'Іваненко',
                'bio' => 'Досвідчений терапевт із понад 10 роками практики.',
                'gender' => 'чоловік',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Київ',
                'contact' => '+380501234567',
                'time_zone' => 2,
                'workplace' => 'Клініка "Здоровʼя+"',
                'position' => 'Терапевт',
            ],
            [
                'first_name' => 'Марія',
                'last_name' => 'Петренко',
                'bio' => 'Сімейний лікар із досвідом роботи 8 років.',
                'gender' => 'жінка',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Одеса',
                'contact' => '+380501234568',
                'time_zone' => 2,
                'workplace' => 'Центр сімейної медицини',
                'position' => 'Сімейний лікар',
            ],
            [
                'first_name' => 'Олег',
                'last_name' => 'Гриценко',
                'bio' => 'Хірург з понад 15 роками досвіду.',
                'gender' => 'чоловік',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Харків',
                'contact' => '+380501234569',
                'time_zone' => 2,
                'workplace' => 'Обласна клінічна лікарня',
                'position' => 'Хірург',
            ],
            [
                'first_name' => 'Анна',
                'last_name' => 'Демченко',
                'bio' => 'Педіатр із 6 роками практики.',
                'gender' => 'жінка',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Львів',
                'contact' => '+380501234570',
                'time_zone' => 2,
                'workplace' => 'Дитяча поліклініка №2',
                'position' => 'Педіатр',
            ],
            [
                'first_name' => 'Павло',
                'last_name' => 'Мороз',
                'bio' => 'Терапевт з досвідом роботи 12 років.',
                'gender' => 'чоловік',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Чернівці',
                'contact' => '+380501234571',
                'time_zone' => 2,
                'workplace' => 'Центр медичних послуг',
                'position' => 'Терапевт',
            ],
            [
                'first_name' => 'Оксана',
                'last_name' => 'Литвин',
                'bio' => 'Кардіолог з досвідом 9 років.',
                'gender' => 'жінка',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Запоріжжя',
                'contact' => '+380501234572',
                'time_zone' => 2,
                'workplace' => 'Кардіоцентр "Серце"',
                'position' => 'Кардіолог',
            ],
            [
                'first_name' => 'Максим',
                'last_name' => 'Шевченко',
                'bio' => 'Лікар-невролог з 7-річним досвідом.',
                'gender' => 'чоловік',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Івано-Франківськ',
                'contact' => '+380501234573',
                'time_zone' => 2,
                'workplace' => 'Нейроцентр "Баланс"',
                'position' => 'Невролог',
            ],
            [
                'first_name' => 'Вікторія',
                'last_name' => 'Коваль',
                'bio' => 'Ендокринолог з досвідом роботи 10 років.',
                'gender' => 'жінка',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Черкаси',
                'contact' => '+380501234574',
                'time_zone' => 2,
                'workplace' => 'Ендокринологічна клініка',
                'position' => 'Ендокринолог',
            ],
            [
                'first_name' => 'Дмитро',
                'last_name' => 'Сидоренко',
                'bio' => 'Лікар-уролог з 14-річним досвідом.',
                'gender' => 'чоловік',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Київ',
                'contact' => '+380501234575',
                'time_zone' => 2,
                'workplace' => 'Урологічний центр',
                'position' => 'Уролог',
            ],
            [
                'first_name' => 'Тетяна',
                'last_name' => 'Назаренко',
                'bio' => 'Акушер-гінеколог з 13-річним досвідом.',
                'gender' => 'жінка',
                'photo' => null,
                'country_of_residence' => 'Україна',
                'city_of_residence' => 'Одеса',
                'contact' => '+380501234576',
                'time_zone' => 2,
                'workplace' => 'Жіноча клініка "Медлайн"',
                'position' => 'Акушер-гінеколог',
            ]
        ];


        foreach ($doctors as $doctorData) {
            $doctor = MyOfficeDoctor::create($doctorData);

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
