@php
    $heads = [
        ['label' => 'SR NO', 'width' => '7%'],
        'Name',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];
  $n=1;
@endphp

@extends('layouts.app')

@section('title', 'categories')

@section('content_header')
  <x-adminlte-button class="my-2" label="Add Machine" theme="success" data-toggle="modal" data-target="#modalMin"/>
@stop
    
@section('content')
<x-alert-components class="my-2" />
  
            <div class="card">
                <div class="card-header">
                   <h3 class="card-title">Machine Lists</h3>
            </div>
            <div class="card-body">
               <div class="row">
                   <div class="col-12 w-100">
                            <!--  -->
                            <!-- -- Minimal example / fill data using the component slot -- -->
                      <x-adminlte-datatable id="table1" :heads="$heads">

                        @foreach ($machines as $machine)
                         <tr>
                            <td>{{$n++}}</td>
                            <td>{{$machine->name??""}}</td>
                
                            <td>
                                 <nobr>
                                   <a href="{{route('machine.edit',$machine->id)}}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                     <i class="fa fa-lg fa-fw fa-pen"></i>
                                   </a>
                                     <form action="{{route('machine.destroy',$machine->id)}}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method("DELETE")
                                       <button class="btn btn-xs btn-default text-danger mx-1 shadow delete-quotation" title="Delete">
                                         <i class="fa fa-lg fa-fw fa-trash"></i>
                                       </button>
                                     </form>
                                 </nobr>
                            </td>
                          </tr>
                        @endforeach
                      </x-adminlte-datatable>

                    </div>
                     
                 </div>
  
                </div>
             </div>

             <x-adminlte-modal id="modalMin" title="Add Machine Type">
              <form method="post" action="{{route('machine.store')}}" enctype="multipart/form-data">
                @csrf
                @method("POST")
                  <div class="row">
                          <div class="col-md-12">
                            <label>Machine Type</label>
                             <select class="form-control js-example-basic-single" name="machine_type_id" single>
                                 @foreach($machineTypes as $type)
                                 <option value="{{$type->id}}" class="p-2">{{$type->name}}</option>
                                 @endforeach
                               
                             </select>
                          </div>
    
                         <div class="col-md-12">
                             <x-adminlte-input type="text" name="name" value="{{old('name')}}" label="Machine Name"
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
          </x-adminlte-modal>
@stop




@push('css')
<link rel="stylesheet" href="{{ asset('style/category.css') }}" />
@endpush
