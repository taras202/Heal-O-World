<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAllergicReaction extends Model
{
    use HasFactory;

    protected $table = 'list_allergic_reactions'; 

    protected $fillable = [
        'title', 
    ];

    public $timestamps = true; 
}
