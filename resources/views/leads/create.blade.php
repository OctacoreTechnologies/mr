@extends('layouts.app')

@section('title', 'Lead Create')

@section('content_header')
    <a href="{{ route('lead.index') }}" class="text-primary"><i class="fas fa-arrow-left"></i> Home</a>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-building"></i> Lead Information
        </h3>
    </div>

    <div class="crm-card-body">

        <form method="POST" action="{{ route('customer.store') }}">
            @csrf

            <input type="hidden" name="type" value="lead">

            {{-- ── Lead Source ── --}}
            <p class="crm-section">Lead Source</p>

            <div class="row">

                <div class="col-md-6">
                    <x-adminlte-select name="lead_source" id="lead_source" label="Lead Source" fgroup-class="mb-3">
                        <option value="web" {{ old('lead_source') == 'web' ? 'selected' : '' }}>Web</option>
                        <option value="referral" {{ old('lead_source') == 'referral' ? 'selected' : '' }}>Referral</option>
                        <option value="cold_call" {{ old('lead_source') == 'cold_call' ? 'selected' : '' }}>Cold Call</option>
                        <option value="social_media" {{ old('lead_source') == 'social_media' ? 'selected' : '' }}>Social Media</option>
                        <option value="other" {{ old('lead_source') == 'other' ? 'selected' : '' }}>Other</option>
                    </x-adminlte-select>
                    @error('lead_source')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-6" id="lead_source_remark_div"
                     style="display: {{ old('lead_source') == 'other' ? 'block' : 'none' }};">
                    <x-adminlte-textarea name="lead_source_remark" label="Lead Source Remark"
                        placeholder="Enter any remarks regarding the lead source"
                        fgroup-class="mb-3">{{ old('lead_source_remark') }}</x-adminlte-textarea>
                </div>

            </div>

            {{-- ── Location Details ── --}}
            <p class="crm-section">Location Details</p>

            <div class="row">

                <div class="col-md-6">
                    <x-adminlte-select name="location_type" label="Location Type" fgroup-class="mb-3">
                        <option value="international">International</option>
                        <option value="domestic">Domestic</option>
                    </x-adminlte-select>
                </div>

                <div class="col-md-6">
                    <x-adminlte-select name="continent" label="Select Continent" fgroup-class="mb-3">
                        <option value="">--Please choose an option--</option>
                        <option value="africa">Africa</option>
                        <option value="antarctica">Antarctica</option>
                        <option value="asia">Asia</option>
                        <option value="europe">Europe</option>
                        <option value="north_america">North America</option>
                        <option value="oceania">Oceania</option>
                        <option value="south_america">South America</option>
                    </x-adminlte-select>
                </div>

                <div class="col-md-6">
                    <x-adminlte-select name="country" label="Select Country" class="country-select">
                        @foreach ($countries as $country)
                            <option value="{{ strtolower($country->country) }}"
                                data-code="{{ $country->country_code }}">
                                {{ $country->country }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                <div class="col-md-6">
                    <label>Region</label>
                    <select name="region" id="region" class="form-control select2">
                        @foreach ($regions as $region)
                            <option value="{{ old('region', $region->name) }}"
                                data-region-id="{{ $region->id }}">
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6" id="stateGroup">
                    <x-adminlte-select name="state" label="State" fgroup-class="mb-3">
                        @foreach ($states as $state)
                            <option value="{{ $state->name }}">{{ $state->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                <div class="col-md-6">
                    <x-adminlte-input name="city" value="{{ old('city') }}" label="City"
                        placeholder="Enter City" fgroup-class="mb-3" />
                </div>

                <div class="col-md-6">
                    <x-adminlte-input name="area" value="{{ old('area') }}" label="Area"
                        placeholder="Enter Area" fgroup-class="mb-3" />
                </div>

                <div class="col-md-6">
                    <x-adminlte-input name="pincode" value="{{ old('pincode') }}" label="Pincode"
                        placeholder="Enter Pincode" fgroup-class="mb-3" />
                </div>

            </div>

            {{-- ── Company Details ── --}}
            <p class="crm-section">Company Details</p>

            <div class="row">

                <div class="col-md-6">
                    <x-adminlte-input name="company_name" value="{{ old('company_name') }}"
                        label="Company Name" placeholder="Enter Company Name"
                        fgroup-class="mb-3" />
                </div>

                <div class="col-md-6">
                    <x-adminlte-input name="gst" value="{{ old('gst') }}"
                        label="GST Number" placeholder="Enter GST Number"
                        fgroup-class="mb-3" />
                </div>

                <div class="col-md-6">
                    <x-adminlte-textarea name="address_line_1" label="Address (Bill To)"
                        fgroup-class="mb-3">{{ old('address_line_1') }}</x-adminlte-textarea>
                </div>

                <div class="col-md-6">
                    <x-adminlte-textarea name="address_line_2" label="Address Line 2 (Ship To)"
                        fgroup-class="mb-3">{{ old('address_line_2') }}</x-adminlte-textarea>
                </div>

            </div>

            {{-- ── Contact Persons ── --}}
            <p class="crm-section">Contact Persons</p>

            <div class="row">

                <div class="col-md-6">
                    <x-adminlte-select name="no_of_persons" id="no_of_persons" label="No. Of Contact Person's">
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </x-adminlte-select>
                </div>

                <div class="row col-12" id="contact_person_fields">

                    <div class="col-md-6">
                        <x-adminlte-input name="contact_person_1_name"
                            value="{{ old('contact_person_1_name') }}"
                            label="Contact Person 1 Name" fgroup-class="mb-3" />
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-input name="contact_person_1_designation"
                            value="{{ old('contact_person_1_designation') }}"
                            label="Contact Person 1 Designation" fgroup-class="mb-3" />
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-input name="contact_person_1_contact"
                            value="{{ old('contact_person_1_contact') }}"
                            label="Contact Person 1 Contact"
                            fgroup-class="mb-3" class="contact-number" />
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-input name="contact_person_1_email"
                            value="{{ old('contact_person_1_email') }}"
                            label="Contact Person 1 Email" fgroup-class="mb-3" />
                    </div>

                </div>

            </div>

            {{-- ── Status & Remarks ── --}}
            <p class="crm-section">Status & Remarks</p>

            <div class="row">

                <div class="col-md-6">
                    <x-adminlte-select name="status" label="Status" fgroup-class="mb-3">
                        <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                        <option value="disqualified" {{ old('status') == 'disqualified' ? 'selected' : '' }}>Disqualified</option>
                    </x-adminlte-select>
                </div>

                <div class="col-md-6">
                    <x-adminlte-select name="followed_by" label="Followed By" fgroup-class="mb-3">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ Auth::id() == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                <div class="col-md-6">
                    <x-adminlte-textarea name="remark" label="Remark 1"
                        fgroup-class="mb-3">{{ old('remark') }}</x-adminlte-textarea>
                </div>

                <div class="col-md-6">
                    <x-adminlte-textarea name="remark2" label="Remark 2"
                        fgroup-class="mb-3">{{ old('remark2') }}</x-adminlte-textarea>
                </div>

            </div>

            {{-- ── Actions ── --}}
            <div class="crm-form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> Submit
                </button>

                <button type="button" class="btn btn-outline-secondary"
                        onclick="window.history.back();">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const noOfPersonsSelect = document.getElementById('no_of_persons') || document.querySelector(
                '[name="no_of_persons"]');
            const contactPersonFieldsContainer = document.getElementById('contact_person_fields');

            const existingContacts = {};
            @for ($i = 1; $i <= 6; $i++)
                existingContacts[{{ $i }}] = {
                    name: {!! json_encode(old('contact_person_' . $i . '_name', '')) !!},
                    designation: {!! json_encode(old('contact_person_' . $i . '_designation', '')) !!},
                    contact: {!! json_encode(old('contact_person_' . $i . '_contact', '')) !!},
                    email: {!! json_encode(old('contact_person_' . $i . '_email', '')) !!}
                };
            @endfor

            function escapeHtml(str) {
                if (str === null || str === undefined) return '';
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/\"/g, '&quot;')
                    .replace(/'/g, '&#39;');
            }

            function renderContactPersons() {
                const numberOfPersons = parseInt((noOfPersonsSelect && noOfPersonsSelect.value) || 1);
                var code = $(this).find(':selected').data('code');
                if (!contactPersonFieldsContainer) return;
                contactPersonFieldsContainer.innerHTML = '';
                for (let i = 1; i <= numberOfPersons; i++) {
                    const data = existingContacts[i] || {
                        name: '',
                        designation: '',
                        contact: '',
                        email: ''
                    };
                    const fieldHTML = `
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="contact_person_${i}_name">Contact Person ${i} Name</label>
                                        <input type="text" class="form-control" id="contact_person_${i}_name" name="contact_person_${i}_name" placeholder="Enter Name" value="${escapeHtml(data.name)}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="contact_person_${i}_designation">Contact Person ${i} Designation</label>
                                        <input type="text" class="form-control" id="contact_person_${i}_designation" name="contact_person_${i}_designation" placeholder="Enter Designation" value="${escapeHtml(data.designation)}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <label>Contact Person ${i} Contact</label>
                                            <div class="input-group">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text country-code">
                                                    +91
                                                </span>
                                                <input type="hidden" name="country_code" id="countryCodeField" value="+91">
                                            </div>

                                             <input type="text" name="contact_person_${i}_contact" value=""
                                                 class="form-control contact-number" placeholder="Enter Contact No">
                 
                                             </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="contact_person_${i}_email">Contact Person ${i} Email</label>
                                        <input type="email" class="form-control" id="contact_person_${i}_email" name="contact_person_${i}_email" placeholder="Enter Email" value="${escapeHtml(data.email)}">
                                    </div>
                                </div>
                            `;
                    contactPersonFieldsContainer.innerHTML += fieldHTML;
                }
            }

            if (noOfPersonsSelect && contactPersonFieldsContainer) {
                noOfPersonsSelect.addEventListener('change', renderContactPersons);
                renderContactPersons();
            }

        });

        const leadSource = document.getElementById('lead_source');
        const remarkDiv = document.getElementById('lead_source_remark_div');

        leadSource.addEventListener('change', function() {
           
            if (this.value === 'other') {
                remarkDiv.style.display = 'block';
            } else {
                remarkDiv.style.display = 'none';
                document.getElementById('lead_source_remark').value = ''; 
            }
        });
    </script>
    <script src={{ asset('js/country.js') }}></script>
@endpush
