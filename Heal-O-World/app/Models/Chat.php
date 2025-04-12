<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats'; 

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'sender_id',
        'messages',
        'status',
    ];

    public $timestamps = true;

    
    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }

    public function sender()
    {
        return $this->belongsTo(Admin::class, 'sender_id');
    }
}
