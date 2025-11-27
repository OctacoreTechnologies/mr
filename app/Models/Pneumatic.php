<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pneumatic extends Model
{
    protected $guarded=[];

      public function quotations(){
        return $this->hasMany(Quotation::class,'pneuamtic_id');
       }

      public function applications(){
        return $this->hasMany(Quotation::class,'pneuamtic_id');
       }
}
