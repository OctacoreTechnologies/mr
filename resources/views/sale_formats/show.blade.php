@extends('layouts.app')

@section('title', 'Sale Format #' . $saleFormat->id)

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice"></i>
        Sale Format
        <span style="color:#64748b;font-weight:400">#{{ $saleFormat->id }}</span>
    </h1>
    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
        <a href="{{ route('sale-formats.pdf', $saleFormat) }}" target="_blank"
           class="btn btn-sm" style="border:1.5px solid #fca5a5;background:#fff5f5;color:#dc2626;font-weight:600">
            <i class="fas fa-file-pdf"></i> PDF
        </a>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="{{ route('sale-formats.edit', $saleFormat) }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('sale-formats.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

<div id="sale-format-printable">

    {{-- ── Summary Row ─────────────────────────────────────────────────────── --}}
    {{-- Layout: Left = Company + Details stacked | Right = Contact Persons (grows freely) --}}
    <div class="row mb-3 align-items-start">

        {{-- Left column: Company + Details stacked --}}
        <div class="col-md-4 mb-3 mb-md-0 d-flex flex-column" style="gap:16px">

            {{-- Company --}}
            <div class="crm-index-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-building"></i> Company</h3>
                </div>
                <div class="card-body">
                    <div style="font-size:.97rem;font-weight:600;margin-bottom:6px">
                        <a href="{{ route('customer.show', $saleFormat->customer_id) }}"
                           class="text-primary text-decoration-none">
                            {{ $saleFormat->customer->company_name ?? '—' }}
                        </a>
                    </div>
                    @if($saleFormat->customer->address_line_1 ?? null)
                        <div style="font-size:.83rem;color:#64748b;line-height:1.55;margin-bottom:4px">
                            <i class="fas fa-map-marker-alt text-muted mr-1" style="width:14px"></i>
                            {{ $saleFormat->customer->address_line_1 }}
                        </div>
                    @endif
                    @if($saleFormat->customer->gst ?? null)
                        <div style="font-size:.78rem;color:#94a3b8;margin-top:4px">
                            <span style="font-weight:600;color:#64748b">GST:</span>
                            {{ $saleFormat->customer->gst }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Details --}}
            <div class="crm-index-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Details</h3>
                </div>
                <div class="card-body">
                    <div class="sf-meta-row">
                        <span class="sf-meta-label">Date</span>
                        <span class="sf-meta-val">{{ $saleFormat->sale_date->format('d M Y') }}</span>
                    </div>
                    <div class="sf-meta-row">
                        <span class="sf-meta-label">Sale Items</span>
                        <span class="sf-meta-val">
                            <span class="badge badge-info">{{ count($saleFormat->sale_details ?? []) }}</span>
                        </span>
                    </div>
                    <div class="sf-meta-row">
                        <span class="sf-meta-label">Requirements</span>
                        <span class="sf-meta-val">
                            <span class="badge badge-info">{{ $saleFormat->requirements->count() }}</span>
                        </span>
                    </div>
                    @if($saleFormat->prepared_by)
                    <div class="sf-meta-row">
                        <span class="sf-meta-label">Prepared By</span>
                        <span class="sf-meta-val">{{ $saleFormat->prepared_by }}</span>
                    </div>
                    @endif
                    @if($saleFormat->approved_by)
                    <div class="sf-meta-row">
                        <span class="sf-meta-label">Approved By</span>
                        <span class="sf-meta-val">{{ $saleFormat->approved_by }}</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Right column: Contact Persons (takes natural height, no stretching) --}}
        <div class="col-md-8">
            <div class="crm-index-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users"></i> Contact Persons</h3>
                    @php $persons = $saleFormat->contact_persons ?? []; @endphp
                    @if(count($persons) > 0)
                        <span class="badge badge-light" style="color:#1e293b;font-size:.7rem">{{ count($persons) }}</span>
                    @endif
                </div>
                <div class="card-body" style="padding:0 !important">
                    @if(count($persons) > 0)
                    {{-- Grid: 2 persons per row so height stays manageable no matter how many --}}
                    <div class="cp-grid">
                        @foreach($persons as $i => $cp)
                            @php
                                $contacts = array_values(array_filter($cp['contact'] ?? []));
                                $emails   = array_values(array_filter($cp['email'] ?? []));
                                $cpDocs   = array_values(array_filter($cp['documents'] ?? []));
                            @endphp
                            <div class="cp-cell">

                                {{-- Name + Designation --}}
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                                    <span style="background:#2563eb;color:#fff;font-size:.6rem;font-weight:700;letter-spacing:.06em;border-radius:20px;padding:2px 8px;flex-shrink:0">
                                        #{{ $i + 1 }}
                                    </span>
                                    <div style="min-width:0">
                                        @if(!empty($cp['name']))
                                            <div style="font-size:.9rem;font-weight:600;color:#1e293b;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $cp['name'] }}</div>
                                        @endif
                                        @if(!empty($cp['designation']))
                                            <div style="font-size:.72rem;color:#64748b;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $cp['designation'] }}</div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Phone --}}
                                @if(count($contacts))
                                <div style="margin-bottom:6px">
                                    <div style="font-size:.64rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px">
                                        <i class="fas fa-phone mr-1"></i> Phone
                                    </div>
                                    @foreach($contacts as $num)
                                        <div style="font-size:.81rem;margin-bottom:2px">
                                            <a href="tel:{{ $num }}" class="text-decoration-none text-dark">{{ $num }}</a>
                                        </div>
                                    @endforeach
                                </div>
                                @endif

                                {{-- Email --}}
                                @if(count($emails))
                                <div style="margin-bottom:6px">
                                    <div style="font-size:.64rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px">
                                        <i class="fas fa-envelope mr-1"></i> Email
                                    </div>
                                    @foreach($emails as $mail)
                                        <div style="font-size:.81rem;margin-bottom:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                            <a href="mailto:{{ $mail }}" class="text-decoration-none text-primary" title="{{ $mail }}">{{ $mail }}</a>
                                        </div>
                                    @endforeach
                                </div>
                                @endif

                                {{-- Attachments --}}
                                @if(!empty($cpDocs))
                                    <div style="margin-top:8px;padding-top:8px;border-top:1px dashed #e2e8f0;display:flex;flex-wrap:wrap;gap:6px">
                                        @foreach($cpDocs as $docPath)
                                        @php $docExt = strtolower(pathinfo($docPath, PATHINFO_EXTENSION)); $isImg = in_array($docExt, ['jpg','jpeg','png','gif','svg']); @endphp
                                        @if($isImg)
                                            <a href="{{ asset($docPath) }}" target="_blank" title="{{ basename($docPath) }}">
                                                <img src="{{ asset($docPath) }}" alt="doc"
                                                     style="width:60px;height:46px;object-fit:cover;border-radius:5px;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.07)">
                                            </a>
                                        @else
                                            <a href="{{ asset($docPath) }}" target="_blank" title="{{ basename($docPath) }}"
                                               style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:2px;width:60px;height:46px;border-radius:5px;border:1px solid #fecaca;background:#fff5f5;text-decoration:none">
                                                <i class="fas fa-file-pdf" style="font-size:1.1rem;color:#dc2626"></i>
                                                <span style="font-size:.52rem;color:#64748b;text-align:center;line-height:1.2;padding:0 3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:56px">{{ basename($docPath) }}</span>
                                            </a>
                                        @endif
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                    @else
                        <div style="padding:36px 18px;text-align:center">
                            <i class="fas fa-user-slash" style="font-size:1.5rem;color:#cbd5e1;display:block;margin-bottom:8px"></i>
                            <span style="font-size:.84rem;color:#94a3b8">No contact persons added</span>
                        </div>
                    @endif
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
            </h3>
            <span class="badge badge-light" style="color:#1e293b">{{ count($saleFormat->sale_details) }}</span>
        </div>
        <div class="card-body" style="padding:0 !important">
            <div class="table-responsive">
                <table class="table mb-0" style="font-size:.87rem">
                    <thead>
                        <tr style="background:#f8fafc;border-bottom:2px solid #e2e8f0">
                            <th class="sf-th" style="width:44px">#</th>
                            <th class="sf-th">Application</th>
                            <th class="sf-th">Model</th>
                            <th class="sf-th">Output</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($saleFormat->sale_details as $i => $detail)
                        <tr style="{{ $i % 2 === 1 ? 'background:#f8fafc' : '' }}">
                            <td class="sf-td" style="color:#94a3b8;text-align:center;font-weight:600">{{ $i + 1 }}</td>
                            <td class="sf-td" style="font-weight:500">{{ $detail['application'] ?? '—' }}</td>
                            <td class="sf-td" style="color:#334155">{{ $detail['model'] ?? '—' }}</td>
                            <td class="sf-td">
                                @if(!empty($detail['output']))
                                    <span style="background:#dbeafe;color:#1d4ed8;padding:2px 8px;border-radius:12px;font-size:.78rem;font-weight:600">
                                        {{ $detail['output'] }}
                                    </span>
                                @else
                                    <span style="color:#94a3b8">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Requirements ─────────────────────────────────────────────────────── --}}
    @if($saleFormat->requirements->isNotEmpty())
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list-ul"></i> Requirements
            </h3>
            <span class="badge badge-light" style="color:#1e293b">{{ $saleFormat->requirements->count() }}</span>
        </div>
        <div class="card-body" style="padding:0 !important">
            @foreach($saleFormat->requirements as $i => $req)
            <div style="display:flex;align-items:flex-start;gap:14px;padding:11px 18px;{{ $i > 0 ? 'border-top:1px solid #f1f5f9' : '' }};font-size:.87rem;{{ $i % 2 === 1 ? 'background:#f8fafc' : '' }}">
                <span style="min-width:24px;color:#2563eb;font-size:.75rem;font-weight:700;text-align:right;flex-shrink:0;padding-top:1px">
                    {{ $req->sort_order }}.
                </span>
                <span style="color:#1e293b;line-height:1.55">{{ $req->requirement_description }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Uploaded Files (visiting card only) ───────────────────────────────── --}}
    @php $vcPath = $saleFormat->customer->visiting_card ?? null; @endphp
    @if($vcPath)
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-id-card"></i> Visiting Card
            </h3>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-wrap:wrap;gap:16px">
                @php $ext = strtolower(pathinfo($vcPath, PATHINFO_EXTENSION)); @endphp
                <div style="display:flex;flex-direction:column;align-items:center;gap:7px;width:130px">
                    @if(in_array($ext, ['jpg','jpeg','png','gif','svg']))
                        <a href="{{ asset($vcPath) }}" target="_blank"
                           style="display:block;border-radius:8px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 2px 6px rgba(0,0,0,.07)">
                            <img src="{{ asset($vcPath) }}" alt="visiting card"
                                 style="width:130px;height:100px;object-fit:cover;display:block">
                        </a>
                        <span style="font-size:.72rem;color:#64748b;word-break:break-all;text-align:center;max-width:130px">{{ basename($vcPath) }}</span>
                    @else
                        <a href="{{ asset($vcPath) }}" target="_blank" style="text-decoration:none">
                            <div style="width:130px;height:100px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;border-radius:8px;border:1px solid #fecaca;background:#fff5f5">
                                <i class="fas fa-file-pdf" style="font-size:2.2rem;color:#dc2626"></i>
                                <span style="font-size:.65rem;color:#64748b;padding:0 6px;text-align:center;line-height:1.3;overflow:hidden;max-width:120px;text-overflow:ellipsis;white-space:nowrap">{{ basename($vcPath) }}</span>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Remark ───────────────────────────────────────────────────────────── --}}
    @php $remarkDocs = array_values(array_filter((array)($saleFormat->upload_file_path ?? []))); @endphp
    @if($saleFormat->remark || !empty($remarkDocs))
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-sticky-note"></i> Remark</h3>
        </div>
        <div class="card-body">
            @if($saleFormat->remark)
                <div id="remark-viewer"></div>
            @endif

            @if(!empty($remarkDocs))
                <div style="{{ $saleFormat->remark ? 'margin-top:18px;padding-top:14px;border-top:1px dashed #e2e8f0;' : '' }}">
                    <div style="font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px">
                        <i class="fas fa-paperclip mr-1"></i> Documents
                    </div>
                    <div style="display:flex;flex-wrap:wrap;gap:12px">
                        @foreach($remarkDocs as $filePath)
                            @php $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','gif','svg']))
                                <div style="display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <a href="{{ asset($filePath) }}" target="_blank"
                                       style="display:block;border-radius:7px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,.07)">
                                        <img src="{{ asset($filePath) }}" alt="doc"
                                             style="width:110px;height:84px;object-fit:cover;display:block">
                                    </a>
                                    <span style="font-size:.68rem;color:#64748b;max-width:110px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;text-align:center">{{ basename($filePath) }}</span>
                                </div>
                            @else
                                <div style="display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <a href="{{ asset($filePath) }}" target="_blank" style="text-decoration:none">
                                        <div style="width:110px;height:84px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;border-radius:7px;border:1px solid #fecaca;background:#fff5f5">
                                            <i class="fas fa-file-pdf" style="font-size:2rem;color:#dc2626"></i>
                                            <span style="font-size:.6rem;color:#64748b;padding:0 5px;text-align:center;line-height:1.3;overflow:hidden;max-width:100px;text-overflow:ellipsis;white-space:nowrap">{{ basename($filePath) }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- ── Delete ───────────────────────────────────────────────────────────── --}}
    <div class="d-flex justify-content-end mb-4">
        <form action="{{ route('sale-formats.destroy', $saleFormat) }}" method="POST"
              class="d-inline" id="deleteForm">
            @csrf @method('DELETE')
            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="if(confirm('Are you sure you want to permanently delete this sale format?')) document.getElementById('deleteForm').submit()">
                <i class="fas fa-trash-alt"></i> Delete Sale Format
            </button>
        </form>
    </div>

</div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        .sf-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: .85rem;
        }
        .sf-meta-row:last-child { border-bottom: none; }
        .sf-meta-label {
            color: #64748b;
            font-size: .76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .sf-meta-val {
            color: #1e293b;
            font-weight: 500;
        }
        .sf-th {
            color: #64748b;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: 10px 16px !important;
            font-weight: 700;
            white-space: nowrap;
        }
        .sf-td {
            padding: 10px 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-top: none !important;
            vertical-align: middle !important;
        }
        #remark-viewer .ql-container.ql-snow { border: none !important; font-size: .88rem; font-family: inherit; }
        #remark-viewer .ql-editor { padding: 0 !important; min-height: unset !important; line-height: 1.8; color: #334155; cursor: default !important; }
        #remark-viewer .ql-editor > * { cursor: default !important; }

        /* Contact Persons 2-column grid */
        .cp-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }
        .cp-cell {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        /* Right column cells get a left border */
        .cp-cell:nth-child(even) {
            border-left: 1px solid #f1f5f9;
        }
        /* Remove bottom border from last row */
        .cp-cell:last-child,
        .cp-cell:nth-last-child(2):nth-child(odd) {
            border-bottom: none;
        }
        /* Alternating row tint */
        .cp-cell:nth-child(4n+3),
        .cp-cell:nth-child(4n+4) {
            background: #f8fafc;
        }
        @media (max-width: 576px) {
            .cp-grid { grid-template-columns: 1fr; }
            .cp-cell:nth-child(even) { border-left: none; }
            .cp-cell:last-child { border-bottom: none; }
        }
        @media print {
            .btn, nav, .alert, .content-header, .main-header,
            .main-sidebar, .main-footer { display: none !important; }
            .content-wrapper { margin-left: 0 !important; padding: 0 !important; }
            .crm-index-card { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
(function () {
    var el = document.getElementById('remark-viewer');
    if (!el) return;
    var viewer = new Quill(el, { readOnly: true, theme: 'snow', modules: { toolbar: false } });
    viewer.clipboard.dangerouslyPasteHTML({!! json_encode($saleFormat->remark) !!});
})();
</script>
@endpush
