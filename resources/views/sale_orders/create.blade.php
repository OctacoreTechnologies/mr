@extends('layouts.app')

@section('title', 'Create Order')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0 text-primary font-weight-bold">Create Total Order</h1>
        <a href="{{ route('sale-order.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>
@stop

@section('content')
    <x-alert-components class="mb-3" />

    <form action="{{ route('sale-order.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-plus-circle"></i> Order Information</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    @if ($errors->any())
                     {{ $errors }}                    
                    @endif
                    {{-- Quotation --}}
                    <div class="col-md-6 mb-3">
                        <label for="quotation_id">Quotation <span class="text-primary">*</span></label>
                        <select name="quotation_id" class="form-control select2" required>
                            <option value="">-- Select Quotation --</option>
                            @foreach($quotations as $quotation)
                                <option value="{{$quotation->id }}" {{ $quotation->id == old('quotation_id') ? 'selected' : ''}}>
                                    {{ $quotation->customer->company_name }} ({{ $quotation->reference_no }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Order Date --}}
                    <div class="col-md-3 mb-3">
                        <label for="order_date">Order Date <span class="text-primary">*</span></label>
                        <input type="date" name="order_date" value="{{ old('order_date') }}" class="form-control" required>
                    </div>

                    {{-- Delivery Date --}}
                    <div class="col-md-3 mb-3">
                        <label for="delivery_date">Delivery Date</label>
                        <input type="date" name="delivery_date" value="{{ old('delivery_date') }}" class="form-control" required>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label for="status">Order Status</label>
                        <select name="status" class="form-control" required>
                            @if (old('status'))
                              <option value="{{ old('status') }}" slected>{{ ucfirst(old('statuts')) }}</option>
                            @endif
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status">Payment Status</label>
                        <select name="payment_status" class="form-control" required>
                            @if (old('payment_status'))
                              <option value="{{ old('payment_status') }}" selected>{{ ucfirst(old('payment_status')) }}</option>
                            @endif
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="half_paid">Half Paid</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-adminlte-input type="number" label="Total Amount" name="total_amount" value="{{ old('total_amount') }}" required/>
                    </div>

                    <div class="col-md-4 mb-3">
                        <x-adminlte-input type="number" label="Tax(Include GST)" name="tax" value="{{ old('tax') }}" required/>
                    </div>

                    
                    <div class="col-md-4 mb-3">
                        <x-adminlte-input type="number" label="Discount" name="discount"  value="{{ old('discount') }}" required/>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <x-adminlte-input type="number" label="Grand Total" name="grand_total" value="{{ old('tax') }}" required/>
                    </div>
                    {{-- Notes --}}
                    <div class="col-md-12 mb-3">
                        <label for="remarks">Internal Notes</label>
                        <textarea name="remarks" rows="3" class="form-control" placeholder="Add any comments or instructions...">{{ old('notes') }}</textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-adminlte-input type="number" label="Payment Term" name="payment_term" value="{{ old('payment_term') }}"  />
                    </div>
                     <div class="col-md-4 mb-3">
                        <x-adminlte-select class="select2" label="Followed By" name="followed_by">
                            <option>Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('followed_by') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                </div>

                <hr>

                {{-- Ledger Section --}}
                <h5><i class="fas fa-rupee-sign"></i> Payment Ledger</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="ledger_table">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>Type</th>
                                <th>Payment Date</th>
                                <th>Amount (₹)</th>
                                <th>Mode</th>
                                <th>Transaction ID</th>
                                <th>Remarks</th>
                                <th>
                                    <button type="button" class="btn btn-sm btn-success" id="addLedgerRow">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                     <select name="payments[0][type]" class="form-control"
                                            data-row="0" required>
                                            <option value="">Select</option>
                                            <option value="transportation" >Transportation</option>
                                            <option value="freight">Freight</option>
                                            <option value="machine">Machine</option>
                                        </select>
                                </td>
                                <td><input type="date" name="payments[0][date]" class="form-control" required></td>
                                <td><input type="number" step="0.01" name="payments[0][amount]" class="form-control amount-input"
                                        required>
                                </td>
                                <td>
                                    <select name="payments[0][mode]" class="form-control payment-mode" data-row="0" required>
                                        <option value="">Select</option>
                                        <option value="cash">Cash</option>
                                        <option value="online">Online</option>
                                        <option value="other">Other</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="payments[0][transaction_id]" class="form-control transaction-id d-none"
                                        placeholder="Enter Transaction ID">
                                </td>
                                <td>
                                    <textarea name="payments[0][remarks]" class="form-control remarks d-none"
                                        placeholder="Enter Remarks"></textarea>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary removeLedgerRow">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right font-weight-bold">Total Payment:</td>
                                <td id="ledger-total-amount" class="text-left font-weight-bold">₹0.00</td>
                            </tr>
                        </tfoot>
                    </table>

                </div>

            </div>

            <div class="card-footer text-right bg-light">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Order
                </button>
                <a href="{{ route('sale-order.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times-circle"></i> Cancel
                </a>
            </div>
        </div>
    </form>
@stop

@push('css')
<style>
    .transaction-id.d-none, .remarks.d-none {
        display: none !important;
    }
</style>
@endpush

@push('js')
<script src="{{ asset('js/sale_order.js') }}"></script>
@endpush