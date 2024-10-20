<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id', // Add this field
    ];

    // If you are using Laravel's built-in hashing for passwords
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
