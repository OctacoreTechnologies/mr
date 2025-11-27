@extends('layouts.app')

@section('title', 'Create Mail')

@section('content_header')
    <h1 class="text-muted">Create New Mail</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">
                <i class="fas fa-Mail-alt mr-2"></i> Mail Information
            </h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('mail.store') }}">
                @csrf

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
                                <option value="{{ $machine->id }}" {{ old('machine_id') == $machine->id ? 'selected' : '' }}>
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
                        </x-adminlte-select>
                        @error('application_id')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Subject --}}
                    <div class="col-md-12">
                        <x-adminlte-input 
                            name="subject" 
                            value="{{ old('subject') }}" 
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
                        >{{ old('message') }}</x-adminlte-textarea>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Mail
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('css')
    <style>
        .card-title {
            font-weight: 600;
            font-size: 1.2rem;
        }
    </style>
@endpush

@push('js')
    <script>
        $('#machine_id').on('change', function () {
            let machineId = $(this).val();
            let selectedText = $(this).find("option:selected").text();
            
        
            // $('#machine_label').text(`Select ${selectedText}`);

            if (machineId) {
                $.ajax({
                    url: '/categories/options/applications/' + machineId,
                    type: 'GET',
                    success: function (applications) {
                        $('#application_id').empty().append('<option value="">Select Application</option>');

                        $.each(applications, function (key, application) {
                            $('#application_id').append('<option value="' + application.id + '">' + application.name + '</option>');
                        });

                        // If you're using select2
                        $('#application_id').trigger('change');
                    }
                });
            } else {
                $('#application_id').empty().append('<option value="">Select Application</option>');
                // $('#machine_label').text('Select Machine');
                // $('#model_id').empty().append('<option value="">Select Model</option>');
            }

        });
    </script>
@endpush
