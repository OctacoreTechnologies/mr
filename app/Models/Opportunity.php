<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Opportunity extends Model
{
    use SoftDeletes;
    protected $guarded=[];



    public function quotation(){
        return $this->belongsTo(Quotation::class,'quotation_id');
    }

      protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }

    public function lead(){
        return $this->belongsTo(Lead::class,'lead_id');
    }
}
