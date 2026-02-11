<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blower extends Model
{
    protected $guarded = [];

    public function model(){
       return $this->belongsTo(Modele::class, 'model_id');
    }
}
