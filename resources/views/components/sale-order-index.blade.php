@php
    $heads = [
        'SR.No',
        'Work Order No',
        'Customer',
        'Machine',
        'Application',
        'Order Date',
        'Delivery Date',
        'Status',
        'Payment',
    ];

    if ($advancePdf) {
        $heads[] = 'Advance Payment(Pdf)';
    }
    if ($oalPdf) {
        $heads[] = 'OAL(Pdf)';
    }

    $heads[] = ['label' => 'Actions', 'no-export' => true, 'width' => 15];
    $editView = "sale-order.edit";
    $showView="sale-order.show";
    if($edit =='saleOrder'){
     $editView = "sale-order.edit";
     $showView="sale-order.show";
    }
    else if($edit == 'advance'){
       $editView = 'total_order_advance.index.edit';
      // $showView="total_order_advance.show";
    }
    else if($edit=='oal'){
         $editView = 'order-acceptence-letter.edit';
         $showView = "orderaceptance.show";
    }
@endphp


@extends('layouts.app')

@section('title', $title)

@section('content_header')
  
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0 text-primary font-weight-bold">{{ $title }}</h1>
        @if ($createBtn)
        <a href="{{ route('sale-order.create') }}" class="btn btn-primary btn-md">
            <i class="fas fa-plus-circle"></i> New Total Order
        </a>
        @endif
    </div>
@stop

@section('content')

    <x-alert-components class="my-3" />

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="fas fa-file-invoice-dollar"></i> Total Order List</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <x-adminlte-datatable id="sales-order-table" :heads="$heads" striped hoverable  with-buttons>
                    @foreach ($salesOrders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->work_order_no??'N/A' }}</td>
                               <td><button type="button" class="btn btn-outline-primary view-account-btn" data-id="{{ $order->id }}">{{ $order->quotation->customer->company_name ?? 'N/A' }}</button></td>
                            <td>{{ $order->quotation->machine->name??'' }}</td>
                            <td>{{ $order->quotation->application->name??'' }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</td>
                            <td>
                              {{--<a class="btn btn-link text-primary" href="{{ route('sale_order.pdf', $order->id) }}" target="_blank">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>--}}
                                <span class="badge badge-success">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            @if ($advancePdf)
                            <td>
                              <a href="{{ route('sale-order.advance-pdf', $order->id) }}" class="btn btn-outline-primary rounded-pill border border-primary px-4 py-2" target="_blank">
                                  <i class="fas fa-file-pdf"></i>
                              </a>
                            </td>
                           @endif
                           @if ($oalPdf)
                            <td>
                            <a href="{{ route('orderaceptance.pdf',$order->id) }}" class="btn btn-outline-primary rounded-pill border border-primary px-4 py-2" id="downloadPdfBtn" target="_blank">
                                  <i class="fas fa-file-pdf"></i>
                            </a>
                            </td>
                           @endif
                         <td class="text-center">
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle shadow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Actions
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <!-- View -->
            <a class="dropdown-item" href="{{ route($showView, $order->id) }}">
                <i class="fas fa-eye text-teal mr-2"></i> View
            </a>
            <!-- Edit -->
            <a class="dropdown-item" href="{{ route($editView, $order->id) }}">
                <i class="fas fa-edit text-primary mr-2"></i> Edit
            </a>
            
            <!-- Edit -->
           {{-- <a class="dropdown-item" href="{{ route('order-acceptence-letter.edit',$order->id) }}">
                <i class="fas fa-file-alt text-primary mr-2"></i> OAL
            </a>--}}
            <!-- Delete -->
            <form action="{{ route('sale-order.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this  order?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-primary">
                    <i class="fas fa-trash-alt mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
</td>

                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>
    <!-- modal -->
     <!-- Modal -->
<div class="modal fade" id="accountDetailsModal" tabindex="-1" role="dialog" aria-labelledby="accountDetailsModalLabel" aria-hidden="true">
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
            <tbody id="accountDetailsBody">
                <tr>
                    <td colspan="2" class="text-center"><span class="spinner-border"></span> Loading...</td>
                </tr>
            </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <a href="#" class="btn btn-primary btn-sm" id="downloadPdfBtn" target="_blank">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    <!-- end modal -->
@endsection

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush

@push('js')
  <script src="{{ asset('js/sale_order.js') }}"></script>
@endpush

