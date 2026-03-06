<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class MixingTool extends Model
{
  use LogsUserActivity;
  protected $guarded = [];

  public function quotations()
  {
    return $this->hasMany(Quotation::class, 'mixing_tool_id');
  }

  public function applications()
  {
    return $this->hasMany(Quotation::class, 'mixing_tool_id');
  }

  public function model()
  {
    return $this->belongsTo(Modele::class, 'model_id');
  }

  protected static function booted()
  {
    static::addGlobalScope('order', function ($query) {
      $query->orderBy('mixing_tool', 'asc');
    });
  }
}
