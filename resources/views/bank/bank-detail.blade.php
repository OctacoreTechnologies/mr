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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-lg border-0 rounded-4">
                
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="fas fa-edit mr-2"></i> Update Bank Detail
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="{{ route('bank.details.update') }}">
                        @csrf
                        @method('POST')
                        {{-- compnay name --}}
                        <div class="mb-4">
                            <label for="company_name" class="form-label font-weight-semibold">
                                Company Name
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-building text-primary"></i>
                                </span>
                                <input type="text" 
                                    class="form-control rounded-end" 
                                    id="company_name" 
                                    name="company_name"
                                    value="{{ $bankDetail->company_name }}" 
                                    required>
                            </div>

                        {{-- Bank Name --}}
                        <div class="mb-4">
                            <label for="bank_name" class="form-label font-weight-semibold">
                                Bank Name
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-building text-primary"></i>
                                </span>
                                <input type="text" 
                                    class="form-control rounded-end" 
                                    id="bank_name" 
                                    name="bank_name"
                                    value="{{ $bankDetail->bank_name }}" 
                                    required>
                            </div>
                        </div>

                        {{-- Account Number --}}
                        <div class="mb-4">
                            <label for="account_number" class="form-label font-weight-semibold">
                                Account Number
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-credit-card text-primary"></i>
                                </span>
                                <input type="text" 
                                    class="form-control rounded-end" 
                                    id="account_number" 
                                    name="account_number"
                                    value="{{ $bankDetail->account_number }}" 
                                    required>
                            </div>
                        </div>

                        {{-- ifsc code --}}
                        <div class="mb-4">
                            <label for="ifsc_code" class="form-label font-weight-semibold">
                                IFSC Code
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-code text-primary"></i>
                                </span>
                                <input type="text" 
                                    class="form-control rounded-end" 
                                    id="ifsc_code" 
                                    name="ifsc_code"
                                    value="{{ $bankDetail->ifsc_code }}" 
                                    required>
                            </div>
                        </div>
                        {{-- branch --}}
                        <div class="mb-4">
                            <label for="branch" class="form-label font-weight-semibold">
                                Branch
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-code-branch text-primary"></i>
                                </span>
                                <input type="text" 
                                    class="form-control rounded-end" 
                                    id="branch" 
                                    name="branch_name"
                                    value="{{ $bankDetail->branch_name }}" 
                                    required>
                            </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" 
                               class="btn btn-outline-secondary rounded-pill px-4">
                                Cancel
                            </a>

                            <button type="submit" 
                                    class="btn btn-primary rounded-pill px-4 shadow-sm">
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