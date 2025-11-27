@extends('layouts.app')

@section('title', 'OAL')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 text-primary font-weight-bold">OAL(Order Acceptance Letter)</h1>
    <a href="{{ route('sale-order.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>
@stop
@php
  function printValue($value){
       if($value == '0'){
         return 'Yes';
       }
       else if($value == '1'){
        return 'No';
       }
       else{
         return $value;
       }
    }
    @endphp


@section(section: 'content')

<x-alert-components class="mb-3" />

{{-- Main Details Card --}}
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-info-circle"></i> Order Information</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3" onclick="showQuotationDetailsModal()" >
                <strong>Quotation:</strong><br>
                {{ $saleOrder->quotation->reference_no ?? 'N/A' }}
            </div>
            <div class="col-md-3 mb-3" onclick="showQuotationDetailsModal()" >
                <strong>Work Order No.:</strong><br>
                {{ $saleOrder->work_order_no ?? 'N/A' }}
            </div>
            <div class="col-md-3 mb-3" onclick="showQuotationDetailsModal()" >
                <strong> Machine:</strong><br>
                {{ $saleOrder->quotation->machine->name ?? 'N/A' }}
            </div>

            @foreach($oal->getAttributes() as $field => $value)
            @if(!is_null($value) && $value !== '' && $field!='created_at' && $field != 'updated_at' && $field != 'sale_order_id' && $field != 'id' && $field != 'machine_id')
                <div class="col-md-3 mb-3">
                    <strong>{{ ucwords(str_replace('_', ' ', $field)) }}:</strong><br>
                    {{ printValue($value) }}
                </div>
            @endif
           @endforeach
        </div>
    </div>
</div>

{{-- Payment Ledger
@if($saleOrder->saleLedgers && $saleOrder->saleLedgers->count())
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-dark text-white">
        <h3 class="card-title"><i class="fas fa-rupee-sign"></i> Payment Ledger</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Payment Date</th>
                        <th>Amount (₹)</th>
                        <th>Mode</th>
                        <th>Transaction ID</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saleOrder->saleLedgers as $index => $ledger)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ ucfirst($ledger->type) }}</td>
                        <td>{{ \Carbon\Carbon::parse($ledger->payment_date)->format('d M Y') }}</td>
                        <td>₹{{ number_format($ledger->amount, 2) }}</td>
                        <td>{{ ucfirst($ledger->mode) }}</td>
                        <td>{{ $ledger->transaction_id ?? 'N/A' }}</td>
                        <td>{{ $ledger->remarks ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
             <p><strong>Total Ledger Payments:</strong> ₹{{ number_format($totalLedgerAmount, 2) }}</p>
             <p><strong>Advance Payment:</strong> ₹{{ number_format($advancePayment, 2) }}</p>
             <p><strong>Grand Total:</strong> ₹{{ number_format($grandTotal, 2) }}</p>
             <p><strong class="text-primary">Pending Amount:</strong> ₹{{ number_format($pendingAmount, 2) }}</p>
         </div>
    </div>
</div>
@endif--}}


    <!-- modal  -->
<div class="modal fade" id="quotationDetailsModal" tabindex="-1" role="dialog" aria-labelledby="quotationDetailsModalLabel" aria-hidden="true">
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
    $tax=$saleOrder->tax??"0";
    $taxAmount=($saleOrder->total_amount*$tax)/100;
    $grandTotal=$saleOrder->total_amount + $taxAmount;
    $totalTransporation=0;
    $totalFreight=0;

    foreach($saleOrder->payments as $payment){
      if($payment->type=='transportation'){
        $totalTransporation+=$payment->amount;
      }
      else if($payment->type=='freight'){
       $totalFreight+=$payment->amount;
      }
    }
        
    @endphp
            <tbody>
            <tr><th>1. Company Name & Address</th><td>{{ $saleOrder->quotation->customer->company_name ?? 'N/A' }}<br>{{ $saleOrder->quotation->customer->address ?? 'N/A' }}</td></tr>
            <tr><th>2. Contact Person</th><td>{{ $saleOrder->quotation->customer->contact_person_1_name ?? 'N/A' }}</td></tr>
            <tr><th>3. Contact Number</th><td>{{ $saleOrder->quotation->customer->contact_no ?? 'N/A' }}</td></tr>
            <tr><th>4. Machine Name</th><td>{{ $saleOrder->quotation->machine->name ?? 'N/A' }}</td></tr>
            <tr><th>5. Model No.</th><td>{{ $saleOrder->quotation->modele->name ?? 'N/A' }}</td></tr>
            <tr><th>6. Customer PO No.</th><td>{{ $saleOrder->po_no ?? 'N/A' }}</td></tr>
            <tr><th>7. PO Date Received by MR</th><td>{{ formatDate($saleOrder->order_date??'') }}</td></tr>
            <tr><th>8. Sales Order No.</th><td>{{ $saleOrder->purchase_order_no ?? 'N/A' }}</td></tr>
            <tr><th>9. Delivery Date</th><td>{{ formatDate($saleOrder->delivery_date??'')   }}</td></tr>
            <tr><th>10. Total Basic Price</th><td>{{ format_indian_number($saleOrder->total_amount ?? 'N/A') }}</td></tr>
            <tr><th>11. Total GST Price</th><td>{{format_indian_number($taxAmount)}}</td></tr>
            <tr><th>12. Total Final Price</th><td>{{format_indian_number($grandTotal) }}</td></tr>
            <tr><th>13. Total Advance</th><td>{{format_indian_number($saleOrder->advanace_payment ?? 'N/A') }}</td></tr>
            <tr><th>14. Balance Payment</th><td>{{format_indian_number($grandTotal - $saleOrder->total_advanace_amount ?? 'N/A') }}</td></tr>
            <tr><th>15. Transportation</th><td>{{ format_indian_number($totalTransporation) }}</td></tr>
            <tr><th>16. Freight</th><td>{{format_indian_number($totalFreight)}}</td></tr>
            </tbody>
        </table>

      </div>
      <div class="modal-footer">
        <a href="{{ route('sale-order.account-pdf', $saleOrder->id) }}" class="btn btn-primary btn-sm" target="_blank">
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
    .badge {
        font-size: 0.85rem;
        padding: 5px 10px;
    }
</style>
@endpush
@push('js')
<script src="{{ asset('js/sale_order.js') }}"></script>
@endpush
