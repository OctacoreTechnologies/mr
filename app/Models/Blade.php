<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blade extends Model
{
    protected $guarded=[];

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }
    public function model()
    {
        return $this->belongsTo(Modele::class, 'model_id');
    }

}
