<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class Bearing extends Model
{
  use LogsUserActivity;
  protected $guarded = [];
  public function quotations()
  {
    return $this->hasMany(Quotation::class, 'bearing');
  }

  public function applications()
  {
    return $this->hasMany(Application::class, 'bearing_id');
  }

  public function quotations2()
  {
    return $this->hasMany(Quotation::class, 'bearing2_id');
  }

  public function applications2()
  {
    return $this->hasMany(Application::class, 'bearing2_id');
  }

  protected static function booted()
  {
    static::addGlobalScope('order', function ($query) {
      $query->orderBy('bearing', 'asc');
    });
  }
}
