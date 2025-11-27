<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ublades extends Model
{
    protected $guarded = [];

    public function applications(){
        return $this->hasMany('blade_id',Ublades::class);
    }

    public function models(){
        return $this->hasMany('blade_id',Ublades::class);
    }
}
