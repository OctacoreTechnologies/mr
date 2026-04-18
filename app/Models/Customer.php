<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use LogsUserActivity;
    protected $guarded = [];


    public function opportunities()
    {
        return $this->hasMany(Opportunity::class, 'customer_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'customer_id');
    }

    public function customerFollowUps()
    {
        return $this->hasMany(CustomerFollowUp::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followedBy()
    {
        return $this->belongsTo(User::class, 'followed_by');
    }

    public function saleOrder()
    {
        return $this->hasManyThrough(
            SaleOrder::class,
            Quotation::class,
            'customer_id',
            'quotation_id',
            'id',
            'id'
        );
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
        static::saved(function ($model) {
            if ($model->status == 'qualified') {
                Opportunity::create(
                    [
                        'customer_id' => $model->id,
                        'type' => 'new_enquiry',
                        'followed_by' => $model->followed_by,
                        'created_by' => Auth::id(),
                    ]
                );
            }
        });

        static::addGlobalScope('order', function ($query) {
            $query->orderBy('company_name', 'asc');
        });
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
