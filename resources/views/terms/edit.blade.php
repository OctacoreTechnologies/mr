{{-- resources/views/term_conditions/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Term Condition')

@section('content_header')
    <h1>Edit Term Condition</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="termConditionForm" action="{{ route('term-conditions.update', $termCondition->id) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $fields = [
                        'price', 'tax', 'delivery', 'payment', 'packing', 'forwarding',
                        'validity', 'commissioning_charges', 'guarantee',
                        'cancellation_of_order', 'judiciary', 'not_in_our_scope_of_supply'
                    ];
                @endphp

                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-warning" id="editBtn">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button type="submit" class="btn btn-primary ml-2" id="saveBtn" style="display: none;">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>

                @foreach ($fields as $field)
                    <div class="form-group">
                        <label for="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        <textarea name="{{ $field }}" id="{{ $field }}" class="form-control" readonly>{{ old($field, $termCondition->$field) }}</textarea>
                    </div>
                @endforeach

            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.getElementById('editBtn').addEventListener('click', function () {
            const form = document.getElementById('termConditionForm');
            const fields = form.querySelectorAll('textarea');

            fields.forEach(field => {
                field.removeAttribute('readonly');
            });

            this.style.display = 'none'; // hide Edit button
            document.getElementById('saveBtn').style.display = 'inline-block'; // show Save button
        });
    </script>
@stop
