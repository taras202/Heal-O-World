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
        'day_of_the_week', 
        'hours_with', 
        'hours_after', 
    ];

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class);
    }
}
