@extends('layouts.app')

@section('title', 'Edit Opportunity')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-edit"></i> Edit Opportunity</h1>
    <a href="{{ route('opportunity.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Back to Opportunities
    </a>
</div>
@stop

@section('content')
<div class="card shadow">
    <div class="card-header bg-warning">
        <h3 class="card-title text-white"><i class="fas fa-info-circle"></i> Opportunity Information</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('opportunity.update', $opportunity->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Lead --}}
                <div class="col-md-6">
                    <x-adminlte-select name="lead_id" id="lead_id" label="Lead" fgroup-class="mb-3"
                        class="js-example-basic-single">
                        <option value="">Select a Lead</option>
                        @foreach ($leads as $lead)
                            <option value="{{ $lead->id }}" {{ old('lead_id', $opportunity->lead_id) == $lead->id ? 'selected' : '' }}>
                                {{ $lead->full_name }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                    @error('lead_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Opportunity Name --}}
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Opportunity Name" value="{{ old('name', $opportunity->name) }}"
                        placeholder="Enter Opportunity Name" fgroup-class="mb-3" />
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stage --}}
                <div class="col-md-6">
                    <x-adminlte-select name="stage" label="Stage" fgroup-class="mb-3">
                        <option value="qualification" {{ old('stage', $opportunity->stage) == 'qualification' ? 'selected' : '' }}>Qualification</option>
                        <option value="proposal" {{ old('stage', $opportunity->stage) == 'proposal' ? 'selected' : '' }}>
                            Proposal</option>
                        <option value="negotiation" {{ old('stage', $opportunity->stage) == 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                        <option value="closed_won" {{ old('stage', $opportunity->stage) == 'closed_won' ? 'selected' : '' }}>Closed Won</option>
                        <option value="closed_lost" {{ old('stage', $opportunity->stage) == 'closed_lost' ? 'selected' : '' }}>Closed Lost</option>
                    </x-adminlte-select>
                    @error('stage')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Expected Close Date --}}
                <div class="col-md-6">
                    <x-adminlte-input name="expected_close_date" type="date" label="Expected Close Date"
                        value="{{ old('expected_close_date', $opportunity->expected_close_date) }}"
                        fgroup-class="mb-3" />
                    @error('expected_close_date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Probability --}}
                <div class="col-md-6">
                    <x-adminlte-input name="probability" type="number" min="0" max="100" label="Probability (%)"
                        value="{{ old('probability', $opportunity->probability) }}" fgroup-class="mb-3" />
                    @error('probability')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Close Date --}}
                <div class="col-md-6">
                    <x-adminlte-input name="close_date" type="date" label="Close Date"
                        value="{{ old('close_date', $opportunity->close_date) }}" fgroup-class="mb-3" />
                    @error('close_date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Priority --}}
                <div class="col-md-6">
                    <x-adminlte-select name="priority" label="Priority" fgroup-class="mb-3">
                        <option value="low" {{ old('priority', $opportunity->priority) == 'low' ? 'selected' : '' }}>Low
                        </option>
                        <option value="medium" {{ old('priority', $opportunity->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $opportunity->priority) == 'high' ? 'selected' : '' }}>
                            High</option>
                    </x-adminlte-select>
                    @error('priority')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Opportunity Type --}}
                <div class="col-md-6">
                    <x-adminlte-select name="opportunity_type" label="Opportunity Type" fgroup-class="mb-3">
                        <option value="new_business" {{ old('opportunity_type', $opportunity->opportunity_type) == 'new_business' ? 'selected' : '' }}>New Enquiry</option>
                        <option value="upsell" {{ old('opportunity_type', $opportunity->opportunity_type) == 'upsell' ? 'selected' : '' }}>Upsell</option>
                        <option value="cross_sell" {{ old('opportunity_type', $opportunity->opportunity_type) == 'cross_sell' ? 'selected' : '' }}>Cross Sell</option>
                        <option value="renewal" {{ old('opportunity_type', $opportunity->opportunity_type) == 'renewal' ? 'selected' : '' }}>Renewal</option>
                    </x-adminlte-select>
                    @error('opportunity_type')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="col-md-6">
                    <x-adminlte-textarea label="Remark 1"
                        name="remark1">{{ old('remark1', $opportunity->remark1) }}</x-admintlte-textarea>
                </div>
                <div class="col-md-6">
                    <x-adminlte-textarea label="Remark 2"
                        name="remark2">{{ old('remark2', $opportunity->remark1) }}</x-admintlte-textarea>
                </div>

            </div>

            <div class="mt-4">
                <a href="{{ route('opportunity.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Opportunity
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
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