<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class Capacity extends Model
{
    protected $guarded = [];

    public function model(){
       return $this->belongsTo(Modele::class, 'model_id');
    }
}
