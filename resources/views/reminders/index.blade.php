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
    <h1 class="text-center text-dark font-weight-bold">
        <i class="fas fa-bell text-primary mr-2"></i> Today's Reminders
    </h1>
@stop

@section('content')
    <x-alert-components class="my-3" />

    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-calendar-alt mr-2"></i> Reminder List
            </h3>
        </div>

        <div class="card-body">
            <x-adminlte-datatable id="reminderTable" :heads="$heads" striped hoverable with-buttons>
                @foreach ($reminders as $reminder)
                    @php
                        $quotation = null;
                        if ($reminder->model === 'Customer') {
                            $customer = Customer::find($reminder->type_id);
                            if ($customer) {
                                $quotation = $customer->quotations()->latest()->first(); // Assuming relationship exists
                            }
                        }
                        elseif($reminder->model=='Quotation'){
                         $quotation = Quotation::findOrFail($reminder->type_id);// Assuming relationship exists
                        }
                    @endphp

                    <tr>
                        <td>{{ $i++ }}</td>

                        <td>
                            <span class="badge badge-info">
                                <i class="fas fa-tag mr-1"></i> {{ ucfirst($reminder->type) }}
                            </span>
                        </td>

                        <td>
                            <i class="fas fa-comment-alt mr-1 text-muted"></i>
                            {{ $reminder->data }}
                        </td>

                        <td>
                            <i class="fas fa-clock text-muted mr-1"></i>
                            {{ \Carbon\Carbon::parse($reminder->sent_date)->format('d-m-Y h:i A') }}
                        </td>

                        <td>
                            @if($reminder->model === 'Customer')
                                <a href="{{ route('followup.edit', $reminder->type_id) }}"
                                   class="btn btn-sm btn-outline-primary shadow-sm"
                                   target="_blank" title="Add Follow-Up">
                                    <i class="fas fa-phone-alt"></i> Follow Up
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>
                            <nobr>
                                <!-- Delete -->
                                <form action="{{ route('reminder.destroy',$reminder->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-xs btn-outline-danger mx-1 shadow-sm"
                                            onclick="return confirm('Are you sure you want to delete this reminder?')"
                                            title="Delete Reminder">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>

                                @if($quotation)
                                    <a href="{{ route('quotation.edit', $quotation->id) }}"
                                       class="btn btn-xs btn-outline-secondary text-primary mx-1 shadow-sm"
                                       title="Edit Quotation">
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    <a href="{{ route('quotation.pdf', $quotation->id) }}"
                                       class="btn btn-xs btn-outline-secondary text-info mx-1 shadow-sm"
                                       title="View PDF" target="_blank">
                                        <i class="fa fa-file-pdf"></i>
                                    </a>
                                @endif
                            </nobr>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop

@push('css')
    <style>
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .table td, .table th {
            vertical-align: middle !important;
        }
        .btn-xs i {
            font-size: 0.85rem;
        }
        .badge i {
            font-size: 0.85rem;
        }
    </style>
@endpush
@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush


@push('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
