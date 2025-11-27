@php
    $heads = [
        'ID',
        'Name',
        'Email',
        'Type',
        'Phone',
        'FollowUp',
        ['label' => 'Actions', 'no-export' => false, ],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Leads')

@section('content_header')
    <a href="{{ route('lead.create') }}" class="btn btn-primary btn-md"><i class="fas fa-plus-circle"></i> Create Lead</a>
@stop

@section('content')
    <x-alert-components class="my-3" />
    
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-users"></i> Lead Lists</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
                    @foreach ($leads as $lead)
                        <tr class="{{$lead->status}}">
                            <td>{{$lead->id}}</td>
                            <td>{{$lead->full_name}}</td>
                            <td>{{$lead->email}}</td>
                            <td>{{ ucwords($lead->status) }}</td>
                            <td>{{$lead->phone}}</td>
                            <td>
                                <a class="btn btn-link text-info" href="{{ route('lead.followup.edit', $lead->id) }}" target="_blank"><i class="fas fa-calendar-check"></i> Follow Up</a>
                            </td>
                            <td>
                                <nobr>
                                    <!-- Edit Button -->
                                    <a href="{{ route('lead.edit', $lead->id) }}" class="btn btn-sm btn-outline-primary mx-1 shadow" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Delete Button -->
                                    <form action="{{ route('lead.destroy', $lead->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger mx-1 shadow delete-project" title="Delete" data-url="{{ route('lead.destroy', $lead->id) }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <!-- View Details Button -->
                                    <a href="{{ route('lead.show', $lead->id) }}" class="btn btn-sm btn-outline-teal mx-1 shadow" title="Details">
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

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush
