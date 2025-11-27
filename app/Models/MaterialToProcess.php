<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialToProcess extends Model
{
    protected $guarded=[];

      public function quotations(){
        return $this->hasMany(Quotation::class,'material_to_process_id');
      }
}
