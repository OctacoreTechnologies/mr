@php
    $heads = [
        'SR NO',
        'Name',
        'Source',
        'Date',
        'Status',
        'Followed By',
        'Actions',
    ];
    $i = 1;

    // Safe request handling (IMPORTANT)
    $reqLeadSource = (array) request('lead_source', []);
    $reqStatus = (array) request('status', []);
    $reqAssignedUser = (array) request('assigned_user', []);
@endphp

@extends('layouts.app')

@section('title', 'Lead Report')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-chart-line"></i>
        Lead Report
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
        <form id="filterForm" method="GET" action="{{ route('lead.report') }}">
            <div class="row">

                {{-- LEAD SOURCE --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Lead Source</label>
                        <select name="lead_source[]" class="form-control crm-multi" multiple>
                            <option value="web" {{ in_array('web', $reqLeadSource) ? 'selected' : '' }}>Web</option>
                            <option value="referral" {{ in_array('referral', $reqLeadSource) ? 'selected' : '' }}>
                                Referral</option>
                            <option value="cold_call" {{ in_array('cold_call', $reqLeadSource) ? 'selected' : '' }}>Cold
                                Call</option>
                            <option value="social media" {{ in_array('social media', $reqLeadSource) ? 'selected' : '' }}>Social Media</option>
                            <option value="other" {{ in_array('other', $reqLeadSource) ? 'selected' : '' }}>Other
                            </option>
                        </select>
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status[]" class="form-control crm-multi" multiple>
                            <option value="new" {{ in_array('new', $reqStatus) ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ in_array('contacted', $reqStatus) ? 'selected' : '' }}>
                                Contacted</option>
                            <option value="qualified" {{ in_array('qualified', $reqStatus) ? 'selected' : '' }}>
                                Qualified</option>
                            <option value="disqualified" {{ in_array('disqualified', $reqStatus) ? 'selected' : '' }}>
                                Disqualified</option>
                        </select>
                    </div>
                </div>

                {{-- FOLLOWED BY --}}
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Followed By</label>
                        <select name="assigned_user[]" class="form-control crm-multi" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, $reqAssignedUser) ? 'selected' : '' }}>
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
                            <option value="this_week" {{ request('due_date') == 'this_week' ? 'selected' : '' }}>This Week
                            </option>
                            <option value="this_month" {{ request('due_date') == 'this_month' ? 'selected' : '' }}>This
                                Month</option>
                            <option value="this_year" {{ request('due_date') == 'this_year' ? 'selected' : '' }}>This Year
                            </option>
                            <option value="custom" {{ request('due_date') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                </div>

                {{-- CUSTOM DATE --}}
                <div class="col-md-3 col-sm-6 custom-date-range"
                    style="display: {{ request('due_date') == 'custom' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label>To</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>
                </div>

                {{-- APPLY / RESET --}}
                <div class="col-md-3 col-sm-6 d-flex align-items-end" style="gap:8px;">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Apply
                    </button>

                    <a href="{{ route('lead.report') }}" class="btn btn-outline-secondary">
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
            <i class="fas fa-user-tie"></i> Lead Records
        </h3>
        <span class="crm-record-count">{{ $leads->count() }} records</span>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <x-adminlte-datatable id="leadTable" :heads="$heads" striped hoverable responsive>

                @foreach ($leads as $lead)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td><strong>{{ $lead->company_name }}</strong></td>
                        <td>{{ $lead->lead_source ?? '—' }}</td>

                        <td>
                            <span class="crm-date-cell">
                                <i class="fas fa-calendar"></i>
                                {{ $lead->created_at ? $lead->created_at->format('d M Y') : '—' }}
                            </span>
                        </td>

                        <td>
                            @php
                                $statusMap = [
                                    'qualified' => 'crm-badge-closed-won',
                                    'contacted' => 'crm-badge-proposal',
                                    'disqualified' => 'crm-badge-negotiation',
                                    'new' => 'crm-badge-qualification',
                                ];
                            @endphp
                            <span class="crm-badge {{ $statusMap[$lead->status] ?? '' }}">
                                {{ ucfirst($lead->status) }}
                            </span>
                        </td>

                        <td>
                            <span class="crm-followed-link">
                                <i class="fas fa-user-circle"></i>
                                {{ optional($users->where('id', $lead->followed_by)->first())->name ?? 'N.A' }}
                            </span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('lead.edit', $lead->id) }}" class="btn btn-default text-primary">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('lead.destroy', $lead->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-default text-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <a href="{{ route('lead.show', $lead->id) }}" class="btn btn-default text-teal">
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
        document.getElementById('exportExcelBtn').addEventListener('click', function (e) {
            e.preventDefault();
            ReportExport.exportExcel('leadTable', 'quotations.xlsx');
        });

        document.getElementById('exportCsvBtn').addEventListener('click', function (e) {
            e.preventDefault();
            ReportExport.exportCSV('leadTable', 'quotations.csv');
        });

        document.getElementById('exportPdfBtn').addEventListener('click', function (e) {
            e.preventDefault();
            ReportExport.exportPDF('leadTable', 'Report', 'report.pdf');
        });


    </script>
@endpush