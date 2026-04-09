@extends('layouts.app')

@section('title', 'Create Mail')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0 text-primary font-weight-bold">
        <i class="fas fa-envelope mr-2"></i> Create Email Template
    </h1>
    <a href="{{ route('email-template.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="container-fluid">
    <div class="card shadow border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-plus-circle mr-2"></i> New Template
            </h5>
        </div>

        <form action="{{ route('email-template.store') }}" method="POST">
            @csrf

            <div class="card-body">

                <div class="row">

                    <!-- Template Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Template Name <span class="text-danger">*</span></label>
                            <input type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Enter template name">

                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ old('status')=='active' ? 'selected':'' }}>Active</option>
                                <option value="inactive" {{ old('status')=='inactive' ? 'selected':'' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- Subject -->
                <div class="form-group">
                    <label>Subject <span class="text-danger">*</span></label>
                    <input type="text"
                        name="subject"
                        class="form-control @error('subject') is-invalid @enderror"
                        value="{{ old('subject') }}"
                        placeholder="Enter email subject">

                    @error('subject')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Body -->
                <div class="form-group">
                    <label>Body <span class="text-danger">*</span></label>

                    <textarea name="body"
                        id="body-editor"
                        class="form-control @error('body') is-invalid @enderror">
                        {{ old('body') }}
                    </textarea>

                    @error('body')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <small class="form-text text-muted mt-2">
                        Use placeholders like:
                        <code>@{{name}}</code>,
                        <code>@{{email}}</code>,
                        <code>@{{company}}</code>
                    </small>
                </div>

                <!-- Variables -->
                <div class="form-group">
                    <label>Variables (Optional JSON)</label>
                    <textarea name="variables"
                        class="form-control"
                        placeholder='["name","email","company"]'>{{ old('variables') }}</textarea>

                    <small class="form-text text-muted">
                        Example: ["name","email"]
                    </small>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="card-footer justify-content-between">
                <button type="submit"
                        class="btn btn-primary rounded-pill ">
                    <i class="fas fa-save mr-1"></i> Create Template
                </button>
                <a href="{{ route('email-template.index') }}"
                   class="btn btn-outline-secondary rounded-pill">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection


@push('css')
<link rel="stylesheet"  href="{{ asset('style/common.css') }}">
<style>

/* Card */
.card {
    border-radius: 10px;
}

/* Header */
.card-header {
    border-radius: 10px 10px 0 0;
}

/* Inputs */
.form-control {
    border-radius: 6px;
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
label {
    display: inline-block !important;
}

label span {
    display: inline !important;
    margin-left: 3px;
}

</style>
@endpush


@push('js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
let editor = CKEDITOR.replace('body-editor', {
    height: 350,
    removeButtons: 'Subscript,Superscript,Anchor',
});

// ✅ IMPORTANT: old body fix
window.onload = function () {
    let oldBody = document.getElementById('body-editor').value;
    if (oldBody) {
        editor.setData(oldBody);
    }
};
</script>
@endpush