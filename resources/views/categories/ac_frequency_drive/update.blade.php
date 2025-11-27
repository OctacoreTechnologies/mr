{{-- resources/views/term_conditions/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit AC Frequency Drive')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form  action="{{ route('ac-frequency-drive.update', $acFrequencyDrive->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input type="text" name="ac_fequency_drive" value="{{$acFrequencyDrive->ac_fequency_drive}}" label="Mixing Tool" fgroup-class="mb-3" required />
                    </div>
                                    <!-- Submit and Cancel Buttons -->
                    <div class="col-md-12">
                        <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2 my-2" />
                        <button type="button" class="btn btn-danger my-2" onclick="window.location.href={{ route('ac-frequency-drive.index') }}">Cancel</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
@stop
