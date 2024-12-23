<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    protected $fillable = [

    'titre', 'date', 'etat', 'contenu', 'dernier_delai', 'stage_id'
];


public function etudiant()
{
    return $this->belongsTo(Etudiant::class);
}

}
