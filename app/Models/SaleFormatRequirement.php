<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleFormatRequirement extends Model
{
    protected $fillable = [
        'sale_format_id',
        'requirement_description',
        'sort_order',
    ];

    public function saleFormat()
    {
        return $this->belongsTo(SaleFormat::class);
    }
}
