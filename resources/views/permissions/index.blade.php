@php
    $heads = [
        'ID',
        'Permission Name',
        'Created Date',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Permissions')

@section('content_header')
<div class="crm-header">
    <div>
        <h1><i class="fas fa-lock"></i> Permissions</h1>
        <p>Manage system access permissions</p>
    </div>

    {{-- Future Add Button --}}
    {{-- 
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Permission
    </a> 
    --}}
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="crm-card">

    {{-- CARD HEADER --}}
    <div class="crm-card-header">
        <div>
            <h3><i class="fas fa-key"></i> Permission List</h3>
            <span class="crm-count">{{ count($permissions) }} Total</span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="crm-table-wrapper">

        @if($permissions->isEmpty())
            <div class="crm-empty">
                <i class="fas fa-folder-open"></i>
                <p>No permissions found</p>
            </div>
        @else

        <x-adminlte-datatable
            id="permissionsTable"
            :heads="$heads"
            striped
            hoverable
            responsive
        >

            @foreach ($permissions as $permission)
                <tr>

                    <td>
                        <span class="crm-id">#{{ $permission->id }}</span>
                    </td>

                    <td>
                        <span class="crm-title">
                            {{ $permission->name }}
                        </span>
                    </td>

                    <td>
                        <span class="crm-date">
                            <i class="fas fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($permission->created_at)->format('d M Y') }}
                        </span>
                    </td>

                    <td>
                        <div class="crm-actions">

                            {{-- OPTIONAL ACTIONS --}}
                            {{-- 
                            <a href="{{ route('admin.permission.edit', $permission->id) }}"
                               class="btn-action edit">
                                <i class="fas fa-pen"></i>
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.permission.destroy', $permission->id) }}"
                                  onsubmit="return confirm('Delete this permission?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn-action delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            --}}

                            <span class="text-muted small">No Actions</span>

                        </div>
                    </td>

                </tr>
            @endforeach

        </x-adminlte-datatable>

        @endif

    </div>

</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
<style>

/* ===== HEADER ===== */
.crm-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.crm-header h1 {
    font-size: 22px;
    font-weight: 600;
    margin: 0;
}

.crm-header p {
    margin: 0;
    font-size: 13px;
    color: #6c757d;
}

/* ===== CARD ===== */
.crm-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
    overflow: hidden;
}

/* HEADER */
.crm-card-header {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}

.crm-card-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.crm-count {
    font-size: 12px;
    color: #888;
}

/* TABLE */
.crm-table-wrapper {
    padding: 15px;
}

/* ID */
.crm-id {
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
}

/* TITLE */
.crm-title {
    font-weight: 500;
}

/* DATE */
.crm-date {
    font-size: 13px;
    color: #555;
}

.crm-date i {
    margin-right: 5px;
    color: #0d6efd;
}

/* ACTIONS */
.crm-actions {
    display: flex;
    gap: 6px;
}

.btn-action {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    font-size: 13px;
    transition: 0.2s;
}

.btn-action.edit {
    background: #e3f2fd;
    color: #0d6efd;
}

.btn-action.delete {
    background: #fdecea;
    color: #dc3545;
}

.btn-action:hover {
    transform: scale(1.1);
}

/* EMPTY */
.crm-empty {
    text-align: center;
    padding: 40px 0;
    color: #999;
}

.crm-empty i {
    font-size: 40px;
    margin-bottom: 10px;
}

</style>
@endpush