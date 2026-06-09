@extends('layouts.app')

@section('title', 'Create Customer')

@push('css')
<link rel="stylesheet" href="{{ asset('style/customer.css') }}">
@endpush

@section('content_header')
<div style="display:flex;align-items:center;justify-content:space-between;padding:0.5rem 0">
    <h1 style="font-size:20px;font-weight:500;display:flex;align-items:center;gap:10px;margin:0">
        <i class="fas fa-user-plus" style="color:#6b7280"></i> Create Customer
    </h1>
    <a href="{{ route('customer.index') }}"
        style="display:flex;align-items:center;gap:6px;font-size:13px;padding:7px 14px;border-radius:6px;border:1px solid #d1d5db;background:#fff;color:#6b7280;text-decoration:none">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')
<x-alert-components class="my-3" />

<form method="POST" action="{{ route('customer.store') }}" enctype="multipart/form-data" id="customerForm">
    @csrf
    <input type="hidden" name="type" value="customer">
    <input type="hidden" name="source" value="customer">

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
                        <option value="international" {{ old('location_type') == 'international' ? 'selected' : '' }}>International</option>
                        <option value="domestic" {{ old('location_type') == 'domestic' ? 'selected' : '' }}>Domestic</option>
                    </select>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Continent <span style="color:#DC2626">*</span></label>
                    <select name="continent" id="continent" class="crm-select" required>
                        <option value="">— select —</option>
                        <option value="africa" {{ old('continent') == 'africa' ? 'selected' : '' }}>Africa</option>
                        <option value="antarctica" {{ old('continent') == 'antarctica' ? 'selected' : '' }}>Antarctica</option>
                        <option value="asia" {{ old('continent') == 'asia' ? 'selected' : '' }}>Asia</option>
                        <option value="europe" {{ old('continent') == 'europe' ? 'selected' : '' }}>Europe</option>
                        <option value="north_america" {{ old('continent') == 'north_america' ? 'selected' : '' }}>North America</option>
                        <option value="oceania" {{ old('continent') == 'oceania' ? 'selected' : '' }}>Oceania</option>
                        <option value="south_america" {{ old('continent') == 'south_america' ? 'selected' : '' }}>South America</option>
                    </select>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Country</label>
                    <select name="country" id="country" class="crm-select country-select">
                        @foreach ($countries as $country)
                            <option value="{{ strtolower($country->country) }}"
                                data-code="{{ $country->country_code }}"
                                {{ old('country') == strtolower($country->country) ? 'selected' : '' }}>
                                {{ $country->country }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="crm-field-wrap" id="regionGroup">
                    <label class="crm-field-label">Region</label>
                    <select name="region" id="region" class="crm-select">
                        @foreach ($regions as $region)
                            <option value="{{ $region->name }}" data-region-id="{{ $region->id }}"
                                {{ old('region') == $region->name ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="crm-field-wrap" id="stateGroup">
                    <label class="crm-field-label">State</label>
                    <select name="state" id="state" class="crm-select">
                        @foreach ($states as $state)
                            <option value="{{ $state->name }}" {{ old('state') == $state->name ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="crm-input" placeholder="Enter city">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Area</label>
                    <input type="text" name="area" value="{{ old('area') }}" class="crm-input" placeholder="Enter area">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Pincode</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" class="crm-input" placeholder="Enter pincode">
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
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" class="crm-input" placeholder="Enter company name">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Company website URL</label>
                    <input type="text" name="company_website" value="{{ old('company_website') }}"
                           class="crm-input" placeholder="https://example.com">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">GST number</label>
                    <input type="text" name="gst" value="{{ old('gst') }}" class="crm-input" placeholder="Enter GST number">
                </div>
            </div>

            <hr class="crm-divider">

            <div class="crm-form-grid crm-form-grid-2">
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Address (bill to)</label>
                    <textarea name="address_line_1" id="billTo" class="crm-textarea" placeholder="Enter billing address">{{ old('address_line_1') }}</textarea>
                </div>
                <div class="crm-field-wrap">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:5px">
                        <label class="crm-field-label" style="margin-bottom:0">Address (ship to)</label>
                        <label style="display:flex;align-items:center;gap:5px;font-size:12px;color:#6b7280;cursor:pointer;font-weight:normal;margin-bottom:0">
                            <input type="checkbox" id="sameAddress" style="margin:0"> same as bill to
                        </label>
                    </div>
                    <textarea name="address_line_2" id="shipTo" class="crm-textarea" placeholder="Enter shipping address">{{ old('address_line_2') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- CONTACT PERSONS SECTION --}}
    {{-- ============================================================ --}}
    <div class="crm-section-card">
        <div class="crm-section-header">
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
                        <option value="lead" {{ old('customer_status') == 'lead' ? 'selected' : '' }}>Lead</option>
                        <option value="quoted" {{ old('customer_status') == 'quoted' ? 'selected' : '' }}>Quoted</option>
                        <option value="existing" {{ old('customer_status') == 'existing' ? 'selected' : '' }}>Existing</option>
                    </select>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Followed by <span style="color:#DC2626">*</span></label>
                    <select name="followed_by" class="crm-select" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ (old('followed_by', Auth::id()) == $user->id) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="crm-field-wrap">
                    <label class="crm-field-label">Lead source</label>
                    <input type="text" name="lead_source" value="{{ old('lead_source') }}" class="crm-input" placeholder="Lead source">
                </div> --}}
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Remark 1</label>
                    <textarea name="remark" class="crm-textarea" placeholder="Enter remarks">{{ old('remark') }}</textarea>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Remark 2</label>
                    <textarea name="remark2" class="crm-textarea" placeholder="Enter additional remarks">{{ old('remark2') }}</textarea>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Lead source remark</label>
                    <textarea name="lead_source_remark" class="crm-textarea" placeholder="Enter lead source remark">{{ old('lead_source_remark') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="crm-form-actions">
        <button type="submit" class="btn-primary-crm">
            <i class="fas fa-save"></i> Submit
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
@if(old('contact_persons'))
<script>
    window.EXISTING_PERSONS = @json(array_values(old('contact_persons')));
</script>
@endif
<script src="{{ asset('js/customer.js') }}"></script>
<script src="{{ asset('js/country.js') }}"></script>
<script>
</script>
@endpush