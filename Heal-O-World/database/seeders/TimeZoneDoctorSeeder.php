<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeZoneDoctorSeeder extends Seeder
{
    public function run(): void
    {
        $timezones = [
            'Europe/Kyiv',
            'Europe/London',
            'America/New_York',
            'Asia/Tokyo',
            'Europe/Berlin',
            'Asia/Kolkata',
            'Australia/Sydney',
            'America/Los_Angeles',
            'Europe/Paris',
            'Africa/Cairo',
            'America/Chicago',
            'America/Sao_Paulo',
            'Asia/Shanghai',
            'Asia/Singapore',
            'Asia/Dubai',
            'Europe/Moscow',
            'Africa/Nairobi',
            'Pacific/Auckland',
            'Asia/Bangkok',
            'America/Vancouver',
        ];

        foreach ($timezones as $tz) {
            DB::table('time_zones')->updateOrInsert(
                ['time_zone' => $tz],
                [
                    'updated_at' => now(),
                    'created_at' => DB::raw('IFNULL(created_at, NOW())'),
                ]
            );
        }
    }
}