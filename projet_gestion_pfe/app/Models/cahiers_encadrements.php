<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cahiers_encadrements extends Model
{
    protected $fillable = ['date', 'commentaire', 'emplacement', 'duree', 'stage_id'];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
}

}
