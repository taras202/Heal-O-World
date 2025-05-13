<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;

    
    protected $table = 'work_schedules';

    
    protected $fillable = [
        'doctor_id', 
        'appointment_date', 
        'consultation_time',  
    ];

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class);
    }
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'consultation_time', 'consultation_time')
                    ->where('appointment_date', $this->appointment_date);
    }
}
