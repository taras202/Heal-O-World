<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use Notifiable;

    

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            if ($patient->password) {
                $patient->password = bcrypt($patient->password);
            }
        });
    }
}
