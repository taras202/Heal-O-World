<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyOfficeDoctor extends Model
{
    use HasFactory;

    protected $table = 'my_office_doctors';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'bio',
        'gender',
        'photo',
        'contact',
        'time_zone_id'
    ];

    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class, 'time_zone_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty', 'doctor_id', 'specialty_id')
                    ->withPivot('experience', 'price') 
                    ->withTimestamps(); 
    }

    public function educations()
    {
        return $this->hasMany(Education::class, 'doctor_id');
    }

    public function placeOfWork()
    {
        return $this->hasOne(PlaceOfWork::class, 'doctor_id');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'doctor_id');
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getSpecialtiesDetails()
    {
        return $this->specialties->map(function ($specialty) {
            return [
                'specialty_name' => $specialty->name,
                'experience' => $specialty->pivot->experience,
                'price' => $specialty->pivot->price,
            ];
        });
    }
}

