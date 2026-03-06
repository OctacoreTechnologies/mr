{{-- resources/views/term_conditions/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Capacity')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('capacity.update', $capacity->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-select name="machine_id" label="Select Machine" id="machine_id">
                            <option disabled selected>Select Machine</option>
                            @foreach ($machines as $machine)
                                <option value="{{ $machine->id }}"
                                    {{ $machine->id === ($capacity->model->machine->id ?? null) ? 'selected' : '' }}>
                                    {{ $machine->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <label for="model" class="form-label font-weight-bold">Model</label>
                        <select id="model_id" name="model_id" class="form-control select2 form-control-lg"
                            style="width: 100%;" required>
                            <option value="{{ $capacity->model->id }}" selected>{{ $capacity->model->name ?? '' }}</option>

                        </select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input type="text" name="capacity" value="{{ $capacity->capacity }}" label="Capacity"
                            fgroup-class="mb-3" required />
                    </div>
                    <div class="col-md-12">
                        <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2 my-2" />
                        <button type="button" class="btn btn-danger my-2"
                            onclick="window.location.href='{{ route('capacity.index') }}'">Cancel</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop
@push('js')
    <script src="{{ asset('js/selection.js') }}"></script>
@endpush
