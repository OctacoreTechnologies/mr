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
        <h1 class="mb-0 text-primart font-weight-bold">Terms & Conditions</h1>
       {{--<a href="{{ route('term-conditions.create') }}" class="btn btn-danger btn-md">
            <i class="fas fa-plus-circle"></i> Add Term
        </a>--}}
    </div>
@stop

@section('content')

    <x-alert-components class="my-3" />

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="fas fa-file-contract"></i> Terms & Conditions List</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <x-adminlte-datatable id="terms-table" :heads="$heads" striped hoverable bordered with-buttons>
                    @foreach ($termAndCondtions as $key => $term)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ ucfirst($term->type) ?? 'N/A' }}</td>
                            <td>{{ Str::limit($term->price, 20) }}</td>
                            <td>{{ Str::limit($term->tax, 20) }}</td>
                            <td>{{ Str::limit($term->delivery, 20) }}</td>
                            <td>{{ Str::limit($term->payment, 20) }}</td>
                            <td class="text-center">
                                <nobr>
                                    <a href="{{ route('term-conditions.edit', $term->id) }}" class="btn btn-sm btn-outline-primary mx-1 shadow" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                  {{--<form action="{{ route('term-conditions.destroy', $term->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-sm btn-outline-danger mx-1 shadow delete-term" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>--}}
                                </nobr>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>
        .card-header {
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            background-color: #f9f9f9;
            border-radius: 0 0 8px 8px;
        }
        .btn-outline-primary, .btn-outline-danger {
            font-size: 14px;
            padding: 6px 14px;
            border-radius: 25px;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
        .table th, .table td {
            padding: 15px;
            text-align: center;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .card-title {
            font-size: 1.1rem;
        }
    </style>
@endpush
