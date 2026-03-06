<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class Ublades extends Model
{
    use LogsUserActivity;
    protected $guarded = [];

    public function applications(){
        return $this->hasMany('blade_id',Ublades::class);
    }

    public function models(){
        return $this->hasMany('blade_id',Ublades::class);
    }
}
