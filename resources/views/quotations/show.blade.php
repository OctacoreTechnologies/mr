@extends('layouts.app')

@section('title', 'Opportunity Details')

@section('content_header')
    <h1>Quotation Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Lead -->
                <div class="col-md-6">
                    <strong>Client Name:</strong>
                    <p>{{ $quotation->customer->company_name ?? 'No Lead Assigned' }}</p>
                </div>

                <!-- Opportunity Name -->
                <div class="col-md-6">
                    <strong>Quotation Reference No:</strong>
                    <p>{{ $quotation->reference_no}}</p>
                </div>

                <div class="col-md-6">
                    <strong>Product</strong>
                    <p>{{ $quotation->product->name}}</p>
                </div>
                <div class="col-md-6">
                    <strong>Date:</strong>
                    <p>{{ $quotation->date}}</p>
                </div>
                <!-- Value -->
                <div class="col-md-6">
                    <strong>Total Amount:</strong>
                    <p>{{ number_format($quotation->total_price, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Quantity:</strong>
                    <p>{{ number_format($quotation->quantity, 2) }}</p>
                </div>

                <!-- Stage -->
                <div class="col-md-6">
                    <strong>Status:</strong>
                    <p>{{ ucfirst($quotation->status) }}</p>
                </div>
                
                <!-- Notes -->
                <div class="col-md-12">
                    <strong>Notes:</strong>
                    <p>{{ $quotation->notes ?? 'No Notes' }}</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('quotation.index') }}" class="btn btn-secondary">Back to Opportunities</a>
            </div>
        </div>
    </div>
@stop
