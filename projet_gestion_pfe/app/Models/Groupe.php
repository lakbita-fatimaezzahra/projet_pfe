<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = [
        'libelle',
    ];

    /**
     * Relation avec les étudiants.
     * Un groupe peut avoir plusieurs étudiants.
     */
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
