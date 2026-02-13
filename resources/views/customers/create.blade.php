@extends('layouts.app')

@section('title', 'Create Customer')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0 text-primary font-weight-bold">Add New Customer</h1>
        <a href="{{ route('customer.index') }}" class="btn btn-outline-primary"><i class="fas fa-home"></i> Home</a>
    </div>
@stop

@section('content')

    <x-alert-components class="my-3" />

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white rounded-top">
            <h3 class="card-title"><i class="fas fa-building"></i> Customer Information</h3>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('customer.store') }}">
                @csrf
                <div class="row">
                    <input type="hidden" name="type" value="customer">
                    <!-- Location Type -->
                    <div class="col-md-4">
                        <x-adminlte-select name="location_type" label="Location Type" fgroup-class="mb-3">
                            <option value="international">International</option>
                            <option value="domestic">Domestic</option>
                        </x-adminlte-select>
                    </div>

                    <!-- Continent -->
                    <div class="col-md-4">
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

                    <!-- Country -->
                    <div class="col-md-4">
                        <x-adminlte-select name="country" label="Select Country" class="country-select">
                            @foreach ($countries as $country)
                                <option value="{{ strtolower($country->country) }}"
                                    data-code="{{ $country->country_code }}">{{ $country->country }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!-- Region -->
                    <div class="col-md-4">
                        <label for="region" class="font-weight-bold text-muted">Region</label>
                        <select name="region" id="region" class="form-control select2 rounded-pill">
                            @foreach ($regions as $region)
                                <option value="{{ old('region', $region) }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- State -->
                    <div class="col-md-4" id="stateGroup">
                        <x-adminlte-select name="state" label="State" class="form-control w-100">
                            @foreach ($states as $state)
                                <option value="{{ $state->name }}">{{ $state->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!-- City -->
                    <div class="col-md-4">
                        <x-adminlte-input name="city" value="{{ old('city') }}" label="City" placeholder="Enter City"
                            fgroup-class="mb-3" disable-feedback />
                    </div>

                    <!-- Area -->
                    <div class="col-md-4">
                        <x-adminlte-input name="area" value="{{ old('area') }}" label="Area"
                            placeholder="Enter Area" fgroup-class="mb-3" disable-feedback />
                    </div>

                    <!-- Pincode -->
                    <div class="col-md-4">
                        <x-adminlte-input name="pincode" value="{{ old('pincode') }}" label="Pincode"
                            placeholder="Enter Pincode" fgroup-class="mb-3" disable-feedback />
                    </div>

                    <!-- Company Name -->
                    <div class="col-md-4">
                        <x-adminlte-input name="company_name" value="{{ old('company_name') }}" label="Company Name"
                            placeholder="Enter Company Name" fgroup-class="mb-3" disable-feedback />
                    </div>

                    <!-- Contact No -->
                    <div class="col-md-4 contact-wrapper">

                        <label>Contact No</label>

                        <div class="input-group">

                            <div class="input-group-prepend">
                                <span class="input-group-text country-code">
                                    +91
                                </span>
                                <input type="hidden" name="country_code" id="countryCodeField" value="+91">
                            </div>

                            <input type="text" name="contact_no" value="{{ old('contact_no') }}"
                                class="form-control contact-number" placeholder="Enter Contact No">

                        </div>
                    </div>

                    <!-- Address Lines -->
                    <div class="col-md-4">
                        <x-adminlte-textarea name="address_line_1" label="Address Line 1 (Bill To)"
                            placeholder="Enter Address Line 1"
                            fgroup-class="mb-3">{{ old('address_line_1') }}</x-adminlte-textarea>
                    </div>
                    <div class="col-md-4">
                        <x-adminlte-textarea name="address_line_2" label="Address Line 2 (Ship To)"
                            placeholder="Enter Address Line 2"
                            fgroup-class="mb-3">{{ old('address_line_2') }}</x-adminlte-textarea>
                    </div>

                    <div class="col-md-4">
                        <x-adminlte-select name="no_of_persons" label="No. Of Contact Person's">
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </x-adminlte-select>
                    </div>

                    <!-- Contact Persons -->
                    <div class="row col-12" id="contact_person_fields">
                        <div class="col-md-4">
                            <x-adminlte-input name="contact_person_1_name" value="{{ old('contact_person_1_name') }}"
                                label="Contact Person 1 Name" placeholder="Enter Name" fgroup-class="mb-3" />
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-input name="contact_person_1_designation"
                                value="{{ old('contact_person_1_designation') }}" label="Contact Person 1 Designation"
                                placeholder="Enter Designation" fgroup-class="mb-3" />
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-input name="contact_person_1_contact"
                                value="{{ old('contact_person_1_contact') }}" label="Contact Person 1 Contact"
                                placeholder="Enter contact" fgroup-class="mb-3" />
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-input name="contact_person_1_email" value="{{ old('contact_person_1_email') }}"
                                label="Contact Person 1 Email" placeholder="Enter Email" fgroup-class="mb-3" />
                        </div>
                    </div>

                    <!-- GST -->
                    <div class="col-md-4">
                        <x-adminlte-input name="gst" value="{{ old('gst') }}" label="GST Number"
                            placeholder="Enter GST Number" fgroup-class="mb-3" />
                    </div>
                    <!-- Status and Followed By -->
                    <div class="col-md-4">
                        <x-adminlte-select name="status" label="Status" fgroup-class="mb-3">
                            <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted
                            </option>
                            <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Qualified
                            </option>
                            <option value="disqualified" {{ old('status') == 'disqualified' ? 'selected' : '' }}>
                                Disqualified
                            </option>
                        </x-adminlte-select>
                    </div>
                    <!-- Remarks -->
                    <div class="col-md-4">
                        <x-adminlte-textarea name="remark" label="Remark1" placeholder="Enter any remarks"
                            fgroup-class="mb-3">{{ old('remark') }}</x-adminlte-textarea>
                    </div>
                    <div class="col-md-4">
                        <x-adminlte-textarea name="remark2" label="Remark2" placeholder="Enter any remarks"
                            fgroup-class="mb-3">{{ old('remark2') }}</x-adminlte-textarea>
                    </div>
                    <div class="col-md-4">
                        <x-adminlte-select name="followed_by" label="Followed By" class="select2" fgroup-class="mb-3">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ Auth::id() == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-12 text-center mt-3">
                        <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2" />
                        <x-adminlte-button label="Cancel" type="button" theme="danger" class="mx-2"
                            onclick="window.history.back();" />
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/customer.css') }}">
@endpush

@push('js')
<script src={{ asset('js/customer.js') }}></script>
<script src={{ asset('js/country.js') }}></script>
@endpush
