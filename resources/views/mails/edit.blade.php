@extends('layouts.app')

@section('title', 'Edit Mail')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 text-primary font-weight-bold">
        <i class="fas fa-edit mr-2"></i> Edit Mail
    </h1>

    <a href="{{ route('mail.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="container-fluid">
    <div class="card shadow border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-envelope-open mr-2"></i> Update Mail Details
            </h5>
        </div>

        <form method="POST" action="{{ route('mail.update', $mail->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="row">

                    <!-- Machine -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Machine <span class="text-danger">*</span></label>

                            <select name="machine_id" id="machine_id"
                                class="form-control @error('machine_id') is-invalid @enderror" required>

                                <option value="">Select Machine</option>

                                @foreach($machines as $machine)
                                    <option value="{{ $machine->id }}"
                                        {{ old('machine_id', $mail->machine_id) == $machine->id ? 'selected' : '' }}>
                                        {{ $machine->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('machine_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Application -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Application <span class="text-danger">*</span></label>

                            <select name="application_id" id="application_id"
                                class="form-control @error('application_id') is-invalid @enderror" required>

                                <option value="">Select Application</option>

                                @foreach($applications as $application)
                                    <option value="{{ $application->id }}"
                                        {{ old('application_id', $mail->application_id) == $application->id ? 'selected' : '' }}>
                                        {{ $application->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('application_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Subject <span class="text-danger">*</span></label>

                            <input type="text"
                                name="subject"
                                class="form-control @error('subject') is-invalid @enderror"
                                value="{{ old('subject', $mail->subject) }}"
                                placeholder="Enter subject"
                                required>

                            @error('subject')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Message <span class="text-danger">*</span></label>

                            <textarea name="messages"
                                rows="6"
                                class="form-control @error('messages') is-invalid @enderror"
                                placeholder="Write your message..."
                                required>{{ old('messages', $mail->messages) }}</textarea>

                            @error('messages')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="card-footer justify-content-between">
                <a href="{{ route('mail.index') }}"
                   class="btn btn-outline-secondary rounded-pill px-4">
                    Cancel
                </a>

                <button type="submit"
                        class="btn btn-primary text-white rounded-pill px-4">
                    <i class="fas fa-save mr-1"></i> Update Mail
                </button>
            </div>

        </form>
    </div>
</div>

@endsection


@push('css')
<link rel="stylesheet" href="{{ asset('style/common.css') }}">
<style>

/* Card */
.card {
    border-radius: 10px;
}

/* Header */
.card-header {
    border-radius: 10px 10px 0 0;
}

/* Inputs */
.form-control {
    border-radius: 6px;
}

/* Focus */
.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 2px rgba(255,193,7,.2);
}

/* Buttons */
.btn-warning {
    border-radius: 20px;
}

.btn-outline-secondary {
    border-radius: 20px;
}
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

    $('#machine_id').on('change', function () {
        let machineId = $(this).val();

        if (machineId) {
            $.ajax({
                url: '/categories/options/applications/' + machineId,
                type: 'GET',
                success: function (applications) {

                    let appDropdown = $('#application_id');
                    appDropdown.empty().append('<option value="">Select Application</option>');

                    $.each(applications, function (key, application) {
                        appDropdown.append('<option value="' + application.id + '">' + application.name + '</option>');
                    });

                    appDropdown.trigger('change');
                }
            });
        } else {
            $('#application_id').empty().append('<option value="">Select Application</option>');
        }
    });

});
</script>
@endpush