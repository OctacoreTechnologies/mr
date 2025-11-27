@extends('layouts.app')

@section('title', 'Edit Lead')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Quotation Follow-ups</h1>
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

        <!-- Follow-up Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Follow-Up Date</th>
                        <th>Notes</th>
                        <th>Next Follow-Up Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($followups as $index => $followup)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <i class="fas fa-calendar-day mr-2 text-muted"></i>
                                {{ \Carbon\Carbon::parse($followup->follow_up_date)->format('d M Y h:i A') }}
                            </td>
                            <td>{{ Str::limit($followup->notes, 60, '...') }}</td>
                            <td>
                                <i class="fas fa-calendar-alt mr-2 text-muted"></i>
                                {{ \Carbon\Carbon::parse($followup->next_follow_up_date)->format('d M Y h:i A') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Follow-up Form -->
        <form action="{{ route('followup.update', $customer_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div id="followup-container">
                {{-- Blank input for new follow-up --}}
                <div class="followup-row border rounded p-3 mb-3 bg-light position-relative shadow-sm">
                    <x-adminlte-input type="hidden" name="follow_up_id[]" />
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-adminlte-input type="date" name="follow_up_date[]" label="Follow-Up Date" />
                        </div>
                        <div class="col-md-12 mb-3">
                            <x-adminlte-textarea name="notes[]" label="Notes"></x-adminlte-textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-adminlte-input type="text" name="next_follow_up_date[]" label="Next Follow-Up Date" />
                        </div>

                    </div>
                       <button type="button" class="btn btn-danger btn-sm my-2 remove-followup">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
                @foreach ($ofollowups as $followup)
                  <div class="followup-row border rounded p-3 mb-3 bg-light position-relative shadow-sm">
                        <x-adminlte-input type="hidden" name="follow_up_id[]" value="{{ $followup->id }}"/>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-adminlte-input type="date" name="follow_up_date[]" label="Follow-Up Date" value="{{ $followup->follow_up_date }}" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <x-adminlte-textarea name="notes[]" label="Notes">{{ $followup->notes }}</x-adminlte-textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-adminlte-input type="datetime-local" name="next_follow_up_date[]" label="Next Follow-Up Date" value="{{ $followup->next_follow_up_date }}" />
                            </div>
                        </div>

                        <button type="button" class="btn btn-danger btn-sm mt-2 me-2 remove-followup">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                @endforeach
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

@push('css')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
@endpush
@endpush

@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.remove-followup').forEach(button => {
            button.addEventListener('click', function () {
                this.closest('.followup-row').remove();
            });
        });
    });
        flatpickr("input[name='next_follow_up_date[]']", {
        enableTime: true,
        dateFormat: "Y-m-d h:i K", // 12-hour format with AM/PM
        time_24hr: false
    });

</script>
@stop
