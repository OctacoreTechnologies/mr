<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationFolloUp extends Model
{
    protected $guarded=[];
    public function quotation(){
        return $this->belongsTo(Quotation::class,' quotation_id');
    }
}
