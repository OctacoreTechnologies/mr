@php
    $heads = [
        'Sr.No',
        'Customer',
        'Date',
        'Requirements',
        'Prepared By',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
    $i = 0;
@endphp

@extends('layouts.app')

@section('title', 'Sale Formats')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice"></i>
        @isset($customer)
            <span class="text-muted" style="font-weight:400">{{ $customer->company_name }}</span>
            <span class="text-muted mx-1" style="font-weight:300">/</span>
        @endisset
        Sale Formats
    </h1>
    <a href="{{ route('sale-formats.create', isset($customer) ? ['customer_id' => $customer->id] : []) }}"
       class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> New Sale Format
    </a>
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

<div class="crm-index-card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list"></i> Sale Format List</h3>
        <div class="card-tools">
            <span class="badge badge-light text-dark" style="font-size:.75rem">
                {{ $saleFormats->count() }} records
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <x-adminlte-datatable id="saleFormatsTable" :heads="$heads" striped hoverable with-buttons>
                @foreach($saleFormats as $sf)
                @php
                    $firstDetail = collect($sf->sale_details ?? [])->first();
                 
                

                    $words    = preg_split('/\s+/', trim($sf->customer->company_name ?? ''));
                    $initials = strtoupper(
                        substr($words[0] ?? '', 0, 1) .
                        (isset($words[1]) ? substr($words[1], 0, 1) : '')
                    );
                    $colors = ['#3b82f6','#0ea5e9','#10b981','#f59e0b','#8b5cf6','#ec4899','#06b6d4','#84cc16'];
                    $bg     = $colors[$i % count($colors)];
                @endphp
                <tr>
                    {{-- Sr No --}}
                    <td class="sr-no">{{ ++$i }}</td>

                    {{-- Customer --}}
                    <td style="min-width:170px;max-width:220px">
                        <a href="#"
                           class="text-decoration-none"
                           style="display:flex;align-items:center;gap:9px">
                            <div style="width:30px;height:30px;border-radius:7px;background:{{ $bg }};
                                        color:#fff;font-size:.68rem;font-weight:700;flex-shrink:0;
                                        display:flex;align-items:center;justify-content:center">
                                {{ $initials }}
                            </div>
                            <span style="font-weight:600;color:#1e293b;overflow:hidden;
                                         white-space:nowrap;text-overflow:ellipsis;display:block;max-width:160px"
                                  title="{{ $sf->customer->company_name ?? '' }}">
                                {{ $sf->customer->company_name ?? '—' }}
                            </span>
                        </a>
                    </td>

                    {{-- Date --}}
                    <td style="white-space:nowrap;font-size:.84rem;color:#64748b">
                        {{ $sf->sale_date->format('d M Y') }}
                    </td>

               


                    {{-- Requirements --}}
                    <td style="min-width:200px;max-width:300px">
                        @if($sf->requirements->isNotEmpty())
                            <ol style="margin:0;padding-left:16px;font-size:.8rem;color:#334155;line-height:1.6">
                                @foreach($sf->requirements->take(3) as $req)
                                    <li style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:260px"
                                        title="{{ $req->requirement_description }}">
                                        {{ $req->requirement_description }}
                                    </li>
                                @endforeach
                            </ol>
                            @if($sf->requirements_count > 3)
                                <span style="font-size:.72rem;color:#94a3b8;margin-left:16px">
                                    +{{ $sf->requirements_count - 3 }} more
                                </span>
                            @endif
                        @else
                            <span style="color:#cbd5e1;font-size:.82rem">—</span>
                        @endif
                    </td>

                    {{-- Prepared By --}}
                    <td style="max-width:140px">
                        <span style="display:block;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;font-size:.85rem"
                              title="{{ $sf->prepared_by }}">
                            {{ $sf->prepared_by ?? '—' }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('sale-formats.show', $sf) }}"
                               class="btn text-primary" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('sale-formats.pdf', $sf) }}" target="_blank"
                               class="btn text-danger" title="PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('sale-formats.edit', $sf) }}"
                               class="btn text-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('sale-formats.destroy', $sf) }}" method="POST"
                                  class="d-inline" id="del-{{ $sf->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn text-danger" title="Delete"
                                        onclick="confirmDelete({{ $sf->id }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
</div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
@endpush

@push('js')
<script>
function confirmDelete(id) {
    if (confirm('Do you really want to delete this sale format? This action cannot be undone.')) {
        document.getElementById('del-' + id).submit();
    }
}
</script>
@endpush
