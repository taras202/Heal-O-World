<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticContent extends Model
{
    protected $fillable = [
    'mission_title',
    'mission_text',
    'why_us_title',
    'why_us_list',
    'reviews_title',
    'reviews_text',
];

}
