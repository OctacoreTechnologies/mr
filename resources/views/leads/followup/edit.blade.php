@extends('layouts.app')

@section('title', 'Edit Lead')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Lead Follow-ups</h1>
        <a href="{{ route('lead.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-home"></i> Back to Leads
        </a>
    </div>
@stop

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-edit"></i> Manage Follow-up Entries</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <x-adminlte-alert theme="danger" title="Validation Errors" dismissable>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-adminlte-alert>
        @endif

        <form action="{{ route('lead.followup.update', $lead_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div id="followup-container">
                @foreach ($followups as $followup)
                    <div class="followup-row border rounded p-3 mb-3 bg-light position-relative shadow-sm">
                        <x-adminlte-input type="hidden" name="follow_up_id[]" value="{{ $followup->id }}"/>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-adminlte-input type="date" name="followup_date[]" label="Follow Up Date" value="{{ $followup->followup_date }}" />
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-textarea name="notes[]" label="Notes">{{ $followup->notes }}</x-adminlte-textarea>
                            </div>
                              <div class="col-md-6 mb-3">
                                <x-adminlte-input type="date" name="next_followup_data_time[]" label="Next FollowUp Date and Time" value="{{ $followup->next_followup_data_time??'' }}" />
                             </div>
                        </div>

                        <button type="button" class="btn btn-danger btn-sm mt-2 me-2 remove-followup">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                @endforeach

                {{-- Blank input for new follow-up --}}
                <div class="followup-row border rounded p-3 mb-3 bg-light position-relative shadow-sm">
                    <x-adminlte-input type="hidden" name="follow_up_id[]" />
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-adminlte-input type="date" name="followup_date[]" label="Follow Up Date" />
                        </div>
                        <div class="col-md-12">
                            <x-adminlte-textarea name="notes[]" label="Notes"></x-adminlte-textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm  my-2 remove-followup">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ redirect()->back() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.remove-followup').forEach(button => {
            button.addEventListener('click', function () {
                this.closest('.followup-row').remove();
            });
        });
    });
</script>
@stop
