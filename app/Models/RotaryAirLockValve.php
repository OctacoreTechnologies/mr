<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class RotaryAirLockValve extends Model
{
    use LogsUserActivity;
    protected $guarded = [];

    public function model()
    {
        return $this->belongsTo(Modele::class, 'model_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('rotary_air_lock_valve', 'asc');
        });
    }
}
