<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Consultation;
use App\Observers\ConsultationObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        
    }

    public function boot()
    {
        
    }
}
