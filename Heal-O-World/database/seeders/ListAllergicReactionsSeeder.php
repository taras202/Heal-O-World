<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListAllergicReactionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('list_allergic_reactions')->insert([
            ['title' => 'Пилок'],
            ['title' => 'Пеніцилін'],
            ['title' => 'Арахіс'],
            ['title' => 'Укуси комах'],
        ]);
    }
}
