@extends('layouts.app')

@section('title', 'Edit Lead')

@section('content_header')
    <a href="{{ route('lead.index') }}" class="text-primary"><i class="fas fa-arrow-left"></i> Back to Leads</a>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-edit"></i> Edit Lead Information</h3>
            @if ($errors->any())
            <p>{{ $errors }}</p>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('lead.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row p-4">

                    <!-- Full Name -->
                    <div class="col-md-6">
                        <x-adminlte-input name="full_name" label="Full Name" value="{{ old('full_name', $lead->full_name) }}" placeholder="Enter Full Name"
                            fgroup-class="mb-3" />
                        @error('full_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <x-adminlte-input name="email" label="Email" value="{{ old('email', $lead->email) }}" placeholder="Enter Email"
                            fgroup-class="mb-3" />
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <x-adminlte-input name="phone" label="Phone" value="{{ old('phone', $lead->phone) }}" placeholder="Enter Phone Number"
                            fgroup-class="mb-3" />
                        @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company -->
                    <div class="col-md-6">
                        <x-adminlte-input name="company" label="Company" value="{{ old('company', $lead->company) }}" placeholder="Enter Company Name"
                            fgroup-class="mb-3" />
                        @error('company')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lead Source -->
                    <div class="col-md-6">
                        <x-adminlte-select name="lead_source" label="Lead Source" fgroup-class="mb-3">
                            <option value="web" {{ old('lead_source', $lead->lead_source) == 'web' ? 'selected' : '' }}>Web</option>
                            <option value="referral" {{ old('lead_source', $lead->lead_source) == 'referral' ? 'selected' : '' }}>Referral</option>
                            <option value="cold_call" {{ old('lead_source', $lead->lead_source) == 'cold_call' ? 'selected' : '' }}>Cold Call</option>
                            <option value="social_media" {{ old('lead_source', $lead->lead_source) == 'social_media' ? 'selected' : '' }}>Social Media</option>
                            <option value="other" {{ old('lead_source', $lead->lead_source) == 'other' ? 'selected' : '' }}>Other</option>
                        </x-adminlte-select>
                        @error('lead_source')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <x-adminlte-select name="status" label="Status" fgroup-class="mb-3">
                            <option value="new" {{ old('status', $lead->status) == 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ old('status', $lead->status) == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="qualified" {{ old('status', $lead->status) == 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="disqualified" {{ old('status', $lead->status) == 'disqualified' ? 'selected' : '' }}>Disqualified</option>
                        </x-adminlte-select>
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <x-adminlte-input name="address" label="Address" value="{{ old('address', $lead->address) }}" placeholder="Enter Address"
                            fgroup-class="mb-3" />
                        @error('address')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div class="col-md-6">
                        <x-adminlte-input name="city" label="City" value="{{ old('city', $lead->city) }}" placeholder="Enter City"
                            fgroup-class="mb-3" />
                        @error('city')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div class="col-md-6">
                        <x-adminlte-select name="state" label="State" fgroup-class="mb-3">
                            @foreach ($states as $state)
                                <option value="{{ $state->name }}" {{ old('state', $lead->state) == $state->name ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!-- Postal Code -->
                    <div class="col-md-6">
                        <x-adminlte-input name="postal_code" label="Postal Code" value="{{ old('postal_code', $lead->postal_code) }}" placeholder="Enter Postal Code"
                            fgroup-class="mb-3" />
                        @error('postal_code')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-md-6">
                        <x-adminlte-textarea name="notes" label="Remark1" placeholder="Enter any additional notes" fgroup-class="mb-3">{{ old('notes', $lead->notes) }}</x-adminlte-textarea>
                    </div>
                    
                    <div class="col-md-6">
                        <x-adminlte-textarea name="remark2" label="Remark2" placeholder="Enter any notes about the lead"
                            fgroup-class="mb-3">{{ old('remark2', $lead->remark2) }}</x-adminlte-textarea>
                    </div>

                    <!-- Assign To -->
                    <div class="col-md-6">
                        <x-adminlte-select class="select2" name="followed_by" label="Followed By">
                            <option>Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('followed_by', $lead->followed_by) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                </div>

                <!-- Save and Cancel Buttons -->
                <div class="mt-4 text-right">
                    <a href="{{ route('lead.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@stop


@push('js')
<script>
    $(document).ready(function() {
        // You can add additional JavaScript functionality if needed
    });
</script>
@endpush

@push('css')
<style type="text/css">
    /* Custom CSS for Form */
    .card-header {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }
    .card-body {
        background-color: #f8f9fa;
    }
    .btn-primary:hover, .btn-secondary:hover {
        cursor: pointer;
    }
    .form-control, .select2 {
        border-radius: 0.375rem;
        box-shadow: none;
    }
    .select2 {
        width: 100% !important;
    }
    .btn-sm {
        font-size: 14px;
        padding: 8px 20px;
    }
    .mb-3 {
        margin-bottom: 1rem !important;
    }
    .card-footer {
        background-color: #f8f9fa;
        
    }
</style>
@endpush

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush

