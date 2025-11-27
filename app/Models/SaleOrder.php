<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SaleOrder extends Model
{
    use SoftDeletes;
    protected $guarded=[];

    public function quotation(){
        return $this->belongsTo(Quotation::class,'quotation_id');
    }

    public function payments(){
        return $this->hasMany(SaleLedger::class,'sale_order_id');
    }

      protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });

        static::updated(function($model){
             $customer=Customer::findOrFail($model->quotation->customer_id);
             if($model->status=='delivered'){
                $customer->status='existing';
                $customer->save();
             }
        });
    }

    public function followedBy(){
        return $this->belongsTo(User::class,'followed_by');
    }

    public function saleLedgers(){
        return $this->hasMany(SaleLedger::class,'sale_order_id');
    }

    public function orderAcceptanceLetter(){
        return $this->hasOne(OrderAcceptanceLetter::class,'sale_order_id');
    }

      public static function countWorkOrdersByWorkOrderNo($prefix){
        // $prefix = 'MR/M-056/';
        $financialYear = getFinancialYear(); // returns '25-26'
        
        // Get the latest work_order_no for this financial year
        $lastOrder = self::where('work_order_no', 'LIKE', "{$prefix}%/{$financialYear}")
            ->orderByDesc('id')
            ->first();

        $nextSequence = '001'; // default

        if ($lastOrder) {
            // Extract sequence number (e.g., '005')
            $parts = explode('/', $lastOrder->work_order_no);
            $lastSeq = (int)$parts[2] ?? 0;
            $nextSequence = str_pad($lastSeq + 1, 3, '0', STR_PAD_LEFT);
        }

        return "{$prefix}{$nextSequence}/{$financialYear}";
    }
    
}
