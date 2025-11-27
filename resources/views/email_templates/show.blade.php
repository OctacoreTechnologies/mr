@extends('layouts.app')
@section('title', 'View Email Template')

@section('content')
<div class="container-fluid py-4 px-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary mb-0">
                    <i class="fas fa-envelope-open-text me-2"></i> Email Template Preview
                </h3>
                <a href="{{ route('email-templates.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <!-- Main Card -->
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0 fw-semibold">{{ $emailTemplate->name }}</h5>
                        <span class="badge bg-light text-dark px-3 py-2 mt-2 mt-sm-0">
                            {{ ucfirst($emailTemplate->module) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Subject -->
                    <div class="mb-4">
                        <label class="fw-semibold text-secondary mb-1">Subject:</label>
                        <div class="border rounded-3 bg-light px-3 py-2">
                            {{ $emailTemplate->subject }}
                        </div>
                    </div>

                    <!-- Email Body -->
                    <div class="email-preview border rounded-3 bg-white shadow-sm p-4">
                        <div class="email-header mb-3 pb-2 border-bottom">
                            <div class="fw-semibold text-dark small">To: [Customer Email]</div>
                            <div class="text-muted small">Subject: {{ $emailTemplate->subject }}</div>
                        </div>

                        <div class="email-body">
                            {!! $emailTemplate->body !!}
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="card-footer bg-light text-end py-3">
                    <a href="{{ route('email-templates.edit', $emailTemplate->id) }}" class="btn btn-primary me-2 px-4">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('email-templates.destroy', $emailTemplate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this template?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(90deg, #007bff, #00bcd4);
    }
    .card {
        transition: 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .email-preview {
        border: 1px solid #e5e5e5;
        background-color: #fafafa;
        min-height: 280px;
        border-radius: 12px;
    }
    .email-header {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px 12px;
    }
    .email-body {
        font-size: 14px;
        line-height: 1.7;
        color: #333;
        margin-top: 10px;
    }
    label {
        font-size: 14px;
    }
    .container-fluid {
        max-width: 1400px;
    }
</style>
@endsection
