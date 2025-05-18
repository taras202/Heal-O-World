<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListOfDiseasesSeeder extends Seeder
{
    public function run()
    {
        DB::table('list_of_diseases')->insert([
            ['title' => 'ГРВІ'],
            ['title' => 'Гастрит'],
            ['title' => 'Отит'],
            ['title' => 'Ангiна'],
        ]);
    }
}
