<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class OrderAcceptanceLetter extends Model
{
    use LogsUserActivity;
    protected $tabe = 'order_acceptance_letters';

    protected $guarded=[];

    public function saleOrder(){
        return $this->belongsTo(SaleOrder::class,'sale_order_id');
    }

}
