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

<form action="{{ route('applications.update', $application->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Application Info --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Application Info</h3>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <x-adminlte-input name="name" label="Application Name" value="{{ old('name', $application->name) }}"
                    placeholder="Enter Application Name" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="price" label="Application Price" value="{{ old('price', $application->price) }}"
                    placeholder="Enter Price" fgroup-class="mb-3" />
            </div>

            <div class="col-md-6">
                <label>Select Machine</label>
                <select class="form-control select2" name="machine" required>
                    <option value="">Select Machine</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->name }}" {{ old('machine', $application->machine) == $machine->name ? 'selected' : '' }}>{{ $machine->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <div class="form-check mt-5">
                    <input class="form-check-input" value="1" type="checkbox" name="is_two_application"
                        id="is_two_application" {{ old('is_two_application', $application->is_two_application) ? 'checked' : '' }}>
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
                <x-adminlte-input name="total_capacity" label="Total Capacity" value="{{ old('total_capacity', $application->total_capacity) }}"
                    placeholder="Enter Total Capacity(Ltr)" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="useful_volume" label="Useful Volume" value="{{ old('useful_volume', $application->useful_volume) }}"
                    placeholder="Enter Useful Volume(Ltr)" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="compress_air_consumption" label="Compress Air Consumption" value="{{ old('compress_air_consumption', $application->compress_air_consumption) }}"
                    placeholder="Enter Compress Air Consumption(Nm3/Hr)" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="water_pressure" label="Water Pressure" value="{{ old('water_pressure', $application->water_pressure) }}"
                    placeholder="Enter Water Pressure" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="operating_pressure" label="Operating Pressure"
                    value="{{ old('operating_pressure', $application->operating_pressure) }}" placeholder="Enter Operating Pressure"
                    fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="cooling_water_inlet" label="Cooling Water Inlet Temp."
                    value="{{ old('cooling_water_inlet', $application->cooling_water_inlet) }}" placeholder="Enter Cooling Temp." fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="cooling_water_flow_rate" label="Cooling Water Flow Rate"
                    value="{{ old('cooling_water_flow_rate', $application->cooling_water_flow_rate) }}" placeholder="Enter Flow Rate" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="feeding_air_pressure" label="Feeding Air Pressure"
                    value="{{ old('feeding_air_pressure', $application->feeding_air_pressure) }}" placeholder="Enter Air Pressure" fgroup-class="mb-3" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="contact_part" label="Contact Part" value="{{ old('contact_part', $application->contact_part) }}"
                    placeholder="Enter Contact Part" fgroup-class="mb-3" />
            </div>

            {{-- Dropdowns --}}
            <div class="col-md-6">
                <x-adminlte-select class="select2" name="capacity" label="Select Capacity (kg/hr)">
                    <option value="">Select</option>
                    @foreach ($capacities as $item)
                        <option value="{{ $item->id }}" {{ old('capacity', $application->capacity) == $item->id ? 'selected' : '' }}>{{ $item->capacity }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select class="select2" name="material_to_process" label="Material to Process">
                    <option value="">Select</option>
                    @foreach ($materialToProcess as $item)
                        <option value="{{ $item->material_to_process }}" {{ old('material_to_process', $application->material_to_process) == $item->material_to_process ? 'selected' : '' }}>
                            {{ $item->material_to_process }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select class="select2" name="no_of_rotating_blade" label="Select Rotating Blade">
                    <option value="">Select</option>
                    @foreach ($rotatingBlades as $item)
                        <option value="{{ $item->id }}" {{ old('no_of_rotating_blade', $application->no_of_rotating_blade) == $item->id ? 'selected' : '' }}>
                            {{ $item->no_of_blades }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-6">
                <x-adminlte-select class="select2" name="no_of_fixes_blade" label="Select Fix Blade">
                    <option value="">Select</option>
                    @foreach ($fixedBlades as $item)
                        <option value="{{ $item->id }}" {{ old('no_of_fixes_blade', $application->no_of_fixes_blade) == $item->id ? 'selected' : '' }}>
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

            @php
                $configFields = [
                    ['name' => 'motor_requirement', 'label' => 'Motor Requirement', 'options' => $motorRequirements, 'key' => 'motor_requirement'],
                    ['name' => 'make_motor', 'label' => 'Make Motor', 'options' => $makeMotors, 'key' => 'name'],
                    ['name' => 'batch', 'label' => 'Select Batch', 'options' => $batchs, 'key' => 'batches'],
                    ['name' => 'mixing_tool', 'label' => 'Mixing Tool', 'options' => $mixingTools, 'key' => 'mixing_tool'],
                    ['name' => 'electrical_control', 'label' => 'Electrical Control', 'options' => $electricalControls, 'key' => 'electrical_control'],
                    ['name' => 'ac_frequency_drive', 'label' => 'AC Frequency Drive', 'options' => $acFrequencyDrives, 'key' => 'ac_fequency_drive'],
                    ['name' => 'bearing', 'label' => 'Bearing', 'options' => $bearings, 'key' => 'bearing'],
                    ['name' => 'pneumatic', 'label' => 'Pneumatic', 'options' => $pneumatics, 'key' => 'pneumatic'],
                    ['name' => 'motor_requirement2', 'label' => 'Second Motor Requirement', 'options' => $motorRequirements, 'key' => 'motor_requirement', 'class' => 'application2'],
                    ['name' => 'batch2', 'label' => 'Select Second Batch', 'options' => $batchs, 'key' => 'batches', 'class' => 'application2'],
                ];
            @endphp

            @foreach ($configFields as $field)
                <div class="col-md-6 {{ $field['class'] ?? '' }}">
                    <x-adminlte-select name="{{ $field['name'] }}" class="select2" label="{{ $field['label'] }}">
                        <option value="">Select</option>
                        @foreach ($field['options'] as $item)
                            <option value="{{ $item[$field['key']] }}" {{ old($field['name'], $application[$field['name']]) == $item[$field['key']] ? 'selected' : '' }}>
                                {{ $item[$field['key']] }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            @endforeach

        </div>
    </div>

    {{-- Submit --}}
    <div class="text-end mt-4">
        <button type="submit" class="btn btn-primary">Update Application</button>
        <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@stop

@push('js')
<script src="{{ asset('js/application.js') }}"></script>
@endpush
