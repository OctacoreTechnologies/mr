@extends('layouts.app')

@section('title', 'Edit Quotation')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Quotation</h1>
    <a class="btn btn-link" href="{{ route('quotation.fullEditForm', $quotation->id) }}">Full Edit</a>
@stop

@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Quotation Details</h3>
            </div>

            <form action="{{ route('quotation.update', $quotation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-row">
                        @if (request()->query('reorder') != 1)
                            <div class="form-group col-md-3">
                                <div class="form-check mt-4 ">
                                    <input type="checkbox" class="form-check-input" id="revise" name="revise"
                                        value="1" {{ old('revise', $quotation->revise) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="revise">Revise Quotation</label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-check mt-4 ">
                                    <input type="checkbox" class="form-check-input" id="reflectInPdf" name="reflect_in_pdf"
                                        value="1" {{ old('revise', $quotation->revise) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="reflect_in_pdf">Reflect In Pdf</label>
                                </div>
                            </div>
                        @endif

                        <div class="form-group col-md-6">
                            <label for="customer_id">Customer</label>
                            <select class="form-control select2" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id', $quotation->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <x-adminlte-input name="application_id" label="Application"
                                value="{{ $quotation->application->name }}" readonly />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="reference_no">Quotation Ref No</label>
                            <input type="text" class="form-control" name="reference_no"
                                value="{{ old('reference_no', $quotation->reference_no) }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="date"
                                value="{{ old('date', $quotation->date) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" class="form-control " name="quantity" step="1"
                                value="{{ old('quantity', $quotation->quantity) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="total_price">Price(Unit)</label>
                            <input type="text" class="form-control format-number" id="total_price" name="total_price"
                                step="1" value="{{ old('total_price', $quotation->total_price) }}">
                        </div>

                        <!-- <div class="form-group col-md-6">
                                                                                                                                                                                        <label for="discount">Discount</label>
                                                                                                                                                                                        <input type="number" class="form-control" name="discount" step="0.01" value="{{ old('discount', $quotation->discount) }}">
                                                                                                                                                                                    </div> -->
                        <div class="form-group col-md-6">
                            <x-adminlte-select label="Discount Type" name="discount_type" id="discountType">
                                <option value="none" {{ $quotation->discount_type == 'none' ? 'selected' : '' }}>None
                                </option>
                                <option value="amount" {{ $quotation->discount_type == 'amount' ? 'selected' : '' }}>Amount
                                </option>
                                <option value="percentage"
                                    {{ $quotation->discount_type == 'percentage' ? 'selected' : '' }}>
                                    Percentage</option>
                            </x-adminlte-select>
                        </div>

                        <div class="form-group col-md-6 mb-3" id="discountPercentage">
                            <x-adminlte-input type="number" label="Discount(%)" id="discount_percentage"
                                name="discount_percentage" value="{{ $quotation->discount_percentage }}" />
                        </div>
                        <div class="form-group col-md-6 mb-3" id="discountAmount">
                            <x-adminlte-input type="text" label="Discount Amount" id="discount_amount"
                                name="discount_amount" value="{{ $quotation->discount_amount }}" class="format-number" />
                        </div>
                        {{-- Quotation Item Added --}}
                        @php $itemNo = 1; @endphp

                        @foreach ($quotation->getRelation('items') ?? [] as $index => $item)
                            <div class="form-group col-md-6 item-row">
                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">

                                <label>Item {{ $itemNo }}</label>

                                <input type="text" name="items[{{ $index }}][name]"
                                    value="{{ $item->item_name }}" placeholder="Item Name" class="form-control mb-1">

                                <input type="text" name="items[{{ $index }}][price]"
                                    value="{{ $item->item_price }}" placeholder="Item Price"
                                    class="form-control item-price format-number">

                                <input type="number" name="items[{{ $index }}][quantity]"
                                    value="{{ $item->item_qty }}" placeholder="Item Quantity"
                                    class="form-control item-qty ">

                                <input type="text" name="items[{{ $index }}][quantity]"
                                    value="{{ $item->item_price * $item->item_qty }}" placeholder="Item Price"
                                    class="form-control item-total format-number item-total" readonly>

                                <button type="button" class="btn btn-danger btn-xs mt-1 removeItem">
                                    Remove
                                </button>
                            </div>

                            @php $itemNo++; @endphp
                        @endforeach
                        <div class="form-group col-md-6 mb-3" id="total">
                            <x-adminlte-input type="text" id="total_amount" label="Total" name="total"
                                value="{{ $quotation->total }}" class="format-number" />
                        </div>
                        <div class="form-group col-md-6" id="reminder">
                            <x-adminlte-input type="datetime-local" label="Remider Date" name="reminder_date"
                                value="{{ $quotation->reminder_date ?? '' }}" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="Draft" {{ $quotation->status == 'Draft' ? 'selected' : '' }}>Draft
                                </option>
                                <option value="Sent" {{ $quotation->status == 'Sent' ? 'selected' : '' }}>Sent</option>
                                <option value="Approved" {{ $quotation->status == 'Approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="Rejected" {{ $quotation->status == 'Rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>


                        <div class="form-group col-md-12">
                            <button type="button" class="btn btn-primary btn-sm" id="addItemBtn">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>
                        {{-- @php
                         
                            $remarkNo = 1;
                        @endphp

                        @foreach ($quotation->getRelation('remarks') ?? [] as $index => $remark)
                            <div class="form-group col-md-6 remark-item">
                                <input type="hidden" name="remarks[{{ $index }}][id]"
                                    value="{{ $remark->id }}">
                                <x-adminlte-textarea label="Remark {{ $remarkNo }}"
                                    name="remarks[{{ $index }}][remark]" rows="4">

                                    {{ $remark->remark }}
                                </x-adminlte-textarea>

                                <button type="button" class="btn btn-danger btn-xs mt-1 removeRemark">
                                    Remove
                                </button>
                            </div>

                            @php $remarkNo++; @endphp
                        @endforeach --}}

                        <div class="col-md-6">
                            <x-adminlte-textarea label="Remark" name="remark"
                                class="form-group py-2">{{ $quotation->remark ?? '' }}</x-adminlte-textarea>
                        </div>




                        {{-- <div class="form-group col-md-12">
                            <button type="button" class="btn btn-primary btn-sm" id="addRemarkBtn">
                                <i class="fas fa-plus"></i> Add Remark
                            </button>
                        </div> --}}



                        <div class="form-group col-md-6">
                            <x-adminlte-select label="Followed By" name="followed_by" class="form-group py-2">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $quotation->followed_by == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Update Quotation</button>
                    <a href="{{ route('quotation.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop

@push('js')
<script src="{{asset('js/quotation_edit.js')}}"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('style/customer.css') }}">
@endpush
