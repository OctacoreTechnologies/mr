@extends('layouts.app')

@section('title', 'Edit Quotation')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Quotation</h1>
    <a class="btn btn-link" href="{{ route('quotation.fullEditForm',$quotation->id) }}">Full Edit</a>
@stop

@section('content')
<div class="container-fluid">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Quotation Details</h3>
        </div>

        <form action="{{ route('quotation.update', $quotation->id) }}" method="POST">
            @csrf
            @method("PUT")

            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-check mt-4">
                            <input type="checkbox" class="form-check-input" id="revise" name="revise" value="1" {{ old('revise', $quotation->revise) ? 'checked' : '' }}>
                            <label class="form-check-label" for="revise">Revise Quotation</label>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_id">Customer</label>
                        <select class="form-control select2" name="customer_id" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $quotation->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <x-adminlte-input name="application_id" label="Application" value="{{ $quotation->application->name }}" readonly/>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="reference_no">Quotation Ref No</label>
                        <input type="text" class="form-control" name="reference_no" value="{{ old('reference_no', $quotation->reference_no) }}" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" value="{{ old('date', $quotation->date) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" class="form-control" name="quantity" step="0.01" value="{{ old('quantity', $quotation->quantity) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="total_price">Price(Unit)</label>
                        <input type="number" class="form-control" id="total_price" name="total_price" step="0.01" value="{{ old('total_price', $quotation->total_price) }}">
                    </div>

                    <!-- <div class="form-group col-md-6">
                        <label for="discount">Discount</label>
                        <input type="number" class="form-control" name="discount" step="0.01" value="{{ old('discount', $quotation->discount) }}">
                    </div> -->
                     <div class="form-group col-md-6" >
                        <x-adminlte-select label="Discount Type" name="discount_type" id="discountType">
                            <option value="none" {{ $quotation->discount_type == "none" ? 'selected' : '' }}>None </option>
                            <option value="amount" {{ $quotation->discount_type == "amount" ? 'selected' : '' }}>Amount</option>
                            <option value="percentage" {{ $quotation->discount_type == "percentage" ? 'selected' : '' }}>
                                Percentage</option>
                        </x-adminlte-select>
                     </div>
    
                    <div class="form-group col-md-6 mb-3" id="discountPercentage">
                        <x-adminlte-input type="number" label="Discount(%)" id="discount_percentage" name="discount_percentage" value="{{ $quotation->discount_percentage }}"
                            />
                    </div>
                    <div class="form-group col-md-6 mb-3" id="discountAmount">
                        <x-adminlte-input type="number" label="Discount Amount" id="discount_amount" name="discount_amount" value="{{ $quotation->discount_amount }}"
                             />
                    </div>
                     <div class="form-group col-md-6 mb-3" id="total">
                        <x-adminlte-input type="number" id="total_amount" label="Total" name="total" value="{{ $quotation->total }}"
                           />
                    </div>
                    <div class="form-group col-md-6" id="reminder">
                     <x-adminlte-input type="datetime-local" label="Remider Date" name="reminder_date"  value="{{ $quotation->reminder_date??'' }}" />
                    </div>

                     <div class="form-group col-md-6">
                         <label for="status">Status</label>
                         <select class="form-control" name="status" id="status">
                             <option value="Draft" {{ $quotation->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                             <option value="Sent" {{ $quotation->status == 'Sent' ? 'selected' : '' }}>Sent</option>
                             <option value="Approved" {{ $quotation->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                             <option value="Rejected" {{ $quotation->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                         </select>
                     </div>
                      <div class="form-group col-md-6">
                         <x-adminlte-textarea label="Remark" name="remark" class="form-group py-2">{{ $quotation->remark??'' }}</x-adminlte-textarea>
                      </div>
                      <div class="form-group col-md-6">
                      <x-adminlte-select label="Followed By" name="followed_by" class="form-group py-2">
                          @foreach ($users as $user)
                              <option value="{{$user->id}}" {{ $quotation->followed_by==$user->id ?'selected':'' }}>{{$user->name}}</option> 
                          @endforeach
                      </x-adminlte-select>
                      </div>

                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Update Quotation</button>
                <a href="{{ route('quotation.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@stop

@push('js')
    <script>
        $(function () {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select an option",
                allowClear: true
            });
        });

        function toggleReminderField(){
             var selectedValue = $('#status').val();

              if (selectedValue === 'Draft') {
                  $('#reminder').show();
                //   $('textarea[name="reminder_date"]').prop('required', true);
              } else {
                  $('#reminder').hide();
                //   $('textarea[name="reminder_date"]').prop('required', false);
              }
        }

         toggleReminderField();

        // Call on change as well
        $('#status').change(function () {
            toggleReminderField();
        });

     $(document).ready(function() {
    // Initially hide both discount fields on page load
    $('#discountPercentage').hide();
    $('#discountAmount').hide();

    // Function to update the total price
    function updateTotal() {
        var price = parseFloat($('#total_price').val()) || 0;
        var quantity = parseFloat($('#quantity').val())||1 ;
        var discountType = $('#discountType').val();
        var discountPercentage = parseFloat($('#discount_percentage').val()) || 0;
        var discountAmount = parseFloat($('#discount_amount').val()) || 0;

        // var totalPirce = price*quantity;

        var total = price*quantity;

        if (discountType === 'percentage') {
            console.log('percentage')
            // Calculate percentage discount
            total = total - (total * discountPercentage / 100);
            $('#discount_amount').val(0); // Clear discount amount field if using percentage
        } else if (discountType === 'amount') {
            // Deduct discount amount
            total = total - discountAmount;
            $('#discount_percentage').val(0); // Clear discount percentage field if using amount
        }

        // Update the total field (making sure it's properly formatted)
        $('#total_amount').val(total.toFixed(2));
    }

    // Handle changes to the discount type
    $('#discountType').on('change', function() {
        var discountType = $(this).val();

        // Show or hide discount fields based on selected type
        if (discountType === 'percentage') {
            $('#discountPercentage').show();
            $('#discountAmount').hide();
        } else if (discountType === 'amount') {
            $('#discountAmount').show();
            $('#discountPercentage').hide();
        } else {
            $('#discountPercentage').hide();
            $('#discountAmount').hide();
        }

        // Update total price whenever discount type changes
        updateTotal();
    });

    // Calculate total whenever discount, price, or amount changes
    $('#total_price, #discount_percentage, #discount_amount').on('input', function() {
        updateTotal();
    });

    // Initial load handling (in case of editing)
    (function() {
        var initialDiscountType = $('#discountType').val();

        // If discount type is 'percentage', show discount_percentage field
        if (initialDiscountType === 'percentage') {
            $('#discountPercentage').show();
            $('#discountAmount').hide();
        }
        // If discount type is 'amount', show discount_amount field
        else if (initialDiscountType === 'amount') {
            $('#discountAmount').show();
            $('#discountPercentage').hide();
        }
        // If no discount, hide both discount fields
        else {
            $('#discountPercentage').hide();
            $('#discountAmount').hide();
        }

        // Update total based on initial selection
        updateTotal();
    })();
});

    </script>
@endpush

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush

