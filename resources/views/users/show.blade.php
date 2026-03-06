@php
    $heads = [
        'SR.No',
        'User',
        'Action',
        'Module',
        'Description',
        'IP Address',
        'Date & Time',
    ];
@endphp

@extends('layouts.app')

@section('title', 'User Activity Logs')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 font-weight-bold text-primary">
        <i class="fas fa-user-clock"></i> User Activity Logs
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

<div class="card shadow-lg border-0">

    <div class="card-header bg-gradient-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-history"></i> Activity History
        </h3>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <x-adminlte-datatable
                id="activity-table"
                :heads="$heads"
                striped
                hoverable
                bordered
                with-buttons
                compressed
            >

                @foreach ($activities as $key => $activity)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>
                            {{ $activity->causer->name ?? 'System' }}
                        </td>

                        <td>
                            <span class="badge badge-info">
                                {{ ucfirst($activity->description) }}
                            </span>
                        </td>

                        <td>
                            {{ class_basename($activity->subject_type) }}
                        </td>

                        <td>
                            {{ $activity->description }}
                        </td>

                        <td>
                           {{ $activity->properties['ip'] ?? '-' }}
                        </td>

                        <td>
                            {{ $activity->created_at->format('d M Y h:i A') }}
                        </td>

                        {{-- <td>

                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </button>

                        </td> --}}

                    </tr>

                @endforeach

            </x-adminlte-datatable>

        </div>

    </div>

</div>

@stop