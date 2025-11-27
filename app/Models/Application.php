<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded=['id'];

      public function quotations(){
        return $this->hasMany(Quotation::class,'application_id');
      }

    public function modele(){
       return $this->belongsTo(Modele::class,'model_id');
     }
   public function machine(){
    return $this->belongsTo(Machine::class,'machine_id');
   }
   
   public function materialToProcess(){
     return $this->belongsTo(MaterialToProcess::class,'material_to_process_id');
   }

   public function batch(){
     return $this->belongsTo(Batch::class,'batch_id');
   }
   public function mixingTool(){
     return $this->belongsTo(MixingTool::class,'mixing_tool_id'); 
   }

   public function motorRequirement(){
    return $this->belongsTo(MototRequirement::class,'motor_requirement_id');
   }

   public function electricalControl(){
     return $this->belongsTo(ElelctricalControl::class,'electrical_control_id');
   }
   public function acFrequencyDrive(){
    return $this->belongsTo(AcFequencyDrive::class,'ac_frequency_drive_id');
   }
   public function bearing(){
     return $this->belongsTo(Bearing::class,'bearing_id');
   }

   public function pneumatics(){
    return $this->belongsTo(Pneumatic::class,'pneuamtic_id');
   }

   public function applicaton(){
    return $this->belongsTo(Application::class,'application_id');
   }

   public function makeMotor(){
    return $this->belongsTo(MakeMotor::class,'make_motor_id');
   }

   public function email(){
    return $this->hasOne(Email::class,'application_id');
   }
   
}
