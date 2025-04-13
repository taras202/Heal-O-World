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
        'hospital_id',
        'country_of_residence',
        'city_of_residence',
        'contact',
        'time_zone',
    ];

    
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public $timestamps = true; 
}
