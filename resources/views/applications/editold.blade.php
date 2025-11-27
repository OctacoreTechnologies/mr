@extends('layouts.app')

@section('title', 'Edit Application')

@section('content_header')
    <h1>Edit Application</h1>
@stop

@section('content')
<div class="card shadow">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('applications.update', $product->id) }}" method="POST">
            @csrf
            @method("PUT")
            <div class="row">
                <!-- Application Name -->
                @if($product->name)
                    <div class="col-md-6">
                        <x-adminlte-input 
                            name="name" 
                            label="Application Name" 
                            value="{{ old('name', $product->name) }}" 
                            placeholder="Enter Application Name" 
                            fgroup-class="mb-3" 
                        />
                    </div>
                @endif

                <!-- Application Price -->
                @if($product->price)
                    <div class="col-md-6">
                        <x-adminlte-input 
                            name="price" 
                            label="Application Price" 
                            value="{{ old('price', $product->price) }}" 
                            placeholder="Enter Application Price" 
                            fgroup-class="mb-3" 
                        />
                    </div>
                @endif

                <!-- Model (Only show if not null) -->
                @if($product->model_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="model_id" 
                            label="Select Model" 
                            fgroup-class="mb-3"
                        >
                            <option value="">Select Model</option>
                            @foreach($models as $model)
                                <option value="{{ $model->id }}" {{ $product->model_id == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Machine (Only show if not null) -->
                @if($product->machine_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="machine_id" 
                            label="Select Machine" 
                            fgroup-class="mb-3"
                        >
                            <option value="">Select Machine</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}" {{ $product->machine_id == $machine->id ? 'selected' : '' }}>{{ $machine->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Material to Process (Only show if not null) -->
                @if($product->material_to_process_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="material_to_process_id" 
                            label="Select Material to Process" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($materialToProcess as $material)
                                <option value="{{ $material->id }}" {{ $product->material_to_process_id == $material->id ? 'selected' : '' }}>{{ $material->material_to_process }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Motor Requirement (Only show if not null) -->
                @if($product->motor_requirement_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="motor_requirement_id" 
                            label="Select Motor Requirement" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($motorRequirements as $motor)
                                <option value="{{ $motor->id }}" {{ $product->motor_requirement_id == $motor->id ? 'selected' : '' }}>{{ $motor->motor_requirement }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Batch Capacity (Only show if not null) -->
                @if($product->batch_capacity_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="batch_capacity_id" 
                            label="Select Batch Capacity" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($batchs as $batch)
                                <option value="{{ $batch->id }}" {{ $product->batch_capacity_id == $batch->id ? 'selected' : '' }}>{{ $batch->batches }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Mixing Tool (Only show if not null) -->
                @if($product->mixing_tool_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="mixing_tool_id" 
                            label="Select Mixing Tool" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($mixingTools as $mixingTool)
                                <option value="{{ $mixingTool->id }}" {{ $product->mixing_tool_id == $mixingTool->id ? 'selected' : '' }}>{{ $mixingTool->mixing_tool }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Motor Requirement 2 -->
                @if($product->motor_requirement2_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="motor_requirement2_id" 
                            label="Select Motor Requirement 2" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($motorRequirements as $motor)
                                <option value="{{ $motor->id }}" {{ $product->motor_requirement2_id == $motor->id ? 'selected' : '' }}>{{ $motor->motor_requirement }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Electrical Control -->
                @if($product->electrical_control_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="electrical_control_id" 
                            label="Select Electrical Control" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($electricalControls as $electricalControl)
                                <option value="{{ $electricalControl->id }}" {{ $product->electrical_control_id == $electricalControl->id ? 'selected' : '' }}>{{ $electricalControl->electrical_control }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- AC Frequency Drive -->
                @if($product->ac_frequency_drive_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="ac_frequency_drive_id" 
                            label="Select AC Frequency Drive" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($acFrequencyDrives as $acFrequencyDrive)
                                <option value="{{ $acFrequencyDrive->id }}" {{ $product->ac_frequency_drive_id == $acFrequencyDrive->id ? 'selected' : '' }}>{{ $acFrequencyDrive->ac_frequency_drive }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Bearing -->
                @if($product->bearing_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="bearing_id" 
                            label="Select Bearing" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($bearings as $bearing)
                                <option value="{{ $bearing->id }}" {{ $product->bearing_id == $bearing->id ? 'selected' : '' }}>{{ $bearing->bearing }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Pneumatics -->
                @if($product->pneumatic_id)
                    <div class="col-md-6">
                        <x-adminlte-select 
                            name="pneumatic_id" 
                            label="Select Pneumatic" 
                            fgroup-class="mb-3"
                        >
                            @foreach ($pneumatics as $pneumatic)
                                <option value="{{ $pneumatic->id }}" {{ $product->pneumatic_id == $pneumatic->id ? 'selected' : '' }}>{{ $pneumatic->pneumatic }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif

                <!-- Water Pressure -->
                @if($product->water_pressure)
                    <div class="col-md-6">
                        <x-adminlte-input 
                            name="water_pressure" 
                            label="Water Pressure" 
                            value="{{ old('water_pressure', $product->water_pressure) }}" 
                            fgroup-class="mb-3" 
                        />
                    </div>
                @endif
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('product.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@stop
