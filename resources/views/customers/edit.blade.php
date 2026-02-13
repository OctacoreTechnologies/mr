@extends('layouts.app')

@section('title', 'Customer Edit')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0 text-primary font-weight-bold">Edit Customer</h1>
        <a href="{{ route('customer.index') }}" class="btn btn-outline-primary"><i class="fas fa-home"></i> Home</a>
    </div>
@stop

@section('content')
    <x-alert-components class="my-3" />

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-edit"></i> Customer Information</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('customer.update', $customer->id) }}">
                @csrf
                @method('PUT')
                <div class="row p-4">
                    <!-- Location Type -->
                    <div class="col-md-6">
                        <x-adminlte-select name="location_type" label="Location Type" fgroup-class="mb-3">
                            <option value="domestic" {{ $customer->location_type == 'domestic' ? 'selected' : '' }}>Domestic
                            </option>
                            <option value="international"
                                {{ $customer->location_type == 'international' ? 'selected' : '' }}>
                                International</option>
                        </x-adminlte-select>
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-select name="continent" id="continent" label="Select Continent" id="continent"
                            class="select2">
                            <option value="">--Please choose an option--</option>
                            <option value="africa" {{$customer->continent == 'africa'?'selected':''}}>Africa</option>
                            <option value="antarctica" {{$customer->continent == 'antarctica'?'selected':''}}>Antarctica</option>
                            <option value="asia" {{$customer->continent == 'asia'?'selected':''}}>Asia</option>
                            <option value="europe" {{$customer->continent == 'europe'?'selected':''}}>Europe</option>
                            <option value="north_america" {{$customer->continent == 'north_america'?'selected':''}}>North America</option>
                            <option value="oceania" {{$customer->continent == 'oceania'?'selected':''}}>Oceania</option>
                            <option value="south_america" {{$customer->continent == 'south_america'?'selected':''}}>South America</option>
                        </x-adminlte-select>
                    </div>

                    <div class="col-md-6">
                        <label for="region" class="font-weight-bold text-muted">Region</label>
                        <select name="region" id="region" class="form-control select2 rounded-pill">
                            <option {{ $customer->region }}>{{ $customer->region }}</option>
                            @foreach ($regions as $region)
                                <option value="{{ old('region', $region->name) }}" data-region-id={{$region->id}} {{$customer->region == $region->name?'selected':''}}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <x-adminlte-select name="country" id="country" label="Select Country" class="country-select">
                            @foreach ($countries as $country)
                                <option value="{{ strtolower($country->country) }}"   data-code="{{ $country->country_code }}"
                                    {{ strtolower($country->country) == strtolower($customer->country) ? 'selected' : '' }}>
                                    {{ $country->country }}
                                </option>
                            @endforeach
                        </x-adminlte-select>

                    </div>

                    <!-- State -->
                    <div class="col-md-6" id="stateGroup">
                        <x-adminlte-select name="state" label="State" fgroup-class="mb-3">
                            @foreach ($states as $state)
                                <option value="{{ $state->name }}"
                                    {{ strtolower($state->name) == strtolower($customer->state) ? 'selected' : '' }}>
                                    {{ $state->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!-- City -->
                    <div class="col-md-6">
                        <x-adminlte-input name="city" value="{{ $customer->city ?? '' }}" label="City"
                            placeholder="Enter City" fgroup-class="mb-3" disable-feedback />
                    </div>

                    <!-- Area -->
                    <div class="col-md-6">
                        <x-adminlte-input name="area" value="{{ $customer->area ?? '' }}" label="Area"
                            placeholder="Enter Area" fgroup-class="mb-3" disable-feedback />
                    </div>

                    <!-- Pincode -->
                    <div class="col-md-6">
                        <x-adminlte-input name="pincode" value="{{ $customer->pincode ?? '' }}" label="Pincode"
                            placeholder="Enter Pincode" fgroup-class="mb-3" disable-feedback />
                        @error('pincode')
                            <p class="text text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Name -->
                    <div class="col-md-6">
                        <x-adminlte-input name="company_name" value="{{ $customer->company_name ?? '' }}"
                            label="Company Name" placeholder="Enter Company Name" fgroup-class="mb-3" disable-feedback />
                    </div>

                    <!-- Contact No -->
                    <div class="col-md-6">

                        <label>Contact No</label>

                        <div class="input-group">

                            <div class="input-group-prepend">
                                <span class="input-group-text country-code">
                                    {{ $customer->country_code ?? +91 }}
                                </span>
                                <input type="hidden" name="country_code" id="countryCodeField"
                                    value="{{ $customer->country_code ?? +91 }}">
                            </div>

                            <input type="text" name="contact_no" value="{{ $customer->contact_no }}"
                                class="form-control contact-number" placeholder="Enter Contact No">

                        </div>
                    </div>

                    <!-- Address Line 1 -->
                    <div class="col-md-6">
                        <x-adminlte-textarea name="address_line_1" label="Address Line 1" placeholder="Enter Address Line 1"
                            fgroup-class="mb-3">{{ $customer->address_line_2 ?? '' }}</x-adminlte-textarea>
                    </div>

                    <!-- Address Line 2 -->
                    <div class="col-md-6">
                        <x-adminlte-textarea name="address_line_2" label="Address Line 2" placeholder="Enter Address Line 2"
                            fgroup-class="mb-3">{{ $customer->address_line_2 ?? '' }}</x-adminlte-textarea>
                    </div>

                    <!-- Contact Person's -->
                    <div class="row col-12">
                        @for ($i = 1; $i <= 6; $i++)
                            <div class="col-md-6">
                                <x-adminlte-input name="contact_person_{{ $i }}_name"
                                    value="{{ $customer->{'contact_person_' . $i . '_name'} ?? '' }}"
                                    label="Contact Person {{ $i }} Name"
                                    placeholder="Enter Contact Person 2 Name" fgroup-class="mb-3" disable-feedback />
                            </div>

                            <!-- Contact Person 2 Designation -->
                            <div class="col-md-6">
                                <x-adminlte-input name="contact_person_{{ $i }}_designation"
                                    value="{{ $customer->{'contact_person_' . $i . '_designation'} ?? '' }}"
                                    label="Contact Person {{ $i }} Designation"
                                    placeholder="Enter Contact Person 2 Designation" fgroup-class="mb-3"
                                    disable-feedback />
                            </div>

                            <!-- Contact Person 2 Contact -->
                            {{-- <div class="col-md-6">
                                <x-adminlte-input name="contact_person_{{ $i }}_contact"
                                    value="{{ $customer->{'contact_person_' . $i . '_contact'} ?? '' }}"
                                    label="Contact Person {{ $i }} Contact"
                                    placeholder="Enter Contact Person 2 Contact" fgroup-class="mb-3" disable-feedback
                                    class="contact-number" />
                            </div> --}}
                            <div class="col-md-6">
                                <label>Contact Person {{ $i }} Contact</label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text country-code">
                                            {{ $customer->country_code ?? +91 }}
                                        </span>
                                        <input type="hidden" name="country_code" id="countryCodeField" class="country_code_field"
                                            value="{{ $customer->country_code ?? +91 }}">
                                    </div>

                                    <input type="text" name="contact_person_{{ $i }}_contact"   value="{{ $customer->{'contact_person_' . $i . '_contact'} ?? '' }}"
                                        class="form-control contact-number" placeholder="Enter Contact No">
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <x-adminlte-input type="email" name="contact_person_{{ $i }}_eamil"
                                        value="{{ $customer->{'contact_person_' . $i . '_email'} ?? '' }}"
                                        label="Contact Person {{ $i }} email"
                                        placeholder="Enter Contact Person 2 Email" fgroup-class="mb-3" disable-feedback />
                                </div>
                        @endfor
                    </div>

                    <!-- GST -->
                    <div class="col-md-6">
                        <x-adminlte-input name="gst" value="{{ $customer->gst ?? '' }}" label="GST"
                            placeholder="Enter GST Number" fgroup-class="mb-3" disable-feedback />
                    </div>
                    <!-- Status -->
                    <div class="col-md-6">
                        <x-adminlte-select name="status" label="Status" fgroup-class="mb-3">
                            <option value="new" {{ $customer->status == 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ $customer->status == 'contacted' ? 'selected' : '' }}>Contacted
                            </option>
                            <option value="qualified" {{ $customer->status == 'qualified' ? 'selected' : '' }}>Qualified
                            </option>
                            <option value="disqualified" {{ $customer->status == 'disqualified' ? 'selected' : '' }}>
                                Disqualified</option>
                        </x-adminlte-select>
                    </div>

                    <!-- Remarks -->
                    <div class="col-md-6">
                        <x-adminlte-textarea name="remark" label="Remark1" placeholder="Enter any remarks"
                            fgroup-class="mb-3">{{ old('remark1', $customer->remark1) }}</x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea name="remark2" label="Remark2" placeholder="Enter any remarks"
                            fgroup-class="mb-3">{{ old('remark2', $customer->remark2) }}</x-adminlte-textarea>
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-select name="followed_by" label="Followed By" class="select2" fgroup-class="mb-3">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $customer->followed_by == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!-- Submit and Cancel Buttons -->
                    <div class="col-md-12">
                        <x-adminlte-button label="Update" type="submit" theme="primary" class="mx-2 my-2" />
                        <x-adminlte-button label="Cancel" type="button" theme="danger" class="my-2"
                            onclick="window.history.back();" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('style/customer.css') }}">
@endpush
@push('js')
    <script src={{ asset('js/country.js') }}></script>
@endpush
