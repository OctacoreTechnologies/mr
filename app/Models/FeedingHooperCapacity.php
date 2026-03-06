<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class FeedingHooperCapacity extends Model
{
    use LogsUserActivity;
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
