@extends('layouts.app')

@section('title', 'Edit User')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-user-edit"></i>
        Edit User
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="my-2" />

<div class="crm-form-card">

    {{-- HEADER --}}
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-id-card"></i> User Information
        </h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- BASIC INFO --}}
            <div class="crm-section">
                <h4 class="crm-section-title">
                    <i class="fas fa-user"></i> Basic Details
                </h4>

                <div class="row">

                    {{-- NAME --}}
                    <div class="col-md-6">
                        <label>Full Name</label>
                        <div class="crm-input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="form-control"
                                   placeholder="Enter full name" required>
                        </div>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-6">
                        <label>Email Address</label>
                        <div class="crm-input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control"
                                   placeholder="Enter email" required>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- CONTACT --}}
                    <div class="col-md-6 mt-3">
                        <label>Contact Number</label>
                        <div class="crm-input-group">
                            <i class="fas fa-phone"></i>
                            <input type="text" name="contact_no"
                                   value="{{ old('contact_no', $user->contact_no) }}"
                                   class="form-control"
                                   placeholder="Enter contact number" required>
                        </div>
                        @error('contact_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ROLES --}}
            <div class="crm-section mt-4">
                <h4 class="crm-section-title">
                    <i class="fas fa-user-shield"></i> Assign Roles
                </h4>

                <div class="crm-checkbox-grid">
                    @foreach ($roles as $role)
                        <label class="crm-checkbox-card">
                            <input type="checkbox"
                                   name="role[]"
                                   value="{{ $role->name }}"
                                   {{ $userRole->contains($role->id) ? 'checked' : '' }}>
                            <span>{{ ucfirst($role->name) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="crm-section mt-4">
                <h4 class="crm-section-title">
                    <i class="fas fa-key"></i> Change Password
                </h4>

                <div class="row">

                    <div class="col-md-6">
                        <label>New Password</label>
                        <div class="crm-input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password"
                                   class="form-control"
                                   placeholder="Enter new password">
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <div class="crm-input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Confirm password">
                        </div>
                    </div>

                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="crm-form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn crm-btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>

                <button type="submit" class="btn crm-btn-primary">
                    <i class="fas fa-save"></i> Update User
                </button>
            </div>

        </form>
    </div>
</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
<style>

/* CARD */
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
}

.crm-form-card .card-title {
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* SECTION */
.crm-section-title {
    font-size: .9rem;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* INPUT */
.crm-input-group {
    display: flex;
    align-items: center;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
}

.crm-input-group i {
    width: 38px;
    text-align: center;
    color: #9ca3af;
}

.crm-input-group input {
    border: none;
    flex: 1;
    padding: 10px;
}

.crm-input-group:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}

/* CHECKBOX GRID */
.crm-checkbox-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.crm-checkbox-card {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 6px 12px;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    font-size: .8rem;
}

.crm-checkbox-card:hover {
    border-color: #2563eb;
    background: #f8fafc;
}

/* BUTTONS */
.crm-form-actions {
    margin-top: 25px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.crm-btn-primary {
    background: #2563eb;
    color: #fff;
    border-radius: 8px;
    padding: 8px 16px;
}

.crm-btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border-radius: 8px;
    padding: 8px 16px;
}

</style>
@endpush