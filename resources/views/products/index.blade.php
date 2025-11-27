@php
    $heads = [
        'ID',
        //'Product Code',
        'Application Name',
        'Application Price',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];
   $n=1;
@endphp

@extends('layouts.app')

@section('title', 'products')

@section('content_header')
   <a href="{{route('product.create')}}" class="btn btn-success btn-sm">Create Application</a>
@stop
    
@section('content')
<x-alert-components class="my-2" />
       
            <div class="card">
                <div class="card-header">
                   <h3 class="card-title">Application Lists</h3>
            </div>
            <div class="card-body">
               <div class="row">
                   <div class="col-12 w-100">
                            <!--  -->
                            <!-- -- Minimal example / fill data using the component slot -- -->
                      <x-adminlte-datatable id="table1" :heads="$heads">

                        @foreach ($products as $product)
                         <tr>
                            <td>{{ $n++ }}</td>
                            <!-- <td>{{ $product->code }}</td> -->
                            <td>{{$product->name}}</td>
                            <td>{{$product->price}}</td>
                            <td>
                                 <nobr>
                                   <a href="{{route('product.edit',$product->id)}}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                     <i class="fa fa-lg fa-fw fa-pen"></i>
                                   </a>
                                     <form action="{{route('product.destroy',$product->id)}}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method("DELETE")
                                       <button class="btn btn-xs btn-default text-danger mx-1 shadow delete-product" title="Delete">
                                         <i class="fa fa-lg fa-fw fa-trash"></i>
                                       </button>
                                     </form>
                        
                                   <a href="{{route('product.show',$product->id)}}" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                       <i class="fa fa-lg fa-fw fa-eye"></i>
                                   </a>
                                 </nobr>
                            </td>
                          </tr>
                        @endforeach
                      </x-adminlte-datatable>

                    </div>
                     
                 </div>
  
                </div>
             </div>
@stop


