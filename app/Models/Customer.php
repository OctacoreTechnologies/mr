<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    protected $guarded=[];

    public function quotations(){
        return $this->hasMany(Quotation::class,'customer_id');
    }

    public function customerFollowUps(){
        return $this->hasMany(CustomerFollowUp::class,'customer_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function followedBy(){
        return $this->belongsTo(User::class,'followed_by');
    }

    public function saleOrder(){
         return $this->hasManyThrough(
            SaleOrder::class,
            Quotation::class,
            'customer_id',
            'quotation_id',
            'id',
            'id'
         );
    }

    protected static function booted(){
          static::creating(function ($model) {
              if (Auth::check()) {
                  $model->user_id = Auth::id();
              }
          });
      }


    
}
