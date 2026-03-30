<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class MakeMotor extends Model
{
    use LogsUserActivity;
    protected $guarded=[];

    public function applications(){
        return $this->hasMany(Application::class,'make_motor_id');
    }

    public function quotations(){
        return $this->hasMany(Quotation::class,'make_motor_id');
    }

     public function applications2(){
        return $this->hasMany(Application::class,'make_motor2_id');
    }

    public function quotations2(){
        return $this->hasMany(Quotation::class,'make_motor2_id');
    }
    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('name', 'asc');
        });
    }
}
