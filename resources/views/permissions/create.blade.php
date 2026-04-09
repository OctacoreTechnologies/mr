@extends('layouts.app')

@section('title', 'Create Permission')

@section('content_header')
<div class="crm-header">
    <div>
        <h1>Create Permission</h1>
        <p class="crm-subtitle">Add a new permission</p>
    </div>
</div>
@stop

@section('content')

<x-alert-components />

<form action="{{ route('admin.permission.store') }}" method="POST">
@csrf

<div class="crm-card">

    {{-- PERMISSION INFO --}}
    <div class="crm-section">
        <h3 class="crm-section-title">Permission Details</h3>

        <div class="row">
            <div class="col-md-6">

                <label class="crm-label">Permission Name</label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-control crm-input"
                       placeholder="e.g. quotation_view"
                       required>

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <small class="text-muted d-block mt-1">
                    Use format: <strong>module_action</strong> (example: quotation_view)
                </small>

            </div>
        </div>
    </div>

    {{-- ACTIONS --}}
    <div class="crm-footer">
        <a href="{{ route('admin.permission.index') }}" class="btn btn-light">
            Cancel
        </a>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Permission
        </button>
    </div>

</div>

</form>

@stop

@push('css')
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

    function generatePermission() {
        let module = $('#module').val();
        let action = $('#action').val();

        if (module && action) {
            $('#permission_name').val(module + '_' + action);
        }
    }

    $('#module, #action').on('change', function () {
        generatePermission();
    });

});

</script>
@endpush