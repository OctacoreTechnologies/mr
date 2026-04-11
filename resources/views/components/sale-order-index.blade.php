@php
    $heads = [
        'SR.No',
        'Quote Ref No',
        'Work Order No',
        'Customer',
        'Machine',
        'Application',
        'Order Date',
        'Delivery Date',
        'Payment Status',
    ];

    if ($advancePdf) {
        $heads[] = 'Advance Payment(Pdf)';
    }
    if ($oalPdf) {
        $heads[] = 'OAL(Pdf)';
    }

    $heads[] = ['label' => 'Actions', 'no-export' => true, 'width' => 15];
    $editView = "sale-order.edit";
    $showView = "sale-order.show";
    if ($edit == 'saleOrder') {
        $editView = "sale-order.edit";
        $showView = "sale-order.show";
    } else if ($edit == 'advance') {
        $editView = 'total_order_advance.index.edit';
    } else if ($edit == 'oal') {
        $editView = 'order-acceptence-letter.edit';
        $showView = "orderaceptance.show";
    }
@endphp

@extends('layouts.app')

@section('title', $title)

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice-dollar text-primary"></i> {{ $title }}
    </h1>

    @if ($createBtn)
        <a href="{{ route('sale-order.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> New Total Order
        </a>
    @endif
</div>
@stop

@section('content')

    <x-alert-components class="my-3" />

    <div class="crm-index-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-invoice"></i> Total Order's
            </h3>
        </div>

        <div class="card-body p-3">
            <div class="table-responsive">
                <x-adminlte-datatable id="sales-order-table" :heads="$heads" striped hoverable with-buttons>

                    @foreach ($salesOrders as $key => $order)
                                <tr>
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle font-weight-bold text">
                                        {{ $order->quotation->reference_no ?? 'N/A' }}
                                    </td>

                                    <td class="align-middle font-weight-bold text-primary">
                                        {{ $order->work_order_no ?? 'N/A' }}
                                    </td>

                                    <td class="align-middle">
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill view-account-btn"
                                            data-id="{{ $order->id }}">
                                            {{ $order->quotation->customer->company_name ?? 'N/A' }}
                                        </button>
                                    </td>

                                    <td class="align-middle">{{ $order->quotation->machine->name ?? '' }}</td>

                                    <td class="align-middle">{{ $order->quotation->application->name ?? '' }}</td>

                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                                    </td>

                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                                    </td>

                                    {{-- <td class="align-middle">
                                        <span class="badge badge-success px-3 py-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td> --}}

                                    <td class="align-middle">
                                        <span class="badge 
                                               @if($order->payment_status == 'received')
                                                   badge-success
                                               @elseif($order->payment_status == 'pending')
                                                   badge-warning
                                               @elseif($order->payment_status == 'cancelled')
                                                   badge-danger
                                               @endif
                                               px-3 py-2">

                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>

                                    @if ($advancePdf)
                                        <td class="align-middle text-center">
                                            @can('advance_payment_pdf')
                                                <a href="{{ route('sale-order.advance-pdf', $order->id) }}"
                                                    class="btn btn-outline-primary btn-sm rounded-pill" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    @endif

                                    @if ($oalPdf)
                                        <td class="align-middle text-center">

                                            @can('oal_pdf')
                                                <a href="{{ route('orderaceptance.pdf', $order->id) }}"
                                                    class="btn btn-outline-primary btn-sm rounded-pill" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    @endif

                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow-sm" type="button"
                                                data-toggle="dropdown">
                                                <i class="fas fa-cogs"></i> Actions
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-right shadow">
                                                @can('sale_order_show')
                                                    <a class="dropdown-item" href="{{ route($showView, $order->id) }}">
                                                        <i class="fas fa-eye text-info mr-2"></i> View
                                                    </a>
                                                @endcan
                                                @can('sale_order_edit')

                                                    <a class="dropdown-item" href="{{ route($editView, $order->id) }}">
                                                        <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                    </a>
                                                @endcan

                                                <div class="dropdown-divider"></div>
                                                @can('sale_order_delete')
                                                    <form action="{{ route('sale-order.destroy', $order->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure to delete this  order?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash-alt mr-2"></i> Delete
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                    @endforeach

                </x-adminlte-datatable>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="accountDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-lg border-0">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user"></i> Customer Account Details
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tbody id="accountDetailsBody">
                            <tr>
                                <td colspan="2" class="text-center">
                                    <div class="spinner-border text-primary"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-primary btn-sm" id="downloadPdfBtn" target="_blank">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
@endpush

@push('js')
    <script src="{{ asset('js/sale_order.js') }}"></script>
@endpush