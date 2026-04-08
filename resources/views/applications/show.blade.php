@extends('layouts.app')

@section('title', 'Application Details')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-cogs"></i>
        Application Details
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-2" />

<div class="crm-index-card">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Overview
        </h3>
    </div>

    <div class="card-body">

        <div class="row">

            @php
                $fields = [
                    'Application Name' => $application->name ?? 'N/A',
                    'Application Price' => $application->price ?? 'N/A',
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
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="crm-detail-box">
                            <span class="crm-detail-label">{{ $label }}</span>
                            <div class="crm-detail-value">
                                {{ $value }}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>

        {{-- BACK BUTTON --}}
        <div class="mt-4">
            <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Applications
            </a>
        </div>

    </div>
</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
<style>
    .crm-detail-box {
        background: var(--crm-bg);
        border: 1px solid var(--crm-border);
        border-radius: 8px;
        padding: 10px 12px;
        height: 100%;
    }

    .crm-detail-label {
        font-size: .7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--crm-text-muted);
        display: block;
        margin-bottom: 3px;
    }

    .crm-detail-value {
        font-size: .85rem;
        color: var(--crm-text);
        font-weight: 500;
        word-break: break-word;
    }
</style>
@endpush