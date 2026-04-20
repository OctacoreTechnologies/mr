@php
    $heads = [
        'Sr.No',
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
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice"></i>
        Quotation List
    </h1>
    @can('quotation_create')
     <a href="{{ route('quotation.previewForm') }}" class="btn btn-success">
         <i class="fas fa-plus"></i> Create Quotation
     </a>
    @endcan
</div>
@stop

@section('content')

<x-alert-components class="my-2" />

<div class="crm-index-card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-invoice"></i> All Quotations
        </h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
                @foreach ($quotations as $quotation)
                    <tr>
                        {{-- Sr No --}}
                        <td class="sr-no">{{ ++$i }}</td>

                        {{-- Reference --}}
                        <td>
                            <span style="font-family:'DM Mono',monospace;font-size:.82rem;font-weight:500;">
                                {{ $quotation->reference_no }}
                            </span>
                        </td>

                        {{-- Customer --}}
                        <td>{{ $quotation->customer->company_name }}</td>

                        {{-- Machine --}}
                        <td>{{ $quotation->machine->name }}</td>

                        {{-- Product / Application --}}
                        <td>{{ $quotation->application->name ?? 'N.A' }}</td>

                        {{-- Status Badge --}}
                        <td>
                            @php
                                $statusMap = [
                                    'Draft'         => ['class' => 'crm-badge-negotiation',   'icon' => 'fa-pencil-alt'],
                                    'Sent'          => ['class' => 'crm-badge-proposal',       'icon' => 'fa-paper-plane'],
                                    'Approved'      => ['class' => 'crm-badge-new-business',   'icon' => 'fa-thumbs-up'],
                                    'Order Confirm' => ['class' => 'crm-badge-closed-won',     'icon' => 'fa-check-circle'],
                                    'Rejected'      => ['class' => 'crm-badge-closed-lost',    'icon' => 'fa-times-circle'],
                                ];
                                $sMap = $statusMap[$quotation->status] ?? ['class' => 'crm-badge-qualification', 'icon' => 'fa-circle'];
                            @endphp
                            <span class="crm-badge {{ $sMap['class'] }}">
                                <i class="fas {{ $sMap['icon'] }}" style="font-size:.65rem;"></i>
                                {{ ucfirst($quotation->status) }}
                            </span>
                        </td>

                        {{-- Verify Badge --}}
                        <td>
                            @php
                                if (is_null($quotation->is_verified)) {
                                    $verifiedStatus = 'Pending';
                                } elseif ($quotation->is_verified == '0') {
                                    $verifiedStatus = 'Reject';
                                } elseif ($quotation->is_verified == '1') {
                                    $verifiedStatus = 'Yes';
                                } elseif ($quotation->is_verified == '2') {
                                    $verifiedStatus = 'Editable';
                                }
                                $verifyMap = [
                                    'Pending'  => ['class' => 'crm-badge-qualification', 'icon' => 'fa-clock'],
                                    'Yes'      => ['class' => 'crm-badge-closed-won',    'icon' => 'fa-check'],
                                    'Reject'   => ['class' => 'crm-badge-closed-lost',   'icon' => 'fa-times'],
                                    'Editable' => ['class' => 'crm-badge-negotiation',   'icon' => 'fa-edit'],
                                ];
                                $vMap = $verifyMap[$verifiedStatus] ?? ['class' => 'crm-badge-qualification', 'icon' => 'fa-circle'];
                            @endphp
                            <span class="crm-badge {{ $vMap['class'] }}">
                                <i class="fas {{ $vMap['icon'] }}" style="font-size:.65rem;"></i>
                                {{ $verifiedStatus }}
                            </span>
                        </td>

                        {{-- PDF --}}
                        <td>
                            @can('quotation_pdf')
                             <a class="btn btn-default text-danger btn-group-sm"
                                href="{{ route('quotation.pdf', $quotation->id) }}"
                                target="_blank" title="View PDF"
                                style="width:auto !important;padding:6px 10px !important;gap:5px;">
                                <i class="fas fa-file-pdf"></i>
                                <span style="font-size:.78rem;font-weight:600;">PDF</span>
                             </a>
                            @endcan
                        </td>

                        {{-- Follow Up --}}

                        <td>
                          @can('followup_customer')
                            <a class="btn btn-default text-primary btn-group-sm"
                                href="{{ route('followup.edit', $quotation->customer_id) }}?type=quotation&quotation_id={{ $quotation->id }}"
                                title="Follow Up"
                                style="width:auto !important;padding:6px 10px !important;gap:5px;">
                                <i class="fas fa-calendar-check"></i>
                                <span style="font-size:.78rem;font-weight:600;">Follow Up</span>
                            </a>
                           @endcan
                        </td>

                        {{-- Actions Dropdown --}}
                        <td>
                            <div class="dropdown">
                                <button class="crm-dropdown-toggle" type="button"
                                    id="actionsDropdown{{ $quotation->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right crm-dropdown-menu"
                                    aria-labelledby="actionsDropdown{{ $quotation->id }}">
                                  @can('quotation_edit')
                                    <a class="crm-dropdown-item" href="{{ route('quotation.edit', $quotation->id) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                  @endcan

                                    <div class="crm-dropdown-divider"></div>
                                  @can('quotation_verify')
                                    <button class="crm-dropdown-item crm-dropdown-item--success"
                                        data-toggle="modal" data-target="#modalMin"
                                        data-id="{{ $quotation->id }}"
                                        data-reference_no="{{ $quotation->reference_no ?? '' }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-verified="{{ $quotation->is_verified ?? '' }}">
                                        <i class="fas fa-check-circle"></i> Verify
                                    </button>
                                   @endcan
                                  @can('quotation_status_update')
                                    <button class="crm-dropdown-item crm-dropdown-item--info"
                                        data-toggle="modal" data-target="#updateQuotationStatus"
                                        data-quotationId="{{ $quotation->id }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-reference_no="{{ $quotation->reference_no }}"
                                        data-status="{{ $quotation->status ?? 'N/A' }}">
                                        <i class="fas fa-sync-alt"></i> Update Status
                                    </button>
                                  @endcan
                                   @can('mail_send')
                                     <button class="crm-dropdown-item crm-dropdown-item--info"
                                        data-toggle="modal" data-target="#sendEmailModal"
                                        data-id="{{ $quotation->id }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-customer_email="{{ $quotation->customer->contact_person_1_email ?? 'N/A' }}"
                                        data-isverify="{{ $quotation->is_verified ? '1' : '0' }}"
                                        data-customer_id="{{ $quotation->customer_id }}"
                                        data-application_id="{{ $quotation->application_id }}">
                                        <i class="fas fa-envelope"></i> Send Email
                                     </button>
                                    @endcan
                                  
                                  @can('quotation_reorder')
                                    <a class="crm-dropdown-item crm-dropdown-item--success"
                                        href="{{ route('quotation.reorder', $quotation->id) }}">
                                        <i class="fas fa-redo"></i> Reorder
                                    </a>
                                  @endcan
                                   
                                   @can('quotation_history')
                                     <button class="crm-dropdown-item"
                                        data-toggle="modal" data-target="#historyModal"
                                        data-id="{{ $quotation->id }}">
                                        <i class="fas fa-history"></i> History
                                     </button>
                                    @endcan
                                  @can('quotation_delete')
                                    <div class="crm-dropdown-divider"></div>

                                    <form action="{{ route('quotation.destroy', $quotation->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this quotation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="crm-dropdown-item crm-dropdown-item--danger">
                                            <i class="fas fa-trash-alt"></i> Delete
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


{{-- ══════════════════════════════════════
     MODALS
══════════════════════════════════════ --}}

{{-- Verify Modal --}}
<x-adminlte-modal id="modalMin" title="Verify Quotation" theme="teal" icon="fas fa-check-circle">
    <form method="POST" action="{{ route('admin.quotation.verify') }}">
        @csrf
        <div class="row">
            <x-adminlte-input type="hidden" name="id" id="modalQuotationId" />
            <x-adminlte-input name="customer_name" id="customerName" label="Customer Name"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input name="reference_no" id="modalReferenceNo" label="Quotation Reference No."
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-select name="is_verified" label="Verification Status" id="isVerified"
                fgroup-class="col-12 mb-3" required>
                <option disabled selected>Select Verify Status</option>
                <option value="1">Yes</option>
                <option value="0">Reject</option>
                <option value="2">Editable</option>
            </x-adminlte-select>
        </div>
        <div class="d-flex justify-content-end mt-3 gap-2">
            <x-adminlte-button label="Cancel" theme="outline-secondary" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Submit" type="submit" theme="primary" />
        </div>
    </form>
</x-adminlte-modal>

{{-- Send Email Modal --}}
<x-adminlte-modal id="sendEmailModal" title="Send Email to Customer" theme="info" icon="fas fa-envelope">
    <form method="POST" action="{{ route('quotation.send.mail') }}">
        @csrf
        <div class="row">
            <x-adminlte-input type="hidden" name="quotation_id" id="quotation_id" />
            <x-adminlte-input type="hidden" name="customer_id" id="customer_id" />
            <x-adminlte-input name="customer_name" id="emailCustomerName" label="Customer Name"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input type="email" name="customer_email" id="emailCustomerEmail" label="Customer Email"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input type="text" name="subject" id="subject" label="Subject"
                fgroup-class="col-12 mb-3" />
            <x-adminlte-textarea name="message" id="message" label="Message" rows="5"
                fgroup-class="col-12 mb-3" placeholder="Type your message here..." required />
            <div class="col-12 mb-3 d-flex align-items-center" style="gap:8px;">
                <input type="checkbox" name="withPdf" id="withPdf" value="1"
                    style="width:16px;height:16px;accent-color:var(--crm-primary,#2563eb);cursor:pointer;">
                <label for="withPdf" style="margin:0;font-size:.88rem;cursor:pointer;">
                    Send with Quotation PDF
                </label>
            </div>
            <div class="col-12 mb-3" id="email"></div>
        </div>
        <div class="d-flex justify-content-end">
            <x-adminlte-button label="Cancel" theme="outline-secondary" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Send" icon="fas fa-paper-plane" theme="info" type="submit" />
        </div>
    </form>
</x-adminlte-modal>

{{-- Update Status Modal --}}
<x-adminlte-modal id="updateQuotationStatus" title="Update Quotation Status" theme="info" icon="fas fa-sync-alt">
    <form method="POST" action="{{ route('quotation.update.status') }}">
        @csrf
        @method('POST')
        <div class="row">
            <x-adminlte-input type="hidden" name="id" id="quotationId" />
            <x-adminlte-input name="customer_name" id="statusCustomerName" label="Customer Name"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input name="reference_no" id="referenceNo" label="Reference No."
                type="text" fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-select name="status" id="status" label="Select Status" fgroup-class="col-12 mb-3">
                <option value="Draft">Draft</option>
                <option value="Sent">Sent</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </x-adminlte-select>
        </div>
        <div class="d-flex justify-content-end">
            <x-adminlte-button label="Cancel" theme="outline-secondary" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Update" icon="fas fa-save" theme="primary" type="submit" />
        </div>
    </form>
</x-adminlte-modal>

{{-- History Modal --}}
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
                <tr><td colspan="5" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    </div>
</x-adminlte-modal>

@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <style>
        /* ── Dropdown toggle button ── */
        .crm-dropdown-toggle {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--crm-border);
            border-radius: var(--crm-radius-sm);
            background: var(--crm-card-bg);
            color: var(--crm-text-muted);
            font-size: .85rem;
            cursor: pointer;
            transition: all var(--crm-transition);
        }
        .crm-dropdown-toggle:hover,
        .crm-dropdown-toggle:focus {
            background: var(--crm-primary-light);
            border-color: var(--crm-primary);
            color: var(--crm-primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }

        /* ── Dropdown menu ── */
        .crm-dropdown-menu {
            min-width: 180px;
            padding: 6px !important;
            border: 1.5px solid var(--crm-border) !important;
            border-radius: var(--crm-radius) !important;
            box-shadow: 0 8px 24px rgba(0,0,0,.1) !important;
            background: var(--crm-card-bg) !important;
        }

        /* ── Dropdown items ── */
        .crm-dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 7px 12px;
            font-family: var(--crm-font);
            font-size: .84rem;
            font-weight: 500;
            color: var(--crm-text);
            border-radius: var(--crm-radius-sm);
            border: none;
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            transition: background var(--crm-transition), color var(--crm-transition);
            text-align: left;
        }
        .crm-dropdown-item:hover {
            background: var(--crm-bg);
            color: var(--crm-primary);
            text-decoration: none;
        }
        .crm-dropdown-item i {
            width: 14px;
            text-align: center;
            font-size: .82rem;
        }

        /* Coloured variants */
        .crm-dropdown-item--danger       { color: var(--crm-danger) !important; }
        .crm-dropdown-item--danger:hover  { background: var(--crm-danger-light) !important; }
        .crm-dropdown-item--success       { color: var(--crm-success) !important; }
        .crm-dropdown-item--success:hover { background: var(--crm-success-light) !important; }
        .crm-dropdown-item--info          { color: #0369a1 !important; }
        .crm-dropdown-item--info:hover    { background: #e0f2fe !important; }

        /* ── Divider ── */
        .crm-dropdown-divider {
            height: 1px;
            background: var(--crm-border);
            margin: 5px 0;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('js/quotation.js') }}"></script>
    <script>
        // History modal fetch
        $('#historyModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id     = button.data('id');
            const body   = $('#historyBody');
            body.html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');

            fetch(`{{ url('') }}/quotation/${id}/audits`)
                .then(res => res.json())
                .then(data => {
                    if (!data || data.length === 0) {
                        body.html('<tr><td colspan="5" class="text-center text-muted">No history found</td></tr>');
                        return;
                    }
                    let rows = '';
                    data.forEach((a, idx) => {
                        const oldVals = a.old_values || {};
                        const newVals = a.new_values || {};
                        const keys    = Array.from(new Set(Object.keys(oldVals).concat(Object.keys(newVals))));
                        let changes   = '-';
                        if (keys.length) {
                            changes = '<ul style="margin:0;padding-left:14px;">';
                            keys.forEach(k => {
                                const ov = (oldVals[k] == null) ? '' : escapeHtml(String(oldVals[k]));
                                const nv = (newVals[k] == null) ? '' : escapeHtml(String(newVals[k]));
                                if (ov === nv) return;
                                changes += `<li><strong>${escapeHtml(k)}</strong>: ${ov} ➜ ${nv}</li>`;
                            });
                            changes += '</ul>';
                        }
                        rows += `<tr>
                            <td>${idx + 1}</td>
                            <td>${escapeHtml(a.event)}</td>
                            <td>${escapeHtml(a.user_name ?? a.user_id ?? 'System')}</td>
                            <td>${escapeHtml(a.created_at)}</td>
                            <td>${changes}</td>
                        </tr>`;
                    });
                    body.html(rows);
                })
                .catch(() => {
                    body.html('<tr><td colspan="5" class="text-center text-danger">Failed to load history</td></tr>');
                });
        });

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g,  '&amp;')
                .replace(/</g,  '&lt;')
                .replace(/>/g,  '&gt;')
                .replace(/"/g,  '&quot;')
                .replace(/'/g,  '&#39;');
        }
    </script>
@endpush