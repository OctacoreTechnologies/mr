@php
    $heads = [
        'SR.No',
        'Company Name',
        'Country',
        'status',
        'Followed By',
        'Track Followup',
        'Followup',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Customer')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-users"></i>
        Customers
    </h1>
    <div>
        <a href="{{ route('customer.create') }}" class="btn btn-primary btn-md"><i class="fas fa-plus-circle"></i> Add
            Customer</a>
        <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#customerImport">
            <i class="fas fa-file-excel"></i> Import Excel
        </button>
    </div>

</div>
@stop

@section('content')

    <x-alert-components class="my-3" />

    {{-- 📋 Customer Table --}}
    <div class="crm-card">
        <div class="crm-card-header">
            <h3 class="card-title">
                <i class="fas fa-users"></i> Customer List
            </h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <x-adminlte-datatable id="customer-table" :heads="$heads" striped hoverable with-buttons>
                    @foreach ($customers as $key => $customer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->company_name }}</td>
                            <td>{{strtoupper($customer->country) }}</td>
                            <td>
                                @php
                                    $statusClass = match ($customer->customer_status) {
                                        'lead' => 'badge badge-warning',
                                        'quoted' => 'badge badge-info',
                                        'existing' => 'badge badge-success',
                                        default => 'badge badge-secondary',
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ strtoupper($customer->customer_status) }}</span>
                            </td>
                            <td>{{ $customer->user->name ?? 'N.A' }}</td>
                             <td> 
                              @can('customer followup track')
                                <a href="{{ route('followup.customers.show', $customer->id) }}"
                                    class="btn btn-sm btn-outline-success mx-1 shadow" title="Edit">
                                    Track
                                </a>
                              @endcan
                             </td>
                             <td>
                                @can('customer-followup')
                                 <a href="{{ route('followup.edit', $customer->id) }}"
                                     class="btn btn-sm btn-outline-info shadow-sm btn-round" target="_blank"
                                     title="Add Follow-Up">
                                     <i class="fas fa-phone-alt"></i> Follow Up
                                 </a>
                                @endcan
                             </td>
                            <td class="text-center">
                                <nobr>
                                    <!-- Edit Button -->
                                  @can('edit customer')
                                    <a href="{{ route('customer.edit', $customer->id) }}"
                                        class="btn btn-sm btn-outline-warning mx-1 shadow" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    <!-- Delete Button -->
                                    @can('delete customer')
                                     <form action="{{ route('customer.destroy', $customer->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-sm btn-outline-danger mx-1 shadow delete-customer"
                                            title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                     </form>
                                    @endcan

                                    <!-- View Details Button -->
                                    @can('show customer')
                                     <a href="{{ route('customer.show', $customer->id) }}"
                                        class="btn btn-sm btn-outline-teal mx-1 shadow" title="Details">
                                        <i class="fas fa-eye"></i>
                                     </a>
                                    @endcan
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
    <x-adminlte-modal id="customerImport" title="Import Customer Excel File" theme="info" icon="fas fa-file-excel">

        {{-- Sample Download Section --}}
        <div class="mb-3 p-3 border rounded bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Download Sample File</strong><br>
                    <small class="text-muted">
                        Please download the sample Excel file and follow the format before uploading.
                    </small>
                </div>
                <a href="{{ route('fetch.customer.excel.sample') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-download"></i> Sample
                </a>
            </div>
        </div>

        {{-- Upload Form --}}
        <form action="{{ route('customer.import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Select Excel File</label>
                <input type="file" name="file" class="form-control" required>
            </div>

            <div class="text-right mt-3">
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </form>

    </x-adminlte-modal>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush


@push('js')
    <script>
        // JavaScript or jQuery functionalities can go here if needed
    </script>
@endpush