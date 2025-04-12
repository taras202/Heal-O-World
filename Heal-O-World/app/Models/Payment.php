<?php

namespace App\Models;

use Illuminate\Database\Concerns\ManagesTransactions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'doctor_id', 
        'patient_id', 
        'transaction_amount',
        'status',
        'payment_date',
        'appointment_id',
        'notes',
        'transaction_id',
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

    public function appointment()
    {
        return $this->belongsTo(Consultation::class, 'appointment_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }
}
