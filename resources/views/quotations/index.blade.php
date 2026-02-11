@php
    $heads = [
        'ID',
        'Quotation Ref.No',
        'Customer Name',
        'Machine',
        'Product',
        'Status',
        'Verify',
        'PDF',
        'Follow Up',
        ['label' => 'Actions', 'no-export' => false, 'width' => 10],
    ];
    $i = 0;
@endphp

@extends('layouts.app')

@section('title', 'Quotations')

@section('content_header')
<a href="{{ route('quotation.previewForm') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus-circle"></i> Create Quotation
</a>
@stop

@section('content')
<x-alert-components class="my-3" />

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-file-invoice"></i> Quotation Lists</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
                @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $quotation->reference_no }}</td>
                        <td>{{ $quotation->customer->company_name }}</td>
                        <td>{{ $quotation->machine->name }}</td>
                        <td>{{ $quotation->application->name ?? 'N.A' }}</td>
                        <td>
                            @php
                                $statusClass = [
                                               'Draft'         => 'secondary', // initial stage
                                               'Sent'          => 'info',      // in progress
                                               'Approved'      => 'primary',   // approved but not confirmed
                                               'Order Confirm' => 'success',   // final positive stage
                                               'Rejected'      => 'danger',    // failed state
                                                //    'Accepted'      => '',
                                               ];


                                $badgeClass = $statusClass[$quotation->status] ?? 'secondary'; // fallback if status is unknown
                            @endphp

                            <span class="badge badge-{{ $badgeClass }}">
                                {{ ucfirst($quotation->status) }}
                            </span>
                        </td>
                        <td>
                            {{--is_null($quotation->is_verified) ? 'Pending' : ($quotation->is_verified ? 'Yes' : 'No') --}}
                            @php
                            $verifiedStatusClass = [
                                    'Reject' => 'danger',
                                    'Yes' => 'success',
                                    'Editable' => 'warning',
                                ];
                            $verifiedStatus = "Pending";
                            if(is_null($quotation->is_verified)){
                              $verifiedStatus = "Pending";
                            }
                            elseif($quotation->is_verified== "0"){
                              $verifiedStatus = "Reject";
                            }
                            elseif($quotation->is_verified == "1"){
                              $verifiedStatus = "Yes";
                            }
                            elseif($quotation->is_verified == "2"){
                              $verifiedStatus = "Editable";
                            }
                            $verifiedBadgeClass = $verifiedStatusClass[$verifiedStatus] ?? 'secondary';
                            @endphp

                            <span class="badge badge-{{ $verifiedBadgeClass }}">
                                {{ ucfirst($verifiedStatus) }}
                            </span>
                        </td>
                        <td>
                            <a class="btn btn-link text-danger" href="{{ route('quotation.pdf', $quotation->id) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-link text-info" href="{{ route('followup.edit', $quotation->customer_id) }}">
                                <i class="fas fa-calendar-check"></i> Follow Up
                            </a>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow" type="button"
                                    id="actionsDropdown{{ $quotation->id }}" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-cogs"></i> Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="actionsDropdown{{ $quotation->id }}">
                                    <a class="dropdown-item" href="{{ route('quotation.edit', $quotation->id) }}">
                                        <i class="fas fa-edit text-primary"></i> Edit
                                    </a>
                                    {{-- <a class="dropdown-item" href="{{ route('quotation.show', $quotation->id) }}">
                                        <i class="fas fa-eye text-teal"></i> View Details
                                    </a>--}}
                                    <form action="{{ route('quotation.destroy', $quotation->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                    <button class="dropdown-item text-success" data-toggle="modal" data-target="#modalMin"
                                        data-id="{{ $quotation->id }}"
                                        data-reference_no="{{ $quotation->reference_no ?? '' }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-verified="{{ $quotation->is_verified ?? '' }}">
                                        <i class="fas fa-check-circle"></i> Verify
                                    </button>
                                    <button class="dropdown-item text-info" data-toggle="modal"
                                        data-target="#updateQuotationStatus" data-quotationId="{{ $quotation->id }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-reference_no="{{ $quotation->reference_no }}"
                                        data-status="{{ $quotation->status ?? 'N/A' }}">

                                        <i class="fas fa-sync-alt"></i> Update Status
                                    </button>
                                    <button class="dropdown-item text-info" data-toggle="modal"
                                        data-target="#sendEmailModal" data-id="{{ $quotation->id }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-customer_email="{{ $quotation->customer->contact_person_1_email ?? 'N/A' }}"
                                        data-isverify="{{ $quotation->is_verified ? "1" : "0" }}"
                                        data-customer_id="{{ $quotation->customer_id }}"
                                        data-application_id="{{ $quotation->application_id }}">

                                        <i class="fas fa-envelope"></i> Send Email
                                    </button>
                                    <a class="dropdown-item text-success"
                                        href="{{ route('quotation.reorder', $quotation->id) }}">
                                        <i class="fas fa-redo"></i> Reorder Quotation
                                    </a>
                                    <button class="dropdown-item text-secondary" data-toggle="modal"
                                        data-target="#historyModal" data-id="{{ $quotation->id }}">
                                        <i class="fas fa-history"></i> History
                                    </button>

                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
</div>

<!-- Verify Modal -->
<x-adminlte-modal id="modalMin" title="Verify Quotation" theme="teal" icon="fas fa-check-circle">
    <form method="POST" action="{{ route('admin.quotation.verify') }}">
        @csrf
        <div class="row">
            <x-adminlte-input type="hidden" name="id" id="modalQuotationId" />
            <x-adminlte-input name="customer_name" id="customerName" label="Customer Name" fgroup-class="col-12 mb-3"
                readonly />
            <x-adminlte-input name="reference_no" id="modalReferenceNo" label="Quotation Reference No."
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-select name="is_verified" label="Select" id="isVerified" fgroup-class="col-12 mb-3" required>
                <option disabled selected>Select Quotation Verify</option>
                <option value="1">Yes</option>
                <option value="0">Reject</option>
                <option value="2">Editable</option>
            </x-adminlte-select>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <x-adminlte-button label="Cancel" theme="outline-danger" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Submit" type="submit" theme="primary" />
        </div>
    </form>
</x-adminlte-modal>

<!-- Send Email Modal -->
<x-adminlte-modal id="sendEmailModal" title="Send Email to Customer" theme="info" icon="fas fa-envelope">
    <form method="POST" action="{{ route('quotation.send.mail') }}">
        @csrf
        <div class="row">
            <x-adminlte-input type="hidden" name="quotation_id" id="quotation_id" />
            <x-adminlte-input type="hidden" name="customer_id" id="customer_id" />
            <x-adminlte-input name="customer_name" id="emailCustomerName" label="Customer Name"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input type="email" name="customer_email" id="emailCustomerEmail" label="Customer Email"
                type="email" fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input type="text" id="subject" name="subject" id="subject" label="Subject"
                fgroup-class="col-12 mb-3" />
            <x-adminlte-textarea name="message" id="message" label="Message" rows="5" fgroup-class="col-12 mb-3"
                placeholder="Type your message here..." required />
            <div class="col-12 mb-3">
                <input type="checkbox" name="withPdf" id="withPdf" value="1" label="With Quotation Pdf Send" /><label
                    for="withPdf">Send with Quotation Pdf</label>
            </div>
            <div class="col-12 mb-3" id="email">

            </div>
        </div>
        <div class="d-flex justify-content-end">
            <x-adminlte-button label="Cancel" theme="outline-danger" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Send" icon="fas fa-paper-plane" theme="info" type="submit" />
        </div>
    </form>
</x-adminlte-modal>
<!-- Quotation Status Update -->
<x-adminlte-modal id="updateQuotationStatus" title="Update Status of Quotation" theme="info" icon="fas fa-envelope">
    <form method="POST" action="{{ route('quotation.update.status') }}">
        @csrf
        @method('POST')
        <div class="row">
            <x-adminlte-input type="hidden" name="id" id="quotationId" />
            <x-adminlte-input name="customer_name" id="statusCustomerName" label="Customer Name"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input name="reference_no" id="referenceNo" label="Reference NO." type="text"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-select name="status" id="status" label="Select Status" fgroup-class="col-12 mb-3">
                <option value="Draft" {{ $quotation->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Sent" {{ $quotation->status == 'Sent' ? 'selected' : '' }}>Sent</option>
                <option value="Approved" {{ $quotation->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ $quotation->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </x-adminlte-select>
        </div>
        <div class="d-flex justify-content-end">
            <x-adminlte-button label="Cancel" theme="outline-danger" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Send" icon="fas fa-paper-plane" theme="info" type="submit" />
        </div>
    </form>
</x-adminlte-modal>
@stop

@push('js')
    <script src="{{ asset('js/quotation.js') }}"> </script>
@endpush

<!-- History Modal -->
<x-adminlte-modal id="historyModal" title="Quotation History" theme="secondary" icon="fas fa-history" size="lg">
    <div id="historyContent">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event</th>
                    <th>User</th>
                    <th>When</th>
                    <th>Changes</th>
                </tr>
            </thead>
            <tbody id="historyBody">
                <tr>
                    <td colspan="5" class="text-center">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-adminlte-modal>

@push('js')
    <script>
        // Fetch and display audits when history modal opens
        $('#historyModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const body = $('#historyBody');
            body.html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');

            fetch(`{{ url('') }}/quotation/${id}/audits`)
                .then(res => res.json())
                .then(data => {
                    if (!data || data.length === 0) {
                        body.html('<tr><td colspan="5" class="text-center">No history found</td></tr>');
                        return;
                    }
                    let rows = '';
                    data.forEach((a, idx) => {
                        // Prepare a readable changes string (show old -> new)
                        let changes = '';
                        const oldVals = a.old_values || {};
                        const newVals = a.new_values || {};
                        const keys = Array.from(new Set(Object.keys(oldVals).concat(Object.keys(newVals))));
                        if (keys.length === 0) {
                            changes = '-';
                        } else {
                            changes = '<ul style="margin:0;padding-left:14px;">';
                            keys.forEach(k => {
                                const ov = (oldVals[k] === undefined || oldVals[k] === null) ? '' : escapeHtml(String(oldVals[k]));
                                const nv = (newVals[k] === undefined || newVals[k] === null) ? '' : escapeHtml(String(newVals[k]));
                                if (ov === nv) return; // skip identical
                                changes += `<li><strong>${escapeHtml(k)}</strong>: ${ov} ➜ ${nv}</li>`;
                            });
                            changes += '</ul>';
                        }

                        rows += `
                                <tr>
                                    <td>${idx + 1}</td>
                                    <td>${escapeHtml(a.event)}</td>
                                    <td>${escapeHtml(a.user_name ?? a.user_id ?? 'System')}</td>
                                    <td>${escapeHtml(a.created_at)}</td>
                                    <td>${changes}</td>
                                </tr>`;
                    });
                    body.html(rows);
                }).catch(err => {
                    body.html('<tr><td colspan="5" class="text-center text-danger">Failed to load history</td></tr>');
                    console.error(err);
                });
        });

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }
    </script>
@endpush

@push('css')
<style>
    /* ===== Card Enhancement ===== */
/* ===== Prevent Horizontal Scroll ===== */
html, body {
    max-width: 100%;
    overflow-x: hidden !important;
}

/* ===== Content Wrapper Fix (AdminLTE) ===== */
.content-wrapper {
    margin-left: 250px !important; /* sidebar width */
    overflow-x: hidden;
}

/* ===== When Sidebar Collapsed ===== */
.sidebar-collapse .content-wrapper {
    margin-left: 80px !important;
}

/* ===== Main Content Padding ===== */
.content {
    padding: 15px 20px;
    overflow-x: hidden;
}

/* ===== Table Responsive Control ===== */
.table-responsive {
    overflow-x: auto;
    padding-bottom: 5px;
}

/* ===== Datatable Width Fix ===== */
table.dataTable {
    width: 100% !important;
    table-layout: auto;
}

/* ===== Fix Floating Card Rows ===== */
table.dataTable tbody tr {
    max-width: 100%;
}

/* ===== Actions Column Wrap Control ===== */
table.dataTable td:last-child {
    white-space: nowrap;
}

/* ===== Sidebar Shadow Separation ===== */
.main-sidebar {
    box-shadow: 2px 0 12px rgba(0,0,0,0.08);
}

/* ===== Remove Extra Body Margin ===== */
.wrapper {
    overflow-x: hidden;
}

</style>
@endpush


