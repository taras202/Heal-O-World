<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSpecialty extends Model
{
    use HasFactory;

    protected $table = 'doctor_specialty';

    protected $fillable = [
        'doctors_id',
        'specialty_id',
        'experience',
    ];

    
    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctors_id');
    }

    public $timestamps = true; 
}
