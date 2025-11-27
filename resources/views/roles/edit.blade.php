@extends('layouts.app')

@section('title', 'Edit Role')

@section('content_header')
    <h1 class="text-muted">Edit Role</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">
                <i class="fas fa-user-shield mr-2"></i> Update Role & Permissions
            </h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                @csrf
                @method("PUT")

                {{-- Role Name --}}
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input 
                            name="name" 
                            value="{{ old('name', $role->name) }}" 
                            label="Role Name" 
                            placeholder="Enter role name" 
                            fgroup-class="mb-3" 
                            disable-feedback 
                            required 
                        />
                        @error('name')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Permissions --}}
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="font-weight-bold mb-2">Assign Permissions:</label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            name="permission[]" 
                                            value="{{ $permission->name }}"
                                            id="permission-{{ $permission->id }}"
                                            {{ $assignPermission->contains($permission->name) ? 'checked' : '' }}>
                                            
                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                            {{ ucfirst($permission->name) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('permission')
                            <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('admin.role.index') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Role
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

    .form-check-input {
        margin-top: 0.3rem;
    }

    .form-check-label {
        margin-left: 0.3rem;
        font-weight: 500;
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
