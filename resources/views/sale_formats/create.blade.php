@extends('layouts.app')

@section('title', 'New Sale Format')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice"></i> New Sale Format
    </h1>
    <a href="{{ route('sale-formats.index') }}"
       style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #d1d5db;background:#fff;color:#6b7280;text-decoration:none">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

<form action="{{ route('sale-formats.store') }}" method="POST" id="saleFormatForm" enctype="multipart/form-data">
    @csrf

    @include('sale_formats._form')

    <div class="crm-form-actions">
        <button type="submit" class="btn-primary-crm">
            <i class="fas fa-save"></i> Save Sale Format
        </button>
        <button type="button" class="btn-cancel-crm" onclick="window.history.back()">
            Cancel
        </button>
    </div>
</form>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/customer.css') }}">
@endpush
