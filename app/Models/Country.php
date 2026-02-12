<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table="countries";

    protected $guarded=[];

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('country', 'asc');
        });
    }

}
