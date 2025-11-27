{{-- resources/views/term_conditions/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Term Condition')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form  action="{{ route('machine.update', $machine->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                      <label>Machine Type</label>
                       <select class="form-control js-example-basic-single" name="machine_type_id" single>
                           @foreach($machineTypes as $type)
                           <option value="{{$type->id}}" class="p-2" {{$type->name==$machine->machineType->name?'selected':''}}>{{$type->name}}</option>
                           @endforeach
                         
                       </select>
                    </div>

                   <div class="col-md-6">
                       <x-adminlte-input type="text" name="name" value="{{$machine->name}}" label="Machine Name"
                           fgroup-class="mb-3" required />
                   </div>
                   <div class="col-md-12">
                    <x-adminlte-input type="file" name="image_url" value="{{old('image_url')}}" label="Upload Machine Image"
                        fgroup-class="mb-3" required />
                </div>
                   <div class="col-md-12">
                     <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2 my-2" />
                     <x-adminlte-button label="cancel" type="cancel" theme="danger" class="my-2"/>
                   </div>
            </div>

            </form>
        </div>
    </div>
@stop

