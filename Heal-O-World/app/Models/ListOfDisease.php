<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListOfDisease extends Model
{
    use HasFactory;

    protected $table = 'list_of_diseases'; 

    protected $fillable = [
        'title',
    ];

    public $timestamps = true; 
}
