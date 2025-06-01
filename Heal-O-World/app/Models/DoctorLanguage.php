<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorLanguage extends Model
{
    use HasFactory;

    protected $table = 'doctor_languages';

    protected $fillable = [
        'doctor_id',
        'language_id',
    ];

    public $timestamps = true;

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id'); 
    }
}
