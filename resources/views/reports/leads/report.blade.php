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
            <!-- Filter Section -->
            <form id="filterForm" method="GET" action="{{ route('lead.report') }}" class="mb-4">
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
                        <label for="customers" class="font-weight-bold text-muted">Lead Source</label>
                        <select name="lead_source[]" id="lead_source" class="form-control select2 rounded-pill" multiple="multiple">
                                <option value="web">Web</option>
                                <option value="referral">Referall</option>
                                <option value="cold_call">Cold Call</option>
                                <option value="social media">Social Media</option>
                                <option value="other">Other</option>
                          
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="font-weight-bold text-muted">Status</label>
                        <select name="status[]" id="status" class="form-control select2 rounded-pill" multiple="multiple">
                            <option value="new" {{ in_array('new', request('status', [])) ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ in_array('contacted', request('status', [])) ? 'selected' : '' }}>Contacted</option>
                            <option value="qualified" {{ in_array('qualified', request('status', [])) ? 'selected' : '' }}>Qualfied</option>
                            <option value="disqualified" {{ in_array('disqualified', request('status', [])) ? 'selected' : '' }}>Disqualified</option>
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

            <!-- lead Table -->
            <x-adminlte-datatable id="leadTable" :heads="$heads" striped hoverable responsive>
                @foreach ($leads as $lead)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$lead->full_name}}</td>
                        <td>{{$lead->lead_source ?? 'N.A'}}</td>
                        <td>{{date($lead->created_at??'N.A')}}</td>
                        <td>
                            <span class="badge badge-{{ $lead->status === 'accepted' ? 'success' : ($lead->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($lead->status) }}
                            </span>
                        </td>
                  
                        <td>
                              @foreach ($users as $user)

                                 {{ ucfirst($lead->followed_by== $user->id?$user->name:'') }}
                              @endforeach
                        </td>
               
  
                        <td>
                            <nobr>
                                <a href="{{route('lead.edit', $lead->id)}}" class="btn btn-xs btn-outline-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{route('lead.destroy', $lead->id)}}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-xs btn-outline-danger mx-1 shadow" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{route('lead.show', $lead->id)}}" class="btn btn-xs btn-outline-success mx-1 shadow" title="Details">
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

            var table = document.getElementById('leadTable');
            var wb = XLSX.utils.table_to_book(table, { sheet: 'leads' });
            XLSX.writeFile(wb, 'leads.xlsx');
        });

        // CSV Export (using PapaParse)
        document.getElementById('exportCsvBtn').addEventListener('click', function () {
            event.preventDefault();

            var table = document.getElementById('leadTable');
            var rows = Array.from(table.rows).map(row => Array.from(row.cells).map(cell => cell.innerText));
            var csv = Papa.unparse(rows);
            var blob = new Blob([csv], { type: 'text/csv' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'leads.csv';
    
            link.click();
        });

        // PDF Export (using jsPDF)
 document.getElementById('exportPdfBtn').addEventListener('click', function (event) {
    event.preventDefault();

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const table = document.getElementById('leadTable');

    // Extract headers
    const headers = Array.from(table.querySelectorAll('thead tr th')).map(th => th.innerText.trim());

    // Extract body rows
    const data = Array.from(table.querySelectorAll('tbody tr')).map(row =>
        Array.from(row.cells).map(cell => cell.innerText.trim())
    );

    // Add title
    doc.text("Lead Report", 14, 15);

    // Add table using autoTable
    doc.autoTable({
        startY: 20,
        head: [headers],
        body: data,
        styles: {
            fontSize: 8,
            cellPadding: 2,
        },
        headStyles: {
            fillColor: [41, 128, 185],
            textColor: 255,
            fontStyle: 'bold',
        },
        alternateRowStyles: {
            fillColor: [245, 245, 245]
        },
        margin: { top: 20 }
    });

    doc.save('leads.pdf');
});

</script>
@endpush
