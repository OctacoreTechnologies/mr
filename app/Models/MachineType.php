<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    protected $guarded=["id"];

    public function machines(){
        return $this->hasMany(Machine::class,'machine_type_id');
    }

    //   public function quotations(){
    //     return $this->hasMany(Quotation::class,'ac_frequency_drive_id');
    //    }
}
