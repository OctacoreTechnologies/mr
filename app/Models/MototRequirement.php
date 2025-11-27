<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MototRequirement extends Model
{
    protected $guarded=[];
      public function quotations(){
        return $this->hasMany(Quotation::class,'motor_requirement_id');
     }
      public function applications(){
        return $this->hasMany(Quotation::class,'motor_requirement_id');
    }

    public function models(){
        return $this->hasMany(Modele::class,'motor_id');
    }

    public function models2(){
      return $this->hasMany(Modele::class,'motor2_id');
    }

     public function quotations2(){
        return $this->hasMany(Quotation::class,'motor_requirement2_id');
     }
}
