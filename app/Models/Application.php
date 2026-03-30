<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use LogsUserActivity;

    protected $guarded = ['id'];

    // ===================== Primary Relations =====================

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'application_id');
    }

    public function modele()
    {
        return $this->hasMany(Modele::class, 'application_id');
    }

    public function email()
    {
        return $this->hasOne(Email::class, 'application_id');
    }

    // ===================== Technical Specs Relations =====================

    public function materialToProcess()
    {
        return $this->belongsTo(MaterialToProcess::class, 'material_to_process_id');
    }

    public function capacity()
    {
        return $this->belongsTo(Capacity::class, 'capacity_id');
    }

    public function rotatingBlade()
    {
        return $this->belongsTo(Blade::class, 'no_of_rotating_blade_id');
    }

    public function fixedBlade()
    {
        return $this->belongsTo(Blade::class, 'no_of_fixes_blade_id');
    }

    public function blower()
    {
        return $this->belongsTo(Blower::class, 'blower_id');
    }

    public function rotaryAirLockValve()
    {
        return $this->belongsTo(RotaryAirLockValve::class, 'rotary_air_lock_valve_id');
    }

    public function feedingHooperCapacity()
    {
        return $this->belongsTo(FeedingHooperCapacity::class, 'feeding_hooper_capacity_id');
    }

    // ===================== First Application — Machine Config =====================

    public function motorRequirement()
    {
        return $this->belongsTo(MototRequirement::class, 'motor_requirement_id');
    }

    public function makeMotor()
    {
        return $this->belongsTo(MakeMotor::class, 'make_motor_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function mixingTool()
    {
        return $this->belongsTo(MixingTool::class, 'mixing_tool_id');
    }

    public function electricalControl()
    {
        return $this->belongsTo(ElelctricalControl::class, 'electrical_control_id');
    }

    public function acFrequencyDrive()
    {
        return $this->belongsTo(AcFequencyDrive::class, 'ac_frequency_drive_id');
    }

    public function bearing()
    {
        return $this->belongsTo(Bearing::class, 'bearing_id');
    }

    public function pneumatic()
    {
        return $this->belongsTo(Pneumatic::class, 'pneumatic_id');
    }

    public function driveSystem()
    {
        return $this->belongsTo(DriveSystem::class, 'drive_system_1_id');
    }

    public function gearBox()
    {
        return $this->belongsTo(GearBox::class, 'gear_box_id');
    }

    // ===================== Second Application — Machine Config =====================

    public function motorRequirement2()
    {
        return $this->belongsTo(MototRequirement::class, 'motor_requirement2_id');
    }

    public function makeMotor2()
    {
        return $this->belongsTo(MakeMotor::class, 'make_motor_2_id');
    }

    public function batch2()
    {
        return $this->belongsTo(Batch::class, 'batch2_id');
    }

    public function electricalControl2()
    {
        return $this->belongsTo(ElelctricalControl::class, 'electrical_control_2_id');
    }

    public function acFrequencyDrive2()
    {
        return $this->belongsTo(AcFequencyDrive::class, 'ac_frequency_drive_2_id');
    }

    public function bearing2()
    {
        return $this->belongsTo(Bearing::class, 'bearing_2_id');
    }

    public function pneumatic2()
    {
        return $this->belongsTo(Pneumatic::class, 'pneumatic_2_id');
    }

    // public function driveSystem2()
    // {
    //     return $this->belongsTo(DriveSystem::class, 'drive_system_2_id');
    // }

    // public function gearBox2()
    // {
    //     return $this->belongsTo(GearBox::class, 'gear_box_2_id');
    // }

    // ===================== Global Scope =====================

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('name', 'asc');
        });
    }
}