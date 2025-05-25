<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $fillable = [
        'doctor_id', 
        'patient_id', 
        'status'
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class);
    }
}
