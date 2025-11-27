@php
    $heads = [
        'ID',
        'Permission Name',
        ['label' => 'Created Date', 'width' => 40],
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Permissions')

@section('content_header')
    <h1 class="text-muted">Permissions</h1>
@stop

@section('content')

    <x-alert-components class="mb-3" />

    {{-- Add Permission Button --}}
    <x-adminlte-button label="Add Permission" theme="success" icon="fas fa-plus" class="mb-3"
        data-toggle="modal" data-target="#modalAddPermission" />

    {{-- Add Permission Modal --}}
    <x-adminlte-modal id="modalAddPermission" title="Add Permission" size="lg" theme="success" icon="fas fa-key">
        <form method="POST" action="{{ route('admin.permission.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-input name="name" label="Permission Name" placeholder="Enter permission name"
                        value="{{ old('name') }}" fgroup-class="mb-3" disable-feedback />

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

    {{-- Permissions Table --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-lock mr-1"></i> Permission List</h3>
        </div>

        <div class="card-body">
            <x-adminlte-datatable id="permissionsTable" :heads="$heads" striped hoverable bordered compressed>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                        <td>
                            <nobr>
                                <a href="{{ route('admin.permission.edit', $permission->id) }}"
                                   class="btn btn-xs btn-info mx-1 shadow" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.permission.destroy', $permission->id) }}"
                                      class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger mx-1 shadow" type="submit" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </nobr>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>

            {{-- Pagination --}}
         {{-- <div class="mt-3">
                {{ $permissions->links() }}
            </div>--}}
        </div>
    </div>

@stop

@push('css')
<style>
    .card-title {
        font-weight: 600;
        font-size: 1.2rem;
    }

    .modal-content {
        border-radius: 0.5rem;
    }

    .btn-xs i {
        font-size: 0.8rem;
    }
</style>
@endpush

@push('js')
    {{-- Optional: Add JavaScript here if needed --}}
@endpush
