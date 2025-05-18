<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientListAllergicReaction extends Model
{
    use HasFactory;

    protected $table = 'patient_list_allergic_reactions';
    
    protected $fillable = [
        'patient_card_id',
        'list_allergic_reactions_id',
    ];

    public function patientCard()
    {
        return $this->belongsTo(PatientCard::class, 'patient_card_id');
    }

    public function allergicReaction()
    {
        return $this->belongsTo(ListAllergicReaction::class, 'list_allergic_reactions_id');
    }
    public $timestamps = true; 
}
