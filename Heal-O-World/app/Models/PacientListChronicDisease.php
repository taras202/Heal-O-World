<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacientListChronicDisease extends Model
{
    use HasFactory;

    protected $table = 'pacient_list_chronic_diseases'; 

   
    public function patient()
    {
        return $this->belongsTo(MyOfficePatient::class, 'patient_id');
    }

    public function chronicDisease()
    {
        return $this->belongsTo(ListChronicDisease::class, 'list_chronic_diseases_id');
    }

    public $timestamps = true; 
}
