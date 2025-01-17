<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class encadrements extends Model
{
    protected $fillable = ['date', 'commentaire', 'emplacement','heure_debut',
    'heure_fin', 'stage_id','salle_id'];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
}

}
