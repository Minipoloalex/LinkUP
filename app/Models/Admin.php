<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    
    public $table = 'admin';

    public $fillable = [
        'name', 
        'email',
        'password',
    ];

    public $hidden = [
        'password', 
    ];
}
