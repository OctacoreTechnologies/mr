@php
    $heads = [
        'SR.No',
        'User',
        'Action',
        'Module',
        'Description',
        'IP',
        'Date & Time',
    ];
@endphp

@extends('layouts.app')

@section('title', 'User Activity Logs')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-user-clock"></i>
        Activity Logs
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-2" />

<div class="crm-index-card">

    {{-- HEADER --}}
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history"></i> User Activities
        </h3>

        <span class="crm-record-count">
            {{ $activities->count() }} records
        </span>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <div class="table-responsive">

            <x-adminlte-datatable id="activityTable" :heads="$heads" striped hoverable responsive>

                @foreach ($activities as $key => $activity)
                    <tr>

                        {{-- SR --}}
                        <td>{{ $key + 1 }}</td>

                        {{-- USER --}}
                        <td>
                            <span class="crm-user-pill">
                                <i class="fas fa-user"></i>
                                {{ $activity->causer->name ?? 'System' }}
                            </span>
                        </td>

                        {{-- ACTION --}}
                        <td>
                            @php
                                $action = strtolower($activity->description);
                                $badge = match(true) {
                                    str_contains($action, 'create') => 'crm-badge-success',
                                    str_contains($action, 'update') => 'crm-badge-warning',
                                    str_contains($action, 'delete') => 'crm-badge-danger',
                                    default => 'crm-badge-info'
                                };
                            @endphp

                            <span class="crm-badge {{ $badge }}">
                                {{ ucfirst($activity->description) }}
                            </span>
                        </td>

                        {{-- MODULE --}}
                        <td>
                            <span class="crm-module-pill">
                                {{ class_basename($activity->subject_type) }}
                            </span>
                        </td>

                        {{-- DESCRIPTION --}}
                        <td class="text-muted">
                            {{ $activity->description }}
                        </td>

                        {{-- IP --}}
                        <td>
                            <span class="crm-ip">
                                {{ $activity->properties['ip'] ?? '-' }}
                            </span>
                        </td>

                        {{-- DATE --}}
                        <td>
                            <span class="crm-date-cell">
                                <i class="fas fa-clock"></i>
                                {{ $activity->created_at->format('d M Y, h:i A') }}
                            </span>
                        </td>

                    </tr>
                @endforeach

            </x-adminlte-datatable>

        </div>

    </div>

</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
<style>

/* USER PILL */
.crm-user-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .8rem;
    font-weight: 500;
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 20px;
}

/* MODULE */
.crm-module-pill {
    font-size: .75rem;
    font-weight: 600;
    background: #eef2ff;
    color: #4338ca;
    padding: 3px 10px;
    border-radius: 20px;
}

/* BADGES */
.crm-badge {
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
}

.crm-badge-success { background:#dcfce7; color:#166534; }
.crm-badge-warning { background:#fef3c7; color:#92400e; }
.crm-badge-danger  { background:#fee2e2; color:#991b1b; }
.crm-badge-info    { background:#e0f2fe; color:#075985; }

/* IP */
.crm-ip {
    font-family: monospace;
    font-size: .75rem;
    background: #f3f4f6;
    padding: 3px 8px;
    border-radius: 6px;
}

/* DATE */
.crm-date-cell {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .8rem;
}

.crm-date-cell i {
    color: #2563eb;
    font-size: .7rem;
}

</style>
@endpush