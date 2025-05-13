<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyOfficePatient extends Model
{
    use HasFactory;

    protected $table = 'my_office_patients';

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'has_insurance',
        'country_of_residence',
        'city_of_residence',
        'time_zone',
        'height',
        'weight',
        'notes',
        'contact',
        'user_id',
    ];

    public $timestamps = true; 

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'patient_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctor()
    {
        return $this->hasOne(MyOfficeDoctor::class);
    }
}
