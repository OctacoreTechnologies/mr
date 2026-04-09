@php
    $heads = [
        'ID',
        'Machine',
        'Application Name',
        'Application Price',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
    $n = 1;
@endphp

@extends('layouts.app')

@section('title', 'Products')

@section('content_header')
    <a href="{{ route('applications.create') }}" class="btn btn-primary btn-md shadow-sm">
        <i class="fas fa-plus-circle"></i> Create Application
    </a>
@stop

@section('content')
    <x-alert-components class="my-3" />
    
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-cogs"></i> Application Lists
            </h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <x-adminlte-datatable id="table1" :heads="$heads">

                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $n++ }}</td>

                            <td>{{ $product->machine->name }}</td>

                            <td>{{ $product->name }}</td>

                            <td>
                                <span class="font-weight-bold">
                                    {{ $product->price }}
                                </span>
                            </td>

                            <td>
                                <nobr>
                                    <!-- Edit Button -->
                                @can('edit application')
                                    <a href="{{ route('applications.edit', $product->id) }}"
                                       class="btn btn-sm btn-outline-primary mx-1 shadow-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                    <!-- Delete Button -->
                                    @can('delete application')

                                      <form action="{{ route('applications.destroy', $product->id) }}"
                                            method="POST"
                                            class="d-inline-block">
                                          @csrf
                                          @method('DELETE')
                                          <button class="btn btn-sm btn-outline-danger mx-1 shadow-sm delete-product"
                                                  title="Delete">
                                              <i class="fas fa-trash-alt"></i>
                                          </button>
                                      </form>
                                    @endcan

                                    <!-- View Details Button -->
                                    @can('show application')
                                     <a href="{{ route('applications.show', $product->id) }}"
                                       class="btn btn-sm btn-outline-teal mx-1 shadow-sm"
                                       title="Details">
                                        <i class="fas fa-eye"></i>
                                     </a>
                                    @endcan
                                </nobr>
                            </td>
                        </tr>
                    @endforeach

                </x-adminlte-datatable>

            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        // unchanged
    });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
@endpush