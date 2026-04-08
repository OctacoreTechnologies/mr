<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThroatSize extends Model
{
    use LogsUserActivity,SoftDeletes;
    protected $guarded = [];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('size', 'like', '%' . $search . '%');
        }
    }

    public function model()
    {
        return $this->belongsTo(Modele::class, 'model_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'throat_size_id');
    }
}
