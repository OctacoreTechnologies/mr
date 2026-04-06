@extends('layouts.app')

@section('title', 'Create Quotation')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice"></i>
        Create Quotation
    </h1>
    <a href="{{ route('quotation.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Quotations
    </a>
</div>
@stop

@section('content')

<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Quotation Information
        </h3>
    </div>

    <div class="crm-card-body">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('quotation.preview') }}" method="POST">
            @csrf
            @method("POST")

            {{-- ── Machine Selection ── --}}
            <p class="crm-section">Machine Selection</p>
            <div class="row">

                {{-- Customer --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_id">Customer</label>
                        <select class="select2 form-control w-100" name="customer_id" id="customer_id" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id', $quotation->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Machine Type --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="machine_type_id">Machine Type</label>
                        <select class="select2 form-control w-100" name="machine_type_id" id="machine_type_id" required>
                            <option value="">Select Machine Type</option>
                            @foreach($machineTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('machine_type_id') == $type->id ? 'selected' : '' }}
                                    data-price="{{ $type->price }}">
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Machine --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="machine_id">Machine</label>
                        <select class="select2 form-control w-100" name="machine_id" id="machine_id" required>
                            <option value="">Select Machine</option>
                        </select>
                    </div>
                </div>

                {{-- Application --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="application_id">Application</label>
                        <select class="select2 form-control w-100" name="application_id" id="application_id" required>
                            <option value="">Select Application</option>
                        </select>
                    </div>
                </div>

                {{-- Model --}}
                <div class="col-md-6" id="model">
                    <div class="form-group">
                        <label for="model_id">Model</label>
                        <select class="select2 form-control w-100" name="model_id" id="model_id" required>
                            <option value="">Select Model</option>
                        </select>
                    </div>
                </div>

            </div>

            {{-- ── Quotation Details ── --}}
            <p class="crm-section">Quotation Details</p>
            <div class="row">

                {{-- Reference No --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="reference_no">Quotation Ref No</label>
                        <input type="text" name="reference_no" id="reference_no"
                            class="form-control"
                            value="{{ $reference_no }}" readonly>
                    </div>
                </div>

                {{-- Date --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date"
                            class="form-control"
                            value="{{ old('date') }}">
                    </div>
                </div>

                {{-- Price --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="total_price">Price (Unit)</label>
                        <input type="text" name="total_price" id="total_price"
                            class="form-control format-number"
                            step="0.01"
                            value="{{ old('total_price') }}"
                            placeholder="0.00">
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity"
                            class="form-control"
                            step="1"
                            value="{{ old('quantity', 1) }}"
                            min="1">
                    </div>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            </div>

            {{-- ── Actions ── --}}
            <div class="crm-form-actions">
                <a href="{{ route('quotation.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Preview Quotation
                </button>
            </div>

        </form>
    </div>{{-- /crm-card-body --}}
</div>{{-- /crm-card --}}

@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush

@push('js')
    <script>
        $(document).ready(function () {

            // Init Select2
            $('.select2').select2({ width: '100%' });
            $(".selection").children('.select2-selection').addClass('h-100');

            // ── Price calculation ──
            function updatePrice() {
                var productPrice = $('#product_id option:selected').data('price');
                var quantity     = $('#quantity').val();
                var totalPrice   = productPrice * quantity;
                // $('#total_price').val(totalPrice.toFixed(2));
            }

            $('#product_id').change(updatePrice);
            $('#quantity').on('input', updatePrice);
            updatePrice();

            // ── Machine Type → Machines ──
            $('#machine_type_id').on('change', function () {
                let machineTypeId = $(this).val();

                if (machineTypeId) {
                    $.ajax({
                        url: '/categories/get-machines/' + machineTypeId,
                        type: 'GET',
                        success: function (machines) {
                            $('#machine_id').empty().append('<option value="">Select Machine</option>');
                            $.each(machines, function (key, machine) {
                                $('#machine_id').append(
                                    '<option value="' + machine.id + '">' + machine.name + '</option>'
                                );
                            });
                            $('#machine_id').trigger('change');
                        }
                    });
                } else {
                    $('#machine_id').empty().append('<option value="">Select Machine</option>');
                }
            });

            // ── Machine → Applications ──
            $('#machine_id').on('change', function () {
                let machineId = $(this).val();

                $('#application_id').empty().append('<option value="">Select Application</option>');
                $('#model_id').empty().append('<option value="">Select Model</option>');

                if (machineId) {
                    $.ajax({
                        url: '/categories/options/applications/' + machineId,
                        type: 'GET',
                        success: function (applications) {
                            $.each(applications, function (key, application) {
                                $('#application_id').append(
                                    '<option value="' + application.id + '">' + application.name + '</option>'
                                );
                            });
                            $('#application_id').trigger('change');
                        }
                    });
                }
            });

            // ── Application → Models ──
            $('#application_id').on('change', function () {
                let applicationId = $(this).val();
                let machineId     = $('#machine_id').val();

                $('#model_id').empty().append('<option value="">Select Model</option>');

                if (applicationId && machineId) {
                    $.ajax({
                        url: '/categories/options/models/application/' + machineId + '/' + applicationId,
                        type: 'GET',
                        success: function (models) {
                            if (models.length > 0) {
                                $.each(models, function (key, model) {
                                    $('#model_id').append(
                                        '<option value="' + model.id + '">' + model.name + '</option>'
                                    );
                                });
                            } else {
                                $('#model_id').append('<option value="">No Models Found</option>');
                            }
                            $('#model_id').trigger('change');
                        },
                        error: function () {
                            $('#model_id').append('<option value="">No Models Found</option>');
                        }
                    });
                }
            });

            // Edit icon helper
            $('.edit-icon').on('click', function () {
                const input = $(this).siblings('input, select');
                input.prop('readonly', false).prop('disabled', false).removeClass('readonly-input');
            });

        });
    </script>
@endpush