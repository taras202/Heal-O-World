<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSpecialty extends Model
{
    use HasFactory;

    protected $table = 'doctor_specialty';

    protected $fillable = [
        'doctor_id',
        'specialty_id',
        'experience',
    ];

    public $timestamps = true;

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }
}
