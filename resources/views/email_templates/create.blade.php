@extends('layouts.app')

@section('title', 'Create Mail')

@section('content_header')
    <h1 class="text-muted">Create New Mail</h1>
@stop

@section('content')
<div class="container-fluid pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Email Template</h3>
            <div class="card-tools">
                <a href="{{ route('email-template.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
            </div>
        </div>
        <form action="{{ route('email-template.store') }}" method="POST">
            @csrf
            <div class="card-body">
                {{-- Template Name --}}
                <div class="form-group">
                    <label for="name">Template Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Enter template name">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Subject --}}
                <div class="form-group">
                    <label for="subject">Subject <span class="text-danger">*</span></label>
                    <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror"
                        value="{{ old('subject') }}" placeholder="Enter email subject">
                    @error('subject')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Body --}}
                <div class="form-group">
                    <label for="body">Body <span class="text-danger">*</span></label>
                    <textarea name="body" id="body-editor" class="form-control @error('body') is-invalid @enderror"
                        placeholder="Enter email body">{{ old('body') }}</textarea>
                    @error('body')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                   <small class="form-text text-muted">
                             You can use placeholders like 
                             <code>@{{name}}</code>, 
                             <code>@{{email}}</code>, etc.
                   </small>

                </div>

                {{-- Variables --}}
                <div class="form-group">
                    <label for="variables">Variables (JSON format)</label>
                    <textarea name="variables" id="variables" class="form-control" placeholder='["name","email"]'>{{ old('variables') }}</textarea>
                    <small class="form-text text-muted">
                        Optional: Enter placeholders in JSON array format.
                    </small>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create Template</button>
                <a href="{{ route('email-templates.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('css')

@endpush

@push('js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('body-editor', {
        height: 400,
        removeButtons: 'Subscript,Superscript,Anchor',
        toolbarGroups: [
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ] },
            { name: 'styles' },
            { name: 'insert' },
            { name: 'colors' },
            { name: 'tools' },
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] }
        ]
    });
</script>
@endpush
