<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    use LogsUserActivity;
    protected $guarded=["id"];

    public function machines(){
        return $this->hasMany(Machine::class,'machine_type_id');
    }

    //   public function quotations(){
    //     return $this->hasMany(Quotation::class,'ac_frequency_drive_id');
    //    }
}
