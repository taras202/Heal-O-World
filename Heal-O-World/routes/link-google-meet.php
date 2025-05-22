<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

Route::get('/google/redirect', function () {
    $client = new Google_Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
    $client->addScope(Google_Service_Calendar::CALENDAR);
    $client->setAccessType('offline');
    $client->setPrompt('consent');

    return redirect($client->createAuthUrl());
});

Route::get('/google/callback', function (Request $request) {
    $client = new Google_Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

    $code = $request->get('code');

    if (!$code) {
        return '⛔ Помилка: код авторизації не отримано.';
    }

    $token = $client->fetchAccessTokenWithAuthCode($code);

    if (isset($token['error'])) {
        return '⛔ Помилка авторизації: ' . $token['error_description'];
    }

    if (!isset($token['access_token']) || !isset($token['refresh_token'])) {
        return '⛔ Неповний токен. Повторіть авторизацію.';
    }

    file_put_contents(storage_path('app/google-calendar/token.json'), json_encode($token));

    return '✅ Токен успішно збережено!';
});
