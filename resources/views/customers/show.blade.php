@extends('layouts.app')

@section('title', 'Customer Details')

@section('content_header')
    <h1><i class="fas fa-user-circle"></i> Customer Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Overview</h3>
        </div>
        <div class="card-body">
            <div class="row">

                @php
                    $fields = [
                        'Location' => $customer->location_type ?? '',
                        'Country' => $customer->country ?? '',
                        'Region' => $customer->region ?? '',
                        'State' => $customer->state ?? '',
                        'City' => $customer->city ?? '',
                        'Area' => $customer->area ?? '',
                        'Pincode' => $customer->pincode ?? '',
                        'Company Name' => $customer->company_name ?? '',
                        'Contact No' => $customer->contact_no ?? '',
                        'Status' => $customer->status ?? '',
                        'Contact Person 1 name'         => $customer->contact_person_1_name,
                        'Contact Person 1 designation'  => $customer->contact_person_1_designation,
                        'Contact Person 1 email'        => $customer->contact_person_1_email,
                        'Contact Person 1 contact'      => $customer->contact_person_1_contact,

                        'Contact Person 2 name'         => $customer->contact_person_2_name,
                        'Contact Person 2 designation'  => $customer->contact_person_2_designation,
                        'Contact Person 2 email'        => $customer->contact_person_2_email,
                        'Contact Person 2 contact'      => $customer->contact_person_2_contact,

                        'Contact Person 3 name'         => $customer->contact_person_3_name,
                        'Contact Person 3 designation'  => $customer->contact_person_3_designation,
                        'Contact Person 3 email'        => $customer->contact_person_3_email,
                        'Contact Person 3 contact'      => $customer->contact_person_3_contact,

                        'Contact Person 4 name'         => $customer->contact_person_4_name,
                        'Contact Person 4 designation'  => $customer->contact_person_4_designation,
                        'Contact Person 4 email'        => $customer->contact_person_4_email,
                        'Contact Person 4 contact'      => $customer->contact_person_4_contact,

                        'Contact Person 5 name'         => $customer->contact_person_5_name,
                        'Contact Person 5 designation'  => $customer->contact_person_5_designation,
                        'Contact Person 5 email'        => $customer->contact_person_5_email,
                        'Contact Person 5 contact'      => $customer->contact_person_5_contact,

                        'Contact Person 6 name'         => $customer->contact_person_6_name,
                        'Contact Person 6 designation'  => $customer->contact_person_6_designation,
                        'Contact Person 6 email'        => $customer->contact_person_6_email,
                        'Contact Person 6 contact'      => $customer->contact_person_6_contact,
                    ];
                @endphp

                @foreach($fields as $label => $value)
                    <div class="col-md-6 mb-3">
                        <div class="border p-2 rounded bg-light">
                            <strong>{{ $label }}:</strong>
                            <p class="mb-0 text-muted">{{ $value }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-12 mb-3">
                    <div class="border p-2 rounded bg-light">
                        <strong>Remark 1:</strong>
                        <p class="mb-0 text-muted">{{ $customer->remark ?? '—' }}</p>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="border p-2 rounded bg-light">
                        <strong>Remark 2:</strong>
                        <p class="mb-0 text-muted">{{ $customer->remark2 ?? '—' }}</p>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="border p-2 rounded bg-light">
                        <strong>Followed By:</strong>
                        <p class="mb-0 text-muted">{{ $customer->followedBy->name ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Customers
                </a>
            </div>
        </div>
    </div>
@stop
