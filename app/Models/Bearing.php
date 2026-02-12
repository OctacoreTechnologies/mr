<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bearing extends Model
{
  protected $guarded = [];
  public function quotations()
  {
    return $this->hasMany(Quotation::class, 'bearing');
  }

  public function applications()
  {
    return $this->hasMany(Quotation::class, 'batch_id');
  }

  protected static function booted()
  {
    static::addGlobalScope('order', function ($query) {
      $query->orderBy('bearing', 'asc');
    });
  }
}
