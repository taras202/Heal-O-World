<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'rating',
        'content',
    ];

    public $timestamps = true; 

    
    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }
}
