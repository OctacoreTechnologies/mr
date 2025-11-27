@extends('layouts.app')

@section('title', 'Added Quotation')

@section('content_header')
<h1>Added Application</h1>
@stop

@section('content')
<div class="card">
    @if ($errors->any())
     {{ $errors }}
    @endif
    <div class="card-body">
        <form action="{{ route('product.store') }}" method="POST">
            @csrf
            @method("POST")
            <div class="row">

                <!-- <div class="col-md-6">
                    <x-adminlte-input type="text" name="code"  label="Enter Product code" value="{{ old('code')}}"/>
 
                </div> -->

                <div class="col-md-6">
                    <x-adminlte-input  name="name" label="Application Name" value="{{ old('name') }}"
                        placeholder="Enter Product Name" fgroup-class="mb-3" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input  name="price" label="Application Price" value="{{ old('price') }}"
                        placeholder="Enter Product Price" fgroup-class="mb-3" />
                </div>
                {{-- <div class="col-md-6">
                    <x-adminlte-input  name="model" label="Model" value="{{ old('model','140 Ltr') }}"
                        placeholder="Enter Model" fgroup-class="mb-3"  readonly/>
                </div> --}}
                
                <div class="col-md-6">
                    <x-adminlte-input  name="material_to_process" label="Material To Process" value="{{ old('material_to_process') }}"
                        placeholder="Material to process" fgroup-class="mb-3" />
                </div>
                <!-- <div class="col-md-6">
                <x-adminlte-input  name="mixing_tool" label="Mixing Total" value="{{ old('mixing_tool') }}"
                  placeholder="Mixing Total" fgroup-class="mb-3" /> 
                </div> -->

                <div class="col-md-6">
                    <x-adminlte-textarea name="motor_requirement" label="Motor Requirment"></x-adminlte-textarea>
                </div>
                
                <div class="col-md-6">
                    <x-adminlte-textarea name="description" label="Product Description" value="{{ old('description') }}"
                        fgroup-class="mb-3" />
                </div>
            </div>
    </div>

    <div class="m-2">
        <button type="submit" class="btn btn-primary">Added Application</button>
        <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
</div>
@stop