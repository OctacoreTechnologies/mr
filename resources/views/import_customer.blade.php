@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Import Customers')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Import Customers')

{{-- Content body: main page content --}}

@section('content_body')
    <form action="/import/excel/customer" enctype='multipart/form-data' method="post">
        @csrf
        <input type="file" name="customer" id="customer">
        <input type="submit" value="save">
    </form>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
@endpush