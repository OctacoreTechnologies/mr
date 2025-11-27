@extends('layouts.app')

@section('title', 'Task Details')

@section('content_header')
    <a href="{{ route('lead.index') }}" class="text-primary"><i class="fas fa-arrow-left"></i> Home</a>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-edit"></i> Lead Details</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('lead.store') }}">
                @csrf
                @method("POST")
                <div class="row p-4">
                    <!-- Full Name -->
                    <div class="col-md-6">
                        <x-adminlte-input name="full_name" value="{{ old('full_name') }}" label="Full Name"
                            placeholder="Enter Full Name" fgroup-class="mb-3" disable-feedback />
                        @error('full_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <x-adminlte-input name="email" value="{{ old('email') }}" label="Email"
                            placeholder="Enter Email" fgroup-class="mb-3" disable-feedback />
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <x-adminlte-input name="phone" value="{{ old('phone') }}" label="Phone"
                            placeholder="Enter Phone Number" fgroup-class="mb-3" disable-feedback />
                        @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company -->
                    <div class="col-md-6">
                        <x-adminlte-input name="company" value="{{ old('company') }}" label="Company"
                            placeholder="Enter Company Name" fgroup-class="mb-3" disable-feedback />
                        @error('company')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lead Source -->
                    <div class="col-md-6">
                        <x-adminlte-select name="lead_source" label="Lead Source" fgroup-class="mb-3">
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

                    <!-- Status -->
                    <div class="col-md-6">
                        <x-adminlte-select name="status" label="Status" fgroup-class="mb-3">
                            <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="disqualified" {{ old('status') == 'disqualified' ? 'selected' : '' }}>Disqualified</option>
                        </x-adminlte-select>
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <x-adminlte-input name="address" value="{{ old('address') }}" label="Address"
                            placeholder="Enter Address" fgroup-class="mb-3" disable-feedback />
                        @error('address')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div class="col-md-6">
                        <x-adminlte-input name="city" value="{{ old('city') }}" label="City"
                            placeholder="Enter City" fgroup-class="mb-3" disable-feedback />
                        @error('city')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div class="col-md-6">
                        <x-adminlte-select name="state" label="State" fgroup-class="mb-3">
                            @foreach ($states as $state)
                                <option value="{{ $state->name }}" {{ old('state') == $state->name ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!-- Postal Code -->
                    <div class="col-md-6">
                        <x-adminlte-input name="postal_code" value="{{ old('postal_code') }}" label="Postal Code"
                            placeholder="Enter Postal Code" fgroup-class="mb-3" disable-feedback />
                        @error('postal_code')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-md-6">
                        <x-adminlte-textarea name="notes" label="Remark1" placeholder="Enter any notes about the lead"
                            fgroup-class="mb-3">{{ old('notes') }}</x-adminlte-textarea>
                        @error('notes')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-textarea name="remark2" label="Remark2" placeholder="Enter any notes about the lead"
                            fgroup-class="mb-3">{{ old('remark2') }}</x-adminlte-textarea>
                    </div>

                    <!-- Assign To User -->
                    <div class="col-md-6">
                        <x-adminlte-select class="select2" label="Followed By" name="followed_by">
                            <option>Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('followed_by') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-12 text-right">
                        <x-adminlte-button label="Submit" type="submit" theme="success" class="mx-2 my-2" />
                        <x-adminlte-button label="Cancel" type="reset" theme="danger" class="my-2" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        // JavaScript functionality can be added here if needed
    });
</script>
@endpush

@push('css')
<style type="text/css">
    /* Custom styles for this page */
    .card-header {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }
    .card-body {
        background-color: #f8f9fa;
    }
    .btn-success:hover, .btn-danger:hover {
        cursor: pointer;
    }
    .form-control {
        border-radius: 0.375rem;
    }
    .select2 {
        width: 100% !important;
    }
    .btn-sm {
        font-size: 14px;
        padding: 8px 20px;
    }
</style>
@endpush

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush

