@extends('layouts.app')

@section('title', 'Opportunity Details')

@section('content_header')
    <h1><i class="fas fa-briefcase"></i> Opportunity Details</h1>
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
                        'Lead' => $opportunity->lead->full_name ?? '—',
                        'Opportunity Name' => $opportunity->name ?? '—',
                        'Stage' => ucfirst(str_replace('_', ' ', $opportunity->stage)) ?? '—',
                        'Expected Close Date' => $opportunity->expected_close_date ?? '—',
                        'Probability (%)' => $opportunity->probability ?? '—',
                        'Close Date' => $opportunity->close_date ?? '—',
                        'Priority' => ucfirst($opportunity->priority) ?? '—',
                        'Opportunity Type' => ucfirst(str_replace('_', ' ', $opportunity->opportunity_type)) ?? '—',
                        'Created At' => $opportunity->created_at->format('d M, Y h:i A'),
                        'Updated At' => $opportunity->updated_at->format('d M, Y h:i A'),
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

                @if (!empty($opportunity->remark1))
                    <div class="col-md-12 mb-3">
                        <div class="border p-2 rounded bg-light">
                            <strong>Remark 1:</strong>
                            <p class="mb-0 text-muted">{{ $opportunity->remark1 }}</p>
                        </div>
                    </div>
                @endif

                @if (!empty($opportunity->remark2))
                    <div class="col-md-12 mb-3">
                        <div class="border p-2 rounded bg-light">
                            <strong>Remark 2:</strong>
                            <p class="mb-0 text-muted">{{ $opportunity->remark2 }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-4">
                <a href="{{ route('opportunity.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Opportunities
                </a>
            </div>
        </div>
    </div>
@stop
