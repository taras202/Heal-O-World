<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyOfficeDoctor extends Model
{
    use HasFactory;

    protected $table = 'my_office_doctors'; 

    protected $fillable = [
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

    public $timestamps = true;

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty', 'doctor_id', 'specialty_id')
                    ->withPivot('experience', 'price')
                    ->withTimestamps();
    }
}
