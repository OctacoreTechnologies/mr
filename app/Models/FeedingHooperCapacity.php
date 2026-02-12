<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedingHooperCapacity extends Model
{
    protected $table='feeding_hooper_capacities';
    protected $guarded = [];

    public function model(){
       return $this->belongsTo(Modele::class, 'model_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('feeding_hooper_capacity', 'asc');
        });
    }
}
