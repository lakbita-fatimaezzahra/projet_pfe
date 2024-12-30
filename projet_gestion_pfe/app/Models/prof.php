<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class prof extends Authenticatable

{
    protected $fillable = [
        'name', 'last_name', 'username', 'email', 'password', 'type', 'skills', 'role','photo','genre',

    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function affectations()
    {
        return $this->hasMany(Affectation::class);
}
}
