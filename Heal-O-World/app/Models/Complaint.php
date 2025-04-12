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

    /**
     * Визначення зв'язку "належить консультації" з моделлю Consultation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    /**
     * Визначення зв'язку "належить користувачу" з моделлю User (відправник).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class);
    }
}
