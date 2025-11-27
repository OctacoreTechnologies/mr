@extends('layouts.app')

@section('title', 'Email Templates')

@section('styles')
<style>
.table-container {
    background: #fff;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.table thead th {
    background-color: #4a90e2;
    color: #fff;
    font-weight: 600;
}

.table tbody tr:hover {
    background-color: #f1f7ff;
    transition: 0.2s;
}

.btn-action {
    margin: 0 2px 2px 0;
    font-size: 0.85rem;
}
</style>
@endsection

@section('content')
<div class="container-fluid pt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Email Templates</h3>
        <a href="{{ route('email-templates.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Create Template
        </a>
    </div>

    <div class="table-container table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Template Name</th>
                    <th>Subject</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $index => $template)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $template->name }}</td>
                        <td>{{ $template->subject }}</td>
                        <td class="text-center">
                            <a href="{{ route('email-template.show', $template->id) }}" class="btn btn-info btn-sm btn-action">
                                <i class="fas fa-eye"></i> Show
                            </a>
                            <a href="{{ route('email-template.edit', $template->id) }}" class="btn btn-primary btn-sm btn-action">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('email-templates.destroy', $template->id) }}" method="POST" class="d-inline-block btn-action" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No email templates found. <a href="{{ route('email-templates.create') }}" class="text-decoration-underline">Create one now</a>.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
