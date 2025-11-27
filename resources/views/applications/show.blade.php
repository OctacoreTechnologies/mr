@extends('layouts.app')

@section('title', 'Application Details')

@section('content_header')
    <h1><i class="fas fa-cogs"></i> Application Details</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Overview</h3>
        </div>

        <div class="card-body">
            <div class="row">

                @php
                    $fields = [
                        'Application Name' => $application->name ?? 'N/A',
                        'Application Price' => $application->price ?? 'N/A',
                        'Model' => $application->modele->name ?? 'N/A',
                        'Machine' => $application->machine->name ?? 'N/A',
                        'Material to Process' => $application->materialToProcess->material_to_process ?? 'N/A',
                        'Motor Requirement' => $application->motorRequirement->motor_requirement ?? 'N/A',
                        'Batch Capacity' => $application->batch->batches ?? 'N/A',
                        'Mixing Tool' => $application->mixingTool->mixing_tool ?? 'N/A',
                        'Electrical Control' => $application->electricalControl->electrical_control ?? 'N/A',
                        'AC Frequency Drive' => $application->acFrequencyDrive->ac_fequency_drive ?? 'N/A',
                        'Bearing' => $application->bearing->bearing ?? 'N/A',
                        'Pneumatic' => $application->pneumatics->pneumatic ?? 'N/A',
                        'Make Motor' => $application->makeMotor->name ?? 'N/A',
                        'Total Capacity' => $application->total_capacity ?? 'N/A',
                        'Useful Volume' => $application->useful_volume ?? 'N/A',
                        'Compress Air Consumption' => $application->compress_air_consumption ?? 'N/A',
                        'Water Pressure' => $application->water_pressure ?? 'N/A',
                        'Operating Pressure' => $application->operating_pressure ?? 'N/A',
                        'Cooling Water Inlet Temperature' => $application->cooling_water_inlet_temperature ?? 'N/A',
                        'Cooling Water Flow Rate' => $application->cooling_water_flow_rate ?? 'N/A',
                        'Feeding Air Pressure' => $application->feeding_air_pressure ?? 'N/A',
                        'Contact Part' => $application->contact_part ?? 'N/A',
                        'Rotating Blades' => $application->no_of_rotating_blade_id ?? 'N/A',
                        'Fixed Blades' => $application->no_of_fixes_blade_id ?? 'N/A',
                        'Capacity' => $application->capacity_id ?? 'N/A',
                        'Second Motor Requirement' => $application->motor_requirement2_id ?? 'N/A',
                        'Second Batch' => $application->batch2_id ?? 'N/A',
                        'Is Two Application' => $application->is_two_application ? 'Yes' : 'No',
                    ];
                @endphp

                @foreach($fields as $label => $value)
                  @if ($value != "N/A")
                    <div class="col-md-6 mb-3">
                        <div class="border p-2 rounded bg-light">
                            <strong>{{ $label }}:</strong>
                            <p class="mb-0 text-muted">{{ $value }}</p>
                        </div>
                    </div>
                   @endif
                @endforeach

            </div>

            <div class="mt-4">
                <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Applications
                </a>
            </div>
        </div>
    </div>
@stop
