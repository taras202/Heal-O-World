<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorLanguagesSeeder extends Seeder
{
    public function run(): void
    {
        $languages = ['українська', 'російська', 'англійська'];

        foreach ($languages as $language) {
            DB::table('doctor_languages')->insert([
                'doctor_id' => 1, 
                'language' => $language,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
