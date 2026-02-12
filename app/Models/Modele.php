<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    protected $table = "modeles";
    protected $guarded=[];

    public function modeles(){
        return $this->hasMany(Quotation::class,'model_id');
    }

    public function machine(){
        return $this->belongsTo(Machine::class,'machine_id');
    }

    public function motorRequirement(){
        return $this->belongsTo(MototRequirement::class,'motor_id');
    }

     public function motorRequirement2(){
        return $this->belongsTo(MototRequirement::class,'motor2_id');
    }
    
    public function quotations(){
        return $this->hasMany(Quotation::class,'model_id');
    }

    public function capacities(){
        return $this->hasMany(Capacity::class,'model_id');
    }

    public function blades(){
        return $this->hasMany(Blade::class,'model_id');
    }

    public function batches(){
        return $this->hasMany(Batch::class,'model_id');
    }

    public function application(){
        return $this->belongsTo(Application::class,'model_id');
    }

    public function blowers(){
        return $this->hasMany(Blower::class,'model_id');
    }

    public function rotaryAirLockValve(){
        return $this->hasMany(RotaryAirLockValve::class,'model_id');
    }

    public function feedingHooperCapacity(){
        return $this->hasMany(FeedingHooperCapacity::class,'model_id');
    }

      // sorting
   protected static function booted()
{
    static::addGlobalScope('order', function ($query) {
        $query->orderByRaw("
            CAST(
                REGEXP_SUBSTR(name, '[0-9]+')
            AS UNSIGNED
            ) ASC
        ");
    });
}

}

    