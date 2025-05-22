<?php

namespace App\Observers;

use App\Models\Consultation;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_CreateConferenceRequest;

class ConsultationObserver
{
    public function created(Consultation $consultation)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');

        $tokenPath = storage_path('app/google-calendar/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        } else {
            throw new \Exception('Google API token file not found. Please authorize first.');
        }

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                file_put_contents($tokenPath, json_encode($newToken));
                $client->setAccessToken($newToken);
            } else {
                throw new \Exception('No refresh token found. Please re-authorize.');
            }
        }

        $service = new Google_Service_Calendar($client);

        $startDateTime = new Google_Service_Calendar_EventDateTime([
            'dateTime' => $consultation->appointment_date . 'T' . $consultation->consultation_time . ':00',
            'timeZone' => 'Europe/Kyiv',
        ]);

        $endDateTime = new Google_Service_Calendar_EventDateTime([
            'dateTime' => date('Y-m-d\TH:i:s', strtotime($consultation->appointment_date . 'T' . $consultation->consultation_time . ':00') + 30 * 60),
            'timeZone' => 'Europe/Kyiv',
        ]);

        $conferenceRequest = new Google_Service_Calendar_CreateConferenceRequest([
            'requestId' => uniqid(),
            'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
        ]);

        $conferenceData = new Google_Service_Calendar_ConferenceData([
            'createRequest' => $conferenceRequest,
        ]);

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Онлайн консультація з пацієнтом',
            'start' => $startDateTime,
            'end' => $endDateTime,
            'attendees' => [
                ['email' => 'tarasul20@gmail.com'],
            ],
            'conferenceData' => $conferenceData,
        ]);

        $createdEvent = $service->events->insert('primary', $event, ['conferenceDataVersion' => 1]);

        $meetLink = $createdEvent->getHangoutLink();

        $consultation->update([
            'google_meet_link' => $meetLink,
        ]);
    }
}
