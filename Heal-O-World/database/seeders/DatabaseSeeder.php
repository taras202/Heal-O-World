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

        $this->call(ConsultationSeeder::class); 

        $this->call(WorkScheduleSeeder::class); 

    }
}
