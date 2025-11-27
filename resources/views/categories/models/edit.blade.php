{{-- resources/views/term_conditions/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit ')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form  action="{{ route('model.update', $model->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input type="text" name="name" value="{{$model->name}}" label="Model" fgroup-class="mb-3" required />
                    </div>
                    <div class="col-md-6">
                         <x-adminlte-input type="text" name="production" value="{{ old('production',$model->production) }}" label="Actual(Production)" fgroup-class="mb-3" required />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select name="machine_id" class="select" label="Machine" fgroup-class="mb-3" required>
                            <option>Select Machine</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}" {{ $machine->id == $model->machine_id ? 'selected' : '' }}>
                                    {{ $machine->name }}
                                </option>
                            @endforeach
                       </x-adminlte-select>
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-select name="motor" class="select2" label="Motor Requirement" fgroup-class="mb-3" required>
                            <option>Select Motor Requirement</option>
                            @foreach($motorRequirements as $motorRequirement)
                                <option value="{{ $motorRequirement->motor_requirement }}" {{ $motorRequirement->id == $model->motor_id ? 'selected' : '' }}>
                                    {{ $motorRequirement->motor_requirement }}
                                </option>
                            @endforeach
                       </x-adminlte-select>
                    </div>
              
                <!-- Submit and Cancel Buttons -->
                    <div class="col-md-12">
                        <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2 my-2" />
                        <button type="button" class="btn btn-danger my-2" onclick="window.location.href='{{ route('machine-type.index') }}'">Cancel</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
@stop



