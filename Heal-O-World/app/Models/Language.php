<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function doctors()
    {
        return $this->belongsToMany(MyOfficeDoctor::class, 'doctor_languages', 'language_id', 'doctor_id');
    }
}
