
@extends('layouts.app')

@php
$fields = [
    'price', 'tax', 'delivery', 'payment', 'packing', 'forwarding',
    'validity', 'commissioning_charges', 'guarantee',
    'cancellation_of_order', 'judiciary', 'not_in_our_scope_of_supply'
];
@endphp
@section('title', 'Added Quotation')

@section('content_header')
<h1>Added Product</h1>
@stop

@section('content')
<div class="card">
    @if ($errors->any())
     {{ $errors }}
    @endif
    <div class="card-body">
        <form action="{{ route('term-conditions.store') }}" method="POST">
            @csrf
            @method("POST")
            @foreach ($fields as $field)
                <div class="form-group">
                    <label for="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                    <textarea name="{{ $field }}" id="{{ $field }}" class="form-control">{{ old($field, $termCondition->$field ?? '') }}</textarea>
                </div>
          @endforeach

            <div class="m-2">
                <button type="submit" class="btn btn-primary">Added Product</button>
                <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
</div>
</div>
@stop