@extends('layouts.app')

@section('title', 'Create User')

@section('content_header')
    <h1 class="text-muted">Create New User</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i> User Information</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                @method("POST")

                <div class="row">
                    {{-- Name --}}
                    <div class="col-md-6">
                        <x-adminlte-input 
                            name="name" 
                            value="{{ old('name') }}" 
                            label="Full Name" 
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
                            value="{{ old('email') }}" 
                            label="Email Address" 
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
                            value="{{ old('contact_no') }}" 
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

                    {{-- Password --}}
                    <div class="col-md-6">
                        <x-adminlte-input 
                            type="password" 
                            name="password" 
                            label="Password" 
                            placeholder="Enter password" 
                            fgroup-class="mb-3" 
                            disable-feedback 
                            required 
                        />
                        @error('password')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6">
                        <x-adminlte-input 
                            type="password" 
                            name="password_confirmation" 
                            label="Confirm Password" 
                            placeholder="Re-enter password" 
                            fgroup-class="mb-3" 
                            disable-feedback 
                            required 
                        />
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('css')
<style>
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
