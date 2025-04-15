<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function doctors()
    {
        return $this->belongsToMany(MyOfficeDoctor::class, 'doctor_specialty', 'specialty_id', 'doctor_id')
                    ->withPivot('experience', 'price')
                    ->withTimestamps();
    }
}
