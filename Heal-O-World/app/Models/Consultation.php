<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
