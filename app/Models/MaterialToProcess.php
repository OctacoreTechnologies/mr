<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialToProcess extends Model
{
  protected $guarded = [];

  public function quotations()
  {
    return $this->hasMany(Quotation::class, 'material_to_process_id');
  }

  public function model()
  {
    return $this->belongsTo(Modele::class, 'model_id');
  }

  protected static function booted()
  {
    static::addGlobalScope('order', function ($query) {
      $query->orderBy('material_to_process', 'asc');
    });
  }
}
