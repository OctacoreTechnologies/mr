<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, LogsUserActivity;

    protected $guarded=[];

    public function quotations(){
        return $this->hasMany(Quotation::class,'product_id');
    }

}
