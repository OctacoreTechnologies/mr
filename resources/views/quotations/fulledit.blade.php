@extends('layouts.app')

@section('title', 'Edit Quotation')

@push('css')
    <style>
        /* (Same CSS as create.blade.php - for brevity, you can reuse your existing styles) */
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

        label {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
        }

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

        .form-group-position {
            position: relative;
        }

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

        .select2-container--default .select2-selection--single {
            border-radius: 10px;
            padding: 10px;
            font-size: 14px;
        }

        .invalid-feedback {
            font-size: 13px;
            color: #dc3545;
        }

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
    <h1>Edit Quotation</h1>
@stop

@php
    $machineName = trim($machine->name);
    $parts = explode(' and ', $machineName);
    if (count($parts) == 2) {
        $first = trim($parts[0]);
        $second = trim($parts[1]);
    } else {
        $first = $second = $machineName;
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
            'label' => 'Select ' . $second . ' Motor Requirement',
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
            'label' => 'Electrical Control for ' . $second,
            'name' => 'electrical_control_2',
            'name1' => 'electrical_control_2_id',
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
            'label' => 'Select ' . $second . ' Ac Frequency Drive',
            'name' => 'ac_frequency_drive_2',
            'name1' => 'ac_frequency_drive_2_id',
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
            'label' => 'Select ' . $second . ' Bearing',
            'name' => 'bearing_2',
            'name1' => 'bearing_2_id',
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
            'label' => 'Select ' . $second . ' Pneumatic',
            'name' => 'pneumatic_2',
            'name1' => 'pneumatic_2_id',
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
            'label' => 'Select Make ' . $second . ' Motor',
            'name' => 'make_motor_2',
            'name1' => 'make_motor_2_id',
            'options' => $makeMotors,
            'key' => 'name',
        ],
        // [
        //     'label' => 'Select No of Rotating Blade',
        //     'name' => 'no_of_rotating_blades',
        //     'name1' => 'no_of_rotating_blades',
        //     'options' => $noOfRotatingBlades,
        //     'key' => 'no_of_blades',
        // ],
        // [
        //     'label' => 'Select No of Fixes Blade',
        //     'name' => 'no_of_fixes_blades',
        //     'name1' => 'no_of_fixes_blades',
        //     'options' => $noOfFixesBlades,
        //     'key' => 'no_of_blades',
        // ],
        // [
        //     'label' => 'Select Capacity',
        //     'name' => 'capacity',
        //     'name1' => 'capacity',
        //     'options' => $capacities,
        //     'key' => 'capacity',
        // ],
    ];

    $inputs = [
        ['label' => 'Date', 'name' => 'date', 'type' => 'date', 'id' => 'dateselect', 'class' => 'form-control'],
        [
            'label' => 'Quantity',
            'name' => 'quantity',
            'type' => 'number',
            'id' => 'quantity',
            'class' => 'form-control',
        ],
        [
            'label' => 'Unit Price',
            'name' => 'total_price',
            'type' => 'text',
            'id' => 'total_price',
            'class' => 'form-control format-number',
        ],
    ];
@endphp

@section('content')
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Quotation</h4>
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
            <form action="{{ route('quotation.fullUpdate', $quotation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    @if (request()->query('reorder') != 1)
                        <div class="form-group col-md-3">
                            <div class="form-check mt-4 ">
                                <input type="checkbox" class="form-check-input" id="revise" name="revise" value="1"
                                    {{ old('revise', $quotation->revise) ? 'checked' : '' }}>
                                <label class="form-check-label" for="revise">Revise Quotation</label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="form-check mt-4 ">
                                <input type="checkbox" class="form-check-input" id="reflectInPdf" name="reflect_in_pdf"
                                    value="1" {{ old('revise', $quotation->reflect_in_pdf) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reflect_in_pdf">Reflect In Pdf</label>
                            </div>
                        </div>
                    @endif

                    {{-- Customer (readonly) --}}
                    <div class="col-md-6 form-group">
                        <x-adminlte-input type="text" name="customer" label="Customer"
                            value="{{ $customer->company_name }}" readonly />
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}" />
                    </div>

                    {{-- Machine (readonly) --}}
                    <div class="col-md-6 form-group">
                        <x-adminlte-input type="text" name="machine" label="Machine" value="{{ $machine->name }}"
                            readonly />
                        <input type="hidden" name="machine_id" value="{{ $machine->id }}" />
                    </div>

                    {{-- Model (readonly) --}}
                    <div class="col-md-6 form-group">
                        <x-adminlte-input type="text" name="model" label="Model" value="{{ $model->name ?? '' }}"
                            readonly />
                        <input type="hidden" name="model_id" value="{{ $model->id ?? '' }}" />
                    </div>

                    {{-- Application (readonly) --}}
                    @if (!empty($product->name))
                        <div class="col-md-6 form-group">
                            <x-adminlte-input type="text" name="application" label="Application"
                                value="{{ $product->name }}" readonly />
                            <input type="hidden" name="application_id" value="{{ $product->id }}" />
                        </div>
                    @endif

                    {{-- Quotation Ref No (readonly) --}}
                    <div class="col-md-6 form-group form-group-position">
                        <label>Quotation Ref No</label>
                        <input type="text" name="reference_no" class="form-control readonly-input"
                            value="{{ $quotation->reference_no ?? '' }}" readonly />
                    </div>

                    {{-- Editable Inputs with condition --}}
                    @foreach ($inputs as $input)
                        @if (!empty($quotation->{$input['name']}))
                            <div class="col-md-6 form-group form-group-position">
                                <label>{{ $input['label'] }}</label>
                                <input type="{{ $input['type'] ?? 'text' }}" name="{{ $input['name'] }}"
                                    class="{{ $input['class'] }} readonly-input" id="{{ $input['name'] }}"
                                    value="{{ old($input['name'], $quotation->{$input['name']}) }}" readonly />
                                <i class="fas fa-pencil-alt edit-icon"></i>
                            </div>
                        @endif
                    @endforeach

                    {{-- Select fields with condition --}}
                    @foreach ($selects as $select)
                        @php
                            $fieldName = $select['name'];
                            $fieldIdName = $select['name1'];
                            $selectedValue = $quotation->{$fieldIdName} ?? null;
                        @endphp

                        @if (!empty($selectedValue))
                            <div class="col-md-6 form-group form-group-position">
                                <label>{{ $select['label'] }}</label>
                                <select class="form-control select2 readonly-select" name="{{ $fieldName }}" readonly>
                                    @foreach ($select['options'] as $option)
                                        <option value="{{ $option->{$select['key']} }}"
                                            {{ $selectedValue == $option->id ? 'selected' : '' }}>
                                            {{ $option->{$select['key']} }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-pencil-alt edit-icon"></i>
                            </div>
                        @endif
                    @endforeach

                    @if (!empty($quotation->no_of_rotating_blades))
                        <div class="col-md-6 form-group">
                            <label>No of Rotating Blades</label>
                            <select class="form-control select2 readonly-select" name="no_of_rotating_blades" readonly>
                                <option value="{{ $quotation->no_of_rotating_blades }}" selected> {{  $quotation->no_of_rotating_blades }}</option>
                                @foreach ($noOfRotatingBlades as $blade)
                                    <option value="{{ $blade->no_of_blades }}"
                                        {{ $quotation->no_of_rotating_blades == $blade->no_of_blades ? 'selected' : '' }}>
                                        {{ $blade->no_of_blades }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (!empty($quotation->no_of_fixes_blades))
                        <div class="col-md-6 form-group">
                            <label>No of Fixes Blades</label>
                           <select class="form-control select2 readonly-select" name="no_of_fixes_blades" readonly>
                               <option value="{{ $quotation->no_of_fixes_blades }}" selected> {{  $quotation->no_of_fixes_blades }}</option>
                                @foreach ($noOfFixesBlades as $blade)
                                    <option value="{{ $blade->no_of_blades }}"
                                        {{ $quotation->no_of_fixes_blades == $blade->no_of_blades ? 'selected' : '' }}>
                                        {{ $blade->no_of_blades }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                    @endif

                    {{-- capacity --}}

                    @if (!empty($quotation->capacity))
                        <div class="col-md-6 form-group">
                            <label>Capacity</label>
                            <select class="form-control select2 readonly-select" name="capacity" readonly>
                                <option value="{{ $quotation->capacity }}" selected> {{  $quotation->capacity }}</option>
                                @foreach ($capacities as $capacity)
                                    <option value="{{ $capacity->capacity }}"
                                        {{ $quotation->capacity == $capacity->capacity ? 'selected' : '' }}>
                                        {{ $capacity->capacity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    @endif

                    {{-- gear box 1 --}}

                    @if (!empty($quotation->gear_box_1))
                        <div class="col-md-6 form-group">
                            <label>Gear Box 1</label>
                            <select class="form-control select2 readonly-select" name="gear_box_1" readonly>
                                <option value="{{ $quotation->gear_box_1 }}" selected> {{  $quotation->gear_box_1 }}</option>
                                @foreach ($gearBoxes as $gearBox)
                                    <option value="{{ $gearBox->name }}"
                                        {{ $quotation->gear_box_1 == $gearBox->name ? 'selected' : '' }}>
                                        {{ $gearBox->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    @endif

                     {{-- gear box 2 --}}

                     @if (!empty($quotation->gear_box_2))
                        <div class="col-md-6 form-group">
                            <label>Gear Box 2</label>
                            <select class="form-control select2 readonly-select" name="gear_box_2" readonly>
                                <option value="{{ $quotation->gear_box_2 }}" selected> {{  $quotation->gear_box_2 }}</option>
                                @foreach ($gearBoxes as $gearBox)
                                    <option value="{{ $gearBox->name }}"
                                        {{ $quotation->gear_box_2 == $gearBox->name ? 'selected' : '' }}>
                                        {{ $gearBox->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- drive System 1 --}}
                    @if (!empty($quotation->drive_system_1))
                        <div class="col-md-6 form-group">
                            <label>Drive System 1</label>
                            <select class="form-control select2 readonly-select" name="drive_system_1" readonly>
                                <option value="{{ $quotation->drive_system_1 }}" selected> {{  $quotation->drive_system_1 }}</option>
                                @foreach ($driveSystems as $driveSystem)
                                    <option value="{{ $driveSystem->name }}"
                                        {{ $quotation->drive_system_1 == $driveSystem->name ? 'selected' : '' }}>
                                        {{ $driveSystem->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- drive System 2 --}}    

                    @if (!empty($quotation->drive_system_2))
                        <div class="col-md-6 form-group">
                            <label>Drive System 2</label>
                            <select class="form-control select2 readonly-select" name="drive_system_2" readonly>
                                <option value="{{ $quotation->drive_system_2 }}" selected> {{  $quotation->drive_system_2 }}</option>
                                @foreach ($driveSystems as $driveSystem)
                                    <option value="{{ $driveSystem->name }}"
                                        {{ $quotation->drive_system_2 == $driveSystem->name ? 'selected' : '' }}>
                                        {{ $driveSystem->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Other input fields with condition (Example fields from your code) --}}

                    @if (!empty($quotation->useful_volume))
                        <div class="col-md-6 form-group">
                            <label>Useful Volume</label>
                            <input type="text" name="useful_volume" value="{{ $quotation->useful_volume }}"
                                class="form-control readonly-input" readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->compress_air_consumption))
                        <div class="col-md-6 form-group">
                            <label>Compress Air Consumption</label>
                            <input type="text" name="compress_air_consumption"
                                value="{{ $quotation->compress_air_consumption }}" class="form-control readonly-input"
                                readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->water_pressure))
                        <div class="col-md-6 form-group">
                            <label>Water Pressure</label>
                            <input type="text" name="water_pressure" value="{{ $quotation->water_pressure }}"
                                class="form-control readonly-input" readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->operating_pressure))
                        <div class="col-md-6 form-group">
                            <label>Operating Pressure</label>
                            <input type="text" name="operating_pressure" value="{{ $quotation->operating_pressure }}"
                                class="form-control readonly-input" readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->cooling_water_inlet_temperature))
                        <div class="col-md-6 form-group">
                            <label>Cooling Water Inlet Temperature</label>
                            <input type="text" name="cooling_water_inlet_temperature"
                                value="{{ $quotation->cooling_water_inlet_temperature }}"
                                class="form-control readonly-input" readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->cooling_water_flow_rate))
                        <div class="col-md-6 form-group">
                            <label>Cooling Water Flow Rate</label>
                            <input type="text" name="cooling_water_flow_rate"
                                value="{{ $quotation->cooling_water_flow_rate }}" class="form-control readonly-input"
                                readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->feeding_air_pressure))
                        <div class="col-md-6 form-group">
                            <label>Feeding Air Pressure</label>
                            <input type="text" name="feeding_air_pressure"
                                value="{{ $quotation->feeding_air_pressure }}" class="form-control readonly-input"
                                readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->contact_part))
                        <div class="col-md-6 form-group">
                            <label>Contact Part</label>
                            <input type="text" name="contact_part" value="{{ $quotation->contact_part }}"
                                class="form-control readonly-input" readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->houseline_length))
                        <div class="col-md-6 form-group">
                            <label>HouseLine Length</label>
                            <input type="text" name="houseline_length" value="{{ $quotation->houseline_length }}"
                                class="form-control readonly-input" readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->capacity_ton_hour))
                        <div class="col-md-6 form-group">
                            <label>Capacity Ton Hour</label>
                            <input type="text" name="capacity_ton_hour" value="{{ $quotation->capacity_ton_hour }}"
                                class="form-control readonly-input" readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    @if (!empty($quotation->power))
                        <div class="col-md-6 form-group">
                            <label>Power</label>
                            <input type="text" name="power" value="{{ $quotation->power }}"
                                class="form-control readonly-input" readonly />
                            <i class="fas fa-pencil-alt edit-icon"></i>
                        </div>
                    @endif

                    <div class="form-group col-md-6">
                        <x-adminlte-select label="Discount Type" name="discount_type" id="discountType" class="p-2">
                            <option value="none" {{ $quotation->discount_type == 'none' ? 'selected' : '' }}>None
                            </option>
                            <option value="amount" {{ $quotation->discount_type == 'amount' ? 'selected' : '' }}>Amount
                            </option>
                            <option value="percentage" {{ $quotation->discount_type == 'percentage' ? 'selected' : '' }}>
                                Percentage</option>
                        </x-adminlte-select>
                    </div>

                    <div class="form-group col-md-6 mb-3" id="discountPercentage">
                        <x-adminlte-input type="number" label="Discount(%)" id="discount_percentage"
                            name="discount_percentage" value="{{ $quotation->discount_percentage }}" />
                    </div>
                    <div class="form-group col-md-6 mb-3" id="discountAmount">
                        <x-adminlte-input type="text" label="Discount Amount" id="discount_amount"
                            name="discount_amount" value="{{ $quotation->discount_amount }}" class="format-number" />
                    </div>

                    @php $itemNo = 1; @endphp

                    @foreach ($quotation->getRelation('items') ?? [] as $index => $item)
                        <div class="form-group col-md-6 item-row">
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">

                            <label>Item {{ $itemNo }}</label>

                            <input type="text" name="items[{{ $index }}][name]"
                                value="{{ $item->item_name }}" placeholder="Item Name" class="form-control mb-1">

                            <input type="text" name="items[{{ $index }}][price]"
                                value="{{ $item->item_price }}" placeholder="Item Price"
                                class="form-control item-price format-number">

                            <input type="number" name="items[{{ $index }}][qty]" value="{{ $item->item_qty }}"
                                placeholder="Item Quantity" class="form-control item-qty ">
                            <select name="items[{{ $index }}][qty_unit]" class="form-control mb-1 p-2">
                                <option value="Nos" {{ $item->qty_unit == 'Nos' ? 'selected' : '' }}>Nos</option>
                                <option value="Meter" {{ $item->qty_unit == 'Meter' ? 'selected' : '' }}>Meter</option>
                                <option value="Kg" {{ $item->qty_unit == 'Kg' ? 'selected' : '' }}>Kg</option>
                                <option value="Set" {{ $item->qty_unit == 'Set' ? 'selected' : '' }}>Set</option>
                            </select>

                            <input type="text" name="total_item_price"
                                value="{{ $item->item_price * $item->item_qty }}" placeholder="Item Price"
                                class="form-control item-total format-number item-total" readonly>

                            <button type="button" class="btn btn-danger btn-xs mt-1 removeItem">
                                Remove
                            </button>
                        </div>

                        @php $itemNo++; @endphp
                    @endforeach
                    <div class="form-group col-md-6 mb-3" id="total">
                        <x-adminlte-input type="text" id="total_amount" label="Total" name="total"
                            value="{{ $quotation->total }}" class="format-number" />
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-textarea label="Remark" name="remark"
                            class="form-group py-2">{{ $quotation->remark ?? '' }}</x-adminlte-textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-primary btn-sm" id="addItemBtn">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>

                    {{-- <div class="form-group col-md-6" id="reminder">
                        <x-adminlte-input type="datetime-local" label="Remider Date" name="reminder_date"
                            value="{{ $quotation->reminder_date ?? '' }}" />
                    </div> --}}

                    {{-- More fields can be added here similarly --}}

                    {{-- Submit and Cancel buttons --}}
                    <div class="col-md-12 mt-4 text-end">
                        <a href="{{ route('quotation.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Update Quotation</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // Toggle readonly/editable on pencil icon click
            $('.edit-icon').on('click', function() {
                const field = $(this).siblings('input, select');

                // For input fields
                if (field.is('input')) {
                    if (field.prop('readonly')) {
                        field.prop('readonly', false); // Make the field editable
                        field.removeClass('readonly-input'); // Remove readonly class for styling
                        field.css('background-color', '#fff'); // Change background to white when editable
                    } else {
                        field.prop('readonly', true); // Make the field readonly
                        field.addClass('readonly-input'); // Add readonly class for styling
                        field.css('background-color',
                            '#f8f9fa'); // Set background color to indicate readonly state
                    }
                }

                // For select fields (select2)
                if (field.is('select')) {
                    if (field.hasClass('readonly-select')) {
                        field.removeClass('readonly-select'); // Remove readonly class for select
                        field.select2('enable', true); // Enable select2 functionality
                        field.css('background-color', '#fff'); // Set background to white when editable
                    } else {
                        field.addClass('readonly-select'); // Add readonly class for select
                        field.select2('enable', false); // Disable select2 functionality
                        field.css('background-color',
                            '#f8f9fa'); // Set background color to indicate readonly state
                    }
                }
            });

        });
    </script>
    <script src="{{ asset('js/quotation_edit.js') }}"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('style/customer.css') }}">
@endpush


{{-- @push('js')
    <script src="{{ asset('js/quotation_edit.js') }}"></script>
@endpush --}}
