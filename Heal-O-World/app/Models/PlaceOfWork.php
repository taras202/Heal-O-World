<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceOfWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'workplace',
        'position',
        'country_of_residence',
        'city_of_residence',
    ];

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }
}
