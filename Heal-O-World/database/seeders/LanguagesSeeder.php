<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            ['code' => 'uk', 'name' => 'Українська'],
            ['code' => 'ru', 'name' => 'Російська'],
            ['code' => 'en', 'name' => 'Англійська'],
        ];

        foreach ($languages as $language) {
            DB::table('languages')->updateOrInsert(
                ['code' => $language['code']],
                [
                    'name' => $language['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
