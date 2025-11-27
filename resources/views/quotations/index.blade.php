@php
    $heads = [
        'ID',
        'Quotation Ref.No',
        'Customer Name',
        'Machine',
        'Product',
        'Status',
        'Verify',
        'PDF',
        'Follow Up',
        ['label' => 'Actions', 'no-export' => false, 'width' => 10],
    ];
    $i = 0;
@endphp

@extends('layouts.app')

@section('title', 'Quotations')

@section('content_header')
<a href="{{ route('quotation.previewForm') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus-circle"></i> Create Quotation
</a>
@stop

@section('content')
<x-alert-components class="my-3" />

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-file-invoice"></i> Quotation Lists</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable with-buttons>
                @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $quotation->reference_no }}</td>
                        <td>{{ $quotation->customer->company_name }}</td>
                        <td>{{ $quotation->machine->name }}</td>
                        <td>{{ $quotation->application->name ?? 'N.A' }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'Draft' => 'warning',
                                    'Sent' => 'info',
                                    //'Accepted' => 'success',
                                    'Approved' => 'success',
                                    'Rejected' => 'danger',
                                ];

                                $badgeClass = $statusClass[$quotation->status] ?? 'secondary'; // fallback if status is unknown
                            @endphp

                            <span class="badge badge-{{ $badgeClass }}">
                                {{ ucfirst($quotation->status) }}
                            </span>
                        </td>
                        <td>
                            {{ is_null($quotation->is_verified) ? 'N.A' : ($quotation->is_verified ? 'Yes' : 'No') }}
                        </td>
                        <td>
                            <a class="btn btn-link text-danger" href="{{ route('quotation.pdf', $quotation->id) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-link text-info" href="{{ route('followup.edit', $quotation->customer_id) }}">
                                <i class="fas fa-calendar-check"></i> Follow Up
                            </a>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow" type="button"
                                    id="actionsDropdown{{ $quotation->id }}" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-cogs"></i> Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="actionsDropdown{{ $quotation->id }}">
                                    <a class="dropdown-item" href="{{ route('quotation.edit', $quotation->id) }}">
                                        <i class="fas fa-edit text-primary"></i> Edit
                                    </a>
                                    {{-- <a class="dropdown-item" href="{{ route('quotation.show', $quotation->id) }}">
                                        <i class="fas fa-eye text-teal"></i> View Details
                                    </a>--}}
                                    <form action="{{ route('quotation.destroy', $quotation->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                    <button class="dropdown-item text-success" data-toggle="modal" data-target="#modalMin"
                                        data-id="{{ $quotation->id }}"
                                        data-reference_no="{{ $quotation->reference_no ?? '' }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-verified="{{ $quotation->is_verified ?? '' }}">
                                        <i class="fas fa-check-circle"></i> Verify
                                    </button>
                                    <button class="dropdown-item text-info" data-toggle="modal"
                                        data-target="#updateQuotationStatus" data-quotationId="{{ $quotation->id }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-reference_no="{{ $quotation->reference_no }}"
                                        data-status="{{ $quotation->status ?? 'N/A' }}">

                                        <i class="fas fa-sync-alt"></i> Update Status
                                    </button>
                                    <button class="dropdown-item text-info" data-toggle="modal"
                                        data-target="#sendEmailModal" data-id="{{ $quotation->id }}"
                                        data-customer_name="{{ $quotation->customer->company_name }}"
                                        data-customer_email="{{ $quotation->customer->contact_person_1_email ?? 'N/A' }}"
                                        data-isverify="{{ $quotation->is_verified ? "1" : "0" }}"
                                        data-customer_id="{{ $quotation->customer_id }}"
                                        data-application_id="{{ $quotation->application_id }}">

                                        <i class="fas fa-envelope"></i> Send Email
                                    </button>
                                    <a class="dropdown-item text-success"
                                        href="{{ route('quotation.reorder', $quotation->id) }}">
                                        <i class="fas fa-redo"></i> Reorder Quotation
                                    </a>

                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
</div>

<!-- Verify Modal -->
<x-adminlte-modal id="modalMin" title="Verify Quotation" theme="teal" icon="fas fa-check-circle">
    <form method="POST" action="{{ route('admin.quotation.verify') }}">
        @csrf
        <div class="row">
            <x-adminlte-input type="hidden" name="id" id="modalQuotationId" />
            <x-adminlte-input name="customer_name" id="customerName" label="Customer Name" fgroup-class="col-12 mb-3"
                readonly />
            <x-adminlte-input name="reference_no" id="modalReferenceNo" label="Quotation Reference No."
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-select name="is_verified" label="Select" id="isVerified" fgroup-class="col-12 mb-3" required>
                <option disabled selected>Select Quotation Verify</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </x-adminlte-select>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <x-adminlte-button label="Cancel" theme="outline-danger" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Submit" type="submit" theme="primary" />
        </div>
    </form>
</x-adminlte-modal>

<!-- Send Email Modal -->
<x-adminlte-modal id="sendEmailModal" title="Send Email to Customer" theme="info" icon="fas fa-envelope">
    <form method="POST" action="{{ route('quotation.send.mail') }}">
        @csrf
        <div class="row">
            <x-adminlte-input type="hidden" name="quotation_id" id="quotation_id" />
            <x-adminlte-input type="hidden" name="customer_id" id="customer_id" />
            <x-adminlte-input name="customer_name" id="emailCustomerName" label="Customer Name"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input type="email" name="customer_email" id="emailCustomerEmail" label="Customer Email"
                type="email" fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input type="text" id="subject" name="subject" id="subject" label="Subject"
                fgroup-class="col-12 mb-3" />
            <x-adminlte-textarea name="message" id="message" label="Message" rows="5" fgroup-class="col-12 mb-3"
                placeholder="Type your message here..." required />
            <div class="col-12 mb-3">
                <input type="checkbox" name="withPdf" id="withPdf" value="1" label="With Quotation Pdf Send" /><label
                    for="withPdf">Send with Quotation Pdf</label>
            </div>
            <div class="col-12 mb-3" id="email">

            </div>
        </div>
        <div class="d-flex justify-content-end">
            <x-adminlte-button label="Cancel" theme="outline-danger" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Send" icon="fas fa-paper-plane" theme="info" type="submit" />
        </div>
    </form>
</x-adminlte-modal>
<!-- Quotation Status Update -->
<x-adminlte-modal id="updateQuotationStatus" title="Update Status of Quotation" theme="info" icon="fas fa-envelope">
    <form method="POST" action="{{ route('quotation.update.status') }}">
        @csrf
        @method('POST')
        <div class="row">
            <x-adminlte-input type="hidden" name="id" id="quotationId" />
            <x-adminlte-input name="customer_name" id="statusCustomerName" label="Customer Name"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-input name="reference_no" id="referenceNo" label="Reference NO." type="text"
                fgroup-class="col-12 mb-3" readonly />
            <x-adminlte-select name="status" id="status" label="Select Status" fgroup-class="col-12 mb-3">
                <option value="Draft" {{ $quotation->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Sent" {{ $quotation->status == 'Sent' ? 'selected' : '' }}>Sent</option>
                <option value="Approved" {{ $quotation->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ $quotation->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </x-adminlte-select>
        </div>
        <div class="d-flex justify-content-end">
            <x-adminlte-button label="Cancel" theme="outline-danger" data-dismiss="modal" class="mr-2" />
            <x-adminlte-button label="Send" icon="fas fa-paper-plane" theme="info" type="submit" />
        </div>
    </form>
</x-adminlte-modal>
@stop

@push('js')
    <script src="{{ asset('js/quotation.js') }}"> </script>
@endpush

<!-- @section('css')
<link rel="stylesheet" href="{{ asset('style/index.css') }}">
@stop -->
{{--
@push('css')
<link rel="stylesheet" href="{{asset('style/customer.css')}}">
@endpush--}}