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
           class="btn btn-sm" style="border:1px solid #fca5a5;background:#fff5f5;color:#dc2626">
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
    <div class="row mb-3">

        {{-- Company --}}
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="crm-index-card h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-building"></i> Company</h3>
                </div>
                <div class="card-body">
                    <h5 class="mb-1" style="font-size:.98rem;font-weight:600">
                        <a href="{{ route('customer.show', $saleFormat->customer_id) }}"
                           class="text-primary text-decoration-none">
                            {{ $saleFormat->customer->company_name ?? '—' }}
                        </a>
                    </h5>
                    @if($saleFormat->customer->address_line_1 ?? null)
                        <div style="font-size:.83rem;color:#64748b;margin-top:4px;line-height:1.5">
                            {{ $saleFormat->customer->address_line_1 }}
                        </div>
                    @endif
                    @if($saleFormat->customer->gst ?? null)
                        <div style="font-size:.78rem;color:#94a3b8;margin-top:4px">
                            GST: {{ $saleFormat->customer->gst }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Contact Persons --}}
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="crm-index-card h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users"></i> Contact Persons</h3>
                </div>
                <div class="card-body" style="padding:0">
                    @php $persons = $saleFormat->contact_persons ?? []; @endphp
                    @forelse($persons as $i => $cp)
                        <div style="padding:12px 16px;{{ $i > 0 ? 'border-top:1px solid #f1f5f9' : '' }}">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:4px">
                                <span style="background:#2563eb;color:#fff;font-size:.65rem;font-weight:700;letter-spacing:.05em;border-radius:20px;padding:2px 8px">
                                    #{{ $i + 1 }}
                                </span>
                                @if(!empty($cp['name']))
                                    <span style="font-size:.9rem;font-weight:600;color:#1e293b">{{ $cp['name'] }}</span>
                                @endif
                            </div>
                            @if(!empty($cp['designation']))
                                <div style="font-size:.78rem;color:#64748b;margin-bottom:6px">{{ $cp['designation'] }}</div>
                            @endif
                            @foreach($cp['contact'] ?? [] as $num)
                                @if(filled($num))
                                    <div style="font-size:.82rem;margin-bottom:3px">
                                        <i class="fas fa-phone text-muted mr-1" style="width:14px"></i>
                                        <a href="tel:{{ $num }}" class="text-decoration-none text-dark">{{ $num }}</a>
                                    </div>
                                @endif
                            @endforeach
                            @foreach($cp['email'] ?? [] as $mail)
                                @if(filled($mail))
                                    <div style="font-size:.82rem;margin-bottom:3px">
                                        <i class="fas fa-envelope text-muted mr-1" style="width:14px"></i>
                                        <a href="mailto:{{ $mail }}" class="text-decoration-none text-dark">{{ $mail }}</a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @empty
                        <div class="text-muted" style="font-size:.85rem;padding:14px 16px">
                            Koi contact person add nahi kiya
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Meta --}}
        <div class="col-md-4">
            <div class="crm-index-card h-100">
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
                        <span class="sf-meta-val">{{ count($saleFormat->sale_details ?? []) }}</span>
                    </div>
                    <div class="sf-meta-row">
                        <span class="sf-meta-label">Requirements</span>
                        <span class="sf-meta-val">{{ $saleFormat->requirements->count() }}</span>
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
            <table class="table mb-0" style="font-size:.87rem">
                <thead>
                    <tr style="background:#f8fafc">
                        <th style="width:44px;color:#64748b;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;padding:10px 14px">#</th>
                        <th style="color:#64748b;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;padding:10px 14px">Application</th>
                        <th style="color:#64748b;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;padding:10px 14px">Model</th>
                        <th style="color:#64748b;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;padding:10px 14px">Output</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saleFormat->sale_details as $i => $detail)
                    <tr style="border-bottom:1px solid #f1f5f9">
                        <td style="color:#94a3b8;padding:10px 14px;text-align:center">{{ $i + 1 }}</td>
                        <td style="padding:10px 14px;font-weight:500">{{ $detail['application'] ?? '—' }}</td>
                        <td style="padding:10px 14px">{{ $detail['model'] ?? '—' }}</td>
                        <td style="padding:10px 14px">{{ $detail['output'] ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
            @foreach($saleFormat->requirements as $req)
            <div style="display:flex;align-items:baseline;gap:12px;padding:10px 16px;border-bottom:1px solid #f1f5f9;font-size:.87rem">
                <span style="min-width:22px;color:#94a3b8;font-size:.78rem;font-weight:600;text-align:right;flex-shrink:0">
                    {{ $req->sort_order }}.
                </span>
                <span style="color:#1e293b">{{ $req->requirement_description }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Uploaded Files ─────────────────────────────────────────────────────── --}}
    @php $uploadedFiles = array_filter((array)($saleFormat->upload_file_path ?? [])); @endphp
    @if(!empty($uploadedFiles))
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-paperclip"></i> Uploaded Files
                <span class="badge badge-secondary ml-1">{{ count($uploadedFiles) }}</span>
            </h3>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-wrap:wrap;gap:14px">
                @foreach($uploadedFiles as $filePath)
                @php $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)); @endphp
                <div style="display:flex;flex-direction:column;align-items:center;gap:6px;width:130px">
                    @if(in_array($ext, ['jpg','jpeg','png','gif','svg']))
                        <a href="{{ asset($filePath) }}" target="_blank">
                            <img src="{{ asset($filePath) }}" alt="file"
                                 style="width:130px;height:100px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;box-shadow:0 2px 6px rgba(0,0,0,.07)">
                        </a>
                        <span style="font-size:.72rem;color:#94a3b8;word-break:break-all;text-align:center">{{ basename($filePath) }}</span>
                    @else
                        <a href="{{ asset($filePath) }}" target="_blank"
                           style="display:flex;flex-direction:column;align-items:center;gap:6px;text-decoration:none">
                            <div style="width:130px;height:100px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1px solid #fecaca;background:#fff5f5">
                                <i class="fas fa-file-pdf" style="font-size:2.5rem;color:#dc2626"></i>
                            </div>
                            <span style="font-size:.72rem;color:#64748b;word-break:break-all;text-align:center">{{ basename($filePath) }}</span>
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ── Visiting Card (customer) ─────────────────────────────────────────── --}}
    @php $vcPath = $saleFormat->customer->visiting_card ?? null; @endphp
    @if($vcPath)
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-id-card"></i> Visiting Card</h3>
        </div>
        <div class="card-body text-center">
            <img src="{{ asset($vcPath) }}" alt="Visiting Card"
                 style="max-width:380px;width:100%;border-radius:8px;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,.08)">
        </div>
    </div>
    @endif

    {{-- ── Remark ───────────────────────────────────────────────────────────── --}}
    @if($saleFormat->remark)
    @php
        $inlineStyles = [
            'p'  => 'margin:0 0 4px 0;padding:0;line-height:1.7;font-size:.88rem;color:#334155;',
            'ul' => 'list-style-type:disc;margin:2px 0 5px 0;padding-left:18px;',
            'ol' => 'list-style-type:decimal;margin:2px 0 5px 0;padding-left:18px;',
            'li' => 'margin:2px 0;line-height:1.7;font-size:.88rem;color:#334155;',
            'h1' => 'font-size:1.1rem;font-weight:700;margin:5px 0 3px 0;padding:0;color:#1e293b;',
            'h2' => 'font-size:1rem;font-weight:700;margin:5px 0 3px 0;padding:0;color:#1e293b;',
            'h3' => 'font-size:.95rem;font-weight:700;margin:4px 0 2px 0;padding:0;color:#1e293b;',
        ];
        $remarkHtml = preg_replace_callback(
            '/<(p|ul|ol|li|h[123])\b([^>]*)>/i',
            function ($m) use ($inlineStyles) {
                $tag   = strtolower($m[1]);
                $attrs = $m[2];
                $add   = $inlineStyles[$tag] ?? '';
                if (preg_match('/style="([^"]*)"/i', $attrs, $sm)) {
                    $attrs = preg_replace('/style="[^"]*"/i', 'style="' . $sm[1] . ';' . $add . '"', $attrs);
                } else {
                    $attrs .= ' style="' . $add . '"';
                }
                return '<' . $tag . $attrs . '>';
            },
            $saleFormat->remark
        );
    @endphp
    <div class="crm-index-card mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-sticky-note"></i> Remark</h3>
        </div>
        <div class="card-body">
            {!! $remarkHtml !!}
        </div>
    </div>
    @endif

    {{-- ── Delete ───────────────────────────────────────────────────────────── --}}
    <div class="mb-4">
        <form action="{{ route('sale-formats.destroy', $saleFormat) }}" method="POST"
              class="d-inline" id="deleteForm">
            @csrf @method('DELETE')
            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="if(confirm('Yeh sale format permanently delete karna chahte hain?')) document.getElementById('deleteForm').submit()">
                <i class="fas fa-trash-alt"></i> Delete
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
            align-items: baseline;
            padding: 5px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: .85rem;
        }
        .sf-meta-row:last-child { border-bottom: none; }
        .sf-meta-label {
            color: #64748b;
            font-size: .78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .sf-meta-val {
            color: #1e293b;
            font-weight: 500;
        }
        /* Restore list styles inside Quill display — AdminLTE resets them */
        .ql-editor ul, .ql-editor ol {
            padding-left: 1.5em !important;
            margin-bottom: .5em !important;
        }
        .ql-editor ul > li { list-style-type: disc !important; }
        .ql-editor ol > li { list-style-type: decimal !important; }
        .ql-editor ul ul > li { list-style-type: circle !important; }
        .ql-editor ul ul ul > li { list-style-type: square !important; }
        @media print {
            .btn, nav, .alert, .content-header, .main-header,
            .main-sidebar, .main-footer { display: none !important; }
            .content-wrapper { margin-left: 0 !important; padding: 0 !important; }
            .crm-index-card { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
@endpush
