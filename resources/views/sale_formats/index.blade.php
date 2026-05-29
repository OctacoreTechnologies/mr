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

{{-- ── Filters ────────────────────────────────────────────────────────────── --}}
@if(!isset($customer))
<div class="crm-index-card mb-3">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter"></i> Filters</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('sale-formats.index') }}">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="crm-field-label">Customer</label>
                    <select name="customer_id" class="crm-select">
                        <option value="">— All Customers —</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ request('customer_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="crm-field-label">Status</label>
                    <select name="status" class="crm-select">
                        <option value="">— All Status —</option>
                        <option value="draft"    {{ request('status') == 'draft'    ? 'selected' : '' }}>Draft</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('sale-formats.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ── Table ─────────────────────────────────────────────────────────────── --}}
<div class="crm-index-card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list"></i> Sale Format List</h3>
        <div class="card-tools">
            <span class="badge badge-light text-dark">
                {{ $saleFormats->total() }} records
            </span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="saleFormatsTable">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Application</th>
                        <th>Model</th>
                        <th>Requirements</th>
                        <th>Prepared By</th>
                        <th>Status</th>
                        <th class="text-center" style="width:130px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($saleFormats as $sf)
                    <tr>
                        <td class="text-muted small">{{ $sf->id }}</td>
                        <td>
                            <a href="{{ route('customers.sale-formats.index', $sf->customer_id) }}"
                               class="font-weight-600 text-primary text-decoration-none">
                                {{ $sf->customer->company_name ?? '—' }}
                            </a>
                        </td>
                        <td>{{ $sf->sale_date->format('d-m-Y') }}</td>
                        <td>{{ $sf->application ?? '—' }}</td>
                        <td>{{ $sf->model ?? '—' }}</td>
                        <td class="text-center">
                            @php $reqCount = $sf->requirements_count ?? $sf->requirements->count(); @endphp
                            @if($reqCount > 0)
                                <span class="badge badge-info">{{ $reqCount }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $sf->prepared_by ?? '—' }}</td>
                        <td>
                            @php
                                $badge = match($sf->status) {
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    default    => 'warning',
                                };
                            @endphp
                            <span class="badge badge-{{ $badge }} text-capitalize">{{ $sf->status }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('sale-formats.show', $sf) }}"
                                   class="btn text-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('sale-formats.edit', $sf) }}"
                                   class="btn text-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('sale-formats.destroy', $sf) }}" method="POST"
                                      class="d-inline" id="del-{{ $sf->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            class="btn text-danger"
                                            title="Delete"
                                            onclick="confirmDelete({{ $sf->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                            Koi sale format nahi mila.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($saleFormats->hasPages())
    <div class="card-footer">
        {{ $saleFormats->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
@endpush

@push('js')
<script>
function confirmDelete(id) {
    if (confirm('Yeh sale format delete karna chahte hain?')) {
        document.getElementById('del-' + id).submit();
    }
}
</script>
@endpush
