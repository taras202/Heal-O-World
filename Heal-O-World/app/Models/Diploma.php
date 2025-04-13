<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    use HasFactory;

    
    protected $table = 'diplomas';

    
    protected $fillable = [
        'doctor_id', 
        'title',     
        'description', 
        'foto',     
    ];

    /**
     * Визначення зв'язку "один до багатьох" з моделлю Doctor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(MyOfficeDoctor::class);
    }
}
