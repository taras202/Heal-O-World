<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Google\Client;

class GoogleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            $client = new Client();
            $client->setAuthConfig([
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect_uris' => [env('GOOGLE_REDIRECT_URI')],
            ]);
            $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
            $client->addScope([
                \Google\Service\Calendar::CALENDAR,
                \Google\Service\Calendar::CALENDAR_EVENTS,
            ]);
            $client->setAccessType('offline');
            $client->setPrompt('consent');
    
            return $client;
        });
    }
    
}
