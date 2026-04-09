@php
    $heads = [
        '#',
        'User',
        'Roles',
        'Email',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Users')

@section('content_header')
<div class="crm-header">

    <div>
        <h1>User Management</h1>
        <p class="crm-subtitle">Manage users, roles and access</p>
    </div>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary crm-add-btn">
        <i class="fas fa-user-plus"></i> Add User
    </a>

</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="crm-card">

    {{-- TOP BAR --}}
    <div class="crm-card-header">

        <div class="crm-left">
            <span class="crm-title">Users</span>
            <span class="crm-count">{{ $users->total() }}</span>
        </div>

        {{-- SEARCH --}}
        <div class="crm-search">
            <input type="text" id="tableSearch" placeholder="Search user...">
        </div>

    </div>

    {{-- TABLE --}}
    <div class="crm-table-wrap">

        @if($users->count() == 0)
            <div class="crm-empty">No users found</div>
        @else

        <x-adminlte-datatable id="userTable" :heads="$heads" striped hoverable responsive>

            @foreach ($users as $user)
                <tr>

                    {{-- INDEX --}}
                    <td class="text-muted">{{ $loop->iteration }}</td>

                    {{-- USER --}}
                    <td>
                        <div class="crm-user">
                            <div class="crm-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="crm-user-name">{{ $user->name }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- ROLES --}}
                    <td>
                        @php $roles = $user->roles->pluck('name'); @endphp

                        @if($roles->count())
                            <div class="crm-role-wrap">
                                @foreach($roles->take(2) as $role)
                                    <span class="crm-role-badge">{{ $role }}</span>
                                @endforeach

                                @if($roles->count() > 2)
                                    <span class="crm-role-more"
                                          title="{{ $roles->implode(', ') }}">
                                        +{{ $roles->count() - 2 }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="text-muted">No roles</span>
                        @endif
                    </td>

                    {{-- EMAIL (secondary now) --}}
                    <td class="crm-light-text">
                        {{ $user->email }}
                    </td>

                    {{-- ACTIONS --}}
                    <td>
                        <div class="crm-actions">

                            <a href="{{ route('admin.users.show', $user->id) }}"
                               class="crm-btn crm-view"
                               title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="crm-btn crm-edit"
                               title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')

                                <button class="crm-btn crm-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
            @endforeach

        </x-adminlte-datatable>

        @endif

    </div>

    {{-- PAGINATION --}}
    <div class="crm-pagination">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>

</div>

@stop
@push('css')
<link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
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
}

.crm-subtitle {
    font-size: 0.8rem;
    color: #6b7280;
}

/* CARD */
.crm-card {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #eef2f7;
}

/* TOP BAR */
.crm-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.crm-title {
    font-weight: 600;
}

.crm-count {
    background: #eef2ff;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.7rem;
    margin-left: 5px;
}

/* SEARCH */
.crm-search input {
    height: 32px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 0 10px;
    font-size: 0.8rem;
}

/* USER */
.crm-user {
    display: flex;
    align-items: center;
    gap: 10px;
}

.crm-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #4f46e5;
    color: #fff;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.crm-user-name {
    font-weight: 600;
    font-size: 0.9rem;
}

.crm-user-email {
    font-size: 0.75rem;
    color: #6b7280;
}

/* ROLES */
.crm-role-wrap {
    display: flex;
    gap: 5px;
}

.crm-role-badge {
    background: #eef2ff;
    color: #4f46e5;
    padding: 2px 6px;
    border-radius: 6px;
    font-size: 0.7rem;
}

.crm-role-more {
    font-size: 0.7rem;
    color: #6b7280;
}

/* TEXT */
.crm-light-text {
    font-size: 0.8rem;
    color: #6b7280;
}

/* ACTIONS */
.crm-actions {
    display: flex;
    gap: 6px;
}

.crm-btn {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    color: #fff;
}

.crm-view { background: #0ea5e9; }
.crm-edit { background: #6366f1; }
.crm-delete { background: #ef4444; }

.crm-btn:hover {
    opacity: 0.85;
}

/* EMPTY */
.crm-empty {
    padding: 20px;
    text-align: center;
    color: #6b7280;
}

/* PAGINATION */
.crm-pagination {
    padding: 12px;
    border-top: 1px solid #f1f5f9;
}
</style>
@endpush

@push('js')

<script>
$(document).ready(function () {

    $('#tableSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase();

        $('#userTable tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().includes(value));
        });
    });

});
</script>
@endpush