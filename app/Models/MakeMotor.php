<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakeMotor extends Model
{
    protected $guarded=[];

    public function applications(){
        return $this->hasMany(Application::class,'make_motor_id');
    }

    public function quotations(){
        return $this->hasMany(Quotation::class,'make_motor_id');
    }
}
