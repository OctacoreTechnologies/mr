@php
    $heads = [
        'SR.No',
        'Company Name',
        'Country',
        'Followed By',
        'Track Followup',
        'Followup',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Customer')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0 text-primary font-weight-bold">Customers</h1>
        <div>
          <a href="{{ route('customer.create') }}" class="btn btn-primary btn-md"><i class="fas fa-plus-circle"></i> Add Customer</a>
          <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#customerImport">
           <i class="fas fa-file-excel"></i> Import Excel
          </button>
        </div>

    </div>
@stop

@section('content')

    <x-alert-components class="my-3" />

    {{-- 📋 Customer Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="fas fa-building"></i> Customer List</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <x-adminlte-datatable id="customer-table" :heads="$heads" striped hoverable with-buttons>
                    @foreach ($customers as $key => $customer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->company_name }}</td>
                            <td>{{strtoupper($customer->country) }}</td>
                            <td>{{ $customer->user->name ??'N.A' }}</td>
                            <td> <a href="{{ route('followup.customers.show', $customer->id) }}" class="btn btn-sm btn-outline-success mx-1 shadow" title="Edit">
                                        Track
                                    </a>
                            </td>
                            <td>
                                <a href="{{ route('followup.edit', $customer->id) }}"
                                   class="btn btn-sm btn-outline-info shadow-sm btn-round"
                                   target="_blank" title="Add Follow-Up">
                                    <i class="fas fa-phone-alt"></i> Follow Up
                                </a>
                            </td>
                            <td class="text-center">
                                <nobr>
                                    <!-- Edit Button -->
                                    <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-outline-warning mx-1 shadow" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-sm btn-outline-danger mx-1 shadow delete-customer" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                    <!-- View Details Button -->
                                    <a href="{{ route('customer.show', $customer->id) }}" class="btn btn-sm btn-outline-teal mx-1 shadow" title="Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </nobr>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>

    <!-- import Model -->
     <x-adminlte-modal id="customerImport" title="Import Customer Excel File" theme="info" icon="fas fa-envelope">
      <form action="{{ route('customer.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="file" name="file" required>
        <button class="btn btn-success" type="submit">Upload</button>
      </form>
    </x-adminlte-modal>

@endsection

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush

@push('js')
    <script>
        // JavaScript or jQuery functionalities can go here if needed
    </script>
@endpush
