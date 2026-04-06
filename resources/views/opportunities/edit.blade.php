@extends('layouts.app')

@section('title', 'Edit Opportunity')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-edit"></i>
        Edit Opportunity
    </h1>
    <a href="{{ route('opportunity.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Opportunities
    </a>
</div>
@stop

@section('content')

<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Opportunity Information
        </h3>
    </div>

    <div class="crm-card-body">

        <form action="{{ route('opportunity.update', $opportunity->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ── Opportunity Details ── --}}
            <p class="crm-section">Opportunity Details</p>
            <div class="row">
            <div class="col-md-12">
                <x-adminlte-textarea name="description" label="Description">{{ $opportunity->description??'' }}</x-adminlte-textarea>
                <input type="hidden" name="customer_id" value="{{ $opportunity->customer_id ?? '' }}" />
              </div>
                {{-- Stage --}}
                <div class="col-md-6">
                    <x-adminlte-select name="stage" label="Stage" fgroup-class="mb-3">
                        <option value="qualification" {{ old('stage', $opportunity->stage) == 'qualification' ? 'selected' : '' }}>Qualification</option>
                        <option value="proposal"      {{ old('stage', $opportunity->stage) == 'proposal'      ? 'selected' : '' }}>Proposal</option>
                        <option value="negotiation"   {{ old('stage', $opportunity->stage) == 'negotiation'   ? 'selected' : '' }}>Negotiation</option>
                        <option value="closed_won"    {{ old('stage', $opportunity->stage) == 'closed_won'    ? 'selected' : '' }}>Closed Won</option>
                        <option value="closed_lost"   {{ old('stage', $opportunity->stage) == 'closed_lost'   ? 'selected' : '' }}>Closed Lost</option>
                    </x-adminlte-select>
                    @error('stage') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                {{-- Expected Close Date --}}
                <div class="col-md-6">
                    <x-adminlte-input name="expected_close_date" type="date" label="Expected Close Date"
                        value="{{ old('expected_close_date', $opportunity->expected_close_date) }}"
                        fgroup-class="mb-3" />
                    @error('expected_close_date') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                {{-- Close Date --}}
                <div class="col-md-6">
                    <x-adminlte-input name="close_date" type="date" label="Close Date"
                        value="{{ old('close_date', $opportunity->close_date) }}"
                        fgroup-class="mb-3" />
                    @error('close_date') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                {{-- Opportunity Type --}}
                <div class="col-md-6">
                    <x-adminlte-select name="opportunity_type" label="Opportunity Type" fgroup-class="mb-3">
                        <option value="new_business" {{ old('opportunity_type', $opportunity->opportunity_type) == 'new_business' ? 'selected' : '' }}>New Enquiry</option>
                        <option value="upsell"       {{ old('opportunity_type', $opportunity->opportunity_type) == 'upsell'       ? 'selected' : '' }}>Upsell</option>
                        <option value="cross_sell"   {{ old('opportunity_type', $opportunity->opportunity_type) == 'cross_sell'   ? 'selected' : '' }}>Cross Sell</option>
                        <option value="renewal"      {{ old('opportunity_type', $opportunity->opportunity_type) == 'renewal'      ? 'selected' : '' }}>Renewal</option>
                    </x-adminlte-select>
                    @error('opportunity_type') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                {{-- Assigned To --}}
                <div class="col-md-6">
                    <x-adminlte-select name="assigned_to" label="Assigned To" fgroup-class="mb-3"
                        class="js-example-basic-single">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                    @error('assigned_to') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                {{-- Priority --}}
                <div class="col-md-6">
                    <x-adminlte-select name="priority" label="Priority" fgroup-class="mb-3">
                        <option value="low"    {{ old('priority', $opportunity->priority) == 'low'    ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $opportunity->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high"   {{ old('priority', $opportunity->priority) == 'high'   ? 'selected' : '' }}>High</option>
                    </x-adminlte-select>
                    @error('priority') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- ── Remarks ── --}}
            <p class="crm-section">Remarks</p>
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-textarea label="Remark 1" name="remark1">{{ old('remark1', $opportunity->remark1) }}</x-adminlte-textarea>
                </div>
                <div class="col-md-6">
                    <x-adminlte-textarea label="Remark 2" name="remark2">{{ old('remark2', $opportunity->remark2) }}</x-adminlte-textarea>
                </div>
            </div>

            {{-- ── Actions ── --}}
            <div class="crm-form-actions">
                <a href="{{ route('opportunity.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Opportunity
                </button>
            </div>

        </form>
    </div>{{-- /crm-card-body --}}
</div>{{-- /crm-card --}}

@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush

@section('js')
<script>
    $(document).ready(function () {
        $('#lead_id').select2({
            placeholder: "Search for a lead",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@stop