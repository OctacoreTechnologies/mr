@extends('layouts.app')

@section('title', 'Create Opportunity')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-plus-circle"></i> Create Opportunity</h1>
        <a href="{{ route('opportunity.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Opportunities
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Opportunity Information</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('opportunity.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Lead --}}
                    <div class="col-md-6">
                        <x-adminlte-select name="lead_id" label="Lead" fgroup-class="mb-3" class="select2">
                            @foreach ($leads as $lead)
                                <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                    {{ $lead->full_name }}
                                </option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    {{-- Opportunity Name --}}
                    <div class="col-md-6">
                        <x-adminlte-input name="name" label="Opportunity Name" value="{{ old('name') }}"
                            placeholder="Enter Opportunity Name" fgroup-class="mb-3" />
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stage --}}
                    <div class="col-md-6">
                        <x-adminlte-select name="stage" label="Stage" fgroup-class="mb-3">
                            <option value="qualification" {{ old('stage') == 'qualification' ? 'selected' : '' }}>Qualification</option>
                            <option value="proposal" {{ old('stage') == 'proposal' ? 'selected' : '' }}>Proposal</option>
                            <option value="negotiation" {{ old('stage') == 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                            <option value="closed_won" {{ old('stage') == 'closed_won' ? 'selected' : '' }}>Closed Won</option>
                            <option value="closed_lost" {{ old('stage') == 'closed_lost' ? 'selected' : '' }}>Closed Lost</option>
                        </x-adminlte-select>
                        @error('stage')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Expected Close Date --}}
                    <div class="col-md-6">
                        <x-adminlte-input name="expected_close_date" label="Expected Close Date"
                            value="{{ old('expected_close_date') }}" type="date" fgroup-class="mb-3" />
                        @error('expected_close_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Probability --}}
                    <div class="col-md-6">
                        <x-adminlte-input name="probability" label="Probability (%)"
                            value="{{ old('probability') }}" type="number" min="0" max="100"
                            placeholder="Enter probability" fgroup-class="mb-3" />
                        @error('probability')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Opportunity Type --}}
                    <div class="col-md-6">
                        <x-adminlte-select name="type" label="Opportunity Type" fgroup-class="mb-3">
                            <option value="new_business" {{ old('opportunity_type') == 'new_business' ? 'selected' : '' }}>New Business</option>
                            <option value="upsell" {{ old('opportunity_type') == 'upsell' ? 'selected' : '' }}>Upsell</option>
                            <option value="cross_sell" {{ old('opportunity_type') == 'cross_sell' ? 'selected' : '' }}>Cross Sell</option>
                            <option value="renewal" {{ old('opportunity_type') == 'renewal' ? 'selected' : '' }}>Renewal</option>
                        </x-adminlte-select>
                        @error('opportunity_type')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea label="Remark 1" name="remark1">{{ old('remark1') }}</x-admintlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea label="Remark 2" name="remark2">{{ old('remark2') }}</x-admintlte-textarea>
                    </div>

                    {{-- Assigned To --}}
                    <div class="col-md-6">
                        <x-adminlte-select name="assigned_to" label="Assigned To" fgroup-class="mb-3" class="js-example-basic-single">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select>
                        @error('assigned_to')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="col-md-6">
                        <x-adminlte-select name="priority" label="Priority" fgroup-class="mb-3">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </x-adminlte-select>
                        @error('priority')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Notes --}}
                  {{--  <div class="col-md-6">
                        <x-adminlte-textarea name="notes" label="Opportunity Description" fgroup-class="mb-3">
                            {{ old('notes') }}
                        </x-adminlte-textarea>
                        @error('notes')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>--}}

                </div>

                <div class="mt-4">
                    <a href="{{ route('opportunity.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Create Opportunity
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>
@endpush
