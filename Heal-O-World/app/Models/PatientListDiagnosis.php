<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientListDiagnosis extends Model
{
    use HasFactory;

    protected $table = 'patient_list_diagnoses';
    
    protected $fillable = [
        'patient_card_id',
        'list_diagnoses_id',
    ];    

    public function patientCard()
    {
        return $this->belongsTo(PatientCard::class, 'patient_card_id');
    }

    public function diagnoses()
    {
        return $this->belongsTo(ListDiagnosis::class, 'list_diagnoses_id');
    }
    public $timestamps = true; 
}
