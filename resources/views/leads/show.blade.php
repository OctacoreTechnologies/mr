
@extends('layouts.app')

@section('title', 'Lead Details')

@section('content_header')
    <h1><i class="fas fa-user-tag"></i> Lead Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Lead Overview</h3>
        </div>
        <div class="card-body">
            <div class="row">

                @php
                    $fields = [
                        'Full Name'     => $lead->full_name ?? '',
                        'Email'         => $lead->email ?? '',
                        'Phone'         => $lead->phone ?? '',
                        'Company'       => $lead->company ?? '',
                        'Lead Source'   => $lead->lead_source ?? '',
                        'Status'        => ucfirst($lead->status ?? ''),
                        'Address'       => $lead->address ?? '',
                        'City'          => $lead->city ?? '',
                        'State'         => $lead->state ?? '',
                        'Postal Code'   => $lead->postal_code ?? '',
                        'Followed By'   => $lead->leadFollowedBy->name ?? '',
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
                        <strong>Notes:</strong>
                        <p class="mb-0 text-muted">{{ $lead->notes ?? '—' }}</p>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="border p-2 rounded bg-light">
                        <strong>Notes:</strong>
                        <p class="mb-0 text-muted">{{ $lead->remark2 ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('lead.index') }}" class="btn btn-outline-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Back to Leads
            </a>
        </div>
    </div>
@stop

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush
