<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCard extends Model
{
    use HasFactory;

    protected $table = 'patient_card';

    protected $fillable = [
        'patient_id',
        'visit_date',
        'diagnosis',
        'notes',
    ];

    
    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }

    public $timestamps = true; 
}
