<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class affectation extends Model
{protected $fillable = ['role', 'prof_id', 'stage_id'];

public function prof()
{
    return $this->belongsTo(Prof::class);
}

public function stage()
{
    return $this->belongsTo(Stage::class);
}

}
