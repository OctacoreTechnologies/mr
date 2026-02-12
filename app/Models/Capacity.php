<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class Capacity extends Model
{
    protected $guarded = [];

    public function model()
    {
        return $this->belongsTo(Modele::class, 'model_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderByRaw("
            CAST(
                TRIM(
                    SUBSTRING_INDEX(capacity, '-', 1)
                ) AS UNSIGNED
            ) ASC
        ");
        });
    }
}
