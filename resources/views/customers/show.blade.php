@extends('layouts.app')

@section('title', 'Customer Details')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-user-circle"></i>
        Customer Details
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-2" />

<div class="crm-index-card">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Overview
        </h3>
    </div>

    <div class="card-body">

        {{-- BASIC DETAILS --}}
        <div class="row">
            @php
                $fields = [
                    'Location' => ucfirst($customer->location_type) ?? '',
                    'Country' => ucfirst($customer->country) ?? '',
                    'Region' => ucfirst($customer->region) ?? '',
                    'State' => ucfirst($customer->state) ?? '',
                    'City' => ucfirst($customer->city) ?? '',
                    'Area' => ucfirst($customer->area) ?? '',
                    'Pincode' => $customer->pincode ?? '',
                    'Company Name' => $customer->company_name ?? '',
                    'gst' => $customer->gst ?? '',
                    'Status' => $customer->status ?? '',
                ];
            @endphp

            @foreach($fields as $label => $value)
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">{{ $label }}</span>
                        <div class="crm-detail-value">
                            {{ $value ?: '—' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CONTACT PERSONS --}}
        <div class="mt-4">
            <h5 class="crm-section-title">Contact Persons</h5>

            <div class="row">

                @for ($i = 1; $i <= 6; $i++)
                    @php
                        $name = $customer->{'contact_person_'.$i.'_name'};
                    @endphp

                    @if($name)
                        <div class="col-md-6 mb-3">
                            <div class="crm-detail-box">
                                <strong class="d-block mb-1">
                                    <i class="fas fa-user"></i> Contact Person {{ $i }}
                                </strong>

                                <div class="crm-detail-value">
                                    <div><b>Name:</b> {{ $name }}</div>
                                    <div><b>Designation:</b> {{ $customer->{'contact_person_'.$i.'_designation'} }}</div>
                                    <div><b>Email:</b> {{ $customer->{'contact_person_'.$i.'_email'} }}</div>
                                    <div><b>Contact:</b> {{ $customer->{'contact_person_'.$i.'_contact'} }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor

            </div>
        </div>


         {{-- Address --}}
        <div class="mt-4">
            <h5 class="crm-section-title">Address</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Bill To</span>
                        <div class="crm-detail-value">
                            {{ $customer->address_line_1 ?? '—' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Ship To</span>
                        <div class="crm-detail-value">
                            {{ $customer->address_line_2 ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- REMARKS --}}
        <div class="mt-4">
            <h5 class="crm-section-title">Remarks</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Remark 1</span>
                        <div class="crm-detail-value">
                            {{ $customer->remark ?? '—' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Remark 2</span>
                        <div class="crm-detail-value">
                            {{ $customer->remark2 ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOLLOWED BY --}}
        <div class="mt-3">
            <div class="crm-detail-box">
                <span class="crm-detail-label">Followed By</span>
                <div class="crm-detail-value">
                    <i class="fas fa-user-circle"></i>
                    {{ $customer->followedBy->name ?? '—' }}
                </div>
            </div>
        </div>

        {{-- BACK BUTTON --}}
        <div class="mt-4">
            <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Customers
            </a>
        </div>

    </div>
</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
<style>
    .crm-detail-box {
        background: var(--crm-bg);
        border: 1px solid var(--crm-border);
        border-radius: 8px;
        padding: 10px 12px;
        height: 100%;
    }

    .crm-detail-label {
        font-size: .7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--crm-text-muted);
        display: block;
        margin-bottom: 3px;
    }

    .crm-detail-value {
        font-size: .85rem;
        color: var(--crm-text);
        font-weight: 500;
        word-break: break-word;
    }

    .crm-section-title {
        font-size: .85rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--crm-text-muted);
        text-transform: uppercase;
    }
</style>
@endpush