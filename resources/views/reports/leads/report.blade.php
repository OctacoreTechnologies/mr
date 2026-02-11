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
@endphp

@extends('layouts.app')

@section('title', 'Lead Report')
@section('content_header')
    <h1>Lead Report</h1>
@stop

@section('content')
<x-alert-components class="my-3" />

<div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Lead Report's</h3>
    </div>

    <div class="card-body">

        <!-- FILTER FORM -->
        <form id="filterForm" method="GET" action="{{ route('lead.report') }}" class="mb-4">
            <div class="row g-4">

                <!-- EXPORT BUTTONS -->
                <div class="col-md-12 mb-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-outline-light btn-sm mx-1" id="exportExcelBtn">
                                <i class="fa fa-file-excel"></i> Export Excel
                            </button>
                            <button type="button" class="btn btn-outline-light btn-sm mx-1" id="exportCsvBtn">
                                <i class="fa fa-file-csv"></i> Export CSV
                            </button>
                            <button type="button" class="btn btn-outline-light btn-sm mx-1" id="exportPdfBtn">
                                <i class="fa fa-file-pdf"></i> Export PDF
                            </button>
                        </div>
                    </div>
                </div>

                @php
                    $leadSources   = request('lead_source', []);
                    $statuses      = request('status', []);
                    $assignedUsers = request('assigned_user', []);
                @endphp

                <!-- LEAD SOURCE -->
                <div class="col-md-3">
                    <label class="font-weight-bold text-muted">Lead Source</label>
                    <select name="lead_source[]" class="form-control select2 rounded-pill" multiple>
                        <option value="web" {{ in_array('web', $leadSources) ? 'selected' : '' }}>Web</option>
                        <option value="referral" {{ in_array('referral', $leadSources) ? 'selected' : '' }}>Referral</option>
                        <option value="cold_call" {{ in_array('cold_call', $leadSources) ? 'selected' : '' }}>Cold Call</option>
                        <option value="social media" {{ in_array('social media', $leadSources) ? 'selected' : '' }}>Social Media</option>
                        <option value="other" {{ in_array('other', $leadSources) ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- STATUS -->
                <div class="col-md-3">
                    <label class="font-weight-bold text-muted">Status</label>
                    <select name="status[]" class="form-control select2 rounded-pill" multiple>
                        <option value="new" {{ in_array('new', $statuses) ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ in_array('contacted', $statuses) ? 'selected' : '' }}>Contacted</option>
                        <option value="qualified" {{ in_array('qualified', $statuses) ? 'selected' : '' }}>Qualified</option>
                        <option value="disqualified" {{ in_array('disqualified', $statuses) ? 'selected' : '' }}>Disqualified</option>
                    </select>
                </div>

                <!-- FOLLOWED BY -->
                <div class="col-md-3">
                    <label class="font-weight-bold text-muted">Followed By</label>
                    <select name="assigned_user[]" class="form-control select2 rounded-pill" multiple>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ in_array($user->id, $assignedUsers) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- DUE DATE -->
                <div class="col-md-3">
                    <label class="font-weight-bold text-muted">Due Date</label>
                    <select name="due_date" id="due_date" class="form-control select2 rounded-pill">
                        <option value="">Any</option>
                        <option value="today" {{ request('due_date') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="this_week" {{ request('due_date') == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_month" {{ request('due_date') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="this_year" {{ request('due_date') == 'this_year' ? 'selected' : '' }}>This Year</option>
                        <option value="custom" {{ request('due_date') == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>

                <!-- CUSTOM DATE RANGE -->
                <div class="col-md-3 custom-date-range"
                    style="display: {{ request('due_date') == 'custom' ? 'block' : 'none' }};">
                    <label>From</label>
                    <input type="date" name="from_date" class="form-control rounded-pill"
                        value="{{ request('from_date') }}">

                    <label class="mt-2">To</label>
                    <input type="date" name="to_date" class="form-control rounded-pill"
                        value="{{ request('to_date') }}">
                </div>

                <!-- APPLY BUTTON -->
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary mt-4 w-100 rounded-pill">
                        Apply Filters
                    </button>
                </div>

            </div>
        </form>

        <!-- LEADS TABLE -->
        <x-adminlte-datatable id="leadTable" :heads="$heads" striped hoverable responsive>
            @php $i = 1; @endphp
            @foreach ($leads as $lead)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $lead->company_name }}</td>
                    <td>{{ $lead->lead_source ?? 'N/A' }}</td>
                    <td>{{ $lead->created_at->format('d-m-Y') }}</td>

                    <td>
                        <span class="badge badge-warning">
                            {{ ucfirst($lead->status) }}
                        </span>
                    </td>

                    <td>
                        {{ optional($users->where('id', $lead->followed_by)->first())->name }}
                    </td>

                    <td>
                        <nobr>
                            <a href="{{ route('lead.edit', $lead->id) }}"
                                class="btn btn-xs btn-outline-primary">
                                <i class="fa fa-pen"></i>
                            </a>

                            <form action="{{ route('lead.destroy', $lead->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>

                            <a href="{{ route('lead.show', $lead->id) }}"
                                class="btn btn-xs btn-outline-success">
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
        // $('#due_date').change(function() {
        //     if ($(this).val() == 'custom') {
        //         $('.custom-date-range').show();
        //     } else {
        //         $('.custom-date-range').hide();
        //     }
        // });
        
        
        if ($('#due_date').length) {
            $('#due_date').on('change', function () {
                if ($(this).val() === 'custom') {
                    $('.custom-date-range').slideDown();
                } else {
                    $('.custom-date-range').slideUp();
                }
            });
        }
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
