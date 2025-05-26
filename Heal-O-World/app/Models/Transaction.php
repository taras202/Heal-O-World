<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'payment_id',
        'doctor_id',
        'patient_id',
        'amount',
        'transaction_type',
        'status',
        'description',
    ];

    public $timestamps = true; 

    
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }
}
