@php
    $heads = [
        'SR NO',
        'Name',
        'Location',
        'Country',
        'Company Name',
        'Followed By',
        'Date',
        'Status',
        'Actions',
    ];
    $i = 1;
@endphp

@extends('layouts.app')

@section('title', 'customer Report')
@section('content_header')
    <h1>customer Report</h1>
@stop

@section('content')
    <x-alert-components class="my-3" />

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">customer Report's</h3>
        </div>

        <div class="card-body">
            <!-- Filter Section -->
            <form id="filterForm" method="GET" action="{{ route('customer.report') }}" class="mb-4">
                <div class="row g-4">
                    <!-- Export Buttons -->
                    <div class="col-md-12 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button class="btn btn-outline-light btn-sm mx-2" id="exportExcelBtn">
                                    <i class="fa fa-file-excel"></i> Export Excel
                                </button>
                                <button class="btn btn-outline-light btn-sm mx-2" id="exportCsvBtn">
                                    <i class="fa fa-file-csv"></i> Export CSV
                                </button>
                                <button class="btn btn-outline-light btn-sm mx-2" id="exportPdfBtn">
                                    <i class="fa fa-file-pdf"></i> Export PDF
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Section (Grouped) -->
                    <div class="col-md-3">
                        <label for="customers" class="font-weight-bold text-muted">Customer Source</label>
                        <select name="location_type[]" id="customer_source" class="form-control select2 rounded-pill" multiple="multiple">
                                <option value="domestic">Domestic</option>
                                <option value="interanation">International</option>                          
                        </select>
                    </div>

                     <div class="col-md-3">
                       <label for="status" class="font-weight-bold text-muted">Status</label>
                        <select name="status[]" id="status" class="form-control select2 rounded-pill" multiple="multiple">
                            <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="quoated" {{ old('status') == 'quoated' ? 'selected' : '' }}>Quoated</option>
                            <option value="lead" {{ old('status') == 'lead' ? 'selected' : '' }}>Lead</option>
                            <option value="invoice" {{ old('status') == 'invoice' ? 'selected' : '' }}>Invoice</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="region" class="font-weight-bold text-muted">Region</label>
                        <select name="region[]" id="region" class="form-control select2 rounded-pill" multiple="multiple">
                            @foreach ($regions as $region )
                             <option value="{{ $region}}" {{ in_array( $region, request( 'region', [])) ? 'selected' : '' }}>{{ $region}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="state" class="font-weight-bold text-muted">State</label>
                        <select name="state[]" id="state" class="form-control select2 rounded-pill" multiple="multiple">
                            @foreach ($states as $state )
                             <option value="{{ $state->id }}" {{ in_array( $state->id, request( 'state', [])) ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="city" class="font-weight-bold text-muted">City</label>
                          <select name="city[]" id="city" class="form-control select2 rounded-pill" multiple="multiple">
                            @foreach ($cities as $city )
                             <option value="{{ $city}}" {{ in_array( $city, request( 'city', [])) ? 'selected' : '' }}>{{ $city}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="area" class="font-weight-bold text-muted">Select Area</label>
                          <select name="area[]" id="area" class="form-control select2 rounded-pill" multiple="multiple">
                            @foreach ($areas as $area )
                             <option value="{{ $area}}" {{ in_array( $area, request( 'area', [])) ? 'selected' : '' }}>{{ $area}}</option>
                            @endforeach
                        </select>
                    </div>

        

                    <div class="col-md-3">
                        <label for="due_date" class="font-weight-bold text-muted">Due Date</label>
                        <select name="due_date" id="due_date" class="form-control select2 rounded-pill">
                            <option value="">Any</option>
                            <option value="today" {{ request('due_date') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week" {{ request('due_date') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('due_date') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="this_year" {{ request('due_date') == 'this_year' ? 'selected' : '' }}>This Year</option>
                            <option value="custom" {{ request('due_date') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 custom-date-range" style="display: {{ request('due_date') == 'custom' ? 'block' : 'none' }};">
                        <label for="from_date" class="font-weight-semibold">From</label>
                        <input type="date" name="from_date" id="from_date" class="form-control rounded-pill" value="{{ request('from_date') }}">

                        <label for="to_date" class="font-weight-semibold">To</label>
                        <input type="date" name="to_date" id="to_date" class="form-control rounded-pill" value="{{ request('to_date') }}">
                    </div>

                      <div class="col-md-3">
                        <label for="followed_by" class="font-weight-bold text-muted">Followed  By</label>
                        <select name="followed_by[]" id="followed_by" class="form-control select2 rounded-pill" multiple="multiple">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, request('followed_by', [])) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-md mt-4 w-100 rounded-pill" style="height: 40px;">Apply Filters</button>
                    </div>
                </div>
            </form>

            <!-- customer Table -->
            <x-adminlte-datatable id="customerTable" :heads="$heads" striped hoverable responsive>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$customer->company_name}}</td>
                        <td>{{$customer->location_type ?? 'N.A'}}</td>
                        <td>{{$customer->country ?? 'N.A'}}</td>
                        <td>{{ $customer->company_name??'N.A' }}</td>
                        <td> <a href="{{ route('followup.customers.show', $customer->id) }}" class="btn btn-sm btn-outline-primary mx-1 shadow" title="Edit">
                                     {{ $customer->user->name ??'N.A'}}
                              </a></td>
                        <td>{{date($customer->created_at??'N.A')}}</td>
                        <td>
                            <span class="badge badge-{{ $customer->status === 'accepted' ? 'success' : ($customer->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($customer->status) }}
                            </span>
                        </td>
                        <td>
                            <nobr>
                                <a href="{{route('customer.edit', $customer->id)}}" class="btn btn-xs btn-outline-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{route('customer.destroy', $customer->id)}}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-xs btn-outline-danger mx-1 shadow" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{route('customer.show', $customer->id)}}" class="btn btn-xs btn-outline-success mx-1 shadow" title="Details">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </nobr>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    /* Custom Styles */
    .custom-date-range input {
        width: 100%;
        margin-bottom: 5px;
    }
</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

    <!-- PapaParse for CSV export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

    <!-- jsPDF for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for multi-select dropdowns
        $('#status, #machine_type, #machine_id, #assigned_user').select2();

        // Show date range inputs when 'Custom' is selected from the Due Date filter
        $('#due_date').change(function() {
            if ($(this).val() == 'custom') {
                $('.custom-date-range').show();
            } else {
                $('.custom-date-range').hide();
            }
        });
    });

    // export files code  
     document.getElementById('exportExcelBtn').addEventListener('click', function () {
             event.preventDefault();

            var table = document.getElementById('customerTable');
            var wb = XLSX.utils.table_to_book(table, { sheet: 'customers' });
            XLSX.writeFile(wb, 'customers.xlsx');
        });

        // CSV Export (using PapaParse)
        document.getElementById('exportCsvBtn').addEventListener('click', function () {
            event.preventDefault();

            var table = document.getElementById('customerTable');
            var rows = Array.from(table.rows).map(row => Array.from(row.cells).map(cell => cell.innerText));
            var csv = Papa.unparse(rows);
            var blob = new Blob([csv], { type: 'text/csv' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'customers.csv';
    
            link.click();
        });

        // PDF Export (using jsPDF)
    document.getElementById('exportPdfBtn').addEventListener('click', function (event) {
    event.preventDefault();

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const table = document.getElementById('customerTable');

    // Get headers
    const headers = Array.from(table.rows[0].cells).map(cell => cell.innerText);

    // Get data rows
    const data = Array.from(table.rows)
        .slice(1)
        .map(row => Array.from(row.cells).map(cell => cell.innerText.trim()));

    doc.text("Customer Report", 14, 10);
    
    doc.autoTable({
        startY: 20,
        head: [headers],
        body: data,
        styles: {
            fontSize: 8
        },
        headStyles: {
            fillColor: [52, 58, 64], // Dark header
            textColor: 255
        }
    });

    doc.save('customers.pdf');
});

</script>
@endpush
