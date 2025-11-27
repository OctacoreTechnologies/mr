@extends('layouts.app')

@section('title', 'Edit Application')

@section('content_header')
<h1 class="mb-2">Edit Application</h1>
@stop

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>There were some problems with your input.</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('applications.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Application Info --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Application Info</h3>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <x-adminlte-input name="name" label="Application Name" value="{{ old('name', $product->name) }}"
                    placeholder="Enter Application Name" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="price" label="Application Price" value="{{ old('price', $product->price) }}"
                    placeholder="Enter Price" fgroup-class="mb-3" />
            </div>

            <div class="col-md-6">
                <label>Select Machine</label>
                <select class="form-control select2" name="machine" required>
                    <option value="">Select Machine</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->name }}" 
                            {{ old('machine', $product->machine->id) == $machine->id ? 'selected' : '' }}>
                            {{ $machine->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <div class="form-check mt-5">
                    <input class="form-check-input" value="1" type="checkbox" name="is_two_application"
                        id="is_two_application" {{ old('is_two_application', $product->is_two_application) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_two_application">Is Two Application?</label>
                </div>
            </div>
        </div>
    </div>

    {{-- Technical Specifications --}}
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <h3 class="card-title">Technical Specifications</h3>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <x-adminlte-input name="total_capacity" label="Total Capacity" value="{{ old('total_capacity', $product->total_capacity) }}"
                    placeholder="Enter Total Capacity(Ltr)" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="useful_volume" label="Useful Volume" value="{{ old('useful_volume', $product->useful_volume) }}"
                    placeholder="Enter Useful Volume(Ltr)" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="compress_air_consumption" label="Compress Air Consumption" value="{{ old('compress_air_consumption', $product->compress_air_consumption) }}"
                    placeholder="Enter Compress Air Consumption(Nm3/Hr)" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="water_pressure" label="Water Pressure" value="{{ old('water_pressure', $product->water_pressure) }}"
                    placeholder="Enter Water Pressure" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="operating_pressure" label="Operating Pressure" value="{{ old('operating_pressure', $product->operating_pressure) }}"
                    placeholder="Enter Operating Pressure" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="cooling_water_inlet" label="Cooling Water Inlet Temp." value="{{ old('cooling_water_inlet', $product->cooling_water_inlet_temperature) }}"
                    placeholder="Enter Cooling Temp." fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="cooling_water_flow_rate" label="Cooling Water Flow Rate" value="{{ old('cooling_water_flow_rate', $product->cooling_water_flow_rate) }}"
                    placeholder="Enter Flow Rate" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="feeding_air_pressure" label="Feeding Air Pressure" value="{{ old('feeding_air_pressure', $product->feeding_air_pressure) }}"
                    placeholder="Enter Air Pressure" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="contact_part" label="Contact Part" value="{{ old('contact_part', $product->contact_part) }}"
                    placeholder="Enter Contact Part" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-select class="select2" name="capacity" label="Select Capacity (kg/hr)">
                    <option value="">Select</option>
                    @foreach ($capacities as $item)
                        <option value="{{ $item->id }}" {{ $product->capacity_id == $item->id ? 'selected' : '' }}>
                            {{ $item->capacity }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select class="select2" name="material_to_process" label="Material to Process">
                    <option value="">Select</option>
                    @foreach ($materialToProcess as $item)
                        <option value="{{ $item->material_to_process }}" 
                            {{ $product->material_to_process_id == $item->id ? 'selected' : '' }}>
                            {{ $item->material_to_process }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select class="select2" name="no_of_rotating_blade" label="Select Rotating Blade">
                    <option value="">Select</option>
                    @foreach ($rotatingBlades as $item)
                        <option value="{{ $item->id }}" 
                            {{ $product->no_of_rotating_blade_id== $item->no_of_blades ? 'selected' : '' }}>
                            {{ $item->no_of_blades }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select class="select2" name="no_of_fixes_blade" label="Select Fix Blade">
                    <option value="">Select</option>
                    @foreach ($fixedBlades as $item)
                        <option value="{{ $item->id }}" 
                            {{ $product->no_of_fixes_blade_id == $item->no_of_blades ? 'selected' : '' }}>
                            {{ $item->no_of_blades }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>
        </div>
    </div>

    {{-- Machine Configuration --}}
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h3 class="card-title">Machine Configuration</h3>
        </div>
        <div class="card-body row g-3">

           <div class="col-md-6">
                <x-adminlte-select name="motor_requirement" class="select2" label="Motor Requirement 2">
                    <option value="">Select</option>
                    @foreach ($motorRequirements as $item)
                        <option value="{{ $item->motor_requirement }}" 
                            {{ $product->motor_requirement_id == $item->id ? 'selected' : '' }}>
                            {{ $item->motor_requirement }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select name="make_motor" class="select2" label="Make Motor">
                    <option value="">Select</option>
                    @foreach ($makeMotors as $item)
                        <option value="{{ $item->name }}" 
                            {{ $product->make_motor_id == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select name="batch" class="select2" label="Select Batch">
                    <option value="">Select</option>
                    @foreach ($batchs as $item)
                        <option value="{{ $item->batches }}" 
                            {{ $product->batch_id == $item->id ? 'selected' : '' }}>
                            {{ $item->batches }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>
            <div class="col-md-6">
                <x-adminlte-select name="mixing_tool" class="select2" label="Mixing Tool">
                    <option value="">Select</option>
                    @foreach ($mixingTools as $item)
                        <option value="{{ $item->mixing_tool }}" {{ $product->mixing_tool_id == $item->id ? 'selected':''}}>{{ $item->mixing_tool }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select name="electrical_control" class="select2" label="Electrical Control">
                    <option value="">Select</option>
                    @foreach ($electricalControls as $item)
                        <option value="{{ $item->electrical_control }}" {{ $product->electrical_control_id == $item->id?'selected':'' }}>{{ $item->electrical_control }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select name="ac_frequency_drive" class="select2" label="AC Frequency Drive">
                    <option value="">Select</option>
                    @foreach ($acFrequencyDrives as $item)
                        <option value="{{ $item->ac_fequency_drive }}" {{ $product->ac_frequency_drive_id == $item->id ?'selected':'' }}>{{ $item->ac_fequency_drive }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select name="bearing" class="select2" label="Bearing">
                    <option value="">Select</option>
                    @foreach ($bearings as $item)
                        <option value="{{ $item->bearing}}" {{ $product->bearing_id == $item->id ?'selected':'' }}>{{ $item->bearing }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select name="pneumatic" class="select2" label="Pneumatic">
                    <option value="">Select</option>
                    @foreach ($pneumatics as $item)
                        <option value="{{ $item->pneumatic }}" {{ $item->id == $product->pneumatic_id ? 'selected':'' }}>{{ $item->pneumatic }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

           <div class="col-md-6">
                <x-adminlte-select name="motor_requirement2" class="select2" label="Motor Requirement 2">
                    <option value="">Select</option>
                    @foreach ($motorRequirements2 as $item)
                        <option value="{{ $item->motor_requirement }}" 
                            {{ $product->motor_requirement2_id == $item->id ? 'selected' : '' }}>
                            {{ $item->motor_requirement }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>


              <div class="col-md-6">
                <x-adminlte-select name="batch2" class="select2" label="Select Batch 2">
                    <option value="">Select</option>
                    @foreach ($batchs as $item)
                        <option value="{{ $item->batches }}" 
                            {{ $product->batch2_id == $item->id ? 'selected' : '' }}>
                            {{ $item->batches }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-success">Update Application</button>
        <a href="{{ route('applications.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@stop
