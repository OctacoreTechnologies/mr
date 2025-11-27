@extends('layouts.app')

@section('title', 'Added Quotation')

@push('css')
<style>
    .readonly-input {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
    }
    .readonly-select {
        pointer-events: none;
        background-color: #f8f9fa !important;
        cursor: not-allowed;
    }
    .edit-icon {
        position: absolute;
        right: 10px;
        top: 38px;
        cursor: pointer;
        color: #007bff;
    }
    .form-group-position {
        position: relative;
    }
</style>
@endpush

@section('content_header')
    <h1>Added Quotation</h1>
@stop

@section('content')
<div class="card shadow-sm border-0 rounded-2">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Create Quotation</h4>
    </div>
    @if($errors->any())
    {{ $errors }}
    @endif
    <div class="card-body">
        {{-- {{ $errors }} --}}
        <form action="{{ route('quotation.store') }}" method="POST">
            @csrf
            @method("POST")
            <div class="row">
                {{-- Client (always readonly) --}}
                <div class="col-md-6 form-group">
                    <label>Client</label>
                    <select class="form-control  readonly-select" name="client_id">
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $previewData['client_id'] == $client->id ? 'selected' : '' }}>
                                {{ $client->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
 
                {{-- Machine --}}
                <div class="col-md-6 form-group">
                  <x-adminlte-input type="text" name="machine" label="Machine" value="{{ $machine->name }}" readonly/>
                  <input type="hidden" value="{{$machine->id }}" name="machine_id" />

                </div>

                 {{-- -models --}}
                  <div class="col-md-6 form-group">
                     <x-adminlte-input type="text" name="model_id" label="Model" value="{{ $model->name??'' }}" readonly/>
                     <input type="hidden" value="{{$model->id}}" name="model_id" id="model_id" />
                  </div>

                {{-- Application (always readonly) --}}
                <div class="col-md-6 form-group">
                    <x-adminlte-input name="application" value="{{$product->name}}" label="Application" placeholder="Application"  readonly/>
                    <input type="hidden" name="application_id" id="application_id" value="{{$product->id}}"  />
                </div>

                   <div class="col-md-6 form-group form-group-position">
                    <label>Quotation Ref No</label>
                    <input
                        type="text"
                        name="reference_no"
                        class="form-control readonly-input"
                        value="{{ $previewData['reference_no'] ?? '' }}"
                        readonly
                    >
                </div>

                {{-- Input fields with pencil icon --}}
                @php
                    $inputs = [
                        // ['label' => 'Quotation Ref No', 'name' => 'reference_no'],
                        ['label' => 'Date', 'name' => 'date', 'type' => 'date'],
                        ['label' => 'Quantity', 'name' => 'quantity', 'type' => 'number'],
                    ];
                @endphp

                @foreach ($inputs as $input)
                <div class="col-md-6 form-group form-group-position">
                    <label>{{ $input['label'] }}</label>
                    <input
                        type="{{ $input['type'] ?? 'text' }}"
                        name="{{ $input['name'] }}"
                        class="form-control readonly-input"
                        value="{{ $previewData[$input['name']] ?? '' }}"
                        readonly
                    >
                    <i class="fas fa-pencil-alt edit-icon"></i>
                </div>
                @endforeach

                {{-- Editable Total Price --}}
                <div class="col-md-6 form-group form-group-position">
                    <label>Total Price</label>
                    <input
                        type="number"
                        name="total_price"
                        class="form-control readonly-input"
                        value="{{ $previewData['total_price'] }}"
                        step="0.01"
                        readonly
                    >
                    <i class="fas fa-pencil-alt edit-icon"></i>
                </div>

                 <div class="col-md-6 form-group form-group-position">
                    <label>Discount</label>
                    <input
                        type="number"
                        name="discount"
                        class="form-control readonly-input"
                        value="{{ $previewData['discount'] }}"
                        step="0.01"
                        readonly
                    > 
                    <i class="fas fa-pencil-alt edit-icon"></i>
                </div>

                {{-- Dynamic Select Fields --}}
                @php
                    $selects = [
                        ['label' => 'Select Material to Process', 'name' => 'material_to_process','name1' => 'material_to_process_id', 'options' => $materialToProcess, 'key' => 'material_to_process'],
                        ['label' => 'Select Motor Requirement', 'name' => 'motor_requirement', 'name1' => 'motor_requirement_id', 'options' => $motorRequirements, 'key' => 'motor_requirement'],
                        ['label' => 'Select Second Application Motor Requirement', 'name' => 'motor_requirement2', 'name1' => 'motor_requirement2_id', 'options' => $motorRequirements2, 'key' => 'motor_requirement'],
                        ['label' => 'Select Batch', 'name' => 'batch', 'name1' => 'batch_id' , 'options' => $batches, 'key' => 'batches'],
                        ['label' => 'Select Batch for Second Application', 'name' => 'batch2', 'name1' => 'batch2_id' , 'options' => $batches, 'key' => 'batch2'],
                        ['label' => 'Mixing Tool', 'name' => 'mixing_tool', 'name1' => 'mixing_tool_id', 'options' => $mixingTools, 'key' => 'mixing_tool'],
                        ['label' => 'Electrical Control', 'name' => 'electrical_control', 'name1' => 'electrical_control_id', 'options' => $electricalControls, 'key' => 'electrical_control'],
                        ['label' => 'Select Ac Frequency Drives', 'name' => 'ac_frequency_drive', 'name1' => 'ac_frequency_drive_id', 'options' => $acFrequencyDrives, 'key' => 'ac_fequency_drive'],
                        ['label' => 'Select Bearing', 'name' => 'bearing', 'name1' => 'bearing_id' ,'options' => $bearings, 'key' => 'bearing'],
                        ['label' => 'Select Pneumatics', 'name' => 'pneumatic', 'name1' => 'pneumatic_id', 'options' => $pneumatics, 'key' => 'pneumatic'],
                        ['label' => 'Select Make Motor', 'name' => 'make_motor', 'name1' => 'make_motor_id', 'options' => $makeMotors, 'key' => 'name'],
                        ['label' => 'Select No of Rotating Blade', 'name' => 'no_of_rotating_blades', 'name1' => 'no_of_rotating_blade_id', 'options' => $noOfRotatingBlades, 'key' => 'no_of_blades'],
                        ['label' => 'Select No of Fixes Blade', 'name' => 'no_of_fixes_blades', 'name1' => 'no_of_fixes_blade_id', 'options' => $noOfFixesBlades, 'key' => 'no_of_blades'],
                        ['label' => 'Select Capacity', 'name' => 'capacity', 'name1' => 'capacity_id', 'options' => $capacities, 'key' => 'capacity'],
                    ];
                @endphp

                @foreach ($selects as $select)
                  @if(isset($product->{$select['name1']}))

                <div class="col-md-6 form-group form-group-position">
                    <label value="">{{ $select['label'] }}</label>
                    <select class="form-control select2 readonly-select" name="{{ $select['name'] }}">
                        @foreach ($select['options'] as $option)
                            <option value="{{$option[$select['key']] }}" {{ ($previewData[$select['name']] ?? '') == $option->id ? 'selected' : '' }}>
                                {{ $option[$select['key']] }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-pencil-alt edit-icon"></i>
                </div>
                @endif
                @endforeach
                {{-- input fields --}}
                 @if(isset($product->useful_volume))
                  <div class="col-md-6">
                    <label>Useful Volume</label>
                    <input name="useful_volume" label="Useful Volume" value="{{$product->useful_volume}}"  class="form-control readonly-input" required/>
                     <i class="fas fa-pencil-alt edit-icon"></i>
                  </div>
                @endif

                 @if(isset($product->compress_air_consumption))
                  <div class="col-md-6">
                    <label>Compress Air Consumption</label>
                    <input name="compress_air_consumption" label="Compress Air Consumption" value="{{$product->compress_air_consumption}}"  class="form-control readonly-input" required/>
                     <i class="fas fa-pencil-alt edit-icon"></i>
                  </div>
                @endif

                 @if(isset($product->total_capacity))
                  <div class="col-md-6">
                    <label>Total Capacity</label>
                    <input name="total_capacity" label="Total Capacity" value="{{$product->total_capacity}}"  class="form-control readonly-input" required/>
                     <i class="fas fa-pencil-alt edit-icon"></i>
                  </div>
                @endif


                @if(isset($product->water_pressure))
                  <div class="col-md-6">
                    <label>Water Pressure</label>
                    <input name="water_pressure" label="Water Pressure" value="{{$product->water_pressure}}"  class="form-control readonly-input" required/>
                     <i class="fas fa-pencil-alt edit-icon"></i>
                  </div>
                @endif
                @if(isset($product->operating_pressure))
                  <div class="col-md-6">
                    <label>Operating Pressure</label>
                    <input name="operating_pressure" label="Water Pressure" value="{{$product->operating_pressure}}"  class="form-control readonly-input" required/>
                    <i class="fas fa-pencil-alt edit-icon"></i>
                </div>
                @endif
                @if(isset($product->cooling_water_inlet_temperature))
                  <div class="col-md-6">
                    <label>Cooling Water Inlet Temperature</label>
                    <input name="cooling_water_inlet_temperature" label="Water Pressure" value="{{$product->cooling_water_inlet_temperature}}"  class="form-control readonly-input" required/>
                    <i class="fas fa-pencil-alt edit-icon"></i>
                </div>
                @endif
                @if(isset($product->cooling_water_flow_rate))
                  <div class="col-md-6">
                     <label>Cooling Water Flow Rate</label>
                    <input name="cooling_water_flow_rate" label="Cooling Water Flow Rate" value="{{$product->cooling_water_flow_rate}}"  class="form-control readonly-input" required/>
                         <i class="fas fa-pencil-alt edit-icon"></i>
                    </div>
                @endif
                @if(isset($product->feeding_air_pressure))
                  <div class="col-md-6">
                    <label>Feeding Air Pressure</label>
                    <input name="feeding_air_pressure" label="Feeding Air Pressure" value="{{$product->feeding_air_pressure}}"  class="form-control readonly-input" required/>
                     <i class="fas fa-pencil-alt edit-icon"></i>
                  </div>
                @endif
             @if(isset($product->contact_part))
                  <div class="col-md-6">
                     <label>Contact Part</label>
                    <input name="contact_part" label="Contact Part" value="{{$product->contact_part}}"  class="form-control readonly-input" required/>
                        <i class="fas fa-pencil-alt edit-icon"></i>
                 </div>
             @endif
              @if(isset($product->no_of_rotating_blades))
                  <div class="col-md-6">
                     <label>No of Rotating Blades</label>
                    <input name="no_of_rotating_blades" label="No. of Rotating Plates" value="{{$product->no_of_rotating_blades}}"  class="form-control readonly-input" required/>
                    <i class="fas fa-pencil-alt edit-icon"></i>
                 </div>
              @endif
                 @if(isset($product->no_of_fixes_blades))
                  <div class="col-md-6">
                     <label>No of Fixes Blades</label>
                    <input name="no_of_fixes_blades" label="No. of Fixes Blades" value="{{$product->no_of_fixes_blades}}"  class="form-control readonly-input" required/>
                    <i class="fas fa-pencil-alt edit-icon"></i>
                 </div>
               @endif
               @if(isset($product->capacity))
                  <div class="col-md-6">
                     <label>Capacity</label>
                    <input name="capacity" value="{{$product->capacity}}"  class="form-control readonly-input" required/>
                    <i class="fas fa-pencil-alt edit-icon"></i>
                 </div>
              @endif
                <div class="col-md-6">
                    <x-adminlte-select label="Created By" name="user_id">
                        @foreach ($users as $user)
                           <option value="{{$user->id}}">{{$user->name}}</option> 
                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2">Submit</button>
                <a href="{{ route('quotation.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@stop

@push('js')
<script>
    $(document).ready(function () {
       // $('.select2').select2();

        // Toggle readonly/editable
        $('.edit-icon').on('click', function () {
            const field = $(this).siblings('input, select');

            if (field.is('input')) {
                if (field.prop('readonly')) {
                    field.prop('readonly', false).removeClass('readonly-input');
                } else {
                    field.prop('readonly', true).addClass('readonly-input');
                }
            } else if (field.is('select')) {
                if (field.hasClass('readonly-select')) {
                    field.removeClass('readonly-select');
                    field.select2('enable', true);
                } else {
                    field.addClass('readonly-select');
                    field.select2('enable', false);
                }
            }
        });

        // Optional: Auto-calculate total price (if price and quantity exist)
        function updatePrice() {
            var productPrice = $('#product_id option:selected').data('price') || 0;
            var quantity = $('#quantity').val() || 1;
            var totalPrice = productPrice * quantity;
            $('#total_price').val(totalPrice.toFixed(2));
        }

        $('#product_id, #quantity').on('change input', updatePrice);
        updatePrice();
    });
</script>
@endpush
