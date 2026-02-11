@extends('layouts.app')

@section('title', 'Added Quotation')

@push('css')
    <style>
        /* General form styling */
        .form-control {
            border-radius: 10px;
            box-shadow: none;
            padding: 12px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .readonly-input,
        .readonly-select {
            background-color: #f8f9fa !important;
            cursor: not-allowed;
            border-color: #e0e0e0;
        }

        .readonly-input:focus,
        .readonly-select:focus {
            border-color: #d1d1d1;
            box-shadow: none;
        }

        /* Label styling */
        label {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
        }

        /* Edit icon styling */
        .edit-icon {
            position: absolute;
            right: 10px;
            top: 38px;
            color: #007bff;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .edit-icon:hover {
            color: #0056b3;
        }

        /* Input field with icon */
        .form-group-position {
            position: relative;
        }

        /* Card styling */
        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background-color: #007bff;
            color: #fff;
            padding: 18px 20px;
        }

        .card-body {
            padding: 30px;
        }

        /* Button Styling */
        .btn {
            border-radius: 10px;
            padding: 10px 20px;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Select2 Styling */
        .select2-container--default .select2-selection--single {
            border-radius: 10px;
            padding: 10px;
            font-size: 14px;
        }

        /* Error Message Styling */
        .invalid-feedback {
            font-size: 13px;
            color: #dc3545;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-group {
                margin-bottom: 1rem;
            }

            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
@endpush

@section('content_header')
    <h1>Added Quotation</h1>
@stop

@php

    $machineName = $machine->name;
    $machineName = trim($machineName);
    $parts = explode(' and ', $machineName);
    if (count($parts) == 2) {
        $first = trim($parts[0]);
        $second = trim($parts[1]);
    } else {
        $first = $second = trim($machineName);
    }

    $selects = [
        [
            'label' => 'Select Material to Process',
            'name' => 'material_to_process',
            'name1' => 'material_to_process_id',
            'options' => $materialToProcess,
            'key' => 'material_to_process',
        ],
        [
            'label' => 'Select ' . $first . ' Motor Requirement',
            'name' => 'motor_requirement',
            'name1' => 'motor_requirement_id',
            'options' => $motorRequirements,
            'key' => 'motor_requirement',
        ],
        [
            'label' => 'Selec ' . $second . ' Motor Requirement',
            'name' => 'motor_requirement2',
            'name1' => 'motor_requirement2_id',
            'options' => $motorRequirements2,
            'key' => 'motor_requirement',
        ],
        [
            'label' => 'Select Batch for ' . $first,
            'name' => 'batch',
            'name1' => 'batch_id',
            'options' => $batches,
            'key' => 'batches',
        ],
        [
            'label' => 'Select Batch for ' . $second,
            'name' => 'batch2',
            'name1' => 'batch2_id',
            'options' => $batches,
            'key' => 'batches',
        ],
        [
            'label' => 'Mixing Tool',
            'name' => 'mixing_tool',
            'name1' => 'mixing_tool_id',
            'options' => $mixingTools,
            'key' => 'mixing_tool',
        ],
        [
            'label' => 'Electrical Control',
            'name' => 'electrical_control',
            'name1' => 'electrical_control_id',
            'options' => $electricalControls,
            'key' => 'electrical_control',
        ],
        [
            'label' => 'Select Ac Frequency Drives',
            'name' => 'ac_frequency_drive',
            'name1' => 'ac_frequency_drive_id',
            'options' => $acFrequencyDrives,
            'key' => 'ac_fequency_drive',
        ],
        [
            'label' => 'Select Bearing',
            'name' => 'bearing',
            'name1' => 'bearing_id',
            'options' => $bearings,
            'key' => 'bearing',
        ],
        [
            'label' => 'Select Pneumatics',
            'name' => 'pneumatic',
            'name1' => 'pneumatic_id',
            'options' => $pneumatics,
            'key' => 'pneumatic',
        ],
        [
            'label' => 'Select Make Motor',
            'name' => 'make_motor',
            'name1' => 'make_motor_id',
            'options' => $makeMotors,
            'key' => 'name',
        ],
        [
            'label' => 'Select No of Rotating Blade',
            'name' => 'no_of_rotating_blades',
            'name1' => 'no_of_rotating_blade_id',
            'options' => $noOfRotatingBlades,
            'key' => 'no_of_blades',
        ],
        [
            'label' => 'Select No of Fixes Blade',
            'name' => 'no_of_fixes_blades',
            'name1' => 'no_of_fixes_blade_id',
            'options' => $noOfFixesBlades,
            'key' => 'no_of_blades',
        ],
        [
            'label' => 'Select Capacity',
            'name' => 'capacity',
            'name1' => 'capacity_id',
            'options' => $capacities,
            'key' => 'capacity',
        ],
        [
            'label' => 'Select Blower',
            'name' => 'blower',
            'name1' => 'blower_id',
            'options' => $blowers,
            'key' => 'blower',
        ],
        [
            'label' => 'Select Rotary Air Lock Valve',
            'name' => 'rotary_air_lock_valve',
            'name1' => 'rotary_air_lock_valve_id',
            'options' => $rotaryAirLockValves,
            'key' => 'rotary_air_lock_valve',
        ],
        [
            'label' => 'Select Feeding Hooper Capacity',
            'name' => 'feeding_hooper_capacity',
            'name1' => 'feeding_hooper_capacity_id',
            'options' => $feedingHooperCapacities,
            'key' => 'feeding_hooper_capacity',
        ],
    ];
@endphp

@section('content')
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create Quotation</h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('quotation.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    {{-- Client (always readonly) --}}
                    <div class="col-md-6 form-group">

                        <x-adminlte-input type="text" name="client" label="Client" value="{{ $customer->company_name }}"
                            readonly />
                        <input type="hidden" value="{{ $customer->id }}" name="customer_id" />
                    </div>

                    {{-- Machine --}}
                    <div class="col-md-6 form-group">
                        <x-adminlte-input type="text" name="machine" label="Machine" value="{{ $machine->name }}"
                            readonly />
                        <input type="hidden" value="{{ $machine->id }}" name="machine_id" />
                    </div>

                    {{-- Models --}}
                    <div class="col-md-6 form-group">
                        <x-adminlte-input type="text" name="model_id" label="Model" value="{{ $model->name ?? '' }}"
                            readonly />
                        <input type="hidden" value="{{ $model->id }}" name="model_id" id="model_id" />
                    </div>

                    {{-- Application --}}
                    <div class="col-md-6 form-group">
                        <x-adminlte-input name="application" value="{{ $product->name }}" label="Application"
                            placeholder="Application" readonly />
                        <input type="hidden" name="application_id" id="application_id" value="{{ $product->id }}" />
                    </div>

                    {{-- Quotation Ref No --}}
                    <div class="col-md-6 form-group form-group-position">
                        <label>Quotation Ref No</label>
                        <input type="text" name="reference_no" class="form-control readonly-input"
                            value="{{ $previewData['reference_no'] ?? '' }}" readonly>
                    </div>

                    {{-- Editable Fields --}}
                    @php
                        $inputs = [
                            ['label' => 'Date', 'name' => 'date', 'type' => 'date'],
                            ['label' => 'Quantity', 'name' => 'quantity', 'type' => 'number'],
                        ];
                    @endphp

                    @foreach ($inputs as $input)
                        <div class="col-md-6 form-group form-group-position">
                            <label>{{ $input['label'] }}</label>
                            <input type="{{ $input['type'] ?? 'text' }}" name="{{ $input['name'] }}"
                                class="form-control readonly-input" value="{{ $previewData[$input['name']] ?? '' }}"
                                readonly>
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endforeach

                    {{-- Editable Total Price --}}
                    <div class="col-md-6 form-group form-group-position">
                        <label>Total Price</label>
                        <input type="text" name="total_price" class="form-control readonly-input format-number"
                            value="{{ $previewData['total_price'] }}" step="0.01" readonly>
                        <i class="fas fa-pencil-alt edit-icon"></i>
                    </div>

                    {{-- Dynamic Select Fields --}}
                    @foreach ($selects as $select)
                        @if (isset($product->{$select['name1']}))
                            <div class="col-md-6 form-group form-group-position">
                                <label>{{ $select['label'] }}</label>
                                <select class="form-control select2 readonly-select" name="{{ $select['name'] }}">
                                    @foreach ($select['options'] as $option)
                                        <option value="{{ $option[$select['key']] }}"
                                            {{ ($previewData[$select['name']] ?? '') == $option->id || ($product->{$select['name1']} ?? '') == $option->id
                                                ? 'selected'
                                                : '' }}>
                                            {{ $option[$select['key']] }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-pencil-alt edit-icon"></i>
                            </div>
                        @endif
                    @endforeach
                    <!-- conditional Besed Input fields -->

                    @if (isset($product->useful_volume))
                        <div class="col-md-6">
                            <label>Useful Volume</label>
                            <input name="useful_volume" label="Useful Volume" value="{{ $product->useful_volume }}"
                                class="form-control readonly-input" required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (isset($product->compress_air_consumption))
                        <div class="col-md-6">
                            <label>Compress Air Consumption</label>
                            <input name="compress_air_consumption" label="Compress Air Consumption"
                                value="{{ $product->compress_air_consumption }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (isset($product->total_capacity))
                        <div class="col-md-6">
                            <label>Total Capacity</label>
                            <input name="total_capacity" label="Total Capacity" value="{{ $product->total_capacity }}"
                                class="form-control readonly-input" required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif


                    @if (isset($product->water_pressure))
                        <div class="col-md-6">
                            <label>Water Pressure</label>
                            <input name="water_pressure" label="Water Pressure" value="{{ $product->water_pressure }}"
                                class="form-control readonly-input" required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->operating_pressure))
                        <div class="col-md-6">
                            <label>Operating Pressure</label>
                            <input name="operating_pressure" label="Water Pressure"
                                value="{{ $product->operating_pressure }}" class="form-control readonly-input" required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->cooling_water_inlet_temperature))
                        <div class="col-md-6">
                            <label>Cooling Water Inlet Temperature</label>
                            <input name="cooling_water_inlet_temperature" label="Water Pressure"
                                value="{{ $product->cooling_water_inlet_temperature }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->cooling_water_flow_rate))
                        <div class="col-md-6">
                            <label>Cooling Water Flow Rate</label>
                            <input name="cooling_water_flow_rate" label="Cooling Water Flow Rate"
                                value="{{ $product->cooling_water_flow_rate }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->feeding_air_pressure))
                        <div class="col-md-6">
                            <label>Feeding Air Pressure</label>
                            <input name="feeding_air_pressure" label="Feeding Air Pressure"
                                value="{{ $product->feeding_air_pressure }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->contact_part))
                        <div class="col-md-6">
                            <label>Contact Part</label>
                            <input name="contact_part" label="Contact Part" value="{{ $product->contact_part }}"
                                class="form-control readonly-input" required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->no_of_rotating_blades))
                        <div class="col-md-6">
                            <label>No of Rotating Blades</label>
                            <input name="no_of_rotating_blades" label="No. of Rotating Plates"
                                value="{{ $product->no_of_rotating_blades }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->no_of_fixes_blades))
                        <div class="col-md-6">
                            <label>No of Fixes Blades</label>
                            <input name="no_of_fixes_blades" label="No. of Fixes Blades"
                                value="{{ $product->no_of_fixes_blades }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->size_of_input_material))
                        <div class="col-md-6">
                            <label>
                                Size of Input Material
                            </label>
                            <input name="size_of_input_material" value="{{ $product->size_of_input_material }}"
                                class="form-control readonly-input" required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->output))
                        <div class="col-md-6">
                            <label>Output</label>
                            <input name="output" value="{{ $product->output }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->finish_mesh_size))
                        <div class="col-md-6">
                            <label>Finish Mesh Size</label>
                            <input name="finish_mesh_size" value="{{ $product->finish_mesh_size }}"
                                class="form-control readonly-input" required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->conveying_pipe))
                        <div class="col-md-6">
                            <label>Conveying Pipe</label>
                            <input name="conveying_pipe" value="{{ $product->conveying_pipe }}"
                                class="form-control readonly-input" required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->tank))
                        <div class="col-md-6">
                            <label>Tank</label>
                            <input name="tank" value="{{ $product->tank }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->rotary))
                        <div class="col-md-6">
                            <label>Rotary</label>
                            <input name="rotary" value="{{ $product->rotary }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif
                    @if (isset($product->material))
                        <div class="col-md-6">
                            <label>Material</label>
                            <input name="material" value="{{ $product->material }}" class="form-control readonly-input"
                                required />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    {{-- User Selector --}}
                    <div class="col-md-6">
                        <x-adminlte-select label="Followed By" name="followed_by" class="form-group py-2">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea label="Remark" name="remark" class="form-group py-2"></x-adminlte-textarea>
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
        $(document).ready(function() {

            $('.edit-icon').on('click', function() {

                const field = $(this).siblings('input, select');

                /* INPUT */
                if (field.is('input')) {
                    let isReadonly = field.prop('readonly');

                    field.prop('readonly', !isReadonly)
                        .toggleClass('readonly-input', !isReadonly);
                }

                /* SELECT2 */
                if (field.is('select')) {
                    let container = field.next('.select2-container');
                    let isReadonly = field.data('readonly') === true;

                    if (isReadonly) {
                        field.data('readonly', false);
                        container.removeClass('select2-readonly')
                            .find('.select2-selection')
                            .css('pointer-events', 'auto');
                    } else {
                        field.data('readonly', true);
                        container.addClass('select2-readonly')
                            .find('.select2-selection')
                            .css('pointer-events', 'none');
                    }
                }
            });


            /* ========= FORM SUBMIT (VERY IMPORTANT) ========= */
            $('form').on('submit', function() {
                $('input, select').prop('readonly', false).prop('disabled', false);
            });

        });
    </script>
@endpush

{{-- @section('css')
<link rel="stylesheet" href="{{ asset('style/index.css') }}">
@stop --}}

@push('css')
    <link rel="stylesheet" href="{{ asset('style/customer.css') }}">
@endpush
