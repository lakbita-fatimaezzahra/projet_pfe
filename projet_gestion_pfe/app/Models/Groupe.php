<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = [
        'libelle',
        'filiere_id',  // Assure-toi que cette colonne existe dans la table
    ];

    /**
     * Relation avec les étudiants.
     * Un groupe peut avoir plusieurs étudiants.
     */
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    /**
     * Relation avec la filière.
     * Un groupe appartient à une filière.
     */
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
}
