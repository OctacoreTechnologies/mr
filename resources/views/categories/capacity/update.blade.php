{{-- resources/views/term_conditions/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Capacity')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form  action="{{ route('capacity.update', $capacity->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input type="text" name="capacity" value="{{$capacity->capacity}}" label="Capacity" fgroup-class="mb-3" required />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select class="select2" name="model_id" label="Model" fgroup-class="mb-3" required>
                            <option value="">Select Model</option>
                            @foreach($models as $model)
                                <option value="{{ $model->id }}" {{ $capacity->model_id == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-12">
                        <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2 my-2" />
                        <button type="button" class="btn btn-danger my-2" onclick="window.location.href='{{ route('batch.index') }}'">Cancel</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
@stop
