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
                <x-adminlte-input name="cooling_water_inlet_temperature" label="Cooling Water Inlet Temp." value="{{ old('cooling_water_inlet_temperature', $product->cooling_water_inlet_temperature) }}"
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
                <x-adminlte-input name="size_of_input_material" label="Size of Input Material" value="{{ old('size_of_input_material',$product->size_of_input_material) }}"
                    placeholder="Enter Size of Input Material(e.g 2,4)" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="output" label="Output" value="{{ old('output',$product->output) }}"
                    placeholder="Enter Output " fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="finish_mesh_size" label="Finish Mesh Size" value="{{ old('finish_mesh_size',$product->finish_mesh_size) }}"
                    placeholder="Enter Finish Mesh Size" fgroup-class="mb-3" />
            </div>

            <div class="col-md-6">
                <x-adminlte-input name="conveying_pipe" label="Conveying Pipe" value="{{ old('conveying_pipe',$product->conveying_pipe) }}"
                    placeholder="Enter Conveing Pipe(MM Dia)" fgroup-class="mb-3" />
            </div>
               <div class="col-md-6">
                <x-adminlte-input name="tank" label="Tank" value="{{ old('tank',$product->tank) }}"
                    placeholder="Enter tank (for e.g SS 304)" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="rotor" label="Rotor" value="{{ old('rotor',$product->rotor) }}"
                    placeholder="Enter Rotor " fgroup-class="mb-3" />
            </div>
                        <div class="col-md-6">
                <x-adminlte-input name="material" label="Material" value="{{ old('material',$product->material) }}"
                    placeholder="Enter Material" fgroup-class="mb-3" />
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
                            {{ $product->no_of_rotating_blade_id== $item->id ? 'selected' : '' }}>
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
                            {{ $product->no_of_fixes_blade_id == $item->id ? 'selected' : '' }}>
                            {{ $item->no_of_blades }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>
             <div class="col-md-6">
                <x-adminlte-select class="select2" name="blower_id" label="Select Blower">
                    <option value="">Select</option>
                    @foreach ($blowers as $item)
                        <option value="{{ $item->id }}"  {{ $product->blower_id == $item->id ? 'selected' : '' }}>{{ $item->blower }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select class="select2" name="rotary_air_lock_valve" label="Rotary Air Lock Valve">
                    <option value="">Select</option>
                    @foreach ($rotaryAirLockValves as $item)
                        <option value="{{ $item->id }}"  {{ $product->rotary_air_lock_valve_id == $item->id ? 'selected' : '' }}> {{ $item->rotary_air_lock_valve }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>
            
             <div class="col-md-6">
                <x-adminlte-select class="select2" name="feeding_hooper_capacity" label="Feeding Hooper">
                    <option value="">Select</option>
                    @foreach ($feedingHooperCapacities as $item)
                        <option value="{{ $item->id }}" {{ $product->feeding_hooper_capacity_id == $item->id ? 'selected' : '' }}>{{ $item->feeding_hooper_capacity }}</option>
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

        @php $product = $product ?? null; @endphp

        {{-- Motor Requirement --}}
        <div class="col-md-6">
            <x-adminlte-select name="motor_requirement" class="select2" label="Motor Requirement">
                <option value="">Select</option>
                @forelse ($motorRequirements ?? [] as $item)
                    @if(!empty($item->motor_requirement))
                        <option value="{{ $item->id }}"
                            {{ old('motor_requirement', optional($product)->motor_requirement_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->motor_requirement }}
                        </option>
                    @endif
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        {{-- Make Motor --}}
        <div class="col-md-6">
            <x-adminlte-select name="make_motor" class="select2" label="Make Motor">
                <option value="">Select</option>
                @forelse ($makeMotors ?? [] as $item)
                    @if(!empty($item->name))
                        <option value="{{ $item->id }}"
                            {{ old('make_motor', optional($product)->make_motor_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endif
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        {{-- Batch --}}
        <div class="col-md-6">
            <x-adminlte-select name="batch" class="select2" label="Batch">
                <option value="">Select</option>
                @forelse ($batchs ?? [] as $item)
                    @if(!empty($item->batches))
                        <option value="{{ $item->id }}"
                            {{ old('batch', optional($product)->batch_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->batches }}
                        </option>
                    @endif
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        {{-- Mixing Tool --}}
        <div class="col-md-6">
            <x-adminlte-select name="mixing_tool" class="select2" label="Mixing Tool">
                <option value="">Select</option>
                @forelse ($mixingTools ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('mixing_tool', optional($product)->mixing_tool_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->mixing_tool }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        {{-- Electrical Control --}}
        <div class="col-md-6">
            <x-adminlte-select name="electrical_control" class="select2" label="Electrical Control">
                <option value="">Select</option>
                @forelse ($electricalControls ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('electrical_control', optional($product)->electrical_control_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->electrical_control }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        {{-- AC Drive --}}
        <div class="col-md-6">
            <x-adminlte-select name="ac_frequency_drive" class="select2" label="AC Frequency Drive">
                <option value="">Select</option>
                @forelse ($acFrequencyDrives ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('ac_frequency_drive', optional($product)->ac_frequency_drive_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->ac_frequency_drive }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        {{-- Bearing --}}
        <div class="col-md-6">
            <x-adminlte-select name="bearing" class="select2" label="Bearing">
                <option value="">Select</option>
                @forelse ($bearings ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('bearing', optional($product)->bearing_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->bearing }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        {{-- Pneumatic --}}
        <div class="col-md-6">
            <x-adminlte-select name="pneumatic" class="select2" label="Pneumatic">
                <option value="">Select</option>
                @forelse ($pneumatics ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('pneumatic', optional($product)->pneumatic_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->pneumatic }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        {{-- SECOND SECTION --}}

        <div class="col-md-6">
            <x-adminlte-select name="motor_requirement2" class="select2" label="Motor Requirement For Second Application">
                <option value="">Select</option>
                @forelse ($motorRequirements2 ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('motor_requirement2', optional($product)->motor_requirement2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->motor_requirement }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="batch2" class="select2" label="Batch For Second Application">
                <option value="">Select</option>
                @forelse ($batchs ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('batch2', optional($product)->batch2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->batches }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="electrical_control2" class="select2" label="Electrical Control For Second Application">
                <option value="">Select</option>
                @forelse ($electricalControls ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('electrical_control2', optional($product)->electrical_control2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->electrical_control }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="ac_frequency_drive2" class="select2" label="AC Frequency Drive For Second Application">
                <option value="">Select</option>
                @forelse ($acFrequencyDrives ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('ac_frequency_drive2', optional($product)->ac_frequency_drive2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->ac_frequency_drive }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="bearing2" class="select2" label="Bearing For Second Application">
                <option value="">Select</option>
                @forelse ($bearings ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('bearing2', optional($product)->bearing2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->bearing }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="pneumatic2" class="select2" label="Pneumatic For Second Application">
                <option value="">Select</option>
                @forelse ($pneumatics ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('pneumatic2', optional($product)->pneumatic2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->pneumatic }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="make_motor2" class="select2" label="Make Motor For Second Application">
                <option value="">Select</option>
                @forelse ($makeMotors ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('make_motor2', optional($product)->make_motor2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="drive_system_1" class="select2" label="Drive System ">
                <option value="">Select</option>
                @forelse ($driveSystems ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('drive_system_1', optional($product)->drive_system_1_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->drive_system }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="drive_system_2" class="select2" label="Drive System For Second Application">
                <option value="">Select</option>
                @forelse ($driveSystems ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('drive_system_2', optional($product)->drive_system_2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->drive_system }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="gear_box_1" class="select2" label="Gear Box ">
                <option value="">Select</option>
                @forelse ($gearBoxes ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('gear_box_1', optional($product)->gear_box_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->gear_box }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
            </x-adminlte-select>
        </div>

        <div class="col-md-6">
            <x-adminlte-select name="gear_box_2" class="select2" label="Gear Box For Second Application">
                <option value="">Select</option>
                @forelse ($gearBoxes ?? [] as $item)
                    <option value="{{ $item->id }}"
                        {{ old('gear_box_2', optional($product)->gear_box_2_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->gear_box }}
                    </option>
                @empty
                    <option>No Data Available</option>
                @endforelse
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
