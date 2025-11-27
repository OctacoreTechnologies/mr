@extends('layouts.app')

@section('title', 'Edit Sales Order')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 text-primary font-weight-bold">Total Order Payment's</h1>
    <a href="{{ route('sale-order.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>
@stop

@section('content')
<x-alert-components class="mb-3" />

<form action="{{ route('sale-order.update', $saleOrder->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-edit"></i> Edit Order Information</h3>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Quotation --}}
                <div class="col-md-3 mb-3">
                    <x-adminlte-input value="" label="Work Order No" value="{{ $saleOrder->work_order_no }}" name="purchase_order_no" readonly />
                </div>
                <div class="col-md-3 mb-3">
                    <x-adminlte-input value="{{ $saleOrder->quotation->reference_no ?? '' }}" label="Quotation"
                        name="quotation" readonly onclick="showQuotationDetailsModal()" style="cursor:pointer;" />
                    <input type="hidden" value="{{ $saleOrder->quotation_id }}" name="quotation_id" />
                </div>

                {{--<div class="col-md-3 mb-3">
                    <x-adminlte-input value="{{ $saleOrder->quotation->customer->company_name??''}}"
                        label="Company Name" name="company_name" readonly />
                </div>
                <div class="col-md-3 mb-3">
                    <x-adminlte-input value="" label="Customer PO No" name="cstmr_po_no" readonly />
                </div>
                <div class="col-md-3 mb-3">
                    <x-adminlte-textarea label="Address" name="company_name" readonly>
                        {{ $saleOrder->quoation->customer->address??''}}
                    </x-adminlte-textarea>
                </div>
                <div class="col-md-3 mb-3">
                    <x-adminlte-input label="Contact No" name="conact_no"
                        value="{{ $saleOrder->quotation->customer->contact_no??'' }}" readonly />
                </div>
                <div class="col-md-3 mb-3">
                    <x-adminlte-input label="Machine Name" name="machine_name"
                        value="{{ $saleOrder->quotation->machine->name??'' }}" readonly />
                </div>
                <div class="col-md-3 mb-3">
                    <x-adminlte-input label="Model No." name="model_no"
                        value="{{ $saleOrder->quotation->modele->name??'' }}" readonly />
                </div>--}}


                {{-- Order Date --}}
              {{--<div class="col-md-3 mb-3">
                    <label for="order_date">Order Date <span class="text-primary">*</span></label>
                    <input type="date" name="order_date" class="form-control" value="{{ $saleOrder->order_date}}"
                        required>
                </div>--}}

                {{-- Delivery Date --}}
              <div class="col-md-3 mb-3">
                    <label for="delivery_date">Delivery Date</label>
                    <input type="date" name="delivery_date" class="form-control" value="{{$saleOrder->delivery_date}}">
                </div> 

                {{-- Status --}}
                <div class="col-md-3 mb-3">
                    <label for="status">Order Status</label>
                    <select name="status" class="form-control">
                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'canceled'] as $status)
                            <option value="{{ $status }}" {{ $saleOrder->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Status --}}
              {{-- <div class="col-md-3 mb-3">
                    <label for="payment_status">Payment Status</label>
                    <select name="payment_status" class="form-control">
                        @foreach(['Paid', 'Unpaid', 'Half Paid'] as $status)
                            <option value="{{ strtolower($status) }}" {{ $saleOrder->payment_status == strtolower($status) ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>--}}
                {{-- Transporation payment --}}
                <div class="col-md-3 mb-3">
                    <label for="transporation_payment">Transporation Payment</label>
                    <select name="transporation_payment" class="form-control" id="transporationpayment">
                        <option value="0" {{ $saleOrder->transporation_payment == "0"?'selected':'' }}>Mr Will Pay</option>
                        <option value="1" {{ $saleOrder->transporation_payment == "1"?'selected':'' }}>To Pay</option>
                    </select>
                </div>


                <div class="col-md-3 mb-3">
                    <x-adminlte-input type="number" label="Total Basic Price" name="total_amount"
                        value="{{ $saleOrder->total_amount }}" id="total_amount" />
                </div>

                <div class="col-md-3 mb-3" id="transporationChargeDiv">
                    <x-adminlte-input type="number" label="Transporation Charge" name="transporation_charge"
                        value="{{ $saleOrder->transporation_charge ?? '0'}}" id="transporationCharge" />
                </div>

                <div class="col-md-3 mb-3">
                    <x-adminlte-input type="number" label="Tax (Include GST)" name="tax"
                        value="{{ $saleOrder->tax ?? '18' }}" id="tax" />
                </div>

                <div class="col-md-3 mb-3" >
                    <x-adminlte-select label="Discount Type" name="discount_type" value="{{ $saleOrder->discount }}"
                        id="discountType">
                        <option value="none" {{ $saleOrder->discount_type == "none" ? 'selected' : '' }}>None </option>
                        <option value="amount" {{ $saleOrder->discount_type == "amount" ? 'selected' : '' }}>Amount</option>
                        <option value="percentage" {{ $saleOrder->discount_type == "percentage" ? 'selected' : '' }}>
                            Percentage</option>
                    </x-adminlte-select>
                </div>
                <div class="form-group col-md-3 mb-3" id="discountPercentage">
                    <x-adminlte-input type="number" label="Discount(%)" id="discount_percentage" name="discount_percentage" value="{{ $saleOrder->discount_percentage }}"
                        />
                </div>
                <div class="form-group col-md-3 mb-3" id="discountAmount">
                    <x-adminlte-input type="number" label="Discount Amount" id="discount_amount" name="discount_amount" value="{{ $saleOrder->discount_amount }}"
                         />
                </div>


                <!-- <div class="col-md-3 mb-3" id="discountDiv">
                    <x-adminlte-input type="number" label="Discount" name="discount" value="{{ $saleOrder->discount }}"
                        id="discount" />
                </div> -->
                <div class="col-md-3 mb-2" id="insuranceDiv">
                       <x-adminlte-input type="number" label="Insurance" name="insurance" value="{{ $saleOrder->insurance }}"
                        id="insurance" />
                </div>
                <div class="col-md-3 mb-2" id="packingDiv">
                       <x-adminlte-input type="number" label="Packing" name="packging" value="{{ $saleOrder->packging }}"
                        id="packing" />
                </div>

                <div class="col-md-3 mb-3">
                    <x-adminlte-input type="number" id="ledger-grand-total-amount" label="Grand Total"
                        name="grand_total" value="{{ $saleOrder->grand_total }}" readonly />
                    <input type="hidden" name="advanace_payment" value="{{ $saleOrder->advanace_payment ?? '0'  }}" id="total_advanace_amount" />    
                </div>
                {{--<div class="col-md-3 mb-3">
                    <x-adminlte-input type="number" label="Total Advanace Payment" name="advanace_payment"
                        id="total_advanace_amount" value="{{ $saleOrder->advanace_payment ?? '0' }}" />
                </div>--}}
              {{--  <div class="col-md-3 mb-3">
                    <x-adminlte-input type="date" label="Advanace Payment Date" name="advance_payment_date"
                        id="advance_payment_date" value="{{ $saleOrder->advance_payment_date }}" />
                </div>--}}
                <div class="col-md-3 mb-3">
                    <x-adminlte-input type="number" label="Payment Term" name="payment_term"
                        value="{{ $saleOrder->payment_term }}" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-input label="Customer Po No." name="po_no" id="po_no" value="{{$saleOrder->po_no}}"
                        required />
                </div>

                {{-- Notes --}}
                <div class="col-md-6 mb-3">
                    <label for="remarks">Remark</label>
                    <textarea name="remarks" rows="3" class="form-control"
                        placeholder="Add any comments or instructions...">{{ $saleOrder->remarks }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="address">Customer Address</label>
                    <textarea name="address" rows="3" class="form-control"
                        placeholder="Add   address here...">{{ $saleOrder->address ?? $saleOrder->quotation->customer->address_line_1 ?? '' }}</textarea>
                </div>
                <div class="col-md-3 mb-3">
                    <x-adminlte-select class="select2" label="Followed By" name="followed_by">
                        <option>Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('followed_by', $saleOrder->followed_by) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>

            <!-- <hr> -->

            {{-- Ledger Section --}}
          <h5><i class="fas fa-rupee-sign"></i>Advance Payment Ledger</h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="ledger_table">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th>Payment Date</th>
                            <th>Amount (₹)</th>
                            <th>Mode</th>
                            <th>Transaction ID</th>
                            <th>Remarks</th>
                            <th>
                                <button type="button" data-pay="after" class="btn btn-sm btn-success" id="addLedgerRow">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saleOrder->payments as $index => $payment)
                          @if ($payment->type == "before") 
                            <tr>

                                <td>
                                    <input type="hidden" value="before" name="payments[{{ $index }}][type]"/>
                                    <input type="date" name="payments[{{ $index }}][date]" class="form-control"
                                        value="{{ $payment->payment_date }}" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="payments[{{ $index }}][amount]"
                                        class="form-control amount-input" value="{{ $payment->amount }}" required>
                                </td>
                                <td>
                                    <select name="payments[{{ $index }}][mode]" class="form-control payment-mode"
                                        data-row="{{ $index }}" required>
                                        <option value="">Select</option>
                                        <option value="cash" {{ $payment->mode === 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="online" {{ $payment->mode === 'online' ? 'selected' : '' }}>Online
                                        </option>
                                        <option value="other" {{ $payment->mode === 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </td>

                                <td>
                                    <input type="text" name="payments[{{ $index }}][transaction_id]"
                                        class="form-control transaction-id {{ $payment->mode === 'online' ? '' : 'd-none' }}"
                                        value="{{ $payment->transaction_id }}" placeholder="Enter Transaction ID">
                                </td>
                                <td>
                                    <textarea name="payments[{{ $index }}][remarks]"
                                        class="form-control remarks {{ $payment->mode === 'other' ? '' : 'd-none' }}"
                                        placeholder="Enter Remarks">{{ $payment->remarks }}</textarea>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary removeLedgerRow">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                          @endif  
                          @if ($payment->type == "after") 
                            <tr>

                                <td>
                                    <input type="hidden" value="before" name="payments[{{ $index }}][type]"/>
                                    <input type="date" name="payments[{{ $index }}][date]" class="form-control"
                                        value="{{ $payment->payment_date }}" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="payments[{{ $index }}][amount]"
                                        class="form-control amount-input" value="{{ $payment->amount }}" required>
                                </td>
                                <td>
                                    <select name="payments[{{ $index }}][mode]" class="form-control payment-mode"
                                        data-row="{{ $index }}" required>
                                        <option value="">Select</option>
                                        <option value="cash" {{ $payment->mode === 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="online" {{ $payment->mode === 'online' ? 'selected' : '' }}>Online
                                        </option>
                                        <option value="other" {{ $payment->mode === 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </td>

                                <td>
                                    <input type="text" name="payments[{{ $index }}][transaction_id]"
                                        class="form-control transaction-id {{ $payment->mode === 'online' ? '' : 'd-none' }}"
                                        value="{{ $payment->transaction_id }}" placeholder="Enter Transaction ID">
                                </td>
                                <td>
                                    <textarea name="payments[{{ $index }}][remarks]"
                                        class="form-control remarks {{ $payment->mode === 'other' ? '' : 'd-none' }}"
                                        placeholder="Enter Remarks">{{ $payment->remarks }}</textarea>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary removeLedgerRow">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                          @endif  
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right font-weight-bold">Total Amount Due:</td>
                            <td id="ledger-grand-total-amounts" class="text-left font-weight-bold">
                                ₹{{$saleOrder->grand_total}}</td>
                        </tr>
                      {{--  <tr>
                            <td colspan="5" class="text-right font-weight-bold">Paid in Advance:</td>
                            <td id="ledger-advance-total-amount" class="text-left font-weight-bold">₹0.00</td>
                        </tr>--}}
                        <tr>
                            <td colspan="5" class="text-right font-weight-bold">Amount Paid So Far:</td>
                            <td id="ledger-total-amount" class="text-left font-weight-bold">₹0.00</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right font-weight-bold">Balance Amount Remaining:</td>
                            <td id="ledger-pending-total-amount" class="text-left font-weight-bold">₹0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card-footer text-right bg-light">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Order
            </button>
            <a href="{{ route('sale-order.index') }}" class="btn btn-secondary">
                <i class="fas fa-times-circle"></i> Cancel
            </a>
        </div>
    </div>
</form>
<!-- modal  -->
<div class="modal fade" id="quotationDetailsModal" tabindex="-1" role="dialog"
    aria-labelledby="quotationDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="quotationDetailsModalLabel">Customer Account Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-sm">
                    @php
                        $tax=$saleOrder->tax??0;
                        $taxAmount=(($saleOrder->total_amount + $saleOrder->transporation_charge) * $tax) / 100;

                        $grandTotal=$saleOrder->total_amount + $taxAmount;
                        $totalTransporation = 0;
                        $totalFreight = 0;

                        foreach ($saleOrder->payments as $payment) {
                            if ($payment->type == 'transportation') {
                                $totalTransporation += $payment->amount;
                            } else if ($payment->type == 'freight') {
                                $totalFreight += $payment->amount;
                            }
                        }

                    @endphp
                    <tbody>
                        <tr>
                            <th>1. Company Name & Address</th>
                            <td>{{ $saleOrder->quotation->customer->company_name ?? 'N/A' }}<br>{{ $saleOrder->address ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>2. Contact Person</th>
                            <td>{{ $saleOrder->quotation->customer->contact_person_1_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>3. Contact Number</th>
                            <td>{{ $saleOrder->quotation->customer->contact_no ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>4. Machine Name</th>
                            <td>{{ $saleOrder->quotation->machine->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>5. Model No.</th>
                            <td>{{ $saleOrder->quotation->modele->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>6. Customer PO No.</th>
                            <td>{{ $saleOrder->po_no ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>7. PO Date Received by MR</th>
                            <td>{{ formatDate($saleOrder->order_date ?? '') }}</td>
                        </tr>
                        <tr>
                            <th>8. Work Order No.</th>
                            <td>{{ $saleOrder->purchase_order_no ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>9. Delivery Date</th>
                            <td>{{ formatDate($saleOrder->delivery_date ?? '')   }}</td>
                        </tr>
                        <tr>
                            <th>10. Total Basic Price</th>
                            <td>{{ format_indian_number($saleOrder->total_amount ?? 'N/A') }}</td>
                        </tr>
                        <tr>
                            <th>11. Transportation</th>
                            <td>{{ format_indian_number($saleOrder->transporation_charge) }}</td>
                        </tr>
                        <tr>
                            <th>12. Total GST Price</th>
                            <td>{{format_indian_number($taxAmount)}}</td>
                        </tr>
                        <tr>
                            <th>13. Total Final Price</th>
                            <td>{{format_indian_number($grandTotal + $saleOrder->transporation_charge) }}</td>
                        </tr>
                        <tr>
                            <th>14. Total Advance</th>
                            <td>{{format_indian_number($saleOrder->advanace_payment ?? 'N/A') }}</td>
                        </tr>
                        <tr>
                            <th>15. Balance Payment</th>
                            <td>{{format_indian_number($saleOrder->grand_total - $saleOrder->advanace_payment ?? 'N/A') }}</td>
                        </tr>
                        <tr>
                            <th>16. Freight</th>
                            <td>{{format_indian_number($totalFreight)}}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <a href="{{ route('sale-order.account-pdf', $saleOrder->id) }}" class="btn btn-primary btn-sm"
                    target="_blank">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->
@stop

@push('css')
    <style>
        .transaction-id.d-none,
        .remarks.d-none {
            display: none !important;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('js/sale_order.js') }}"></script>
@endpush