<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleFormat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'cp_name',
        'cp_designation',
        'cp_contact',
        'cp_email',
        'sale_date',
        'sale_details',
        'remark',
        'prepared_by',
        'approved_by',
        'upload_file_path',
        'status',
    ];

    protected $casts = [
        'sale_date'        => 'date',
        'sale_details'     => 'array',
        'upload_file_path' => 'array',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function requirements()
    {
        return $this->hasMany(SaleFormatRequirement::class)->orderBy('sort_order');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }
}
