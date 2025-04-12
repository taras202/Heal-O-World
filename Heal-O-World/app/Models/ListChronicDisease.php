<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListChronicDisease extends Model
{
    use HasFactory;

    protected $table = 'list_chronic_diseases'; 

    protected $fillable = [
        'title',
    ];

    public $timestamps = true; 
}
