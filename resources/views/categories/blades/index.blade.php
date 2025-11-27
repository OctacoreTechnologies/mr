@php
    $heads = [
       ['label' => 'SR NO', 'width' => '7%'],
        'Machine',
        'Model',
        'No. of Blades',
        'Blade Type',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];
    $n = 1;
@endphp
@extends('layouts.app')

@section('title', 'Blades')

@section('content_header')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h1 class="mb-2 mb-md-0">Blades</h1>
        <div class="d-flex flex-wrap gap-2">
            {{-- Primary Add Button --}}
            <x-adminlte-button label="Add Blade" theme="success" icon="fas fa-plus" data-toggle="modal" data-target="#modalMin"/>

            {{-- Grouped Functional Buttons in Dropdown --}}
            <div class="btn-group">
                <x-adminlte-button label="Related Actions" theme="info" icon="fas fa-ellipsis-h" data-toggle="dropdown"/>
                  <x-categories-drop-down />
            </div>
        </div>
    </div>
@stop

@section('content')

{{-- Flash Message --}}
@if(session('success'))
    <x-adminlte-callout theme="success" title="Success">
        {{ session('success') }}
    </x-adminlte-callout>
@endif

{{-- Validation Alert --}}
@if ($errors->any())
    <x-adminlte-alert theme="danger" title="Validation Error" dismissable>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-adminlte-alert>
@endif

{{-- Card Table --}}
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Blades</h3>
        {{-- <span class="badge badge-success">{{ count($machineTypes) }} Records</span> --}}
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable bordered compressed>
            @foreach ($blades as $blade)
                <tr>
                    <td>{{ $n++ }}</td>
                    <td>{{ $blade->machine->name ?? '' }}</td>
                    <td>{{ $blade->model->name ?? '' }}</td>
                    <td>{{ $blade->no_of_blades }}</td>
                    <td>
                        @if($blade->type == 'rotating_blades')
                            <span class="badge badge-info">Rotating Blades</span>
                        @elseif($blade->type == 'fix_blades')
                            <span class="badge badge-warning">Fix Blades</span>
                        @else
                            <span class="badge badge-secondary">Unknown Type</span>
                        @endif
                    </td>
                    <td>
                        <nobr>
                            <a href="{{ route('blade.edit', $blade->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form action="{{ route('blade.destroy', $blade->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this blade?')">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </nobr>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</div>

{{-- Back Link --}}
<a href="{{ route('blade.index') }}" class="btn btn-outline-primary mt-3">
    <i class="fas fa-arrow-left mr-1"></i> Back to Machines
</a>

{{-- Modal for Add --}}
<x-adminlte-modal id="modalMin" title="Add Blade" theme="teal" icon="fas fa-plus">
    <form method="POST" action="{{ route('blade.store') }}">
        @csrf

        <div class="row">
            <div class="col-12">
                <x-adminlte-select name="machine_id" label="Select Machine" id="machine_id">
                    <option disabled selected>Select Machine</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                    @endforeach
                </x-adminlte-select> 
            </div>

            {{-- Model Select --}}
            <div class="col-12 mb-3">
                <label for="model" class="form-label font-weight-bold">Model</label>
                <select 
                    id="model_id" 
                    name="model_id" 
                    class="form-control select2 form-control-lg" 
                    style="width: 100%;" 
                    required
                >
                    <option disabled selected>Select Model</option>
                </select>
            </div>
            <x-adminlte-input 
                name="no_of_blades" 
                label="No of Blades"
                placeholder="Enter No of Blades" 
                fgroup-class="col-12 mb-3"
                required
             />
            <x-adminlte-select 
                name="type" 
                label="Select Blade Tyoe"
                fgroup-class="col-12 mb-3"
                required>
                <option disabled selected>Select Blade Type</option>
                <option value="rotating_blades">Rotating Blades</option>
                <option value="fix_blades">Fix Blades</option>
            </x-adminlte-select>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-end mt-3">
            <x-adminlte-button 
                label="Cancel" 
                theme="outline-danger" 
                data-dismiss="modal" 
                class="mr-2"
            />
            <x-adminlte-button 
                label="Submit" 
                type="submit" 
                theme="primary"
            />
        </div>
    </form>
</x-adminlte-modal>
@stop
@push('css')
<style>
    .gap-2 > * {
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@push('js')
<script src="{{ asset('js/selection.js') }}"></script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('style/category.css') }}" />
@endpush
