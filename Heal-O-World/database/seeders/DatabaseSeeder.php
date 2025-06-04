<?php

namespace Database\Seeders;

use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(MyOfficeDoctorsSeeder::class);

        $this->call(TimeZoneDoctorSeeder::class);

        $this->call(LanguagesSeeder::class);

        $this->call([
            ListAllergicReactionsSeeder::class,
            ListChronicDiseasesSeeder::class,
            ListOfDiseasesSeeder::class,
            ListDiagnosesSeeder::class,
        ]);
    }
}
