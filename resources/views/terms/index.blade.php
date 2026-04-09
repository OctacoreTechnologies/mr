@php
    $heads = [
        'SR.No',
        'Type',
        'Price',
        'Tax',
        'Delivery',
        'Payment',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 font-weight-bold">
        <i class="fas fa-file-contract text-primary"></i>
        Terms & Conditions
    </h1>

    {{-- Future Add Button --}}
    {{--
    <a href="{{ route('term-conditions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Term
    </a>
    --}}
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

<div class="card shadow border-0">

    <!-- HEADER -->
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-list"></i> Terms List
        </h3>

        <span class="badge badge-light">
            {{ count($termAndCondtions) }} Records
        </span>
    </div>

    <!-- BODY -->
    <div class="card-body">

        <div class="table-responsive">

            <x-adminlte-datatable 
                id="terms-table" 
                :heads="$heads" 
                striped 
                hoverable 
                bordered 
                compressed
                responsive
            >

                {{-- EMPTY STATE --}}
                @if($termAndCondtions->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No Terms & Conditions Found
                        </td>
                    </tr>
                @endif

                {{-- DATA --}}
                @foreach ($termAndCondtions as $key => $term)
                    <tr>
                        <td>{{ $key + 1 }}</td>

                        <td>
                            <span class="badge badge-info px-3 py-2">
                                {{ ucfirst($term->type) ?? 'N/A' }}
                            </span>
                        </td>

                        <td class="text-truncate" style="max-width:150px;">
                            {{ $term->price ?? '—' }}
                        </td>

                        <td class="text-truncate" style="max-width:150px;">
                            {{ $term->tax ?? '—' }}
                        </td>

                        <td class="text-truncate" style="max-width:150px;">
                            {{ $term->delivery ?? '—' }}
                        </td>

                        <td class="text-truncate" style="max-width:150px;">
                            {{ $term->payment ?? '—' }}
                        </td>

                        <!-- ACTIONS -->
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">

                                <a href="{{ route('term-conditions.edit', $term->id) }}"
                                   class="btn btn-outline-primary"
                                   title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                {{--
                                <form action="{{ route('term-conditions.destroy', $term->id) }}"
                                      method="POST" class="d-inline-block">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-outline-danger delete-term">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                --}}

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
<link rel="stylesheet"  href="{{ asset('style/commonindex.css') }}">
<style>

.card {
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0;
    padding: 12px 16px;
}

.card-body {
    background-color: #f8fafc;
    border-radius: 0 0 10px 10px;
}

/* Table Styling */
.table th {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .05em;
}

.table td {
    vertical-align: middle;
    font-size: 13px;
}

/* Hover */
.table tbody tr:hover {
    background-color: #eef2ff;
}

/* Buttons */
.btn-outline-primary,
.btn-outline-danger {
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 12px;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    color: #fff;
}

/* Badge */
.badge-info {
    background: #3b82f6;
    color: white;
}

/* Truncate text */
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>
@endpush