@extends('layouts.app')
@section('title', 'Edit Email Template')

@section('content')
<div class="container-fluid py-4 px-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary mb-0">
                    <i class="fas fa-edit me-2"></i> Edit Email Template
                </h3>
                <a href="{{ route('email-templates.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <!-- Edit Card -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white py-3 px-4">
                    <h5 class="mb-0 fw-semibold">{{ $emailTemplate->name }}</h5>
                </div>

                <form action="{{ route('email-templates.update', $emailTemplate->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body p-4">

                        <!-- Template Name -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Template Name</label>
                            <input type="text" name="name" class="form-control form-control-lg border-0 shadow-sm" 
                                   value="{{ old('name', $emailTemplate->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Subject</label>
                            <input type="text" name="subject" class="form-control form-control-lg border-0 shadow-sm"
                                   value="{{ old('subject', $emailTemplate->subject) }}" required>
                            @error('subject')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Module -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Module</label>
                            <select name="module" class="form-select form-select-lg border-0 shadow-sm" required>
                                <option value="">Select Module</option>
                                <option value="client" {{ $emailTemplate->module == 'client' ? 'selected' : '' }}>Client</option>
                                <option value="product" {{ $emailTemplate->module == 'product' ? 'selected' : '' }}>Product</option>
                                <option value="quotation" {{ $emailTemplate->module == 'quotation' ? 'selected' : '' }}>Quotation</option>
                            </select>
                            @error('module')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email Body -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Email Body</label>
                            <textarea name="body" id="editor" rows="10" class="form-control shadow-sm border-0">
                                {{ old('body', $emailTemplate->body) }}
                            </textarea>
                            @error('body')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                         <small class="form-text text-muted mt-1">
                                 You can use placeholders like <code>@{{name}}</code>,
                                 <code>@{{email}}</code>, etc.
                         </small>

                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="card-footer bg-light text-end py-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Update Template
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 300,
        removeButtons: 'PasteFromWord'
    });
</script>

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
    label {
        font-size: 14px;
    }
    .container-fluid {
        max-width: 1400px;
    }
</style>
@endsection
