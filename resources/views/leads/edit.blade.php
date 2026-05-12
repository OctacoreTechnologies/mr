@extends('layouts.app')

@section('title', 'Edit Lead')

@push('css')
    <link rel="stylesheet" href="{{ asset('style/customer.css') }}">
@endpush

@section('content_header')
<div style="display:flex;align-items:center;justify-content:space-between;padding:0.5rem 0">
    <h1 style="font-size:20px;font-weight:500;display:flex;align-items:center;gap:10px;margin:0">
        <i class="fas fa-edit" style="color:#6b7280"></i> Edit Lead
    </h1>
    <a href="{{ route('lead.index') }}"
        style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #d1d5db;background:#fff;color:#6b7280;text-decoration:none">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')
<x-alert-components class="my-3" />

<form method="POST" action="{{ route('customer.update', $lead->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
      <input type="hidden" name="type" value="lead">
      <input type="hidden" name="source" value="lead">

              <div class="crm-section-card">
        <div class="crm-section-header">
            <div class="sec-title">
                <i class="fas fa-map-marker-alt"></i> Lead Source
            </div>
        </div>
        <div class="crm-section-body">
            <div class="crm-form-grid crm-form-grid-3">
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Lead Source <span style="color:#DC2626">*</span></label>
                    <select name="lead_source" id="lead_source" class="crm-select" required>
                        <option value="web" {{ old('lead_source', $lead->lead_source) == 'web' ? 'selected' : '' }}>Web</option>
                        <option value="referral" {{ old('lead_source', $lead->lead_source) == 'referral' ? 'selected' : '' }}>Referral</option>
                        <option value="cold_call" {{ old('lead_source', $lead->lead_source) == 'cold_call' ? 'selected' : '' }}>Cold Call</option>
                        <option value="social_media" {{ old('lead_source', $lead->lead_source) == 'social_media' ? 'selected' : '' }}>Social Media</option>
                        <option value="other" {{ old('lead_source', $lead->lead_source) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="crm-field-wrap" id="lead_source_remark_div" style="display: {{ old('lead_source', $lead->lead_source) == 'other' ? 'block' : 'none' }};">
                    <label class="crm-field-label">Lead Source Remark</label>
                    <input type="text" name="lead_source_remark" id="lead_source_remark" value="{{ old('lead_source_remark', $lead->lead_source_remark) }}" class="crm-input" placeholder="Enter lead source remark">
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- LOCATION SECTION --}}
    {{-- ============================================================ --}}
    <div class="crm-section-card">
        <div class="crm-section-header">
            <div class="sec-title">
                <i class="fas fa-map-marker-alt"></i> Location information
            </div>
        </div>
        <div class="crm-section-body">
            <div class="crm-form-grid crm-form-grid-3">
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Location type</label>
                    <select name="location_type" id="location_type" class="crm-select">
                        <option value="international" {{ $lead->location_type == 'international' ? 'selected' : '' }}>International</option>
                        <option value="domestic" {{ $lead->location_type == 'domestic' ? 'selected' : '' }}>Domestic</option>
                    </select>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Continent <span style="color:#DC2626">*</span></label>
                    <select name="continent" id="continent" class="crm-select" required>
                        <option value="">— select —</option>
                        <option value="africa" {{ $lead->continent == 'africa' ? 'selected' : '' }}>Africa</option>
                        <option value="antarctica" {{ $lead->continent == 'antarctica' ? 'selected' : '' }}>Antarctica</option>
                        <option value="asia" {{ $lead->continent == 'asia' ? 'selected' : '' }}>Asia</option>
                        <option value="europe" {{ $lead->continent == 'europe' ? 'selected' : '' }}>Europe</option>
                        <option value="north_america" {{ $lead->continent == 'north_america' ? 'selected' : '' }}>North America</option>
                        <option value="oceania" {{ $lead->continent == 'oceania' ? 'selected' : '' }}>Oceania</option>
                        <option value="south_america" {{ $lead->continent == 'south_america' ? 'selected' : '' }}>South America</option>
                    </select>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Country</label>
                    <select name="country" id="country" class="crm-select country-select">
                        @foreach ($countries as $country)
                            <option value="{{ strtolower($country->country) }}"
                                data-code="{{ $country->country_code }}"
                                {{ strtolower($country->country) == strtolower($lead->country ?? '') ? 'selected' : '' }}>
                                {{ $country->country }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="crm-field-wrap" id="regionGroup">
                    <label class="crm-field-label">Region</label>
                    <select name="region" id="region" class="crm-select">
                        @foreach ($regions as $region)
                            <option value="{{ $region->name }}"
                                data-region-id="{{ $region->id }}"
                                {{ $lead->region == $region->name ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="crm-field-wrap" id="stateGroup">
                    <label class="crm-field-label">State</label>
                    <select name="state" id="state" class="crm-select">
                        @foreach ($states as $state)
                            <option value="{{ $state->name }}"
                                {{ strtolower($state->name) == strtolower($lead->state ?? '') ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">City</label>
                    <input type="text" name="city" value="{{ old('city', $lead->city) }}" class="crm-input" placeholder="Enter city">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Area</label>
                    <input type="text" name="area" value="{{ old('area', $lead->area) }}" class="crm-input" placeholder="Enter area">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Pincode</label>
                    <input type="text" name="pincode" value="{{ old('pincode', $lead->pincode) }}" class="crm-input" placeholder="Enter pincode">
                    @error('pincode')
                        <span style="font-size:12px;color:#DC2626;margin-top:3px">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- COMPANY SECTION --}}
    {{-- ============================================================ --}}
    <div class="crm-section-card">
        <div class="crm-section-header">
            <div class="sec-title">
                <i class="fas fa-building"></i> Company information
            </div>
        </div>
        <div class="crm-section-body">
            <div class="crm-form-grid crm-form-grid-3">
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Company name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $lead->company_name) }}" class="crm-input" placeholder="Enter company name">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">GST number</label>
                    <input type="text" name="gst" value="{{ old('gst', $lead->gst) }}" class="crm-input" placeholder="Enter GST number">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Visiting card</label>
                    <input type="file" name="visiting_card" class="crm-input" accept=".jpg,.jpeg,.png,.gif,.svg">
                    @if($lead->visiting_card)
                        <div class="visiting-card-preview">
                            <img src="{{ asset($lead->visiting_card) }}" alt="Visiting Card">
                            <span>Current card on file</span>
                            <a href="{{ asset($lead->visiting_card) }}" target="_blank"
                                style="margin-left:auto;font-size:11px;color:#1D4ED8;text-decoration:none">
                                <i class="fas fa-external-link-alt"></i> View
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <hr class="crm-divider">

            <div class="crm-form-grid crm-form-grid-2">
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Address (bill to)</label>
                    <textarea name="address_line_1" id="billTo" class="crm-textarea" placeholder="Enter billing address">{{ old('address_line_1', $lead->address_line_1) }}</textarea>
                </div>
                <div class="crm-field-wrap">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:5px">
                        <label class="crm-field-label" style="margin-bottom:0">Address (ship to)</label>
                        <label style="display:flex;align-items:center;gap:5px;font-size:12px;color:#6b7280;cursor:pointer;font-weight:normal;margin-bottom:0">
                            <input type="checkbox" id="sameAddress" style="margin:0"> same as bill to
                        </label>
                    </div>
                    <textarea name="address_line_2" id="shipTo" class="crm-textarea" placeholder="Enter shipping address">{{ old('address_line_2', $lead->address_line_2) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- CONTACT PERSONS SECTION --}}
    {{-- ============================================================ --}}
    <div class="crm-section-card">
        <div class="crm-section-header" >
            <div class="sec-title">
                <i class="fas fa-users"></i> Contact persons
            </div>
            <div class="np-wrap">
                <span class="np-label">Persons:</span>
                <button type="button" class="np-btn" id="decreaseBtn" aria-label="Remove person">&#8722;</button>
                <span class="np-count" id="personCount">1</span>
                <button type="button" class="np-btn" id="increaseBtn" aria-label="Add person">&#43;</button>
            </div>
        </div>
        <div class="crm-section-body">
            <div id="contactPersonsContainer"></div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- STATUS & REMARKS SECTION --}}
    {{-- ============================================================ --}}
    <div class="crm-section-card">
        <div class="crm-section-header">
            <div class="sec-title">
                <i class="fas fa-sticky-note"></i> Status & remarks
            </div>
        </div>
        <div class="crm-section-body">
            <div class="crm-form-grid crm-form-grid-3">
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Customer status</label>
                    <select name="customer_status" class="crm-select">
                        <option value="lead"     {{ $lead->customer_status == 'lead'     ? 'selected' : '' }}>Lead</option>
                        <option value="quoted"   {{ $lead->customer_status == 'quoted'   ? 'selected' : '' }}>Quoted</option>
                        <option value="existing" {{ $lead->customer_status == 'existing' ? 'selected' : '' }}>Existing</option>
                    </select>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Followed by <span style="color:#DC2626">*</span></label>
                    <select name="followed_by" class="crm-select" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $lead->followed_by == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
              
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Remark 1</label>
                    <textarea name="remark" class="crm-textarea" placeholder="Enter remarks">{{ old('remark', $lead->remark) }}</textarea>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Remark 2</label>
                    <textarea name="remark2" class="crm-textarea" placeholder="Enter additional remarks">{{ old('remark2', $lead->remark2) }}</textarea>
                </div>
                
            </div>
        </div>
    </div>

    <div class="crm-form-actions">
        <button type="submit" class="btn-primary-crm">
            <i class="fas fa-save"></i> Update
        </button>
        <button type="button" class="btn-cancel-crm" onclick="window.history.back()">
            Cancel
        </button>
    </div>
</form>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush

@push('js')
<script>
    window.EXISTING_PERSONS = @json($lead->contact_persons ?? []);
</script>

<script src="{{ asset('js/customer.js') }}"></script>
<script src="{{ asset('js/country.js') }}"></script>

@endpush