@extends('layouts.app')

@section('title', 'Edit Mail')

@section('content_header')
    <h1 class="text-muted">Edit Mail</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i> Edit Mail Information
            </h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('mail.update', $mail->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Machine Dropdown --}}
                    <div class="col-md-6">
                        <x-adminlte-select
                            name="machine_id"
                            label="Machine"
                            id="machine_id"
                            fgroup-class="mb-3"
                            data-placeholder="Select a machine"
                            required
                        >
                            <option></option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}" 
                                    {{ (old('machine_id', $mail->machine_id) == $machine->id) ? 'selected' : '' }}>
                                    {{ $machine->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select>
                        @error('machine_id')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Application Dropdown --}}
                    <div class="col-md-6">
                        <x-adminlte-select
                            name="application_id"
                            id="application_id"
                            label="Application"
                            fgroup-class="mb-3"
                            data-placeholder="Select an application"
                            required
                        >
                            <option></option>
                            @foreach($applications as $application)
                                <option value="{{ $application->id }}" 
                                    {{ (old('application_id', $mail->application_id) == $application->id) ? 'selected' : '' }}>
                                    {{ $application->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select>
                        @error('application_id')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Subject --}}
                    <div class="col-md-12">
                        <x-adminlte-input 
                            name="subject" 
                            value="{{ old('subject', $mail->subject) }}" 
                            label="Subject" 
                            placeholder="Enter subject"
                            fgroup-class="mb-3"
                            disable-feedback
                            required
                        />
                        @error('subject')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div class="col-md-12">
                        <x-adminlte-textarea 
                            name="messages" 
                            label="Message" 
                            rows=6 
                            placeholder="Describe your issue or request"
                            fgroup-class="mb-3"
                            disable-feedback
                            required
                        >{{ old('messages', $mail->messages) }}</x-adminlte-textarea>
                        @error('message')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('mail.index') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="fas fa-save"></i> Update Mail
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(document).ready(function () {
            // Populate application dropdown based on selected machine
            $('#machine_id').on('change', function () {
                let machineId = $(this).val();

                if (machineId) {
                    $.ajax({
                        url: '/categories/options/applications/' + machineId,
                        type: 'GET',
                        success: function (applications) {
                            $('#application_id').empty().append('<option value="">Select Application</option>');

                            $.each(applications, function (key, application) {
                                $('#application_id').append('<option value="' + application.id + '">' + application.name + '</option>');
                            });

                            $('#application_id').trigger('change');
                        }
                    });
                } else {
                    $('#application_id').empty().append('<option value="">Select Application</option>');
                }
            });

            // Trigger change if edit page has machine selected
            // let preselectedMachineId = $('#machine_id').val();
            // if (preselectedMachineId) {
            //     $('#machine_id').trigger('change');
            // }
        });
    </script>
@endpush
