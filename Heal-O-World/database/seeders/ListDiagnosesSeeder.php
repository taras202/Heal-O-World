<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListDiagnosesSeeder extends Seeder
{
    public function run()
    {
        DB::table('list_diagnoses')->insert([
            ['title' => 'Гіпертонічна хвороба ІІ ст.'],
            ['title' => 'Цукровий діабет ІІ типу'],
            ['title' => 'Ішемічна хвороба серця'],
            ['title' => 'Бронхіальна астма, середньотяжкий перебіг'],
        ]);
    }
}
