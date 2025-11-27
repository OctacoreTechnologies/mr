<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use PDO;

class Lead extends Model
{
    use SoftDeletes;
    protected $guarded=[];


    public function opportunities(){
        return $this->hasMany(Opportunity::class);
    }

    public function leadFollowUps(){
        return $this->hasMany(LeadFollowup::class,'lead_id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function leadFollowedBy(){
        return $this->belongsTo(User::class,'followed_by');
    }

    public function opportunity(){
        return $this->hasMany(Opportunity::class,'lead_id');
    }

}
