<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=['id'];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Define the relationship with SalesOrderItem
    public function items(): HasMany
    {
        return $this->hasMany(SalesOrderItem::class);
    }
    
    // Define the relationship with SalesOrderItem
    public function production(): HasOne
    {
        return $this->hasOne(Production::class);
    }
        
    // Define the relationship with SalesOrderItem
    public function production_many(): HasMany
    {
        return $this->hasMany(Production::class);
    }        
    // Define the relationship with SalesOrderItem
    public function production_details_many(): HasMany
    {
        return $this->hasMany(ProductionDetails::class);
    }
    
}
