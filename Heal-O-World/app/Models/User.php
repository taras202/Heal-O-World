<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'phone',
        'email',
        'status',        
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function isActivated(): bool
    {
        return $this->status === 'active';
    }

    public function patient()
    {
        return $this->hasOne(MyOfficePatient::class);
    }

    public function doctor()
    {
        return $this->hasOne(MyOfficeDoctor::class);
    }
}
