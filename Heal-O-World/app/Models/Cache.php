<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cache extends Model
{
    use HasFactory;

    protected $table = 'cache';

    protected $primaryKey = 'key'; 

    public $incrementing = false; 

    protected $fillable = [
        'key',
        'value',
        'expiration',
    ];

    public $timestamps = false; 
}
