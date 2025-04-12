<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientListOfDisease extends Model
{
    use HasFactory;

    protected $table = 'patient_list_of_diseases'; 

    
    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }

    public function disease()
    {
        return $this->belongsTo(ListOfDisease::class, 'list_of_diseases_id');
    }

    public $timestamps = true;
}
