@php
    $heads = [
        '#',
        'Role',
        'Permissions',
        'Created',
        ['label' => 'Actions', 'no-export' => true, 'width' => 8],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Roles')

@section('content_header')
<div class="crm-header">
    <div>
        <h1>Role Management</h1>
        <p class="crm-subtitle">Manage user roles and permissions</p>
    </div>

    <a href="{{ route('admin.role.create') }}" class="btn btn-primary crm-add-btn">
        <i class="fas fa-plus"></i> Add Role
    </a>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="crm-card">

    {{-- TOP BAR --}}
    <div class="crm-card-header">
        <div class="crm-title">
            Roles
            <span class="crm-count">{{ $roles->total() }}</span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="crm-table-wrap">

        <x-adminlte-datatable id="roleTable" :heads="$heads" striped hoverable responsive>

            @foreach ($roles as $role)
                <tr>

                    {{-- INDEX --}}
                    <td class="text-muted">{{ $loop->iteration }}</td>

                    {{-- ROLE NAME --}}
                    <td>
                        <div class="crm-role">
                            <div class="crm-role-name">{{ $role->name }}</div>
                        </div>
                    </td>

                    {{-- PERMISSIONS --}}
                    <td>
                        @php
                            $perms = $role->permissions->pluck('name');
                        @endphp

                        @if($perms->count())
                            <div class="crm-permission">
                                {{ $perms->take(2)->implode(', ') }}

                                @if($perms->count() > 2)
                                    <span class="crm-more"
                                        title="{{ $perms->implode(', ') }}">
                                        +{{ $perms->count() - 2 }} more
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="text-muted">No permissions</span>
                        @endif
                    </td>

                    {{-- DATE --}}
                    <td class="crm-date">
                        {{ \Carbon\Carbon::parse($role->created_at)->format('d M Y') }}
                    </td>

                    {{-- ACTIONS --}}
                    <td>
                        <div class="crm-actions">

                            <a href="{{ route('admin.role.show', $role->id) }}"
                               class="crm-btn"
                               title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.role.edit', $role->id) }}"
                               class="crm-btn"
                               title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.role.destroy', $role->id) }}"
                                  onsubmit="return confirm('Delete this role?')">
                                @csrf
                                @method('DELETE')

                                <button class="crm-btn crm-btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
            @endforeach

        </x-adminlte-datatable>

    </div>

    {{-- PAGINATION --}}
    <div class="crm-pagination">
        {{ $roles->links() }}
    </div>

</div>

@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <style>
   /* HEADER */
.crm-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.crm-header h1 {
    font-size: 1.4rem;
    font-weight: 600;
    margin: 0;
}

.crm-subtitle {
    font-size: 0.8rem;
    color: #6b7280;
}

/* ADD BUTTON */
.crm-add-btn {
    font-size: 0.8rem;
    padding: 6px 14px;
    border-radius: 6px;
}

/* CARD */
.crm-card {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #eef2f7;
    overflow: hidden;
}

/* HEADER */
.crm-card-header {
    padding: 12px 16px;
    border-bottom: 1px solid #f1f5f9;
}

.crm-title {
    font-weight: 600;
    font-size: 0.95rem;
}

.crm-count {
    background: #eef2ff;
    color: #4f46e5;
    font-size: 0.7rem;
    padding: 2px 7px;
    border-radius: 10px;
    margin-left: 6px;
}

/* TABLE WRAP */
.crm-table-wrap {
    padding: 5px 10px;
}

/* ROLE NAME */
.crm-role-name {
    font-weight: 600;
    font-size: 0.9rem;
}

/* PERMISSIONS */
.crm-permission {
    font-size: 0.8rem;
    color: #374151;
}

.crm-more {
    background: #f1f5f9;
    padding: 2px 6px;
    border-radius: 8px;
    font-size: 0.7rem;
    margin-left: 5px;
    cursor: pointer;
}

/* DATE */
.crm-date {
    font-size: 0.8rem;
    color: #6b7280;
}

/* ACTIONS */
.crm-actions {
    display: flex;
    gap: 6px;
}

/* BUTTON */
.crm-btn {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
    font-size: 0.75rem;
}

.crm-btn:hover {
    background: #111827;
    color: #fff;
}

/* DELETE */
.crm-btn-danger:hover {
    background: #dc2626;
    color: #fff;
    border-color: #dc2626;
}

/* PAGINATION */
.crm-pagination {
    padding: 12px;
    border-top: 1px solid #f1f5f9;
}

/* TABLE FIX */
.table td {
    vertical-align: middle;
    padding: 10px 12px !important;
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