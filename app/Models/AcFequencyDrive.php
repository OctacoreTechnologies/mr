<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class AcFequencyDrive extends Model
{
  use LogsUserActivity;
  protected $guarded = [];

  public function quotations()
  {
    return $this->hasMany(Quotation::class, 'ac_frequenc y_drive_id');
  }

  public function applications()
  {
    return $this->hasMany(Application::class, 'ac_frequency_drive_id');
  }
   public function quotations2()
  {
    return $this->hasMany(Quotation::class, 'ac_frequency_drive2_id');
  }
  public function applications2()
  {
    return $this->hasMany(Application::class, 'ac_frequency_drive2_id');
  }

}
