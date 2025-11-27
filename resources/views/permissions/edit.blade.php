@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content_header')
    <h1 class="text-muted">Edit Permission</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">
                <i class="fas fa-key mr-2"></i> Update Permission
            </h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.permission.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="name"
                            label="Permission Name"
                            placeholder="Enter permission name"
                            value="{{ old('name', $permission->name) }}"
                            fgroup-class="mb-3"
                            disable-feedback
                            required />

                        @error('name')
                            <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('admin.permission.index') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
        $(".selection").children('.select2-selection').addClass('h-100');
        $('.select2').addClass('w-100');
    });
</script>
@endpush

@push('css')
<style>
    .card-title {
        font-weight: 600;
        font-size: 1.2rem;
    }

    .btn i {
        font-size: 0.9rem;
    }

    .select2-selection--single {
        height: calc(2.25rem + 2px) !important;
        line-height: 1.5 !important;
        padding: 0.375rem 0.75rem;
    }
</style>
@endpush
