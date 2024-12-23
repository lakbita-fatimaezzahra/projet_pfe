<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    // Colonnes autorisées à être remplies via des opérations de masse
    protected $fillable = [

        'libelle', // Correspond au champ "libelle" de la table "departements"
    ];

    /**
     * Relation avec les filières.
     * Un département peut avoir plusieurs filières.
     */
    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }

    /**
     * Relation avec les étudiants.
     * Un département peut avoir plusieurs étudiants.
     */
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

}
