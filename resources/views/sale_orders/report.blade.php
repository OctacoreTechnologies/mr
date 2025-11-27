@php
$heads = [
    'SR NO',
    'Work Order No',
    'Quotation(Ref.No)',
    'Customer Name',
    'Order Date',
    'Machine',
    'Application',
    'Status',
    'Payment Status',
    'Followed By',
    'Pdf',
    'Actions',
];
@endphp

@extends('layouts.app')

@section('title', 'SaleOrder Report')

@section('content_header')
    <h1>SaleOrder Report</h1>
@stop

@section('content')
    <x-alert-components class="my-3" />

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">SaleOrder Report</h3>
        </div>

        <div class="card-body">
            <!-- Filter Section -->
            <form id="filterForm" method="GET" action="{{ route('saleOrder.report') }}" class="mb-4">
                <div class="row g-4">

                    <!-- Export Buttons -->
                    <div class="col-md-12 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-outline-light btn-sm mx-2" id="exportExcelBtn">
                                    <i class="fa fa-file-excel"></i> Export Excel
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm mx-2" id="exportCsvBtn">
                                    <i class="fa fa-file-csv"></i> Export CSV
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm mx-2" id="exportPdfBtn">
                                    <i class="fa fa-file-pdf"></i> Export PDF
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="reference_no">SaleOrder Ref.No</label>
                        <input type="text" name="reference_no" id="reference_no" class="form-control"
                               value="{{ request('reference_no') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="customers">Customers</label>
                        <select name="customers[]" id="customers" class="form-control select2 rounded-pill" multiple>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ in_array($customer->id, request('customers', [])) ? 'selected' : '' }}>
                                    {{ $customer->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="status">Status</label>
                        <select name="status[]" id="status" class="form-control select2 rounded-pill" multiple>
                            @foreach (['pending', 'processing', 'shipped', 'delivered', 'canceled'] as $status)
                                <option value="{{ $status }}"
                                    {{ in_array($status, request('status', [])) ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="due_date" class="font-weight-bold text-muted">Due Date</label>
                        <select name="due_date" id="due_date" class="form-control select2 rounded-pill" multiple>
                            <option value="">Any</option>
                            <option value="today" {{ request('due_date') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week" {{ request('due_date') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('due_date') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="this_year" {{ request('due_date') == 'this_year' ? 'selected' : '' }}>This Year</option>
                            <option value="custom" {{ request('due_date') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="followedBy">Followed By</label>
                        <select name="followed_by[]" id="followedBy" class="form-control select2 rounded-pill" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, request('followed_by', [])) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 custom-date-range" style="display: {{ request('due_date') == 'custom' ? 'block' : 'none' }};">
                        <label for="from_date" class="font-weight-semibold">From</label>
                        <input type="date" name="from_date" id="from_date" class="form-control rounded-pill" value="{{ request('from_date') }}">

                        <label for="to_date" class="font-weight-semibold">To</label>
                        <input type="date" name="to_date" id="to_date" class="form-control rounded-pill" value="{{ request('to_date') }}">
                    </div>



                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-md mt-4 w-100 rounded-pill">Apply Filters</button>
                    </div>
                </div>
            </form>
            <!-- Table -->
            <x-adminlte-datatable id="saleOrderTable" :heads="$heads" striped hoverable responsive>
                @foreach ($saleOrders as $saleOrder)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $saleOrder->work_order_no }}</td>
                        <td>{{ $saleOrder->quotation->reference_no ?? 'N.A' }}</td>
                        <td>{{ $saleOrder->quotation->customer->company_name ?? 'N.A' }}</td>
                        <td>{{ $saleOrder->order_date }}</td>
                        <td>{{ $saleOrder->quotation->machine->name ?? 'N.A' }}</td>
                        <td>{{ $saleOrder->quotation->application->name ?? 'N.A' }}</td>
                        <td>
                            <span class="badge badge-{{ $saleOrder->status === 'shipped' ? 'success' : ($saleOrder->status === 'delivered' ? 'danger' : 'warning') }}">
                                {{ ucfirst($saleOrder->status) }}
                            </span>
                        </td>
                        <td>{{ $saleOrder->payment_status ?? '' }}</td>
                        <td>{{ $saleOrder->followedBy->name ?? '' }}</td>
                        <td>
                            <a class="btn btn-link text-info" href="{{ route('quotation.pdf', $saleOrder->quotation->id) }}" target="_blank">
                                <i class="fa fa-file-pdf"></i> PDF
                            </a>
                        </td>
                        <td>
                            <nobr>
                                <a href="{{ route('sale-order.edit', $saleOrder->id) }}" class="btn btn-xs btn-outline-primary mx-1"><i class="fa fa-pen"></i></a>
                                <form action="{{ route('sale-order.destroy', $saleOrder->id) }}" method="POST" class="d-inline-block">
                                    @csrf @method("DELETE")
                                    <button class="btn btn-xs btn-outline-danger mx-1"><i class="fa fa-trash"></i></button>
                                </form>
                                <a href="{{ route('sale-order.show', $saleOrder->id) }}" class="btn btn-xs btn-outline-success mx-1"><i class="fa fa-eye"></i></a>
                            </nobr>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop


@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

        <!-- PapaParse for CSV export -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

        <!-- jsPDF for PDF export -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script>
            $(document).ready(function () {
                $('#status, #customers, #payment_status, #followedBy, #due_date').select2();

                $('#due_date').change(function () {
                    $('.custom-date-range').toggle($(this).val() == 'custom');
                });

                $('#exportExcelBtn').click(function () {
                    event.preventDefault();
                    const table = document.getElementById('saleOrderTable');
                    const wb = XLSX.utils.table_to_book(table, { sheet: 'Sale Orders' });
                    XLSX.writeFile(wb, 'saleOrders.xlsx');
                });

                $('#exportCsvBtn').click(function () {
                    event.preventDefault();
                    const table = document.getElementById('saleOrderTable');
                    const rows = Array.from(table.rows).map(row =>
                        Array.from(row.cells).map(cell => cell.innerText));
                    const csv = Papa.unparse(rows);
                    const blob = new Blob([csv], { type: 'text/csv' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'saleOrders.csv';
                    link.click();
                });

                $('#exportPdfBtn').click(function () {
                    event.preventDefault();
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF();

                    const table = document.getElementById('saleOrderTable');

                    if (!table) {
                        alert("Table not found!");
                        return;
                    }

                    // Extract table headers
                    const headers = Array.from(table.querySelectorAll("thead tr th")).map(th => th.innerText.trim());

                    // Extract table body rows
                    const bodyRows = Array.from(table.querySelectorAll("tbody tr")).map(row =>
                        Array.from(row.cells).map(cell => cell.innerText.trim())
                    );

                    // Add Title
                    doc.setFontSize(14);
                    doc.text("Sale Order Report", 14, 15);

                    // AutoTable configuration
                    doc.autoTable({
                        startY: 20,
                        head: [headers],
                        body: bodyRows,
                        styles: {
                            fontSize: 9,
                            cellPadding: 3,
                            overflow: 'linebreak',
                        },
                        headStyles: {
                            fillColor: [0, 123, 255],
                            textColor: 255,
                            fontStyle: 'bold',
                        },
                        alternateRowStyles: {
                            fillColor: [245, 245, 245],
                        },
                        theme: 'striped',
                        margin: { top: 20 },
                    });

                    doc.save('saleOrders.pdf');
                });

            });
    </script>
@endpush
