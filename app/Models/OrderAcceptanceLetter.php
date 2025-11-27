<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAcceptanceLetter extends Model
{
    protected $tabe = 'order_acceptance_letters';

    protected $guarded=[];

    public function saleOrder(){
        return $this->belongsTo(SaleOrder::class,'sale_order_id');
    }

}
