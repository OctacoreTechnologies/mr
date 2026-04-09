{{-- resources/views/term_conditions/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Term Condition')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 font-weight-bold">
        <i class="fas fa-file-contract text-primary"></i>
        Edit Term Condition
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

<div class="card shadow border-0">

    <!-- HEADER -->
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Term Details</h3>

        <div>
            <button type="button" class="btn btn-warning btn-sm" id="editBtn">
                <i class="fas fa-pen"></i> Edit
            </button>

            <button type="submit" form="termConditionForm"
                    class="btn btn-light btn-sm ml-2"
                    id="saveBtn"
                    style="display:none;">
                <i class="fas fa-save"></i> Save
            </button>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body">

        <form id="termConditionForm"
              action="{{ route('term-conditions.update', $termCondition->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            @php
                $fields = [
                    'price', 'tax', 'delivery', 'payment',
                    'packing', 'forwarding', 'validity',
                    'commissioning_charges', 'guarantee',
                    'cancellation_of_order', 'judiciary',
                    'not_in_our_scope_of_supply'
                ];
            @endphp

            <div class="row">

                @foreach ($fields as $field)
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-muted">
                            {{ ucwords(str_replace('_', ' ', $field)) }}
                        </label>

                        <textarea
                            name="{{ $field }}"
                            class="form-control term-field"
                            rows="3"
                            readonly
                        >{{ old($field, $termCondition->$field) }}</textarea>
                    </div>
                @endforeach

            </div>

        </form>

    </div>
</div>

@stop

@push('css')
<link rel="stylesheet"  href="{{ asset('style/common.css') }}">
<style>

/* Card */
.card {
    border-radius: 10px;
}

/* Header */
.card-header {
    border-radius: 10px 10px 0 0;
    padding: 12px 16px;
}

/* Body */
.card-body {
    background: #f8fafc;
    border-radius: 0 0 10px 10px;
}

/* Textarea */
.term-field {
    border-radius: 8px;
    font-size: 13px;
    resize: vertical;
    transition: all .2s ease;
}

/* Readonly style */
.term-field[readonly] {
    background-color: #f1f5f9;
    cursor: not-allowed;
}

/* Editable focus */
.term-field:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37,99,235,.15);
}

/* Buttons */
.btn-warning {
    border-radius: 20px;
}

.btn-light {
    border-radius: 20px;
}

</style>
@endpush

@push('js')
<script>

document.getElementById('editBtn').addEventListener('click', function () {

    const fields = document.querySelectorAll('.term-field');

    fields.forEach(field => {
        field.removeAttribute('readonly');
    });

    // Toggle buttons
    this.style.display = 'none';
    document.getElementById('saveBtn').style.display = 'inline-block';

});

</script>
@endpush