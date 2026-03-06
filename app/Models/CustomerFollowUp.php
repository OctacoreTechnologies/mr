<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class CustomerFollowUp extends Model
{
    use LogsUserActivity;
    protected $guarded=[];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
