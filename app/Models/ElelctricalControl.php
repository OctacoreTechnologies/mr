<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElelctricalControl extends Model
{
    protected $guarded=[];

      public function quotations(){
        return $this->hasMany(Quotation::class,'electical_control_id');
     }
      public function applications(){
        return $this->hasMany(Quotation::class,'batch_id');
      }

      
    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('electrical_control', 'asc');
        });
    }
}
