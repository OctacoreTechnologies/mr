@php
    $heads = [
        'ID',
        'Name',
        ['label' => 'Created Date', 'width' => 40],
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Clients')

@section('content_header')
    <h1 class="text-muted">Clients</h1>
@stop

@section('content')

    <x-alert-components class="my-3" />

    {{-- Add Client Button --}}
    <x-adminlte-button label="Add Client" theme="success" icon="fas fa-plus" class="mb-3" data-toggle="modal" data-target="#modalMin" />

    {{-- Add Client Modal --}}
    <x-adminlte-modal id="modalMin" title="Add Client" size="lg" theme="success" icon="fas fa-user-plus">
        <form method="POST" action="{{ route('permission.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-input name="name" label="Client Name" placeholder="Enter client name" value="{{ old('name') }}"
                        fgroup-class="mb-3" disable-feedback />

                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="text-right">
                <x-adminlte-button label="Cancel" data-dismiss="modal" theme="outline-danger" class="mr-2" />
                <x-adminlte-button label="Submit" type="submit" theme="primary" />
            </div>
        </form>
    </x-adminlte-modal>

    {{-- Clients Table --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-users mr-1"></i> Client List</h3>
        </div>

        <div class="card-body">
            <x-adminlte-datatable id="clientsTable" :heads="$heads" striped hoverable bordered compressed>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($client->created_at)->format('d M, Y') }}</td>
                        <td>
                            <nobr>
                                <a href="{{ route('client.edit', $client->id) }}" class="btn btn-xs btn-info mx-1 shadow" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <form action="{{ route('client.destroy', $client->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger mx-1 shadow" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <a href="{{ route('client.show', $client->id) }}" class="btn btn-xs btn-secondary mx-1 shadow" title="Details">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </nobr>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>

            {{-- Pagination --}}
            <div class="mt-3">
                <!-- {{ $clients->links() }} -->
            </div>
        </div>
    </div>
@stop

@push('css')
<style>
    .card-title {
        font-weight: 600;
    }

    .modal-content {
        border-radius: 0.5rem;
    }

    .btn-xs i {
        font-size: 0.8rem;
    }
</style>
@endpush
