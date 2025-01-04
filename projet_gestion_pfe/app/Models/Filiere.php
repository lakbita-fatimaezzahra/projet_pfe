<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = [
        'libelle',
        'departement_id',
    ];

    /**
     * Relation avec le département.
     * Une filière appartient à un département.
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * Relation avec les groupes.
     * Une filière peut avoir plusieurs groupes.
     */
    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }
}
