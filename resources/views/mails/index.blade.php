@php
    $heads = [
        'Sr. No',
        'Machine',
        'Application',
        'Subject',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Emails')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 text-primary font-weight-bold">
        <i class="fas fa-envelope-open-text mr-2"></i> Emails
    </h1>

    <a href="{{ route('mail.create') }}"
       class="btn btn-primary rounded-pill px-4 shadow-sm d-flex align-items-center">
        <i class="fas fa-plus mr-1"></i> Add Email
    </a>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="card shadow border-0">

    <!-- HEADER -->
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-paper-plane mr-2"></i> Email List
        </h5>
    </div>

    <!-- BODY -->
    <div class="card-body p-0">

        <div class="table-responsive">
            <x-adminlte-datatable
                id="table1"
                :heads="$heads"
                striped
                hoverable
                bordered
            >

                @forelse ($mails as $index => $mail)
                    <tr>
                        <!-- SR NO -->
                        <td class="text-muted font-weight-bold">
                            {{ $index + 1 }}
                        </td>

                        <!-- MACHINE -->
                        <td>
                            <span class="badge badge-light px-3 py-2">
                                {{ $mail->machine->name ?? 'N/A' }}
                            </span>
                        </td>

                        <!-- APPLICATION -->
                        <td>
                            <span class="badge badge-info px-3 py-2">
                                {{ $mail->application->name ?? 'N/A' }}
                            </span>
                        </td>

                        <!-- SUBJECT -->
                        <td>
                            <div class="font-weight-semibold text-dark">
                                {{ \Illuminate\Support\Str::limit($mail->subject, 50) }}
                            </div>
                        </td>

                        <!-- ACTIONS -->
                        <td class="text-center">
                            <nobr>

                                <a href="{{ route('mail.edit', $mail->id) }}"
                                   class="btn btn-sm btn-outline-primary mx-1"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('mail.destroy', $mail->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this email?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger mx-1"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </nobr>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5">
                            <div class="text-center py-5">

                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>

                                <h5 class="text-muted">No Emails Found</h5>

                                <p class="text-muted mb-3">
                                    You haven't created any emails yet.
                                </p>

                                <a href="{{ route('mail.create') }}"
                                   class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus mr-1"></i> Create Email
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse

            </x-adminlte-datatable>
        </div>

    </div>
</div>

@stop


@push('css')
<link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
<style>

/* Card */
.card {
    border-radius: 10px;
}

/* Header */
.card-header {
    border-radius: 10px 10px 0 0;
}

/* Table */
.table th {
    font-weight: 600;
    font-size: 14px;
}

/* Row hover */
.table tbody tr:hover {
    background: #f8fbff;
    transition: 0.2s;
}

/* Badge styles */
.badge-light {
    background: #eef2ff;
    color: #333;
}

.badge-info {
    background: #e0f7fa;
    color: #007b8f;
}

/* Buttons */
.btn-outline-primary,
.btn-outline-danger {
    border-radius: 20px;
}

/* Empty state icon */
.text-center i {
    opacity: 0.5;
}

</style>
@endpush