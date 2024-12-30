<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'entreprise', 'sujet', 'date_debut', 'date_fin', 'type_stage',
         'etudiant_id','documentsDebut','documentsfin','Skills'
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function cahierEncadrement()
    {
        return $this->hasOne(cahiers_encadrement::class);
    }

    public function affectations()
    {
        return $this->hasMany(Affectation::class);
}
public function rapports()
{
    return $this->hasOne(Rapport::class);
}

}