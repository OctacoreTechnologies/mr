@extends('layouts.app')

@section('title', 'Create Role')

@section('content_header')
<div class="crm-header">
    <div>
        <h1>Create Role</h1>
        <p class="crm-subtitle">Define role and assign permissions</p>
    </div>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<form action="{{ route('admin.role.store') }}" method="POST">
@csrf

<div class="crm-card">

    {{-- ROLE INFO --}}
    <div class="crm-section">
        <h3 class="crm-section-title">Role Details</h3>

        <div class="row">
            <div class="col-md-6">
                <label class="crm-label">Role Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-control crm-input"
                       placeholder="Enter role name"
                       required>

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- PERMISSIONS --}}
    <div class="crm-section border-top">

        <div class="crm-section-header">
            <h3 class="crm-section-title">Permissions</h3>

            <div class="crm-permission-actions">
                <input type="text" id="permissionSearch"
                       class="form-control form-control-sm"
                       placeholder="Search permission...">

                <button type="button" class="btn btn-sm btn-light" id="selectAll">
                    Select All
                </button>

                <button type="button" class="btn btn-sm btn-light" id="unselectAll">
                    Clear
                </button>
            </div>
        </div>

        <div class="crm-permission-grid" id="permissionList">

            @foreach ($permissions as $permission)
                <label class="crm-permission-item">
                    <input type="checkbox"
                           name="permission[]"
                           value="{{ $permission->name }}"
                           class="crm-checkbox"
                           {{ in_array($permission->name, old('permission', [])) ? 'checked' : '' }}>

                    <span>{{ ucfirst($permission->name) }}</span>
                </label>
            @endforeach

        </div>

        @error('permission')
            <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    {{-- ACTIONS --}}
    <div class="crm-footer">
        <a href="{{ route('admin.role.index') }}" class="btn btn-light">
            Cancel
        </a>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Create Role
        </button>
    </div>

</div>

</form>

@stop
@push('css')
<link rel="stylesheet" href="{{ asset('style/common.css') }}">
<style>
.crm-header {
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
    overflow: hidden;
}

/* SECTION */
.crm-section {
    padding: 18px;
}

.crm-section-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 12px;
}

/* INPUT */
.crm-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
}

.crm-input {
    height: 38px;
    border-radius: 6px;
}

/* PERMISSION HEADER */
.crm-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.crm-permission-actions {
    display: flex;
    gap: 8px;
}

/* PERMISSION GRID */
.crm-permission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 10px;
    margin-top: 12px;
}

/* PERMISSION ITEM */
.crm-permission-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 10px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: #f9fafb;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.15s ease;
}

.crm-permission-item:hover {
    background: #eef2ff;
    border-color: #6366f1;
}

/* CHECKBOX */
.crm-checkbox {
    accent-color: #4f46e5;
}

/* FOOTER */
.crm-footer {
    padding: 15px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
</style>
@endpush

@push('js')
<script>
$(document).ready(function () {

    // Select All
    $('#selectAll').click(function () {
        $('.crm-checkbox').prop('checked', true);
    });

    // Unselect All
    $('#unselectAll').click(function () {
        $('.crm-checkbox').prop('checked', false);
    });

    // Search Filter
    $('#permissionSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase();

        $('#permissionList .crm-permission-item').filter(function () {
            $(this).toggle($(this).text().toLowerCase().includes(value));
        });
    });

});
</script>
@endpush
