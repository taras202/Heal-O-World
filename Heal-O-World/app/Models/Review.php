<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'rating',
        'comment',
    ];

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }
}
