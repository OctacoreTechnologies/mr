@extends('layouts.app')

@section('title', 'Email Templates')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 text-primary font-weight-bold">
        <i class="fas fa-envelope mr-2"></i> Email Templates
    </h1>

    <a href="{{ route('email-templates.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="fas fa-plus mr-1"></i> Create Template
    </a>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="card shadow border-0">

    <!-- HEADER -->
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-list mr-2"></i> Template List
        </h5>
    </div>

    <!-- BODY -->
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="thead-light">
                    <tr>
                        <th width="70">#</th>
                        <th>Template Name</th>
                        <th>Subject</th>
                        <th class="text-center" width="220">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($templates as $index => $template)
                        <tr>
                            <td class="font-weight-bold text-muted">
                                {{ $index + 1 }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="template-icon mr-2">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-semibold">
                                            {{ $template->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge badge-light px-3 py-2">
                                    {{ $template->subject }}
                                </span>
                            </td>

                            <td class="text-center">
                                <nobr>

                                    <a href="{{ route('email-template.show', $template->id) }}"
                                       class="btn btn-sm btn-outline-info mx-1"
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('email-template.edit', $template->id) }}"
                                       class="btn btn-sm btn-outline-primary mx-1"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('email-templates.destroy', $template->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this template?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger mx-1"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </nobr>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="text-center py-5">

                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>

                                    <h5 class="text-muted">No Templates Found</h5>

                                    <p class="text-muted mb-3">
                                        You haven't created any email templates yet.
                                    </p>

                                    <a href="{{ route('email-templates.create') }}"
                                       class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-plus mr-1"></i> Create Template
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection


@push('css')
<link rel="stylesheet"  href="{{ asset('style/commonindex.css') }}">
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

/* Hover effect */
.table tbody tr:hover {
    background: #f8fbff;
    transition: 0.2s;
}

/* Template icon */
.template-icon {
    width: 35px;
    height: 35px;
    background: rgba(0,123,255,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Badge */
.badge-light {
    background: #eef2ff;
    color: #333;
    font-weight: 500;
}

/* Buttons */
.btn-outline-primary,
.btn-outline-danger,
.btn-outline-info {
    border-radius: 20px;
}

/* Empty state */
.text-center i {
    opacity: 0.5;
}

</style>
@endpush