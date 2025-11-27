<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MixingTool extends Model
{
    protected $guarded=[];

      public function quotations(){
        return $this->hasMany(Quotation::class,'mixing_tool_id');
       }

       public function applications(){
        return $this->hasMany(Quotation::class,'mixing_tool_id');
       }
}
