<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'prices'; 

    protected $fillable = [
        'doctor_id',
        'title',
        'description',
        'price',
        'currency',
    ];

    public $timestamps = true; 

    
    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }
}
