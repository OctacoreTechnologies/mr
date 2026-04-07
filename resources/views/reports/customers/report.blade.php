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

    // Helper: safely get request array — request() can return string or array
    $reqLocationType = (array) request('location_type', []);
    $reqStatus       = (array) request('status', []);
    $reqRegion       = (array) request('region', []);
    $reqState        = (array) request('state', []);
    $reqCity         = (array) request('city', []);
    $reqArea         = (array) request('area', []);
    $reqFollowedBy   = (array) request('followed_by', []);


@endphp

@extends('layouts.app')

@section('title', 'Customer Report')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-chart-bar"></i>
        Customer Report
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-2" />

{{-- ── Filter Card ── --}}
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
        <form id="filterForm" method="GET" action="{{ route('customer.report') }}">
            <div class="row">

                {{-- Customer Source --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Customer Source</label>
                        <select name="location_type[]" id="customer_source"
                            class="form-control crm-multi" multiple="multiple">
                            <option value="domestic"
                                {{ in_array('domestic', $reqLocationType) ? 'selected' : '' }}>
                                Domestic
                            </option>
                            <option value="interanation"
                                {{ in_array('interanation', $reqLocationType) ? 'selected' : '' }}>
                                International
                            </option>
                        </select>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status[]" id="status"
                            class="form-control crm-multi" multiple="multiple">
                            <option value="lead"
                                {{ in_array('lead', $reqStatus) ? 'selected' : '' }}>Lead</option>
                            <option value="quoted"
                                {{ in_array('quoted', $reqStatus) ? 'selected' : '' }}>Quoted</option>
                            <option value="existing"
                                {{ in_array('existing', $reqStatus) ? 'selected' : '' }}>Existing</option>
                        </select>
                    </div>
                </div>

                {{-- Region --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Region</label>
                        <select name="region[]" id="region"
                            class="form-control crm-multi" multiple="multiple">
                            @foreach ($regions as $region)
                                <option value="{{ $region }}"
                                    {{ in_array($region, $reqRegion) ? 'selected' : '' }}>
                                    {{ $region }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- State --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>State</label>
                        <select name="state[]" id="state"
                            class="form-control crm-multi" multiple="multiple">
                            @foreach ($states as $state)
                                <option value="{{ $state->name }}"
                                 {{ in_array(strtolower(trim($state->name)), array_map(fn($v) => strtolower(trim($v)), $reqState)) ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- City --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>City</label>
                        <select name="city[]" id="city"
                            class="form-control crm-multi" multiple="multiple">
                            @foreach ($cities as $city)
                                <option value="{{ $city }}"
                                    {{ in_array($city, $reqCity) ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Area --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Area</label>
                        <select name="area[]" id="area"
                            class="form-control crm-multi" multiple="multiple">
                            @foreach ($areas as $area)
                                <option value="{{ $area }}"
                                    {{ in_array($area, $reqArea) ? 'selected' : '' }}>
                                    {{ $area }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Due Date --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Due Date</label>
                        <select name="due_date" id="due_date" class="form-control">
                            <option value="">Any</option>
                            <option value="today"
                                {{ request('due_date') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week"
                                {{ request('due_date') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month"
                                {{ request('due_date') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="this_year"
                                {{ request('due_date') == 'this_year' ? 'selected' : '' }}>This Year</option>
                            <option value="custom"
                                {{ request('due_date') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                        </select>
                    </div>
                </div>

                {{-- Custom Date Range --}}
                <div class="col-md-3 col-sm-6 custom-date-range"
                    style="display: {{ request('due_date') == 'custom' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ request('from_date') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label>To</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ request('to_date') }}">
                    </div>
                </div>

                {{-- Followed By --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Followed By</label>
                        <select name="followed_by[]" id="followed_by"
                            class="form-control crm-multi" multiple="multiple">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, $reqFollowedBy) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Apply & Reset --}}
                <div class="col-md-3 col-sm-6 d-flex align-items-end" style="gap:8px;">
                    <div class="form-group w-100 mb-0">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Apply
                        </button>
                    </div>
                    <div class="form-group mb-0" style="flex-shrink:0;">
                        <a href="{{ route('customer.report') }}"
                            class="btn btn-outline-secondary" title="Reset Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ── Customer Table ── --}}
<div class="crm-index-card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i> Customer Records
        </h3>
        <span class="crm-record-count">{{ $customers->count() }} records</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <x-adminlte-datatable id="customerTable" :heads="$heads" striped hoverable responsive>
                @foreach ($customers as $customer)
                    <tr>
                        <td class="sr-no">{{ $i++ }}</td>

                        <td><strong>{{ $customer->company_name }}</strong></td>

                        <td>
                            @if($customer->location_type)
                                <span class="crm-badge {{ $customer->location_type === 'domestic' ? 'crm-badge-new-business' : 'crm-badge-proposal' }}">
                                    {{ ucfirst($customer->location_type) }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>{{ $customer->country ?? '—' }}</td>
                        <td>{{ $customer->company_name ?? '—' }}</td>

                        <td>
                            <a href="{{ route('followup.customers.show', $customer->id) }}"
                                class="crm-followed-link" title="View Follow-ups">
                                <i class="fas fa-user-circle"></i>
                                {{ $customer->user->name ?? 'N.A' }}
                            </a>
                        </td>

                        <td>
                            <span class="crm-date-cell">
                                <i class="fas fa-calendar"></i>
                                {{ $customer->created_at
                                    ? \Carbon\Carbon::parse($customer->created_at)->format('d M Y')
                                    : '—' }}
                            </span>
                        </td>

                        <td>
                            @php
                                $statusMap = [
                                    'existing' => 'crm-badge-closed-won',
                                    'quoted'   => 'crm-badge-proposal',
                                    'lead'     => 'crm-badge-negotiation',
                                ];
                                $sc = $statusMap[$customer->customer_status] ?? 'crm-badge-qualification';
                            @endphp
                            <span class="crm-badge {{ $sc }}">
                                {{ ucfirst($customer->customer_status) }}
                            </span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('customer.edit', $customer->id) }}"
                                    class="btn btn-default text-primary" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('customer.destroy', $customer->id) }}"
                                    method="POST" class="d-inline-block"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-default text-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('customer.show', $customer->id) }}"
                                    class="btn btn-default text-teal" title="View">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="{{ asset('js/report.js') }}"></script>
    <script>
        $(document).ready(function () {

            // ── Init Select2 + preserve pre-selected values ──
            // Key: read native selected BEFORE select2 init, then re-set AFTER
            $('.crm-multi').each(function () {
                var $el = $(this);

                // Step 1: Read which options are natively selected (set by Blade)
                var selected = [];
                $el.find('option:selected').each(function () {
                    selected.push($(this).val());
                });

                // Step 2: Init Select2 (this resets visual state)
                $el.select2({
                    width: '100%',
                    placeholder: 'Select...',
                    allowClear: true
                });

                // Step 3: Re-apply selected values so pills render correctly
                if (selected.length > 0) {
                    $el.val(selected).trigger('change.select2');
                }
            });

            // ── Due date custom range toggle ──
            $('#due_date').on('change', function () {
                $('.custom-date-range').toggle($(this).val() === 'custom');
            });

        });

        document.getElementById('exportExcelBtn').addEventListener('click', function (e) {
            e.preventDefault();
            ReportExport.exportExcel('customerTable', 'customerreport.xlsx');
        });
        document.getElementById('exportCsvBtn').addEventListener('click', function (e) {
            e.preventDefault();
            ReportExport.exportCSV('customerTable', 'customerreport.csv');
        });
        document.getElementById('exportPdfBtn').addEventListener('click', function (e) {
            e.preventDefault();
            ReportExport.exportPDF('customerTable', 'Customer Reports', 'customer.pdf');
        });
    </script>
@endpush