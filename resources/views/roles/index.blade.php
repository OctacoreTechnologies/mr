@php
    $heads = [
        'ID',
        'Role Name',
        'Permissions',
        'Created Date',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
    $i = 0;
@endphp

@extends('layouts.app')

@section('title', 'Roles')

@section('content_header')
    <h1 class="text-muted">Role Management</h1>
@stop

@section('content')

    <x-alert-components class="my-2" />

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-users-cog mr-2"></i> Role List</h3>
        </div>

        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable bordered compressed>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @if($role->permissions->isNotEmpty())
                                <span class="badge badge-info">
                                    {{ $role->permissions->pluck('name')->implode(', ') }}
                                </span>
                            @else
                                <span class="text-muted">No permissions</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}</td>
                        <td>
                            <nobr>
                                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.role.destroy', $role->id) }}" class="d-inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <a href="{{ route('admin.role.show', $role->id) }}" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </nobr>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>

@stop

@push('css')
<style>
    .card-title {
        font-weight: 600;
        font-size: 1.2rem;
    }
    .badge-info {
        font-size: 0.85rem;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function () {
        // You can add dynamic interactivity here if needed
    });
</script>
@endpush
