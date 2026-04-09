@extends('layouts.app')

@section('title', 'Create Mail')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 text-primary font-weight-bold">
        <i class="fas fa-paper-plane mr-2"></i> Create New Mail
    </h1>

    <a href="{{ route('mail.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="fas fa-arrow-left mr-1"></i> Back
    </a>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="card border-0 shadow-sm">

    <!-- HEADER -->
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-envelope text-primary mr-2"></i> Mail Information
        </h5>
    </div>

    <!-- BODY -->
    <div class="card-body p-4">

        <form method="POST" action="{{ route('mail.store') }}">
            @csrf

            <div class="row">

                <!-- Machine -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Machine <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-cogs text-primary"></i>
                            </span>

                            <select name="machine_id"
                                    id="machine_id"
                                    class="form-control select2"
                                    required>
                                <option value="">Select Machine</option>
                                @foreach($machines as $machine)
                                    <option value="{{ $machine->id }}"
                                        {{ old('machine_id') == $machine->id ? 'selected' : '' }}>
                                        {{ $machine->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @error('machine_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Application -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Application <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-layer-group text-primary"></i>
                            </span>

                            <select name="application_id"
                                    id="application_id"
                                    class="form-control select2"
                                    required>
                                <option value="">Select Application</option>
                            </select>
                        </div>

                        @error('application_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Subject -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Subject <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="subject"
                               value="{{ old('subject') }}"
                               class="form-control"
                               placeholder="Enter subject"
                               required>

                        @error('subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Message -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Message <span class="text-danger">*</span>
                        </label>

                        <textarea name="messages"
                                  rows="6"
                                  class="form-control"
                                  placeholder="Write your message here..."
                                  required>{{ old('message') }}</textarea>

                        @error('message')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="d-flex justify-content-end mt-4">

                <a href="{{ route('mail.index') }}"
                   class="btn btn-light border rounded-pill px-4 mr-2">
                    Cancel
                </a>

                <button type="submit"
                        class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-paper-plane mr-1"></i> Send Mail
                </button>

            </div>

        </form>

    </div>
</div>

@stop


@push('css')
<link rel="stylesheet" href="{{ asset('style/common.css') }}">
<style>

/* Card */
.card {
    border-radius: 12px;
}

/* Header */
.card-header {
    border-radius: 12px 12px 0 0;
}

/* Inputs */
.form-control {
    border-radius: 8px;
    height: 42px;
}

/* Textarea */
textarea.form-control {
    height: auto;
}

/* Input group */
.input-group-text {
    border-radius: 8px 0 0 8px;
}

/* Focus */
.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37,99,235,.15);
}

/* Buttons */
.btn-primary,
.btn-light {
    border-radius: 20px;
}

/* Labels */
label {
    display: inline-block !important;
}

label span {
    display: inline !important;
    margin-left: 3px;
}
</style>
@endpush


@push('js')
<script>
$(document).ready(function () {

    $('.select2').select2({
        width: '100%',
        placeholder: "Select option"
    });

    $('#machine_id').on('change', function () {
        let machineId = $(this).val();

        if (machineId) {
            $.ajax({
                url: '/categories/options/applications/' + machineId,
                type: 'GET',
                success: function (applications) {

                    $('#application_id')
                        .empty()
                        .append('<option value="">Select Application</option>');

                    $.each(applications, function (key, application) {
                        $('#application_id').append(
                            `<option value="${application.id}">${application.name}</option>`
                        );
                    });

                    $('#application_id').trigger('change');
                }
            });
        } else {
            $('#application_id')
                .empty()
                .append('<option value="">Select Application</option>');
        }
    });

});
</script>
@endpush