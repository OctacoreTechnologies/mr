{{-- resources/views/term_conditions/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Term Condition')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('material-to-process.update', $materialToProcess->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-select name="machine_id" label="Select Machine" id="machine_id">
                            <option disabled selected>Select Machine</option>
                            @foreach ($machines as $machine)
                                <option value="{{ $machine->id }}" {{$machine->id == $materialToProcess->model->machine->id?'selected':''}}>{{ $machine->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-6">
                        <label for="model" class="form-label font-weight-bold">Model</label>
                        <select id="model_id" name="model_id" class="form-control select2 form-control-lg"
                            style="width: 100%;" required>
                            <option disabled selected>{{$materialToProcess->model->name??''}}</option>

                        </select>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input type="text" name="material_to_process"
                            value="{{ $materialToProcess->material_to_process }}" label="Material To Process"
                            fgroup-class="mb-3" required />
                    </div>
                    <!-- Submit and Cancel Buttons -->
                    <div class="col-md-12">
                        <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2 my-2" />
                        <button type="button" class="btn btn-danger my-2"
                            onclick="window.location.href='{{ route('material-to-process.index') }}'">Cancel</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop
@push('js')
<script src="{{ asset('js/selection.js') }}"></script>
@endpush
