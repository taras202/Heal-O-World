<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    
    protected $table = 'complaints';

    
    protected $fillable = [
        'text',          
        'consultation_id', 
        'status',        
        'sender_id',     
        'type',          
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
    
    public function sender()
    {
        return $this->belongsTo(User::class);
    }
}
