<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Consultation extends Model
{
    use HasFactory;

    protected $table = 'consultations'; 

    protected $fillable = [
        'patient_id', 
        'doctor_id', 
        'google_meet_link',
        'appointment_date',
        'consultation_time',
        'diagnosis',
        'prescription',
        'status',
        'treatment',
        'notes',
    ];

    public $timestamps = true; 

    
    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }

    public function createGoogleMeetLink()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');
    
        $tokenPath = storage_path('app/google-calendar/token.json');
        if (!file_exists($tokenPath)) {
            \Log::error('❌ Google API token not found.');
            return null;
        }
    
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                file_put_contents($tokenPath, json_encode($client->getAccessToken()));
            } else {
                \Log::error('❌ No refresh token found.');
                return null;
            }
        }
    
        $service = new \Google_Service_Calendar($client);
    
        // Формат часу
        if (preg_match('/^\d{4}$/', $this->consultation_time)) {
            $consultation_time = substr($this->consultation_time, 0, 2) . ':' . substr($this->consultation_time, 2, 2);
        } else {
            $consultation_time = $this->consultation_time;
        }
    
        $startDateTime = Carbon::parse($this->appointment_date . ' ' . $consultation_time)
        ->format('Y-m-d\TH:i:s');
    
        $endDateTime = Carbon::parse($startDateTime)
            ->addHour()
            ->format('Y-m-d\TH:i:s');
    
        $event = new \Google_Service_Calendar_Event([
            'summary' => 'Онлайн консультація',
            'start' => new \Google_Service_Calendar_EventDateTime([
                'dateTime' => $startDateTime,
                'timeZone' => 'Europe/Kyiv',
            ]),
            'end' => new \Google_Service_Calendar_EventDateTime([
                'dateTime' => $endDateTime,
                'timeZone' => 'Europe/Kyiv',
            ]),
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                ],
            ],
        ]);
    
        \Log::info('Google Event Data: ', (array) $event->toSimpleObject());
    
        $createdEvent = $service->events->insert(
            'primary',
            $event,
            ['conferenceDataVersion' => 1]
        );
    
        $meetLink = $createdEvent->getHangoutLink();
    
        if ($meetLink) {
            $this->google_meet_link = $meetLink;
            $this->saveQuietly();
            \Log::info('Google Meet link saved to DB: ' . $meetLink);
            return $meetLink;
        }
    
        \Log::warning('Google Meet link is null.');
        return null;
    }    
}
