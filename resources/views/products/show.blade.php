@extends('layouts.app')

@section('title', 'Application Details')

@section('content_header')
    <h1>Application Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Lead -->
                {{-- <div class="col-md-6">
                    <strong>Product Code:</strong>
                    <p>{{$product->code}}</p>
                </div> --}}

                <!-- Opportunity Name -->
                <div class="col-md-6">
                    <strong>Application Name:</strong>
                    <p>{{ $product->name }}</p>
                </div>

                <!-- Value -->
                <div class="col-md-6">
                    <strong>Application Price:</strong>
                    <p>{{ number_format($product->price, 2) }}</p>
                </div>

                {{-- <div class="col-md-6">
                    <strong>Model</strong>
                    <p>{{ $product->model }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Model</strong>
                    <p>{{ $product->model }}</p>
                </div> --}}

                <div class="col-md-6">
                    <strong>Material To Process</strong>
                    <p>{{ $product->material_to_process }}</p>
                </div>
                <div class="col-md-6">
                     <strong>Mixing Tool</strong>
                     <p>{{ $product->mixing_tool??'3 Tier Alloy Steel with Heat Treatment Process'}}</p>
                </div>
                <div class="col-md-6">
                     <strong>Motor Requirement</strong>
                     <p>{{ $product->motor_requirement}}</p>
                </div>
                {{-- <div class="col-md-6">
                    <strong>Batch</strong>
                    <p>{{ $product->batch_capacity??'40 kgs' }}</p>
                </div> --}}

                <!-- Notes -->
                <div class="col-md-12">
                    <strong>Description:</strong>
                    <p>{{ $product->description }}</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('product.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@stop
