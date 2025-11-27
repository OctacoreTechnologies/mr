@php
    $heads = [
        'ID',
        'Machine',
        'Application Name',
        'Application Price',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
    $n = 1;
@endphp

@extends('layouts.app')

@section('title', 'Products')

@section('content_header')
    <a href="{{ route('applications.create') }}" class="btn btn-primary btn-md"><i class="fas fa-plus-circle"></i> Create Application</a>
@stop

@section('content')
    <x-alert-components class="my-3" />
    
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-cogs"></i> Application Lists</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-adminlte-datatable id="table1" :heads="$heads">
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{ $product->machine->name }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <nobr>
                                    <!-- Edit Button -->
                                    <a href="{{ route('applications.edit', $product->id) }}" class="btn btn-sm btn-outline-primary mx-1 shadow" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Delete Button -->
                                    <form action="{{ route('applications.destroy', $product->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger mx-1 shadow delete-product" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <!-- View Details Button -->
                                    <a href="{{ route('applications.show', $product->id) }}" class="btn btn-sm btn-outline-teal mx-1 shadow" title="Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </nobr>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        // Add any JavaScript functionalities if needed
    });
</script>
@endpush

@section('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
    <style>
        .card-header {
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            background-color: #f9f9f9;
            border-radius: 0 0 8px 8px;
        }
        .btn-outline-primary, .btn-outline-danger, .btn-outline-teal {
            font-size: 14px;
            padding: 5px 12px;
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
        .btn-outline-teal:hover {
            background-color: #20c997;
            color: white;
        }
        .table th, .table td {
            padding: 15px;
            text-align: center;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
@stop
