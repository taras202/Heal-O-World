<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';
    
    protected $fillable = [
        'doctor_id',
        'institution',
        'degree',
        'start_year',
        'end_year',
        'diploma_photo_1',
        'diploma_photo_2',
        'diploma_photo_3',
    ];

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }
}
