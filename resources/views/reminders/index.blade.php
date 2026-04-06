@php
    use App\Models\Quotation;
    use App\Models\Customer;

    $heads = [
        'SR NO',
        'Type',
        'Message',
        'Due Date',
        'Follow Up',
        'Actions',
    ];
    $i = 1;
@endphp

@extends('layouts.app')

@section('title', "Today's Reminders")

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-bell"></i>
        Today's Reminders
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-calendar-alt"></i> Reminder List
        </h3>
    </div>

    <div class="crm-card-body">

        <div class="table-responsive">
            <table id="reminderTable" class="table table-sm table-striped">
                <thead>
                    <tr>
                        @foreach ($heads as $head)
                            <th>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach ($reminders as $reminder)
                        @php
                            $quotation = null;
                            if ($reminder->model === 'Customer') {
                                $customer = Customer::find($reminder->type_id);
                                if ($customer) {
                                    $quotation = $customer->quotations()->latest()->first();
                                }
                            }
                            elseif($reminder->model=='Quotation'){
                                $quotation = Quotation::findOrFail($reminder->type_id);
                            }
                        @endphp

                        <tr>
                            <td>{{ $i++ }}</td>

                            {{-- Type --}}
                            <td>
                                <span class="badge badge-info">
                                    {{ ucfirst($reminder->type) }}
                                </span>
                            </td>

                            {{-- Message --}}
                            <td>
                                {{ $reminder->data }}
                            </td>

                            {{-- Due Date --}}
                            <td>
                                {{ \Carbon\Carbon::parse($reminder->sent_date)->format('d-m-Y h:i A') }}
                            </td>

                            {{-- Follow Up --}}
                            <td>
                                @if($reminder->model === 'Customer')
                                    <a href="{{ route('followup.edit', $reminder->type_id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       target="_blank">
                                        <i class="fas fa-phone-alt"></i> Follow Up
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <nobr>

                                    {{-- Delete --}}
                                    <form action="{{ route('reminder.destroy',$reminder->id) }}"
                                          method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-xs btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this reminder?')">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>

                                    @if($quotation)

                                        {{-- Edit Quotation --}}
                                        <a href="{{ route('quotation.edit', $quotation->id) }}"
                                           class="btn btn-xs btn-outline-primary">
                                            <i class="fa fa-pen"></i>
                                        </a>

                                        {{-- View PDF --}}
                                        <a href="{{ route('quotation.pdf', $quotation->id) }}"
                                           class="btn btn-xs btn-outline-secondary"
                                           target="_blank">
                                            <i class="fa fa-file-pdf"></i>
                                        </a>

                                    @endif

                                </nobr>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush

@push('js')
<script>
    $(document).ready(function () {

        $('#reminderTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10
        });

    });
</script>
@endpush