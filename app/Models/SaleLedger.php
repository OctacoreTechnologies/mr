<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleLedger extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function saleOrder(){
        return $this->belongsTo(SaleOrder::class,'sale_order_id');
    }
    

}
