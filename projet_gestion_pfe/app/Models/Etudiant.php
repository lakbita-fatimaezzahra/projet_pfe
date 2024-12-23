<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Etudiant extends Authenticatable
{
    protected $fillable = [
        'matricule',
        'name',
        'last_name',
        'email',
        'dateN',
        'CNE',
        'Cin',
        'genre',
        'password',
        'username',
        'groupe_id',
        'departement_id',
        'photo',
    ];

    /**
     * Relation avec le groupe.
     * Un étudiant appartient à un groupe.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    /**
     * Relation avec le département.
     * Un étudiant appartient à un département.
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * Relation avec les stages.
     * Un étudiant peut avoir plusieurs stages.
     */
    public function stages()
    {
        return $this->hasOne(Stage::class);
    }
}
