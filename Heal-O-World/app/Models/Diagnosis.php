<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnoses';

    protected $fillable = [
        'patient_card_id',
        'title',
        'description',
    ];

    public $timestamps = true;

    public function patientCard()
    {
        return $this->belongsTo(PatientCard::class, 'patient_card_id');
    }
}
