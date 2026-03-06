<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use LogsUserActivity;
    protected $table="countries";

    protected $guarded=[];

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('country', 'asc');
        });
    }

}
