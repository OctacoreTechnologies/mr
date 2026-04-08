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

    // Safe request handling
    $reqCustomers    = (array) request('customers', []);
    $reqStatus       = (array) request('status', []);
    $reqMachineType  = (array) request('machine_type', []);
    $reqMachine      = (array) request('machine_id', []);
    $reqAssignedUser = (array) request('assigned_user', []);
@endphp

@extends('layouts.app')

@section('title', 'Quotation Report')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice"></i>
        Quotation Report
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-2" />

{{-- FILTER CARD --}}
<div class="crm-index-card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter"></i> Filters
        </h3>

        <div class="crm-export-group">
            <button class="crm-export-btn" id="exportExcelBtn">
                <i class="fas fa-file-excel"></i> Excel
            </button>
            <button class="crm-export-btn" id="exportCsvBtn">
                <i class="fas fa-file-csv"></i> CSV
            </button>
            <button class="crm-export-btn crm-export-btn--danger" id="exportPdfBtn">
                <i class="fas fa-file-pdf"></i> PDF
            </button>
        </div>
    </div>

    <div class="card-body">
        <form id="filterForm" method="GET" action="{{ route('quotation.report') }}">
            <div class="row">

                {{-- REF NO --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Quotation Ref.No</label>
                        <input type="text" name="reference_no" class="form-control"
                            value="{{ request('reference_no') }}">
                    </div>
                </div>

                {{-- CUSTOMER --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Customers</label>
                        <select name="customers[]" class="form-control crm-multi" multiple>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ in_array($customer->id, $reqCustomers) ? 'selected' : '' }}>
                                    {{ $customer->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status[]" class="form-control crm-multi" multiple>
                            <option value="Draft" {{ in_array('Draft', $reqStatus) ? 'selected' : '' }}>Draft</option>
                            <option value="Sent" {{ in_array('Sent', $reqStatus) ? 'selected' : '' }}>Sent</option>
                            <option value="Approved" {{ in_array('Approved', $reqStatus) ? 'selected' : '' }}>Approved</option>
                            <option value="Rejected" {{ in_array('Rejected', $reqStatus) ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>

                {{-- MACHINE TYPE --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Machine Type</label>
                        <select name="machine_type[]" class="form-control crm-multi" multiple>
                            @foreach ($machineTypes as $machineType)
                                <option value="{{ $machineType->id }}"
                                    {{ in_array($machineType->id, $reqMachineType) ? 'selected' : '' }}>
                                    {{ $machineType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- MACHINE --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Machine</label>
                        <select name="machine_id[]" class="form-control crm-multi" multiple>
                            @foreach ($machines as $machine)
                                <option value="{{ $machine->id }}"
                                    {{ in_array($machine->id, $reqMachine) ? 'selected' : '' }}>
                                    {{ $machine->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- FOLLOWED BY --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Followed By</label>
                        <select name="assigned_user[]" class="form-control crm-multi" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, $reqAssignedUser) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- DUE DATE --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Due Date</label>
                        <select name="due_date" id="due_date" class="form-control">
                            <option value="">Any</option>
                            <option value="today" {{ request('due_date') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week" {{ request('due_date') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('due_date') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="this_year" {{ request('due_date') == 'this_year' ? 'selected' : '' }}>This Year</option>
                            <option value="custom" {{ request('due_date') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                </div>

                {{-- CUSTOM DATE --}}
                <div class="col-md-3 col-sm-6 custom-date-range"
                    style="display: {{ request('due_date') == 'custom' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from_date" class="form-control"
                            value="{{ request('from_date') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label>To</label>
                        <input type="date" name="to_date" class="form-control"
                            value="{{ request('to_date') }}">
                    </div>
                </div>

                {{-- APPLY / RESET --}}
                <div class="col-md-3 col-sm-6 d-flex align-items-end" style="gap:8px;">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Apply
                    </button>

                    <a href="{{ route('quotation.report') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="crm-index-card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-alt"></i> Quotation Records
        </h3>
        <span class="crm-record-count">{{ $quotations->count() }} records</span>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <x-adminlte-datatable id="quotationTable" :heads="$heads" striped hoverable responsive>

                @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $quotation->reference_no }}</td>
                        <td>{{ $quotation->customer->company_name }}</td>
                        <td>{{ $quotation->machine->name }}</td>
                        <td>{{ $quotation->application->name ?? '—' }}</td>

                        <td>
                            <span class="crm-date-cell">
                                <i class="fas fa-calendar"></i>
                                {{ $quotation->date ?? '—' }}
                            </span>
                        </td>

                        <td>
                            @php
                                $statusMap = [
                                    'accepted' => 'crm-badge-closed-won',
                                    'rejected' => 'crm-badge-negotiation',
                                    'pending'  => 'crm-badge-proposal',
                                ];
                            @endphp
                            <span class="crm-badge {{ $statusMap[$quotation->status] ?? '' }}">
                                {{ ucfirst($quotation->status) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('quotation.pdf', $quotation->id) }}"
                                class="btn btn-sm btn-outline-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('quotation.edit', $quotation->id) }}"
                                    class="btn btn-default text-primary">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('quotation.destroy', $quotation->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-default text-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <a href="{{ route('quotation.show', $quotation->id) }}"
                                    class="btn btn-default text-teal">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </x-adminlte-datatable>
        </div>
    </div>
</div>

@stop
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <style>
        .card-body .form-group label {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--crm-text-muted);
            margin-bottom: 5px;
            display: block;
        }
        /* Multi-select pills */
        .select2-container--default .select2-selection--multiple {
            min-height: 42px !important;
            border: 1.5px solid var(--crm-border) !important;
            border-radius: var(--crm-radius-sm) !important;
            background: var(--crm-bg) !important;
            padding: 3px 6px !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--crm-primary) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,.14) !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: var(--crm-primary) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 20px !important;
            padding: 2px 8px !important;
            font-size: .74rem !important;
            font-weight: 600;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: rgba(255,255,255,.8) !important;
            margin-right: 4px;
        }
        /* Export buttons */
        .crm-export-group { display:flex; align-items:center; gap:6px; }
        .crm-export-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 13px;
            font-family: var(--crm-font); font-size: .78rem; font-weight: 600;
            border-radius: 6px;
            border: 1.5px solid rgba(255,255,255,.35);
            background: rgba(255,255,255,.15); color: #fff;
            cursor: pointer; transition: all .18s ease;
        }
        .crm-export-btn:hover { background:rgba(255,255,255,.28); transform:translateY(-1px); }
        .crm-export-btn--danger { background:rgba(220,38,38,.22); border-color:rgba(254,202,202,.5); }
        .crm-export-btn--danger:hover { background:rgba(220,38,38,.38); }
        /* Record count */
        .crm-record-count {
            font-family: var(--crm-mono); font-size:.74rem; font-weight:600;
            color:rgba(255,255,255,.8); background:rgba(255,255,255,.15);
            padding:3px 10px; border-radius:20px;
        }
        /* Followed by pill */
        .crm-followed-link {
            display:inline-flex; align-items:center; gap:5px;
            font-size:.82rem; font-weight:500; color:var(--crm-primary);
            text-decoration:none; padding:3px 9px; border-radius:6px;
            background:var(--crm-primary-light); transition:all .18s ease;
            white-space:nowrap;
        }
        .crm-followed-link:hover { background:var(--crm-primary); color:#fff; text-decoration:none; }
        /* Date cell */
        .crm-date-cell { display:inline-flex; align-items:center; gap:5px; font-size:.83rem; }
        .crm-date-cell i { color:var(--crm-primary); font-size:.76rem; }
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
     $(document).ready(function () {
     
         $('.crm-multi').each(function () {
             var $el = $(this);
     
             let selected = [];
             $el.find('option:selected').each(function () {
                 selected.push($(this).val());
             });
     
             $el.select2({
                 width: '100%',
                 placeholder: 'Select...',
                 allowClear: true
             });
     
             if (selected.length > 0) {
                 $el.val(selected).trigger('change.select2');
             }
         });
     
         $('#due_date').on('change', function () {
             $('.custom-date-range').toggle($(this).val() === 'custom');
         });
     
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
