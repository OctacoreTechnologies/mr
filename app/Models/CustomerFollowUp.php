<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerFollowUp extends Model
{
    use LogsUserActivity,SoftDeletes;
    protected $guarded=[];

    protected $casts = [
        'follow_up_date'      => 'datetime',
        'next_follow_up_date' => 'datetime',
    ];
 
    /* ── Relationships ── */
 
    public function documents()
    {
        return $this->hasMany(CustomerFollowUpDocument::class, 'follow_up_id');
    }
 
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
