@extends('layouts.app')

@section('title', 'Order Acceptance Letter')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 text-primary font-weight-bold">Order Acceptance letter</h1>
    <a href="{{ route('sale-order.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>
@stop

@php
    // Only include fields that are marked as 1
    $dropdownFields = collect($fields)->filter(function ($value, $key) {
        return $value == 1;
    });
 @endphp

@section('content')
<x-alert-components class="mb-3" />
<form action="{{ route('orderaceptance.update', $orderAcceptanceLetter->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-plus-circle"></i> OAL</h3>
        </div>

        <div class="card-body">
            <div class="row">
                @if ($errors->any())
                    {{ $errors }}
                @endif
                <div class="col-md-4">
                    <x-adminlte-input type="text" label="Work Order No." name="work_order" value="{{ $saleOrder->work_order_no }}" readonly/>
                </div>
                <div class="col-md-4">
                    <x-adminlte-input type="text" label="Machine" name="machine" value="{{ $quotation->machine->name??'' }}" />
                </div>
                {{--<div class="col-md-4">
                    <x-adminlte-input type="text" label="Material To Be Process" name="application" value="{{ $quotation->application->name??'' }}" />
                </div>--}}
                <div class="col-md-4">
                    <x-adminlte-select name="modele" label="Model">
                     @foreach ($modeles as $model)

                      <option value="{{ $model }}" {{ $quotation->model_id == $model->id?'selected':''}}>{{ $model->name }}</option>
                     
                     @endforeach
                    </x-adminlte-select>
                </div>

                @foreach($dropdownFields as $key => $val)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="{{ $key . '_id' }}">{{ ucwords(str_replace('_', ' ', $key)) }}</label>

                            <select name="{{ $key  }}" id="{{ $key . '_id' }}" class="form-control select2"
                                style="width: 100%;">
                                <option value="">Select {{ ucwords(str_replace('_', ' ', $key)) }}</option>

                                @if($key == 'material_to_process')
                                  @if($quotation->machine->name == 'High Speed Heater Mixer'||$quotation->machine->name == 'High Speed Heater Mixer Vessel' || $quotation->machine->name == 'High Speed Heater Mixer Blade')
                                  <option value="Rigid PVC" selected>Rigid PVC</option>
                                    <option value="Soft PVC">Soft PVC</option>
                                    <option value="WPC">WPC</option>  
                                    <option value="Natural Raw Material Compounds">Natural Raw Material Compounds</option>  
                                    <option value="Pololefines">Pololefines</option>  
                                    <option value="Coating of Minrals">Coating of Minrals</option> 
                                    <option value="Stabiliser Compounds">Stabiliser Compounds</option>  
                                    <option value="Masterbatch ">Masterbatch </option>  
                                    <option value="Colour concentrates">Colour concentrates</option>  
                                    <option value="Pre Heating">Pre Heating</option>  
                                    <option value="Pre Mixing">Pre Mixing</option> 
                                  @elseif($quotation->machine->name == 'Grinder')
                                    <option value="Molding" selected>Molding</option>
                                    <option value="Pipe">Pipe</option>
                                    <option value="Cable Lump">Cable Lump</option>
                                    <option value="Molding Scrap">Molding Scrap</option>
                                    <option value="Extrusion Scrap">Extrusion Scrap</option>
                                    <option value="PVC Profile">PVC Profile</option>
                                 @elseif($quotation->machine->name == 'Vertical Cooler Mixer' || $quotation->machine->name == 'Horizontal Cooler Mixer')
                                    <option value="Rigid PVC" selected>Rigid PVC</option>
                                    <option value="Soft PVC">Soft PVC</option>
                                    <option value="WPC">WPC</option>
                                    <option value="Natural Raw Material Compounds">Natural Raw Material Compounds</option>
                                    <option value="Pololefines">Pololefines</option>
                                    <option value="Coating of Minrals">Coating of Minrals</option>
                                 @elseif($quotation->machine->name == 'Agglomerator')
                                    <option value="POY" selected>POY</option>
                                    <option value="Wiry">Wiry</option>
                                    <option value="Polyester Film">Polyester Film</option>
                                    <option value=" LD Film">LD Film</option>
                                    <option value=" HD Film"> HD Film</option>
                                    <option value="PP Film">PP Film</option>
                                 @elseif($quotation->machine->name == 'Agglomerator Bottom Vessel')
                                    <option value="PVC" selected>PVC</option>
                                    <option value="LD">LD</option>
                                    <option value=" LDE">LDE</option>            
                                    
                                 @endif
                                  
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif


                                @endif
                                @if($key == 'batch_capacity')
                                    @foreach ($batches as $batche)
                                        <option value="{{$batche->batches}}">{{ $batche->batches }}</option>
                                    @endforeach
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'motor')
                                    @foreach ($motors as $motor)
                                      @if(!is_null($motor))
                                        <option value="{{$motor->motor_requirement}}" {{ $motor->id ==  $quotation->motor_requirement_id?'selected':'' }}>{{ $motor->motor_requirement }}</option>
                                      @endif
                                    @endforeach
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'motor_make')
                                    @foreach ($motor_makes as $motor)
                                        <option value="{{$motor->name}}" {{ $motor->id == $quotation->make_motor_id?'selected':'' }}>{{ $motor->name }}</option>
                                    @endforeach
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'discharge_operated')
                                    <option value="Pneumatic Box" selected>Pneumatic Box</option>
                                    <option value="Hand Lever" >Hand Lever</option>
                                    <option value="Screw Type Model">Screw Type Model</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'top_dish_cylinder_operation')
                                    <option value="Pneumatic ( Standard )">   Pneumatic ( Standard )</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'cylinder_make')
                                    <option value="SPAC" >SPAC
                                    </option>
                                    <option value="JANATICS">JANATICS</option>
                                    <option value="Festo" >Festo</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'top_dish_opening_type')
                                    <option value="Arm Type" >Arm Type</option>
                                    <option value="Sliding Type">Sliding Type</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'blade_tier')
                                    <option value="2" {{ $orderAcceptanceLetter->blade_tier == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $orderAcceptanceLetter->blade_tier == '3' ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $orderAcceptanceLetter->blade_tier == '4' ? 'selected' : '' }}>4</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'mixing_container')
                                    <option value="Jacketed" selected>Jacketed</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif

                                @endif
                                @if($key == 'top_dish_thickness')
                                    <option value="4" selected>4</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'ms_shell_thickness')
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'ms_bottom_dish_thickness')
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'ss_shell_thickness')
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'ss_bottom_dish_thickness')
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'nos_of_opening_in_mixer_lid')
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'pulley_type')
                                    <option value="Taper Lock ( Standard )" selected>Taper Lock ( Standard )</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'top_bearing_make')
                                    @foreach ($bearings as $bearinge)
                                        <option value="{{ $bearinge->bearing }}">{{ $bearinge->bearing }}</option>
                                    @endforeach
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'bottom_bearing_make')
                                    @foreach ($bearings as $bearinge)
                                        <option value="{{ $bearinge->bearing }}">{{ $bearinge->bearing }}</option>
                                    @endforeach
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'tool_speed_selection')
                                    <option value="Pot Type">Pot Type</option>
                                    <option value="Push Button Type" selected>Push Button Type</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'safety_switch')
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'platform_railing_ladder')
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'electrical_panel')
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'remote_electrical_panel')
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'ac_frequency_drive_make')
                                    @foreach ($acFrequencyDrives as $ac):
                                        <option value="{{ $ac->ac_fequency_drive }}">{{ $ac->ac_fequency_drive }}</option>
                                    @endforeach
                                     @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'gasket_type')
                                    <option value="Standard" selected>M R Engineers - Standard</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'elevation_stand')
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'pneumatic_operation')
                                    <option value="Pneumatic Box">Pneumatic Box</option>
                                    <option value="Hand Lever Valve" selected>Hand Lever Valve</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'paint')
                                    <option value="PU Paint" selected>PU Paint</option>
                                    <option value="Oil Paint">Oil Paint</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'layout_drawing')
                                    <option value="Layout-A" selected>Layout-A</option>
                                    <option value="Layout-B">Layout-B</option>
                                    <option value="Layout-C">Layout-C</option>
                                    <option value="Layout-D">Layout-D</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'cooling_ring')
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'gear_box_make')
                                    <option value="Elecon Make" selected>Elecon Make</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'coupling')
                                    <option value="Pin Bush Type - Standard" selected>Pin Bush Type - Standard</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'coupling_make')
                                    <option value="Local" selected> Local</option>
                                    <option value="Elecon"> Elecon</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'motor_rpm')
                                    <option value="Single Speed 1440 RPM" selected> Single Speed 1440 RPM</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'panel_type')
                                    <option value="DOL" selected>DOL</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'panel_kw/hp')
                                    <option value="As Per Motor" selected>As Per Motor</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                @if($key == 'remote_box')
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'limit_switch')
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'mesh_hole_dia')
                                    <option value="8" selected>8</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'hopper_type')
                                    <option value="Article Type" selected>Article Tyoe</option>
                                    <option value="Pipe Type">Pipe Type</option>
                                    <option value="Profie Type">Profile Type</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'hopper_opening_type')
                                    <option value="Manual Type" selected>Manual Type</option>
                                    <option value="Screw Type">Screw Type</option>
                                    <option value="Hydraulic Type">Hydraulic Type</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'collecting_container')
                                    <option value="Standard Container" selected>Standard Container</option>
                                    <option value="Cyclone Container">Cyclone Container</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'fix_blade')
                                    <option value="2" selected>2</option>
                                    <option value="4">4</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                                @if($key == 'rotating_balde')
                                    <option value="3" selected>3</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif
                                 @if($key == 'pulley_make')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'pnuematic_operations')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'model_no')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'work_order_no_for_name_plate')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'blade')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'dishcharge_valve_hieght_from_ground')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'remote_for_electrical_panel')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'discharge_cover')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'deflector')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                 @if($key == 'ac_frequency_drive_model')
                                      @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                         <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                             {{ $orderAcceptanceLetter->$key }}</option>
                                      @endif
                                 @endif
                                @if($key == 'year')
                                    @if (isset($orderAcceptanceLetter->$key) && $orderAcceptanceLetter->$key)
                                        <option value="{{ $orderAcceptanceLetter->$key }}" selected>
                                            {{ $orderAcceptanceLetter->$key }}</option>
                                    @endif
                                @endif

                            </select>

                        </div>
                    </div>
                @endforeach
                   <div class="col-md-4">
                              <x-adminlte-input type="date" name="delivery_date" value="{{ $orderAcceptanceLetter->delivery_date}}" label="Delivery Date" />
                    </div>
                @for ($i=1;$i<=5;$i++)
                 <div class="col-md-4">
                    <x-adminlte-textarea name="remark_{{ $i }}" label="Remark {{ $i }}" id="remark_{{ $i }}_id">
                       {{ $orderAcceptanceLetter->{'remark_' . $i} }}
                    </x-adminlte-textarea>
                 </div>
                @endfor

            </div>

            <hr>


        </div>

        <div class="card-footer text-right bg-light">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Order
            </button>
            <a href="{{ route('sale-order.index') }}" class="btn btn-secondary">
                <i class="fas fa-times-circle"></i> Cancel
            </a>
        </div>
    </div>
</form>
@stop

@push('css')
    <style>
        .transaction-id.d-none,
        .remarks.d-none {
            display: none !important;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('js/sale_order.js') }}"></script>
    <script>
        $(document).ready(function(){
         
            $('#delivery_date_id').parent().parent().remove();
            $("#id_id").parent().parent().remove();
            
        })
    </script>
@endpush