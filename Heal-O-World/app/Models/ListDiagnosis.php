<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDiagnosis extends Model
{
    use HasFactory;

    protected $table = 'list_diagnoses';

    protected $fillable = [
        'title',
    ];

    public $timestamps = true;

    public function patientCard()
    {
        return $this->belongsTo(PatientCard::class, 'patient_card_id');
    }
}
