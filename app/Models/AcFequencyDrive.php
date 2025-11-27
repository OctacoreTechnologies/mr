<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcFequencyDrive extends Model
{
    protected $guarded=[];

       public function quotations(){
        return $this->hasMany(Quotation::class,'ac_frequenc y_drive_id');
       }
        
      public function applications(){
        return $this->hasMany(Quotation::class,'ac_frequency_drive_id');
       }
    
}
