@php
    $heads = [
        ['label' => 'SR NO', 'width' => '7%'],
        'Name',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];
    $n = 1;
@endphp

@extends('layouts.app')

@section('title', 'Ac Frequency Drive')

@section('content_header')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h1 class="mb-2 mb-md-0">Ac Frequency Drive</h1>
        <div class="d-flex flex-wrap gap-2">
            {{-- Primary Add Button --}}
            <x-adminlte-button label="Add Ac Frequency Drive" theme="success" icon="fas fa-plus" data-toggle="modal" data-target="#modalMin"/>

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
        <h3 class="card-title">Ac Frequency Drive</h3>
        {{-- <span class="badge badge-success">{{ count($machineTypes) }} Records</span> --}}
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable bordered compressed>
            @foreach ($acFrequencyDrives as $acFrequencyDrive)
                <tr>
                    <td>{{ $n++ }}</td>
                    <td>{{ $acFrequencyDrive->ac_fequency_drive ?? '' }}</td>
                    <td>
                        <nobr>
                            <a href="{{ route('ac-frequency-drive.edit', $acFrequencyDrive->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form action="{{ route('ac-frequency-drive.destroy', $acFrequencyDrive->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this machine type?')">
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
<a href="{{ route('ac-frequency-drive.index') }}" class="btn btn-outline-primary mt-3">
    <i class="fas fa-arrow-left mr-1"></i> Back to Ac Frequency Drive
</a>

{{-- Modal for Add --}}
<x-adminlte-modal id="modalMin" title="Add Ac Frequency Drives" theme="teal" icon="fas fa-plus">
    <form method="POST" action="{{ route('ac-frequency-drive.store') }}">
        @csrf
        <x-adminlte-input name="ac_fequency_drive" label="Ac Frequency Drive" placeholder="Enter Ac Frequency Drive" fgroup-class="mb-3" required/>
        <div class="d-flex justify-content-end">
            <x-adminlte-button label="Cancel" theme="outline-danger" data-dismiss="modal" class="mr-2"/>
            <x-adminlte-button label="Submit" type="submit" theme="primary"/>
        </div>
    </form>
</x-adminlte-modal>

@stop
@push('css')
<link rel="stylesheet" href="{{ asset('style/category.css') }}" />
@endpush

