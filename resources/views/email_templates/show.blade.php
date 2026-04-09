@extends('layouts.app')
@section('title', 'View Email Template')

@section('content')

<div class="container-fluid py-4 px-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-primary font-weight-bold">
            <i class="fas fa-envelope-open-text mr-2"></i> Email Template Preview
        </h3>

        <a href="{{ route('email-templates.index') }}"
           class="btn btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10">

            <div class="card border-0 shadow">

                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt mr-2"></i> {{ $emailTemplate->name }}
                    </h5>

                    <span class="badge badge-light px-3 py-2 mt-2 mt-sm-0">
                        {{ ucfirst($emailTemplate->module) }}
                    </span>
                </div>

                <div class="card-body p-4">

                    <!-- Subject -->
                    <div class="mb-4">
                        <label class="font-weight-bold text-muted mb-1">
                            Subject
                        </label>
                        <div class="preview-box">
                            {{ $emailTemplate->subject }}
                        </div>
                    </div>

                    <!-- Email Preview -->
                    <div class="email-wrapper">

                        <!-- Fake Email Header -->
                        <div class="email-top">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div>
                                    <strong>To:</strong> customer@example.com
                                </div>
                                <div class="text-muted">
                                    {{ now()->format('d M Y, h:i A') }}
                                </div>
                            </div>

                            <div class="mt-1">
                                <strong>Subject:</strong> {{ $emailTemplate->subject }}
                            </div>
                        </div>

                        <!-- Email Body -->
                        <div class="email-content">
                            {!! $emailTemplate->body !!}
                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer bg-light  justify-content-between">

                    {{-- <a href="{{ route('email-templates.index') }}"
                       class="btn btn-outline-secondary rounded-pill px-4">
                        Cancel --}}
                    </a>

                    <div>
                        {{-- <a href="{{ route('email-templates.edit', $emailTemplate->id) }}"
                           class="btn btn-primary rounded-pill px-4 mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a> --}}

                        <form action="{{ route('email-templates.destroy', $emailTemplate->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this template?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger rounded-pill px-4">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

@endsection


@push('css')
<link rel="stylesheet"  href="{{ asset('style/common.css') }}">
<style>

/* Card */
.card {
    border-radius: 12px;
}

/* Gradient */
.bg-gradient-primary {
    background: linear-gradient(90deg, #2563eb, #06b6d4);
}

/* Subject box */
.preview-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
    border-radius: 8px;
    font-weight: 500;
}

/* Email Wrapper */
.email-wrapper {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
}

/* Top header */
.email-top {
    background: #f1f5f9;
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 13px;
}

/* Body */
.email-content {
    padding: 18px;
    font-size: 14px;
    line-height: 1.7;
    color: #334155;
}

/* Hover */
.card:hover {
    box-shadow: 0 14px 30px rgba(0,0,0,0.08);
}

/* Buttons */
.btn-primary,
.btn-danger,
.btn-outline-secondary {
    border-radius: 20px;
}

</style>
@endpush