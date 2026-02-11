@extends('layouts.app')

@section('title', 'Edit User')

@section('content_header')
    <h1 class="text-muted">Edit User</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-user-edit mr-2"></i> Update User Information</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Name --}}
                    <div class="col-md-6">
                        <x-adminlte-input 
                            name="name" 
                            label="Full Name" 
                            value="{{ old('name', $user->name) }}" 
                            placeholder="Enter full name" 
                            fgroup-class="mb-3" 
                            disable-feedback 
                            required 
                        />
                        @error('name')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <x-adminlte-input 
                            name="email" 
                            label="Email Address" 
                            value="{{ old('email', $user->email) }}" 
                            placeholder="Enter email" 
                            fgroup-class="mb-3" 
                            disable-feedback 
                            required 
                        />
                        @error('email')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <x-adminlte-input 
                            name="contact_no" 
                            value="{{ old('contact_no',$user->contact_no) }}" 
                            label="Contact No" 
                            placeholder="Enter Contact No" 
                            fgroup-class="mb-3" 
                            disable-feedback 
                            required 
                        />
                        @error('contact_no')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- User Roles --}}
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="font-weight-bold mb-2">Assign Roles:</label>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="role[]" 
                                            id="role-{{ $role->id }}" 
                                            value="{{ $role->name }}" 
                                            {{ $userRole->contains($role->id) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="role-{{ $role->id }}">
                                            {{ ucfirst($role->name) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!--  -->
                   {{-- Change Password --}}
<div class="row mt-4">
    <div class="col-md-12">
        <h5 class="text-primary mb-3"><i class="fas fa-key mr-1"></i> Change Password</h5>
    </div>

    {{-- New Password --}}
    <div class="col-md-6">
        <x-adminlte-input 
            name="password" 
            type="password" 
            label="New Password" 
            placeholder="Enter new password" 
            fgroup-class="mb-3"
            disable-feedback
        />
        @error('password')
            <p class="text-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="col-md-6">
        <x-adminlte-input 
            name="password_confirmation" 
            type="password" 
            label="Confirm Password" 
            placeholder="Re-enter new password" 
            fgroup-class="mb-3"
            disable-feedback
        />
    </div>
</div>

                <!--  -->

                {{-- Form Actions --}}
                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('css')
<style>
    .form-check-label {
        margin-left: 0.3rem;
        font-weight: 500;
    }
    .card-title {
        font-weight: 600;
        font-size: 1.2rem;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
        $(".selection").children('.select2-selection').addClass('h-100');
        $('.select2').addClass('w-100');
    });
</script>
@endpush
