<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
  use LogsUserActivity;
  protected $guarded = [];

  public function quotations()
  {
    return $this->hasMany(Quotation::class, 'batch_id');
  }

  public function quotations2()
  {
    return $this->hasMany(Quotation::class, 'batch2_id');
  }

  public function applications()
  {
    return $this->hasMany(Quotation::class, 'batch_id');
  }

  public function applications2()
  {
    return $this->hasMany(Quotation::class, 'batch2_id');
  }
  public function machine()
  {
    return $this->belongsTo(Machine::class, 'machine_id');
  }
  public function model()
  {
    return $this->belongsTo(Modele::class, 'model_id');
  }

  protected static function booted()
  {
    static::addGlobalScope('order', function ($query) {
      $query->orderByRaw("
            CAST(
                TRIM(
                    SUBSTRING_INDEX(batches, '-', 1)
                ) AS UNSIGNED
            ) ASC
        ");
    });
  }
}
