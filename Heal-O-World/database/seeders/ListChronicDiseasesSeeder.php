<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListChronicDiseasesSeeder extends Seeder
{
    public function run()
    {
        DB::table('list_chronic_diseases')->insert([
            ['title' => 'Цукровий діабет'],
            ['title' => 'Гіпертонія'],
            ['title' => 'Астма'],
            ['title' => 'Хронічний бронхіт'],
        ]);
    }
}
