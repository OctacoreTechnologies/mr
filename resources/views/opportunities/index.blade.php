@php
    $heads = [
        'Sr.No',
        'Name',
        'Date',
        'Stage',
        'Type',
        ['label' => 'Actions', 'no-export' => true,],
    ];
    $i=1;
@endphp

@extends('layouts.app')

@section('title', 'Opportunities')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-briefcase"></i> Opportunity List</h1>
        <a href="{{ route('opportunity.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Create Opportunity
        </a>
    </div>
@stop

@section('content')
    <x-alert-components class="my-2" />

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-list-alt"></i> All Opportunities</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <x-adminlte-datatable id="opportunityTable" :heads="$heads" striped hoverable with-buttons>
                    @foreach ($opportunities as $opportunity)
                        <tr>
                            <td class="sr-no">{{$i++ }}</td>
                            <td>{{ $opportunity->name ?? '—' }}</td>
                            <td>{{ $opportunity->created_at ?? '—' }}</td>
                            <td>{{ $opportunity->stage ??'—' }}</td>
                            <td>{{ $opportunity->opportunity_type ??'—' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    {{-- Edit --}}
                                    <a href="{{ route('opportunity.edit', $opportunity->id) }}"
                                        class="btn btn-default text-primary shadow" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('opportunity.destroy', $opportunity->id) }}"
                                        method="POST" class="d-inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this opportunity?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-default text-danger shadow" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    {{-- View --}}
                                    <a href="{{ route('opportunity.show', $opportunity->id) }}"
                                        class="btn btn-default text-teal shadow" title="Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>
@stop

@push('css')
<!-- <link rel="stylesheet"  href="{{asset('style/customer.css')}}"> -->
@endpush