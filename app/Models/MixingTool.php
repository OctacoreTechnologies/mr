<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MixingTool extends Model
{
  protected $guarded = [];

  public function quotations()
  {
    return $this->hasMany(Quotation::class, 'mixing_tool_id');
  }

  public function applications()
  {
    return $this->hasMany(Quotation::class, 'mixing_tool_id');
  }

  protected static function booted()
  {
    static::addGlobalScope('order', function ($query) {
      $query->orderBy('mixing_tool', 'asc');
    });
  }
}
