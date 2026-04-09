@extends('layouts.app')

@section('title', 'Create User')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-user-plus"></i>
        Create User
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-2" />

<div class="crm-form-card">

    {{-- HEADER --}}
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-id-card"></i> User Details
        </h3>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="row">

                {{-- NAME --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Full Name</label>
                        <div class="crm-input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Enter full name"
                                   class="form-control"
                                   required>
                        </div>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- EMAIL --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="crm-input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="Enter email"
                                   class="form-control"
                                   required>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- CONTACT --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Number</label>
                        <div class="crm-input-group">
                            <i class="fas fa-phone"></i>
                            <input type="text" name="contact_no"
                                   value="{{ old('contact_no') }}"
                                   placeholder="Enter contact number"
                                   class="form-control"
                                   required>
                        </div>
                        @error('contact_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password</label>
                        <div class="crm-input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password"
                                   placeholder="Enter password"
                                   class="form-control"
                                   required>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="crm-input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation"
                                   placeholder="Re-enter password"
                                   class="form-control"
                                   required>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ACTION BUTTONS --}}
            <div class="crm-form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn crm-btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>

                <button type="submit" class="btn crm-btn-primary">
                    <i class="fas fa-save"></i> Create User
                </button>
            </div>

        </form>

    </div>
</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
<style>

/* MAIN CARD */
.crm-form-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
    overflow: hidden;
}

/* HEADER */
.crm-form-card .card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #eee;
    background: #fff;
}

.crm-form-card .card-title {
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* BODY */
.crm-form-card .card-body {
    padding: 20px;
}

/* LABEL */
.form-group label {
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #6b7280;
    margin-bottom: 6px;
}

/* INPUT GROUP */
.crm-input-group {
    display: flex;
    align-items: center;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    transition: all .2s ease;
}

.crm-input-group i {
    width: 38px;
    text-align: center;
    color: #9ca3af;
}

.crm-input-group input {
    border: none;
    outline: none;
    box-shadow: none;
    flex: 1;
    padding: 10px;
}

/* FOCUS EFFECT */
.crm-input-group:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}

/* BUTTONS */
.crm-form-actions {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.crm-btn-primary {
    background: #2563eb;
    color: #fff;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
}

.crm-btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border-radius: 8px;
    padding: 8px 16px;
}

.crm-btn-primary:hover {
    background: #1d4ed8;
}

.crm-btn-secondary:hover {
    background: #e5e7eb;
}

</style>
@endpush