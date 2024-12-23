<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Administrateur extends  Authenticatable
{
    protected $fillable = [
        'name',
        'last_name',
        'username',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}

