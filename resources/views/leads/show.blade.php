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

        {{-- BASIC DETAILS --}}
        <div class="row">
            @php
                $fields = [
                    'Location Type' => ucfirst($lead->location_type ?? ''),
                    'Country'       => ucfirst($lead->country ?? ''),
                    'Region'        => $lead->region ?? '',
                    'State'         => $lead->state ?? '',
                    'City'          => $lead->city ?? '',
                    'Area'          => $lead->area ?? '',
                    'Pincode'       => $lead->pincode ?? '',
                    'Company Name'  => $lead->company_name ?? '',
                    'GST'           => $lead->gst ?? '',
                    'Lead Source'   => ucfirst(str_replace('_', ' ', $lead->lead_source ?? '')),
                    'Status'        => ucfirst($lead->status ?? ''),
                    'Followed By'   => $lead->leadFollowedBy->name ?? '',
                ];
            @endphp

            @foreach($fields as $label => $value)
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">{{ $label }}</span>
                        <div class="crm-detail-value">{{ $value ?: '—' }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ADDRESS --}}
        @if($lead->address_line_1 || $lead->address_line_2)
        <div class="mt-4">
            <h5 class="crm-section-title">Address</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Bill To</span>
                        <div class="crm-detail-value">{{ $lead->address_line_1 ?: '—' }}</div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Ship To</span>
                        <div class="crm-detail-value">{{ $lead->address_line_2 ?: '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- CONTACT PERSONS --}}
        @php
            $contactPersons = $lead->contact_persons ?? [];
        @endphp

        @if(!empty($contactPersons))
        <div class="mt-4">
            <h5 class="crm-section-title">Contact Persons</h5>
            <div class="row">
                @foreach($contactPersons as $i => $person)
                    @php
                        $personEmails   = $person['email'] ?? [];
                        if (is_string($personEmails)) $personEmails = array_filter(explode(',', $personEmails));

                        $personContacts = $person['contact'] ?? [];
                        if (is_string($personContacts)) $personContacts = array_filter(explode(',', $personContacts));

                        // Collect all uploaded files: new array > old single > company fallback for person 1
                        if (!empty($person['visiting_cards'])) {
                            $personCards = (array) $person['visiting_cards'];
                        } elseif (!empty($person['visiting_card'])) {
                            $personCards = [$person['visiting_card']];
                        } elseif ($i === 0 && !empty($lead->visiting_card)) {
                            $personCards = [$lead->visiting_card];
                        } else {
                            $personCards = [];
                        }
                    @endphp

                    <div class="col-md-6 mb-3">
                        <div class="crm-detail-box">
                            <strong class="d-block mb-2">
                                <i class="fas fa-user"></i> Contact Person {{ $i + 1 }}
                            </strong>

                            <div class="crm-detail-value">
                                <div class="mb-1"><b>Name:</b> {{ $person['name'] ?? '-' }}</div>
                                <div class="mb-1"><b>Designation:</b> {{ $person['designation'] ?? '-' }}</div>
                                <div class="mb-1"><b>Email:</b> {{ implode(', ', $personEmails) ?: '-' }}</div>
                                <div class="mb-1"><b>Contact:</b> {{ implode(', ', $personContacts) ?: '-' }}</div>

                                @if(!empty($personCards))
                                    <div class="mt-2">
                                        <b>Uploaded files:</b>
                                        @foreach($personCards as $cardPath)
                                            @php $ext = strtolower(pathinfo($cardPath, PATHINFO_EXTENSION)); @endphp
                                            @if(in_array($ext, ['jpg','jpeg','png','gif','webp','svg']))
                                                <div class="mt-1">
                                                    <img src="{{ asset($cardPath) }}"
                                                         alt="File"
                                                         style="max-width:100%;max-height:150px;border-radius:6px;border:1px solid #e5e7eb">
                                                </div>
                                            @else
                                                <div class="mt-1">
                                                    <a href="{{ asset($cardPath) }}" target="_blank"
                                                       style="font-size:12px;color:#1D4ED8;text-decoration:none">
                                                        <i class="fas fa-file-alt"></i>
                                                        {{ basename($cardPath) }}
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- REMARKS --}}
        <div class="mt-4">
            <h5 class="crm-section-title">Remarks</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Remark 1</span>
                        <div class="crm-detail-value">{{ $lead->remark ?? '—' }}</div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="crm-detail-box">
                        <span class="crm-detail-label">Remark 2</span>
                        <div class="crm-detail-value">{{ $lead->remark2 ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="crm-form-actions">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Leads
            </a>
        </div>

    </div>
</div>
@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/common.css') }}">
<style>
    .crm-detail-box {
        background: var(--crm-bg, #f9fafb);
        border: 1px solid var(--crm-border, #e5e7eb);
        border-radius: 8px;
        padding: 10px 12px;
        height: 100%;
    }
    .crm-detail-label {
        font-size: .7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--crm-text-muted, #6b7280);
        display: block;
        margin-bottom: 3px;
    }
    .crm-detail-value {
        font-size: .85rem;
        color: var(--crm-text, #111827);
        font-weight: 500;
        word-break: break-word;
    }
    .crm-section-title {
        font-size: .85rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--crm-text-muted, #6b7280);
        text-transform: uppercase;
    }
</style>
@endpush
