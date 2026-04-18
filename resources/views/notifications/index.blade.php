@extends('layouts.app')

@section('title', "Today's Notifications")

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-bell"></i>
        Today's Notifications
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-calendar-alt"></i> Notification List
        </h3>
    </div>

    <div class="crm-card-body">
        <div class="table-responsive">
            <table id="notificationTable" class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>SR NO</th>
                        <th>Type</th>
                        <th>Channel</th>
                        <th>Customer</th>
                        <th>Message</th>
                        <th>Due Date</th>
                        <th>Follow Up</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notifications as $index => $item)
                        @php
                            $customer   = $item->notifiable;
                            $meta       = $item->meta ?? [];
                            $type       = $meta['type']    ?? 'customer';
                            $typeId     = $meta['type_id'] ?? null;

                            // customer_id safely nikalo
                            $customerId = $customer?->customer_id
                                       ?? $customer?->id
                                       ?? ($meta['customer_id'] ?? null);

                            // Follow-up URL build karo
                            $followUpUrl = null;
                            if ($customerId) {
                                $followUpUrl = match($type) {
                                    'opportunity' => route('followup.edit', $customerId)
                                                     . '?type=opportunity&opportunity_id=' . $typeId,
                                    'quotation'   => route('followup.edit', $customerId)
                                                     . '?type=quotation&quotation_id=' . $typeId,
                                    default       => route('followup.edit', $customerId),
                                };
                            }
                        @endphp

                        <tr>
                            {{-- SR No --}}
                            <td>{{ $index + 1 }}</td>

                            {{-- Type badge --}}
                            <td>
                                <span class="badge badge-info">
                                    {{ ucfirst($type) }}
                                </span>
                            </td>

                            {{-- Channel badge --}}
                            <td>
                                @php
                                    $channelColor = match($item->channel) {
                                        'email'     => 'badge-primary',
                                        'whatsapp'  => 'badge-success',
                                        default     => 'badge-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $channelColor }}">
                                    {{ ucfirst($item->channel) }}
                                </span>
                            </td>

                            {{-- Customer name --}}
                            <td>{{ $customer?->company_name ?? '—' }}</td>

                            {{-- Message --}}
                            <td>{{ $item->messages }}</td>

                            {{-- Due Date --}}
                            <td>
                                {{ \Carbon\Carbon::parse($item->send_at)->format('d-m-Y h:i A') }}
                            </td>

                            {{-- Follow Up link --}}
                            <td>
                                @if ($customerId && $followUpUrl)
                                    <a href="{{ $followUpUrl }}"
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
                                <form action="{{ route('notification.destroy', $item->id) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-xs btn-outline-danger"
                                            onclick="return confirm('Dismiss this notification?')">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No pending notifications.
                            </td>
                        </tr>
                    @endforelse
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
        $('#notificationTable').DataTable({
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