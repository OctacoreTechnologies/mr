<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $guarded=["id"];

    public function machineType(){
        return $this->belongsTo(MachineType::class,'machine_type_id');
    }

    public function quotations(){
        return $this->hasMany(Quotation::class,'machine_id');
    }

    public function applications(){
        return $this->hasMany(Quotation::class,'batch_id');
    }

    public function modeles(){
        return $this->hasMany(Modele::class,'machine_id');
    }

    public function blades(){
        return $this->hasMany(Blade::class,'machine_id');
    }

    public function batches(){
        return $this->hasMany(Batch::class,'machine_id');
    }

    public function emails(){
        return $this->hasMany(Email::class,'machine_id');
    }


    // sorting
    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('name', 'asc');
        });
    }
}
