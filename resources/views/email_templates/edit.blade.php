@extends('layouts.app')
@section('title', 'Edit Email Template')

@section('content')

<div class="container-fluid py-4 px-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-primary font-weight-bold">
            <i class="fas fa-edit mr-2"></i> Edit Email Template
        </h3>
        <a href="{{ route('email-templates.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <x-alert-components class="mb-3" />

    <div class="row justify-content-center">
        <div class="col-xl-10">

            <div class="card border-0 shadow">

                <!-- Header -->
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope mr-2"></i> {{ $emailTemplate->name }}
                    </h5>
                </div>

                <form action="{{ route('email-templates.update', $emailTemplate->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body p-4">

                        <div class="row">

                            <!-- Template Name -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">
                                    Template Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $emailTemplate->name) }}"
                                    placeholder="Enter template name">

                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Subject -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">
                                    Subject <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    name="subject"
                                    class="form-control @error('subject') is-invalid @enderror"
                                    value="{{ old('subject', $emailTemplate->subject) }}"
                                    placeholder="Enter subject">

                                @error('subject')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <!-- Module -->
                        <div class="mb-3">
                            <label class="font-weight-bold">
                                Module <span class="text-danger">*</span>
                            </label>

                            <select name="module"
                                class="form-control @error('module') is-invalid @enderror">

                                <option value="">Select Module</option>

                                <option value="client"
                                    {{ old('module', $emailTemplate->module) == 'client' ? 'selected' : '' }}>
                                    Client
                                </option>

                                <option value="product"
                                    {{ old('module', $emailTemplate->module) == 'product' ? 'selected' : '' }}>
                                    Product
                                </option>

                                <option value="quotation"
                                    {{ old('module', $emailTemplate->module) == 'quotation' ? 'selected' : '' }}>
                                    Quotation
                                </option>

                            </select>

                            @error('module')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Body -->
                        <div class="mb-3">
                            <label class="font-weight-bold">
                                Email Body <span class="text-danger">*</span>
                            </label>

                            <textarea name="body"
                                id="editor"
                                class="form-control @error('body') is-invalid @enderror">
                                {{ old('body', $emailTemplate->body) }}
                            </textarea>

                            @error('body')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror

                            <small class="text-muted mt-2 d-block">
                                Use placeholders like:
                                <code>@{{name}}</code>,
                                <code>@{{email}}</code>,
                                <code>@{{company}}</code>
                            </small>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="card-footer bg-light justify-content-between">
                        
                        <button type="submit"
                                class="btn btn-primary rounded-pill">
                            <i class="fas fa-save mr-1"></i> Update Template
                        </button>
                        <a href="{{ route('email-templates.index') }}"
                           class="btn btn-outline-secondary rounded-pill">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

@endsection


@push('css')
<link rel="stylesheet"  href="{{ asset('style/commonindex.css') }}">
<style>

/* Card */
.card {
    border-radius: 12px;
}

/* Header gradient */
.bg-gradient-primary {
    background: linear-gradient(90deg, #2563eb, #06b6d4);
}

/* Inputs */
.form-control {
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

/* Focus */
.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37,99,235,.15);
}

/* Buttons */
.btn-primary {
    border-radius: 20px;
}

.btn-outline-secondary {
    border-radius: 20px;
}

/* Hover effect */
.card:hover {
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
}

/* Label fix */
label span {
    display: inline !important;
}

</style>
@endpush


@push('js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
let editor = CKEDITOR.replace('editor', {
    height: 320,
    removeButtons: 'PasteFromWord'
});

// ✅ Fix old data not loading issue
window.onload = function () {
    let oldData = document.getElementById('editor').value;
    if(oldData){
        editor.setData(oldData);
    }
};
</script>
@endpush