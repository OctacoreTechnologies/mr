@extends('layouts.app')

@section('title', 'Lead Details')

@section('content_header')
<div class="crm-page-header">
    <h1><i class="fas fa-user-tag"></i> Lead Details</h1>
</div>
@stop

@section('content')
<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title"><i class="fas fa-info-circle"></i> Lead Overview</h3>
    </div>

    <div class="crm-card-body">
        <div class="row">

            @php
                $fields = [
                    'Full Name'     => $lead->full_name ?? '',
                    'Email'         => $lead->email ?? '',
                    'Phone'         => $lead->contact_person_1_contact ?? '',
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
                    <div class="p-3 border rounded" style="background: var(--crm-bg); border-color: var(--crm-border);">
                        <span class="crm-label">{{ $label }}</span>
                        <p class="mb-0 text-muted">{{ $value }}</p>
                    </div>
                </div>
            @endforeach

            <div class="col-md-12 mb-3">
                <div class="p-3 border rounded" style="background: var(--crm-bg); border-color: var(--crm-border);">
                    <span class="crm-label">Notes</span>
                    <p class="mb-0 text-muted">{{ $lead->notes ?? '—' }}</p>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="p-3 border rounded" style="background: var(--crm-bg); border-color: var(--crm-border);">
                    <span class="crm-label">Notes</span>
                    <p class="mb-0 text-muted">{{ $lead->remark2 ?? '—' }}</p>
                </div>
            </div>

        </div>

        <div class="crm-form-actions">
            <a href="{{ route('lead.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Leads
            </a>
        </div>
    </div>
</div>
@stop

@push('css')
<link rel="stylesheet" href="{{asset('style/common.css')}}">
@endpush