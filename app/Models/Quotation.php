<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Quotation extends Model
{
  use SoftDeletes;
  protected $guarded = [];

  // public function opportunity(){
  //     return $this->belongsTo(Opportunity::class,'opportunity_id');
  // }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function modele()
  {
    return $this->belongsTo(Modele::class, 'model_id');
  }
  public function machine()
  {
    return $this->belongsTo(Machine::class, 'machine_id');
  }

  public function materialToProcess()
  {
    return $this->belongsTo(MaterialToProcess::class, 'material_to_process_id');
  }

  public function batch()
  {
    return $this->belongsTo(Batch::class, 'batch_id');
  }

  public function batche2()
  {
    return $this->belongsTo(Batch::class, 'batch2_id');
  }
  public function mixingTool()
  {
    return $this->belongsTo(MixingTool::class, 'mixing_tool_id');
  }

  public function motorRequirement()
  {
    return $this->belongsTo(MototRequirement::class, 'motor_requirement_id');
  }

  public function motorRequirement2()
  {
    return $this->belongsTo(MototRequirement::class, 'motor_requirement2_id');
  }

  public function electricalControl()
  {
    return $this->belongsTo(ElelctricalControl::class, 'electrical_control_id');
  }
  public function acFrequencyDrive()
  {
    return $this->belongsTo(AcFequencyDrive::class, 'ac_frequency_drive_id');
  }
  public function bearinge()
  {
    return $this->belongsTo(Bearing::class, 'bearing_id');
  }

  public function pneumatic()
  {
    return $this->belongsTo(Pneumatic::class, 'pneumatic_id');
  }

  public function application()
  {
    return $this->belongsTo(Application::class, 'application_id');
  }

  public function makeMotor()
  {
    return $this->belongsTo(MakeMotor::class, 'make_motor_id');
  }

  public function quotationFollowUps()
  {
    return $this->hasMany(QuotationFolloUp::class, 'quotation_id');
  }

  public function quotationNotifications()
  {
    return $this->hasMany(QuotationNotification::class, 'quotation_id');
  }

  public function opportunity()
  {
    return $this->hasOne(Opportunity::class, 'quotation_id');
  }

  public function saleOrder()
  {
    return $this->hasOne(SaleOrder::class, 'quotation_id');
  }

  public function sourceQuotation()
  {
    return $this->belongsTo(Quotation::class, 'reordered_from');
  }

  public function reorders()
  {
    return $this->hasMany(Quotation::class, 'reordered_from');
  }

  public function followedBy()
  {
    return $this->belongsTo(User::class, 'followed_by');
  }

  protected static function booted()
  {
    static::creating(function ($model) {
      if (Auth::check()) {
        $model->user_id = Auth::id();
      }
    });
    static::created(function ($model) {
      $customer = Customer::findOrFail($model->customer_id);
      if ($customer->status != 'existing') {
        $customer->status = 'quotated';
      }
      $customer->save();
    });
  }
}
