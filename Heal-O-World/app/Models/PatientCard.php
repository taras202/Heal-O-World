<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCard extends Model
{
    use HasFactory;

    protected $table = 'patient_card';

    protected $casts = [
        'height' => 'float',  
        'weight' => 'float',  
    ];

    protected $fillable = [
        'patient_id',
        'notes',
        'weight',
        'height',
    ];

    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }

    public function allergicReactions()
    {
        return $this->hasMany(PatientListAllergicReaction::class, 'patient_card_id');
    }

    public function chronicDiseases()
    {
        return $this->hasMany(PatientListChronicDisease::class, 'patient_card_id');
    }

    public function diseases()
    {
        return $this->hasMany(PatientListOfDisease::class, 'patient_card_id');
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'patient_card_id');
    }

    public $timestamps = true; 
}
