@extends('layouts.app')

@section('title', 'Edit Sale Format #' . $saleFormat->id)

@section('content_header')
<div style="display:flex;align-items:center;justify-content:space-between;padding:0.5rem 0;flex-wrap:wrap;gap:8px">
    <h1 style="font-size:20px;font-weight:600;display:flex;align-items:center;gap:10px;margin:0;color:#1e293b">
        <i class="fas fa-edit" style="color:#2563eb"></i>
        Edit Sale Format
        <span style="color:#64748b;font-weight:400">#{{ $saleFormat->id }}</span>
    </h1>
    <div style="display:flex;gap:8px">
        <a href="{{ route('sale-formats.show', $saleFormat) }}"
           style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #bfdbfe;background:#eff6ff;color:#2563eb;text-decoration:none">
            <i class="fas fa-eye"></i> View
        </a>
        <a href="{{ url()->previous() }}"
           style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #d1d5db;background:#fff;color:#6b7280;text-decoration:none">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

<form action="{{ route('sale-formats.update', $saleFormat) }}" method="POST" id="saleFormatForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('sale_formats._form')

    <div class="crm-form-actions">
        <button type="button" class="btn-cancel-crm"
                onclick="window.location='{{ url()->previous() }}'">
            Cancel
        </button>
        <button type="submit" class="btn-primary-crm">
            <i class="fas fa-save"></i> Update Sale Format
        </button>
    </div>

</form>

@endsection
