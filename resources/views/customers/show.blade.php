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

                @php
                    $contactPersons = $customer->contact_persons ?? [];
                @endphp

                @foreach ($contactPersons as $i => $person)

                    @php
                        $personEmails = $person['email'] ?? [];
                        if (is_string($personEmails)) $personEmails = array_filter(explode(',', $personEmails));

                        $personContacts = $person['contact'] ?? [];
                        if (is_string($personContacts)) $personContacts = array_filter(explode(',', $personContacts));

                        // Collect all uploaded files: new array format > old single > company fallback for person 1
                        if (!empty($person['visiting_cards'])) {
                            $personCards = (array) $person['visiting_cards'];
                        } elseif (!empty($person['visiting_card'])) {
                            $personCards = [$person['visiting_card']];
                        } elseif ($i === 0 && !empty($customer->visiting_card)) {
                            $personCards = [$customer->visiting_card];
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

                                <div class="mb-1">
                                    <b>Email:</b> {{ implode(', ', $personEmails) ?: '-' }}
                                </div>

                                <div class="mb-1">
                                    <b>Contact:</b> {{ implode(', ', $personContacts) ?: '-' }}
                                </div>

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


        {{-- UPLOADED FILES --}}
        @php
            $allUploadedFiles = [];
            foreach (($customer->contact_persons ?? []) as $person) {
                if (!empty($person['visiting_cards'])) {
                    foreach ((array) $person['visiting_cards'] as $f) {
                        if ($f) $allUploadedFiles[] = $f;
                    }
                } elseif (!empty($person['visiting_card'])) {
                    $allUploadedFiles[] = $person['visiting_card'];
                }
            }
            if (!empty($customer->visiting_card) && !in_array($customer->visiting_card, $allUploadedFiles)) {
                $allUploadedFiles[] = $customer->visiting_card;
            }
            $allUploadedFiles = array_values(array_unique($allUploadedFiles));
        @endphp
        @if(!empty($allUploadedFiles))
        <div class="mt-4">
            <h5 class="crm-section-title">
                Uploaded Files
                <span style="background:#e2e8f0;color:#475569;font-size:.7rem;font-weight:700;border-radius:20px;padding:1px 8px;margin-left:6px;vertical-align:middle">
                    {{ count($allUploadedFiles) }}
                </span>
            </h5>
            <div style="display:flex;flex-wrap:wrap;gap:14px">
                @foreach($allUploadedFiles as $filePath)
                    @php $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)); @endphp
                    <div style="display:flex;flex-direction:column;align-items:center;gap:6px;width:130px">
                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp','svg']))
                            <a href="{{ asset($filePath) }}" target="_blank">
                                <img src="{{ asset($filePath) }}" alt="file"
                                     style="width:130px;height:100px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;box-shadow:0 2px 6px rgba(0,0,0,.07)">
                            </a>
                        @else
                            <a href="{{ asset($filePath) }}" target="_blank"
                               style="display:flex;flex-direction:column;align-items:center;gap:6px;text-decoration:none">
                                <div style="width:130px;height:100px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1px solid #fecaca;background:#fff5f5">
                                    <i class="fas fa-file-pdf" style="font-size:2.5rem;color:#dc2626"></i>
                                </div>
                            </a>
                        @endif
                        <span style="font-size:.72rem;color:#94a3b8;word-break:break-all;text-align:center;max-width:130px">
                            {{ basename($filePath) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

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
            <a href="{{url()->previous()}}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back  
                
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