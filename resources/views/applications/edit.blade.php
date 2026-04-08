@extends('layouts.app')

@section('title', 'Edit Application')

@section('content_header')
    <h1 class="mb-2">Edit Application</h1>
@stop

@section('content')

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle mr-1"></i> There were some problems with your input:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('applications.update', $product->id) }}" method="POST" id="applicationForm">
        @csrf
        @method('PUT')

        {{-- ===================== SECTION 1: Application Info ===================== --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0"><i class="fas fa-info-circle mr-2"></i>Application Info</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Application Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $product->name) }}"
                                placeholder="Enter Application Name" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Application Price <span class="text-danger">*</span></label>
                            <input type="text" id="price" name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $product->price) }}"
                                placeholder="Enter Price" required>
                            @error('price') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="machine">Select Machine <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="machine" name="machine" required>
                                <option value="">-- Select Machine --</option>
                                @foreach ($machines as $machine)
                                    <option value="{{ $machine->name }}"
                                        {{ old('machine', $product->machine->name ?? '') == $machine->name ? 'selected' : '' }}>
                                        {{ $machine->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('machine') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-md-4 pt-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1"
                                    name="is_two_application" id="is_two_application"
                                    {{ old('is_two_application', $product->is_two_application) ? 'checked' : '' }}>
                                <label class="form-check-label font-weight-bold" for="is_two_application">
                                    Is Two Application?
                                </label>
                                <small class="form-text text-muted">Check this if the machine has two applications (e.g. Heater + Horizontal Cooler Mixer).</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== SECTION 2: Technical Specifications ===================== --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0"><i class="fas fa-cogs mr-2"></i>Technical Specifications</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Capacity</label>
                            <input type="text" name="total_capacity" class="form-control"
                                value="{{ old('total_capacity', $product->total_capacity) }}"
                                placeholder="Enter Total Capacity (Ltr)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Useful Volume</label>
                            <input type="text" name="useful_volume" class="form-control"
                                value="{{ old('useful_volume', $product->useful_volume) }}"
                                placeholder="Enter Useful Volume (Ltr)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Compress Air Consumption</label>
                            <input type="text" name="compress_air_consumption" class="form-control"
                                value="{{ old('compress_air_consumption', $product->compress_air_consumption) }}"
                                placeholder="Enter Compress Air Consumption (Nm3/Hr)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Water Pressure</label>
                            <input type="text" name="water_pressure" class="form-control"
                                value="{{ old('water_pressure', $product->water_pressure) }}"
                                placeholder="Enter Water Pressure">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Operating Pressure</label>
                            <input type="text" name="operating_pressure" class="form-control"
                                value="{{ old('operating_pressure', $product->operating_pressure) }}"
                                placeholder="Enter Operating Pressure">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cooling Water Inlet Temperature</label>
                            <input type="text" name="cooling_water_inlet_temperature" class="form-control"
                                value="{{ old('cooling_water_inlet_temperature', $product->cooling_water_inlet_temperature) }}"
                                placeholder="Enter Cooling Temp.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cooling Water Flow Rate</label>
                            <input type="text" name="cooling_water_flow_rate" class="form-control"
                                value="{{ old('cooling_water_flow_rate', $product->cooling_water_flow_rate) }}"
                                placeholder="Enter Flow Rate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Feeding Air Pressure</label>
                            <input type="text" name="feeding_air_pressure" class="form-control"
                                value="{{ old('feeding_air_pressure', $product->feeding_air_pressure) }}"
                                placeholder="Enter Air Pressure">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Part</label>
                            <input type="text" name="contact_part" class="form-control"
                                value="{{ old('contact_part', $product->contact_part) }}"
                                placeholder="Enter Contact Part">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Size of Input Material</label>
                            <input type="text" name="size_of_input_material" class="form-control"
                                value="{{ old('size_of_input_material', $product->size_of_input_material) }}"
                                placeholder="e.g. 2, 4">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Output</label>
                            <input type="text" name="output" class="form-control"
                                value="{{ old('output', $product->output) }}"
                                placeholder="Enter Output">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Finish Mesh Size</label>
                            <input type="text" name="finish_mesh_size" class="form-control"
                                value="{{ old('finish_mesh_size', $product->finish_mesh_size) }}"
                                placeholder="Enter Finish Mesh Size">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Conveying Pipe</label>
                            <input type="text" name="conveying_pipe" class="form-control"
                                value="{{ old('conveying_pipe', $product->conveying_pipe) }}"
                                placeholder="Enter Conveying Pipe (MM Dia)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tank</label>
                            <input type="text" name="tank" class="form-control"
                                value="{{ old('tank', $product->tank) }}"
                                placeholder="e.g. SS 304">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rotor</label>
                            <input type="text" name="rotor" class="form-control"
                                value="{{ old('rotor', $product->rotor) }}"
                                placeholder="Enter Rotor">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Material</label>
                            <input type="text" name="material" class="form-control"
                                value="{{ old('material', $product->material) }}"
                                placeholder="Enter Material">
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>Blade MOC</label>
                                <input type="text" name="blade_moc" class="form-control"
                                    value="{{ old('blade_moc', $product->blade_moc) }}"
                                    placeholder="Enter Blade MOC">
                            </div>
                    </div>

                    {{-- Dropdowns --}}
                    {{-- ✅ Edit mein: $product->capacity->capacity se current value nikalo --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Capacity (kg/hr)</label>
                            <select class="form-control select2" name="capacity">
                                <option value="">-- Select --</option>
                                @foreach ($capacities as $item)
                                    <option value="{{ $item->capacity }}"
                                        {{ old('capacity', optional($product->capacity)->capacity) == $item->capacity ? 'selected' : '' }}>
                                        {{ $item->capacity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Material to Process</label>
                            <select class="form-control select2" name="material_to_process">
                                <option value="">-- Select --</option>
                                @foreach ($materialToProcess as $item)
                                    <option value="{{ $item->material_to_process }}"
                                        {{ old('material_to_process', optional($product->materialToProcess)->material_to_process) == $item->material_to_process ? 'selected' : '' }}>
                                        {{ $item->material_to_process }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. of Rotating Blade</label>
                            <select class="form-control select2" name="no_of_rotating_blade">
                                <option value="">-- Select --</option>
                                @foreach ($rotatingBlades as $item)
                                    <option value="{{ $item->no_of_blades }}"
                                        {{ old('no_of_rotating_blade', $product->no_of_rotating_blade_id ? \App\Models\Blade::find($product->no_of_rotating_blade_id)?->no_of_blades : '') == $item->no_of_blades ? 'selected' : '' }}>
                                        {{ $item->no_of_blades }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. of Fixed Blade</label>
                            <select class="form-control select2" name="no_of_fixes_blade">
                                <option value="">-- Select --</option>
                               @if($product->no_of_fixes_blade_id)
                                    <option value="{{ $product->fixedBlade->no_of_blades }}" selected>
                                        {{  $product->fixedBlade->no_of_blades }}
                                    </option>
                                @endif
                                @foreach ($fixedBlades as $item)
                                    <option value="{{ $item->no_of_blades }}"
                                        {{ old('no_of_fixes_blade') == $item->id ? 'selected' : '' }}>
                                        {{ $item->no_of_blades }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Blower</label>
                            <select class="form-control select2" name="blower">
                                <option value="">-- Select --</option>
                                @foreach ($blowers as $item)
                                    <option value="{{ $item->blower }}"
                                        {{ old('blower_id', $product->blower_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->blower }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Throat Size</label>
                            <select class="form-control select2" name="throat_size">
                                <option value="">-- Select --</option>
                                @foreach ($throatSizes as $item)
                                    <option value="{{ $item->size }}"
                                        {{ old('throat_size', $product->throat_size_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rotary Air Lock Valve</label>
                            <select class="form-control select2" name="rotary_air_lock_valve">
                                <option value="">-- Select --</option>
                                @foreach ($rotaryAirLockValves as $item)
                                    <option value="{{ $item->rotary_air_lock_valve }}"
                                        {{ old('rotary_air_lock_valve', optional($product->rotaryAirLockValve)->rotary_air_lock_valve) == $item->rotary_air_lock_valve ? 'selected' : '' }}>
                                        {{ $item->rotary_air_lock_valve }}
                                    </option>
                                @endforeach
                            </select>
                        </div>  
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Feeding Hooper Capacity</label>
                            <select class="form-control select2" name="feeding_hooper_capacity">
                                <option value="">-- Select --</option>
                                @foreach ($feedingHooperCapacities as $item)
                                    <option value="{{ $item->feeding_hooper_capacity }}"
                                        {{ old('feeding_hooper_capacity', optional($product->feedingHooperCapacity)->feeding_hooper_capacity) == $item->feeding_hooper_capacity ? 'selected' : '' }}>
                                        {{ $item->feeding_hooper_capacity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== SECTION 3: Machine Configuration ===================== --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="card-title mb-0"><i class="fas fa-wrench mr-2"></i>Machine Configuration</h3>
            </div>
            <div class="card-body">

                {{-- ---- First Application ---- --}}
                <div id="first_application_section">
                    <h5 class="border-bottom pb-2 mb-3 text-primary">
                        <i class="fas fa-fire mr-1"></i>
                        <span id="first_app_title">Application Configuration</span>
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Motor Requirement</label>
                                <select class="form-control select2" name="motor_requirement">
                                    <option value="">-- Select --</option>
                                    @foreach ($motorRequirements as $item)
                                        @if (!empty($item->motor_requirement))
                                            <option value="{{ $item->motor_requirement }}"
                                                {{ old('motor_requirement', optional($product->motorRequirement)->motor_requirement) == $item->motor_requirement ? 'selected' : '' }}>
                                                {{ $item->motor_requirement }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Make Motor</label>
                                <select class="form-control select2" name="make_motor">
                                    <option value="">-- Select --</option>
                                    @foreach ($makeMotors as $item)
                                        @if (!empty($item->name))
                                            <option value="{{ $item->name }}"
                                                {{ old('make_motor', optional($product->makeMotor)->name) == $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Batch</label>
                                <select class="form-control select2" name="batch">
                                    <option value="">-- Select --</option>
                                    @foreach ($batchs as $item)
                                        @if (!empty($item->batches))
                                            <option value="{{ $item->batches }}"
                                                {{ old('batch', optional($product->batch)->batches) == $item->batches ? 'selected' : '' }}>
                                                {{ $item->batches }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mixing Tool</label>
                                <select class="form-control select2" name="mixing_tool">
                                    <option value="">-- Select --</option>
                                    @foreach ($mixingTools as $item)
                                        <option value="{{ $item->mixing_tool }}"
                                            {{ old('mixing_tool', optional($product->mixingTool)->mixing_tool) == $item->mixing_tool ? 'selected' : '' }}>
                                            {{ $item->mixing_tool }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Electrical Control</label>
                                <select class="form-control select2" name="electrical_control">
                                    <option value="">-- Select --</option>
                                    @foreach ($electricalControls as $item)
                                        <option value="{{ $item->electrical_control }}"
                                            {{ old('electrical_control', optional($product->electricalControl)->electrical_control) == $item->electrical_control ? 'selected' : '' }}>
                                            {{ $item->electrical_control }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>AC Frequency Drive</label>
                                <select class="form-control select2" name="ac_frequency_drive">
                                    <option value="">-- Select --</option>
                                    @foreach ($acFrequencyDrives as $item)
                                        <option value="{{ $item->ac_fequency_drive }}"
                                            {{ old('ac_frequency_drive', optional($product->acFrequencyDrive)->ac_fequency_drive) == $item->ac_fequency_drive ? 'selected' : '' }}>
                                            {{ $item->ac_fequency_drive }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bearing</label>
                                <select class="form-control select2" name="bearing">
                                    <option value="">-- Select --</option>
                                    @foreach ($bearings as $item)
                                        <option value="{{ $item->bearing }}"
                                            {{ old('bearing', optional($product->bearing)->bearing) == $item->bearing ? 'selected' : '' }}>
                                            {{ $item->bearing }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pneumatic</label>
                                <select class="form-control select2" name="pneumatic">
                                    <option value="">-- Select --</option>
                                    @foreach ($pneumatics as $item)
                                        <option value="{{ $item->pneumatic }}"
                                            {{ old('pneumatic', optional($product->pneumatic)->pneumatic) == $item->pneumatic ? 'selected' : '' }}>
                                            {{ $item->pneumatic }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- ✅ Fixed: $product->driveSystem->drive_system se current value --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Drive System</label>
                                <select class="form-control select2" name="drive_system_1">
                                    <option value="">-- Select --</option>
                                    @foreach ($driveSystems as $item)
                                        <option value="{{ $item->drive_system }}"
                                            {{ old('drive_system_1', optional($product)->drive_system_1) == $item->drive_system ? 'selected' : '' }}>
                                            {{ $item->drive_system }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- ✅ Fixed: $product->gearBox->gear_box se current value, $gearboxes (lowercase) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gear Box</label>
                                <select class="form-control select2" name="gear_box_1">
                                    <option value="">-- Select --</option>
                                    @foreach ($gearboxes as $item)
                                        <option value="{{ $item->gear_box }}"
                                            {{ old('gear_box_1', optional($product)->gear_box_1) == $item->gear_box ? 'selected' : '' }}>
                                            {{ $item->gear_box }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ---- Second Application ---- --}}
                <div id="second_application_section" style="display: none;">
                    <hr class="my-4">
                    <h5 class="border-bottom pb-2 mb-3 text-warning">
                        <i class="fas fa-snowflake mr-1"></i> Second Application (Horizontal Cooler Mixer)
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Motor Requirement <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="motor_requirement2">
                                    <option value="">-- Select --</option>
                                    @foreach ($motorRequirements as $item)
                                        @if (!empty($item->motor_requirement))
                                            <option value="{{ $item->motor_requirement }}"
                                                {{ old('motor_requirement2', optional($product->motorRequirement2)->motor_requirement) == $item->motor_requirement ? 'selected' : '' }}>
                                                {{ $item->motor_requirement }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Make Motor <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="make_motor_2">
                                    <option value="">-- Select --</option>
                                    @foreach ($makeMotors as $item)
                                        @if (!empty($item->name))
                                            <option value="{{ $item->name }}"
                                                {{ old('make_motor_2', optional($product->makeMotor2)->name) == $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Batch <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="batch2">
                                    <option value="">-- Select --</option>
                                    @foreach ($batchs as $item)
                                        @if (!empty($item->batches))
                                            <option value="{{ $item->batches }}"
                                                {{ old('batch2', optional($product->batch2)->batches) == $item->batches ? 'selected' : '' }}>
                                                {{ $item->batches }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Electrical Control <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="electrical_control_2">
                                    <option value="">-- Select --</option>
                                    @foreach ($electricalControls as $item)
                                        <option value="{{ $item->electrical_control }}"
                                            {{ old('electrical_control_2', optional($product->electricalControl2)->electrical_control) == $item->electrical_control ? 'selected' : '' }}>
                                            {{ $item->electrical_control }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>AC Frequency Drive <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="ac_frequency_drive_2">
                                    <option value="">-- Select --</option>
                                    @foreach ($acFrequencyDrives as $item)
                                        <option value="{{ $item->ac_fequency_drive }}"
                                            {{ old('ac_frequency_drive_ 2', optional($product->acFrequencyDrive2)->ac_fequency_drive) == $item->ac_fequency_drive ? 'selected' : '' }}>
                                            {{ $item->ac_fequency_drive }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bearing <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="bearing_2">
                                    <option value="">-- Select --</option>
                                    @foreach ($bearings as $item)
                                        <option value="{{ $item->bearing }}"
                                            {{ old('bearing_2', optional($product->bearing2)->bearing) == $item->bearing ? 'selected' : '' }}>
                                            {{ $item->bearing }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pneumatic <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="pneumatic_2">
                                    <option value="">-- Select --</option>
                                    @foreach ($pneumatics as $item)
                                        <option value="{{ $item->pneumatic }}"
                                            {{ old('pneumatic_2', optional($product->pneumatic2)->pneumatic) == $item->pneumatic ? 'selected' : '' }}>
                                            {{ $item->pneumatic }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- ✅ Fixed: $product->driveSystem2->drive_system se current value --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Drive System <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="drive_system_2">
                                    <option value="">-- Select --</option>
                                    @foreach ($driveSystems as $item)
                                        <option value="{{ $item->drive_system }}"
                                            {{ old('drive_system_2', optional($product)->drive_system_2) == $item->drive_system ? 'selected' : '' }}>
                                            {{ $item->drive_system }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- ✅ Fixed: $product->gearBox2->gear_box se current value, $gearboxes (lowercase) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gear Box <small class="text-muted">(Second Application)</small></label>
                                <select class="form-control select2" name="gear_box_2">
                                    <option value="">-- Select --</option>
                                    @foreach ($gearboxes as $item)
                                        <option value="{{ $item->gear_box }}"
                                            {{ trim(old('gear_box_2', $product->gear_box_2)) == trim($item->gear_box) ? 'selected' : '' }}>
                                            {{ $item->gear_box }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ===================== Form Actions ===================== --}}
        <div class="text-center mb-4">
            <button type="submit" class="btn btn-success btn-lg px-5">
                <i class="fas fa-save mr-1"></i> Update Application
            </button>
            <a href="{{ route('applications.index') }}" class="btn btn-secondary btn-lg px-4 ml-2">
                <i class="fas fa-times mr-1"></i> Cancel
            </a>
        </div>

    </form>

@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush
@push('js')
<script>
    $(document).ready(function () {
        $('.select2').select2({ width: '100%' });

        var $checkbox      = $('#is_two_application');
        var $secondSection = $('#second_application_section');
        var $firstAppTitle = $('#first_app_title');

        function toggleSecondApplication() {
            if ($checkbox.is(':checked')) {
                $firstAppTitle.text('First Application (Heater)');
                $secondSection.slideDown(300);
            } else {
                $firstAppTitle.text('Application Configuration');
                $secondSection.slideUp(300);
            }
        }

        toggleSecondApplication();
        $checkbox.on('change', toggleSecondApplication);
    });
</script>
@endpush