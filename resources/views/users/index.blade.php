@php
    $heads = [
        'ID',
        'Name',
        'Email',
        'Roles',
        ['label' => 'Actions', 'no-export' => false, 'width' => 5],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Users')

@section('content_header')
    <h1 class="text-muted">User Management</h1>
@stop

@section('content')
    <x-alert-components class="my-3" />

    {{-- Add User Button --}}
    <div class="mb-4">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-md">
            <i class="fas fa-user-plus mr-2"></i> Add New User
        </a>
    </div>

    {{-- Users Table --}}
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="fas fa-users mr-2"></i> User List</h3>
        </div>

        <div class="card-body">
            @if(is_null($users)) {{-- Check if users are empty --}}
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i> No users found.
                </div>
            @else
                <x-adminlte-datatable id="table1" :heads="$heads" class="table table-bordered table-hover table-striped">
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id ?? 'N/A' }}</td>
                            <td>{{ $user->name ?? 'No Name Provided' }}</td>
                            <td>{{ $user->email ?? 'No Email Provided' }}</td>
                            <td>
                              @if (is_null($user->roles))
                                    <span class="badge badge-warning">No Roles</span>
                                @else
                                    @foreach ($user->roles as $role)
                                        <span class="badge badge-info">{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary text-white mx-1 shadow-sm" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    {{-- Show --}}
                                  {{-- <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-teal text-white mx-1 shadow-sm" title="Details">
                                        <i class="fa fa-eye"></i>
                                    </a>--}}

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white mx-1 shadow-sm" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            @endif

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@stop

@push('css')
<style>
    /* Table Customizations */
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    /* Badge Styling */
    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.7em;
    }

    /* Header Styles */
    .card-title {
        font-size: 1.4rem;
        font-weight: 700;
    }

    /* Button Enhancements */
    .btn-primary, .btn-teal, .btn-danger {
        font-size: 1rem;
        font-weight: 500;
    }
    .btn:hover {
        opacity: 0.9;
        transition: all 0.3s ease;
    }

    /* Card Styling */
    .card {
        border-radius: 10px;
    }
    .shadow-lg {
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    /* Pagination Styling */
    .pagination .page-item {
        margin: 0 3px;
    }
    .pagination .page-link {
        font-size: 1rem;
        color: #495057;
    }
    .pagination .page-link:hover {
        background-color: #007bff;
        color: #fff;
    }

    /* Empty Table Message */
    .alert {
        font-size: 1.1rem;
        padding: 15px;
        margin-top: 20px;
        border-radius: 8px;
    }
</style>
@endpush
