@extends('layouts.app')

@section('title', 'Added Quotation')

@section('content_header')
    <h1>Added Quotation</h1>
@stop

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('quotation.preview') }}" method="POST">
            @csrf
            @method("POST")
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Customer</label>
                    <select class="select2 form-control" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $quotation->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Machine Type</label>
                    <select class="select2 form-control" name="machine_type_id" id="machine_type_id" required>
                        <option>Select Machine Type</option>
                        @foreach($machineTypes as $type)
                            <option value="{{ $type->id }}" {{ old('machine_type_id') == $type->id ? 'selected' : '' }} data-price="{{ $type->price }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Machine</label>
                    <select class="select2 form-control" name="machine_id" id="machine_id" required>
                        <option>Select Machine</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Application</label>
                    <select class="select2 form-control" name="application_id" id="application_id" required>
                        <option>Select Application</option>
                    </select>
                </div>

              <div class="col-md-6" id="model">
                    <label>Model</label>
                    <select class="select2 form-control" name="model_id" id="model_id" required>
                        <option>Select Model</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Quotation Ref No</label>
                    <input type="text" name="reference_no" class="form-control" value="{{ $reference_no }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Price(Unit)</label>
                    <input type="text" name="total_price" id="total_price" class="form-control format-number" step="0.01" value="{{ old('total_price') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" step="0.01" value="{{ old('quantity', 1) }}">
                </div>

               {{--<div class="col-md-6 mb-3">
                    <label>Discount</label>
                    <input type="number" name="discount" id="discount" class="form-control" step="0.01" value="{{ old('discount', 0) }}">
                </div>--}}

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            </div>

            <div class="mt-3 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('quotation.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@stop

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush


@push('js')
    <script>
        $(document).ready(function () {
            // $("#leadId").hide();
        //    $("#model").hide();
            $('.js-example-basic-single').select2();
            $(".selection").children('.select2-selection').addClass('h-100')
            $('.select2').addClass('w-100');

            function updatePrice() {
        // Get the selected product's price
        var productPrice = $('#product_id option:selected').data('price');
        
        // Get the quantity entered by the user
        var quantity = $('#quantity').val();
        
        // Calculate total price
        var totalPrice = productPrice * quantity;
        
        // Update the total price input field
        $('#total_price').val(totalPrice.toFixed(2));
    }

    // Update price when product is selected
    $('#product_id').change(function() {
        updatePrice();
    });

    // Update price when quantity is changed
    $('#quantity').on('input', function() {
        updatePrice();
    });

    // Initial calculation on page load (in case a product is already selected)
    updatePrice();

    //change dropdown's 
    $('#machine_type_id').on('change', function () {
            let machineTypeId = $(this).val();
            let selectedText = $(this).find("option:selected").text();
    
            // Update label dynamically
            // $('#machine_label').text(`Select ${selectedText}`);

            if (machineTypeId) {
                $.ajax({
                    url: '/categories/get-machines/' + machineTypeId,
                    type: 'GET',
                    success: function (machines) {
                        $('#machine_id').empty().append('<option value="">Select Machine</option>');

                        $.each(machines, function (key, machine) {
                            $('#machine_id').append('<option value="' + machine.id + '">' + machine.name + '</option>');
                        });

                        // If you're using select2
                        $('#machine_id').trigger('change');
                    }
                });
            } else {
                $('#machine_id').empty().append('<option value="">Select Machine</option>');
                $('#machine_label').text('Select Machine');
            }
        });

        $("#machine_id").on('change',function(){
            $("#models").show();
        })
    })

      $('.edit-icon').on('click', function () {
        const input = $(this).siblings('input, select');
        input.prop('readonly', false).prop('disabled', false).removeClass('readonly-input');
    });

    // application dropdowns
    $('#machine_id').on('change', function () {
            let machineId = $(this).val();
            let selectedText = $(this).find("option:selected").text();
            
        
            // $('#machine_label').text(`Select ${selectedText}`);

            if (machineId) {
                $.ajax({
                    url: '/categories/options/applications/' + machineId,
                    type: 'GET',
                    success: function (applications) {
                        $('#application_id').empty().append('<option value="">Select Application</option>');

                        $.each(applications, function (key, application) {
                            $('#application_id').append('<option value="' + application.id + '">' + application.name + '</option>');
                        });

                        // If you're using select2
                        $('#application_id').trigger('change');
                    }
                });
                //Models
                $.ajax({
                    url: '/categories/options/models/' + machineId,
                    type: 'GET',
                    success: function (models) {
                        $("#model").show();
                        $('#model_id').empty().append('<option value="">Select Model</option>');

                        $.each(models, function (key, model) {
                            $('#model_id').append('<option value="' + model.id + '">' + model.name + '</option>');
                        });

                        // If you're using select2
                        $('#model_id').trigger('change');
                    }
                });

            } else {
                $('#application_id').empty().append('<option value="">Select Application</option>');
                // $('#machine_label').text('Select Machine');
                $('#model_id').empty().append('<option value="">Select Model</option>');
            }

        });
    </script>
@endpush