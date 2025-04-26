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
        'country_of_residence',
        'city_of_residence',
        'contact',
        'workplace',
        'position',
        'time_zone',
    ];

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
}
