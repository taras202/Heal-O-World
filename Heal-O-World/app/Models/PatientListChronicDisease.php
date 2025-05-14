<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientListChronicDisease extends Model
{
    use HasFactory;

    protected $table = 'patient_list_chronic_diseases'; 


    public function patientCard()
    {
        return $this->belongsTo(PatientCard::class, 'patient_card_id');
    }

    public function chronicDisease()
    {
        return $this->belongsTo(ListChronicDisease::class, 'list_chronic_diseases_id');
    }

    public $timestamps = true; 
}
