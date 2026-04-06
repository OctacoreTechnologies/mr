@extends('layouts.app')

@section('title', 'Opportunity Details')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-briefcase"></i>
        Opportunity Details
    </h1>
    <a href="{{ route('opportunity.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Opportunities
    </a>
</div>
@stop

@section('content')

<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Opportunity Information
        </h3>
    </div>

    <div class="crm-card-body">

        {{-- ── Opportunity Details ── --}}
        <p class="crm-section">Opportunity Details</p>

        <div class="row">
           
                @if ($opportunity->description)
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" readonly>{{ $opportunity->description }}</textarea>
                        </div>
                    </div>
                @endif

            @php
                $fields = [
                    // 'Lead' => $opportunity->lead->full_name ?? '—',
                    'Company Name' => $opportunity->company_name ?? '—',
                    'Stage' => ucfirst(str_replace('_', ' ', $opportunity->stage)) ?? '—',
                    'Expected Close Date' => $opportunity->expected_close_date ?? '—',
                    'Close Date' => $opportunity->close_date ?? '—',
                    'Priority' => ucfirst($opportunity->priority) ?? '—',
                    'Opportunity Type' => ucfirst(str_replace('_', ' ', $opportunity->opportunity_type)) ?? '—',
                    'Created At' => $opportunity->created_at->format('d M, Y h:i A'),
                    'Updated At' => $opportunity->updated_at->format('d M, Y h:i A'),
                ];
            @endphp

            @foreach($fields as $label => $value)
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ $label }}</label>
                        <input type="text" class="form-control" value="{{ $value }}" readonly>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- ── Remarks ── --}}
        @if ($opportunity->remark1 || $opportunity->remark2)
            <p class="crm-section">Remarks</p>

            <div class="row">
                @if ($opportunity->remark1)
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Remark 1</label>
                            <textarea class="form-control" readonly>{{ $opportunity->remark1 }}</textarea>
                        </div>
                    </div>
                @endif

                @if ($opportunity->remark2)
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Remark 2</label>
                            <textarea class="form-control" readonly>{{ $opportunity->remark2 }}</textarea>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- ── Actions ── --}}
        <div class="crm-form-actions">
            <a href="{{ route('opportunity.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <a href="{{ route('opportunity.edit', $opportunity->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Opportunity
            </a>
        </div>

    </div>
</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush