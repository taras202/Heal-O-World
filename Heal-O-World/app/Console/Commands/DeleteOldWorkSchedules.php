<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WorkSchedule;
use Carbon\Carbon;

class DeleteOldWorkSchedules extends Command
{
    protected $signature = 'schedules:cleanup';
    protected $description = 'Delete past work schedules';

    public function handle()
    {
        $now = Carbon::now();

        $deleted = WorkSchedule::where(function ($query) use ($now) {
                $query->where('appointment_date', '<', $now->toDateString())
                      ->orWhere(function ($q) use ($now) {
                          $q->where('appointment_date', $now->toDateString())
                            ->where('consultation_time', '<', $now->format('H:i:s'));
                      });
            })
            ->whereDoesntHave('consultations')
            ->delete();

        $this->info("Deleted $deleted old schedule(s).");
    }
}
