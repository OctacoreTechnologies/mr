{{-- Create / Edit Bank Detail View --}}
@extends('layouts.app')

@section('title', 'Bank Details')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0 text-primary font-weight-bold">
        <i class="fas fa-university mr-2"></i> Bank Details
    </h1>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow border-0">

                <!-- HEADER -->
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit mr-2"></i> Update Bank Detail
                    </h5>
                </div>

                <!-- BODY -->
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('bank.details.update') }}">
                        @csrf

                        <!-- Company Name -->
                        <div class="form-group mb-3">
                            <label>Company Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-building text-primary"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    name="company_name"
                                    class="form-control"
                                    value="{{ old('company_name', $bankDetail->company_name) }}"
                                    required>
                            </div>
                        </div>

                        <!-- Bank Name -->
                        <div class="form-group mb-3">
                            <label>Bank Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-university text-primary"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    name="bank_name"
                                    class="form-control"
                                    value="{{ old('bank_name', $bankDetail->bank_name) }}"
                                    required>
                            </div>
                        </div>

                        <!-- Account Number -->
                        <div class="form-group mb-3">
                            <label>Account Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-credit-card text-primary"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    name="account_number"
                                    class="form-control"
                                    value="{{ old('account_number', $bankDetail->account_number) }}"
                                    required>
                            </div>
                        </div>

                        <!-- IFSC Code -->
                        <div class="form-group mb-3">
                            <label>IFSC Code</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-code text-primary"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    name="ifsc_code"
                                    class="form-control"
                                    value="{{ old('ifsc_code', $bankDetail->ifsc_code) }}"
                                    required>
                            </div>
                        </div>

                        <!-- Branch -->
                        <div class="form-group mb-3">
                            <label>Branch</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-code-branch text-primary"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    name="branch_name"
                                    class="form-control"
                                    value="{{ old('branch_name', $bankDetail->branch_name) }}"
                                    required>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}"
                               class="btn btn-outline-secondary rounded-pill px-4">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-save mr-1"></i> Update Details
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@stop

@push('css')
<link rel="stylesheet"  href="{{ asset('style/common.css') }}">
<style>

/* Card */
.card {
    border-radius: 10px;
}

/* Header */
.card-header {
    border-radius: 10px 10px 0 0;
}

/* Input */
.form-control {
    border-radius: 6px;
}

/* Input group */
.input-group-text {
    background: #f1f5f9;
    border: 1px solid #ced4da;
}

/* Focus */
.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37,99,235,.15);
}

/* Buttons */
.btn-primary {
    border-radius: 20px;
}

.btn-outline-secondary {
    border-radius: 20px;
}

</style>
@endpush