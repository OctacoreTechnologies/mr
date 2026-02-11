@php
    $heads = [
        'SR NO',
        'Quotation Ref.No',
        'Customer Name',
        'Machine',
        'Application',
        'Date',
        'Status',
        'Pdf',
        'Actions',
    ];
    $i = 1;
@endphp

@extends('layouts.app')

@section('title', 'Quotation Report')
@section('content_header')
    <h1>Quotation Report</h1>
@stop

@section('content')
    <x-alert-components class="my-3" />

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Quotation Report</h3>
        </div>

        <div class="card-body">
            <!-- Filter Section -->
            <form id="filterForm" method="GET" action="{{ route('quotation.report') }}" class="mb-4">
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
                        <label for="reference_no" class="font-weight-bold text-muted">Quotation Ref.No</label>
                        <input type="text" name="reference_no" id="reference_no" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label for="customers" class="font-weight-bold text-muted">Customers</label>
                        <select name="customers[]" id="customers" class="form-control select2 rounded-pill" multiple="multiple">
                            @foreach ($customers as $customer)
                                <option value="{{$customer->id }}">{{ $customer->company_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="font-weight-bold text-muted">Status</label>
                        <select name="status[]" id="status" class="form-control select2 rounded-pill" multiple="multiple">
                            <option value="draft" {{ in_array('draft', request('status', [])) ? 'selected' : '' }}>Draft</option>
                            <option value="sent" {{ in_array('sent', request('status', [])) ? 'selected' : '' }}>Sent</option>
                            <option value="accepted" {{ in_array('accepted', request('status', [])) ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ in_array('rejected', request('status', [])) ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="machine_type" class="font-weight-bold text-muted">Machine Type</label>
                        <select name="machine_type[]" id="machine_type" class="form-control select2 rounded-pill" multiple="multiple">
                          @foreach ($machineTypes as $machineType)
                             <option value="{{ $machineType->id }}" {{ in_array($machineType->id, request('machineType', [])) ? 'selected' : '' }}>{{ $machineType->name }}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="machine_id" class="font-weight-bold text-muted">Machine</label>
                        <select name="machine_id[]" id="machine_id" class="form-control select2 rounded-pill" multiple="multiple">
                            @foreach ($machines as $machine)
                                <option value="{{ $machine->id }}" {{ in_array($machine->id, request('machine_id', [])) ? 'selected' : '' }}>
                                    {{ $machine->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="assingedUser" class="font-weight-bold text-muted">Followed By</label>
                        <select name="assigned_user[]" id="assingedUser" class="form-control select2 rounded-pill" multiple="multiple">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, request('assigned_user', [])) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
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
                        <button type="submit" class="btn btn-primary btn-md mt-4 w-100 rounded-pill" style="height: 40px;">Apply Filters</button>
                    </div>
                </div>
            </form>

            <!-- Quotation Table -->
            <x-adminlte-datatable id="quotationTable" :heads="$heads" striped hoverable responsive>
                @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$quotation->reference_no}}</td>
                        <td>{{$quotation->customer->company_name}}</td>
                        <td>{{$quotation->machine->name}}</td>
                        <td>{{$quotation->application->name ?? 'N.A'}}</td>
                         <td>{{$quotation->date}}</td>
                        <td>
                            <span class="badge badge-{{ $quotation->status === 'accepted' ? 'success' : ($quotation->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($quotation->status) }}
                            </span>
                        </td>
                        <td>
                            <a class="btn btn-link text-info" href="{{ route('quotation.pdf', $quotation->id) }}" target="_blank">
                                <i class="fa fa-file-pdf"></i> PDF
                            </a>
                        </td>
                        <td>
                            <nobr>
                                <a href="{{route('quotation.edit', $quotation->id)}}" class="btn btn-xs btn-outline-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{route('quotation.destroy', $quotation->id)}}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-xs btn-outline-danger mx-1 shadow" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{route('quotation.show', $quotation->id)}}" class="btn btn-xs btn-outline-success mx-1 shadow" title="Details">
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
    <script src="{{ asset('js/report.js') }}"></script>

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

    document.getElementById('exportExcelBtn').addEventListener('click', function (e) {
    e.preventDefault();
    ReportExport.exportExcel('quotationTable', 'quotations.xlsx');
});

document.getElementById('exportCsvBtn').addEventListener('click', function (e) {
    e.preventDefault();
    ReportExport.exportCSV('quotationTable', 'quotations.csv');
});

document.getElementById('exportPdfBtn').addEventListener('click', function (e) {
    e.preventDefault();
    ReportExport.exportPDF('quotationTable', 'Quotation Report', 'quotations.pdf');
});

</script>
@endpush
