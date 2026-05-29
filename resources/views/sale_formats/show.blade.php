@extends('layouts.app')

@section('title', 'Sale Format #' . $saleFormat->id)

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice"></i>
        Sale Format
        <span style="color:#64748b;font-weight:400">#{{ $saleFormat->id }}</span>
    </h1>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="{{ route('sale-formats.pdf', $saleFormat) }}" target="_blank"
           style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #d1d5db;background:#fff;color:#dc2626;text-decoration:none">
            <i class="fas fa-file-pdf"></i> PDF
        </a>
        <button onclick="window.print()"
                style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #d1d5db;background:#fff;color:#6b7280;cursor:pointer">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="{{ route('sale-formats.edit', $saleFormat) }}"
           style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #d1d5db;background:#fff;color:#2563eb;text-decoration:none">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('sale-formats.index') }}"
           style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #d1d5db;background:#fff;color:#6b7280;text-decoration:none">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

<div id="sale-format-printable">

    {{-- ── Header Card ─────────────────────────────────────────────────────── --}}
    <div class="crm-index-card mb-3">
        <div class="card-header" style="background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%)">
            <h3 class="card-title">
                <i class="fas fa-file-invoice"></i>
                Sale Format
                <span style="opacity:.7;font-weight:400">&nbsp;#{{ $saleFormat->id }}</span>
            </h3>
            <div class="card-tools">
                @php
                    $badgeMap = ['approved' => 'success', 'rejected' => 'danger', 'draft' => 'warning'];
                    $badge    = $badgeMap[$saleFormat->status] ?? 'warning';
                @endphp
                <span class="badge badge-{{ $badge }} text-capitalize" style="font-size:.85rem;padding:6px 12px">
                    {{ $saleFormat->status }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-6 mb-2">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Sale Date</span>
                        <div class="crm-detail-value">{{ $saleFormat->sale_date->format('d M Y') }}</div>
                    </div>
                </div>
                <div class="col-md-4 col-6 mb-2">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Sale Items</span>
                        <div class="crm-detail-value">{{ count($saleFormat->sale_details ?? []) }} item(s)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Sale Details ─────────────────────────────────────────────────────── --}}
    @if(!empty($saleFormat->sale_details))
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-cogs"></i> Sale Details
                <span class="badge badge-info ml-2">{{ count($saleFormat->sale_details) }}</span>
            </h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc">
                    <tr>
                        <th style="width:40px;color:#64748b;font-size:.78rem">#</th>
                        <th style="color:#64748b;font-size:.78rem">Application</th>
                        <th style="color:#64748b;font-size:.78rem">Model</th>
                        <th style="color:#64748b;font-size:.78rem">Output</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saleFormat->sale_details as $i => $detail)
                    <tr>
                        <td style="color:#64748b;font-size:.82rem;text-align:center">{{ $i + 1 }}</td>
                        <td>{{ $detail['application'] ?? '—' }}</td>
                        <td>{{ $detail['model'] ?? '—' }}</td>
                        <td>{{ $detail['output'] ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ── Company & Contact ────────────────────────────────────────────────── --}}
    <div class="row mb-3">

        <div class="col-md-6 mb-3 mb-md-0">
            <div class="crm-index-card h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-building"></i> Company</h3>
                </div>
                <div class="card-body">
                    <h5 class="mb-1">
                        <a href="{{ route('customer.show', $saleFormat->customer_id) }}"
                           class="text-primary text-decoration-none">
                            {{ $saleFormat->customer->company_name ?? '—' }}
                        </a>
                    </h5>
                    @if($saleFormat->customer->gst ?? null)
                        <div class="text-muted small">GST: {{ $saleFormat->customer->gst }}</div>
                    @endif
                    @if($saleFormat->customer->address_line_1 ?? null)
                        <div class="text-muted mt-1" style="font-size:.88rem">
                            {{ $saleFormat->customer->address_line_1 }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="crm-index-card h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user"></i> Contact Person</h3>
                </div>
                <div class="card-body">
                    @if($saleFormat->cp_name || $saleFormat->cp_contact || $saleFormat->cp_email)
                        @if($saleFormat->cp_name)
                            <h6 class="mb-0 font-weight-bold">{{ $saleFormat->cp_name }}</h6>
                        @endif
                        @if($saleFormat->cp_designation)
                            <div class="text-muted small mb-2">{{ $saleFormat->cp_designation }}</div>
                        @endif
                        @if($saleFormat->cp_contact)
                            <div class="mb-1">
                                <i class="fas fa-phone text-muted mr-1"></i>
                                <a href="tel:{{ $saleFormat->cp_contact }}" class="text-decoration-none">
                                    {{ $saleFormat->cp_contact }}
                                </a>
                            </div>
                        @endif
                        @if($saleFormat->cp_email)
                            <div>
                                <i class="fas fa-envelope text-muted mr-1"></i>
                                <a href="mailto:{{ $saleFormat->cp_email }}" class="text-decoration-none">
                                    {{ $saleFormat->cp_email }}
                                </a>
                            </div>
                        @endif
                    @else
                        <span class="text-muted">No contact person</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ── Visiting Card ──────────────────────────────────────────────────────── --}}
    @php $vcPath = $saleFormat->customer->visiting_card ?? null; @endphp
    @if($vcPath)
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-id-card"></i> Visiting Card</h3>
        </div>
        <div class="card-body text-center">
            <img src="{{ asset($vcPath) }}"
                 alt="Visiting Card"
                 style="max-width:420px;width:100%;border-radius:8px;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,.08)">
        </div>
    </div>
    @endif

    {{-- ── Requirements ─────────────────────────────────────────────────────── --}}
    @if($saleFormat->requirements->isNotEmpty())
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list-ul"></i> Requirements
                <span class="badge badge-info ml-2">{{ $saleFormat->requirements->count() }}</span>
            </h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <tbody>
                    @foreach($saleFormat->requirements as $req)
                    <tr>
                        <td style="width:40px;color:#64748b;font-size:.82rem;text-align:center">
                            {{ $req->sort_order }}
                        </td>
                        <td>{{ $req->requirement_description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ── Remark ───────────────────────────────────────────────────────────── --}}
    @if($saleFormat->remark)
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-sticky-note"></i> Remark</h3>
        </div>
        <div class="card-body">
            <p class="mb-0" style="white-space:pre-wrap">{{ $saleFormat->remark }}</p>
        </div>
    </div>
    @endif

    {{-- ── Sign-off ─────────────────────────────────────────────────────────── --}}
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-signature"></i> Sign-off</h3>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-6">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Prepared By</span>
                        <div class="crm-detail-value">{{ $saleFormat->prepared_by ?? '—' }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Approved By</span>
                        <div class="crm-detail-value">{{ $saleFormat->approved_by ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Delete ───────────────────────────────────────────────────────────── --}}
    <div class="mb-4">
        <form action="{{ route('sale-formats.destroy', $saleFormat) }}" method="POST"
              class="d-inline" id="deleteForm">
            @csrf @method('DELETE')
            <button type="button"
                    class="btn btn-outline-danger btn-sm"
                    onclick="if(confirm('Yeh sale format permanently delete karna chahte hain?')) document.getElementById('deleteForm').submit()">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
        </form>
    </div>

</div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <style>
        .crm-detail-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 12px;
        }
        .crm-detail-label {
            font-size: .7rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            display: block;
            margin-bottom: 3px;
        }
        .crm-detail-value {
            font-size: .9rem;
            color: #1e293b;
            font-weight: 500;
        }
        @media print {
            .btn, nav, .alert, .content-header, .main-header,
            .main-sidebar, .main-footer { display: none !important; }
            .content-wrapper { margin-left: 0 !important; padding: 0 !important; }
            .crm-index-card { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
@endpush
