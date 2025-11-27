<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guarded=[];

      public function quotations(){
        return $this->hasMany(Quotation::class,'batch_id');
      }

      public function quotations2(){
        return $this->hasMany(Quotation::class,'batch2_id');
      }

      public function applications(){
        return $this->hasMany(Quotation::class,'batch_id');
      }
      public function machine(){
        return $this->belongsTo(Machine::class,'machine_id');
      }
      public function modele(){
        return $this->belongsTo(Modele::class,'model_id');
      }
}
