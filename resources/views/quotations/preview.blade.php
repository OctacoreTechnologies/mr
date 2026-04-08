@extends('layouts.app')

@section('title', 'Create Quotation')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-file-invoice"></i>
        Create Quotation
    </h1>
    <a href="{{ route('quotation.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Quotations
    </a>
</div>
@stop

@section('content')

<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Quotation Information
        </h3>
    </div>

    <div class="crm-card-body">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('quotation.preview') }}" method="POST">
            @csrf
            @method("POST")

            <p class="crm-section">Customer</p>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="customerName">Customer</label>
                        <div class="input-group">
                            <input type="text" name="customer_name" id="customerName" class="form-control" readonly
                                value="{{ old('customer_name') }}" placeholder="Select a customer...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="changeCustomerBtn">
                                    <i class="fas fa-exchange-alt"></i> Change
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="customer_id" id="customerId" value="{{ old('customer_id') }}">
                </div>
            </div>

            {{-- ── Machine Selection ── --}}
            <p class="crm-section">Machine Selection</p>
            <div class="row">
                {{-- Machine Type --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="machine_type_id">Machine Type</label>
                        <select class="select2 form-control w-100" name="machine_type_id" id="machine_type_id" required>
                            <option value="">Select Machine Type</option>
                            @foreach($machineTypes as $type)
                                <option value="{{ $type->id }}" {{ old('machine_type_id') == $type->id ? 'selected' : '' }}
                                    data-price="{{ $type->price }}">
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Machine --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="machine_id">Machine</label>
                        <select class="select2 form-control w-100" name="machine_id" id="machine_id" required>
                            <option value="">Select Machine</option>
                        </select>
                    </div>
                </div>

                {{-- Application --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="application_id">Application</label>
                        <select class="select2 form-control w-100" name="application_id" id="application_id" required>
                            <option value="">Select Application</option>
                        </select>
                    </div>
                </div>

                {{-- Model --}}
                <div class="col-md-6" id="model">
                    <div class="form-group">
                        <label for="model_id">Model</label>
                        <select class="select2 form-control w-100" name="model_id" id="model_id" required>
                            <option value="">Select Model</option>
                        </select>
                    </div>
                </div>

            </div>

            {{-- ── Quotation Details ── --}}
            <p class="crm-section">Quotation Details</p>
            <div class="row">

                {{-- Reference No --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="reference_no">Quotation Ref No</label>
                        <input type="text" name="reference_no" id="reference_no" class="form-control"
                            value="{{ $reference_no }}" readonly>
                    </div>
                </div>

                {{-- Date --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}">
                    </div>
                </div>

                {{-- Price --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="total_price">Price (Unit)</label>
                        <input type="text" name="total_price" id="total_price" class="form-control format-number"
                            step="0.01" value="{{ old('total_price') }}" placeholder="0.00">
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" step="1"
                            value="{{ old('quantity', 1) }}" min="1">
                    </div>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            </div>

            {{-- ── Actions ── --}}
            <div class="crm-form-actions">
                <a href="{{ route('quotation.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Preview Quotation
                </button>
            </div>

        </form>

        {{-- ── Customer Detail Tabs ── --}}
        <div class="mt-5">
            <ul class="nav nav-tabs" id="customerTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="saleorders-tab" data-toggle="tab" href="#saleorders" role="tab"
                        aria-controls="saleorders" aria-selected="true">
                        <i class="fas fa-shopping-cart"></i> Sale Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="quotations-tab" data-toggle="tab" href="#quotations" role="tab"
                        aria-controls="quotations" aria-selected="false">
                        <i class="fas fa-file-invoice"></i> Quotations
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="customerTabContent">
                <div class="tab-pane fade show active" id="saleorders" role="tabpanel" aria-labelledby="saleorders-tab">
                    <div id="customerSaleOrders" class="mt-3"></div>
                </div>
                <div class="tab-pane fade" id="quotations" role="tabpanel" aria-labelledby="quotations-tab">
                    <div id="customerQuotations" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>{{-- /crm-card-body --}}
</div>{{-- /crm-card --}}


<div class="modal fade" id="customerSelectModal" tabindex="-1" role="dialog"
    aria-labelledby="customerSelectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="customerSelectModalLabel">
                    <i class="fas fa-user-circle mr-2"></i> Select Customer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-0">
                    <label for="customerSelect">Choose a customer</label>
                    <select id="customerSelect" class="form-control select2" style="width:100%">
                        <option value="">-- Select Customer --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                data-name="{{ $customer->company_name ?? $customer->name }}">
                                {{ $customer->company_name ?? $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
                <button type="button" class="btn btn-primary" id="confirmCustomerSelect">
                    <i class="fas fa-check"></i> Select Customer
                </button>
            </div>

        </div>
    </div>
</div>

@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush

@push('js')
    <script>
        $(document).ready(function () {

            // Init Select2
            $('.select2').select2({ width: '100%' });
            $(".selection").children('.select2-selection').addClass('h-100');


            // ── Price calculation ──
            function updatePrice() {
                var productPrice = $('#product_id option:selected').data('price');
                var quantity = $('#quantity').val();
                var totalPrice = productPrice * quantity;
                // $('#total_price').val(totalPrice.toFixed(2));
            }

            $('#product_id').change(updatePrice);
            $('#quantity').on('input', updatePrice);
            updatePrice();

            // ── Machine Type → Machines ──
            $('#machine_type_id').on('change', function () {
                let machineTypeId = $(this).val();

                if (machineTypeId) {
                    $.ajax({
                        url: '/categories/get-machines/' + machineTypeId,
                        type: 'GET',
                        success: function (machines) {
                            $('#machine_id').empty().append('<option value="">Select Machine</option>');
                            $.each(machines, function (key, machine) {
                                $('#machine_id').append(
                                    '<option value="' + machine.id + '">' + machine.name + '</option>'
                                );
                            });
                            $('#machine_id').trigger('change');
                        }
                    });
                } else {
                    $('#machine_id').empty().append('<option value="">Select Machine</option>');
                }
            });

            // ── Machine → Applications ──
            $('#machine_id').on('change', function () {
                let machineId = $(this).val();

                $('#application_id').empty().append('<option value="">Select Application</option>');
                $('#model_id').empty().append('<option value="">Select Model</option>');

                if (machineId) {
                    $.ajax({
                        url: '/categories/options/applications/' + machineId,
                        type: 'GET',
                        success: function (applications) {
                            $.each(applications, function (key, application) {
                                $('#application_id').append(
                                    '<option value="' + application.id + '">' + application.name + '</option>'
                                );
                            });
                            $('#application_id').trigger('change');
                        }
                    });
                }
            });

            // ── Application → Models ──
            $('#application_id').on('change', function () {
                let applicationId = $(this).val();
                let machineId = $('#machine_id').val();

                $('#model_id').empty().append('<option value="">Select Model</option>');

                if (applicationId && machineId) {
                    $.ajax({
                        url: '/categories/options/models/application/' + machineId + '/' + applicationId,
                        type: 'GET',
                        success: function (models) {
                            if (models.length > 0) {
                                $.each(models, function (key, model) {
                                    $('#model_id').append(
                                        '<option value="' + model.id + '">' + model.name + '</option>'
                                    );
                                });
                            } else {
                                $('#model_id').append('<option value="">No Models Found</option>');
                            }
                            $('#model_id').trigger('change');
                        },
                        error: function () {
                            $('#model_id').append('<option value="">No Models Found</option>');
                        }
                    });
                }
            });

            // Edit icon helper
            $('.edit-icon').on('click', function () {
                const input = $(this).siblings('input, select');
                input.prop('readonly', false).prop('disabled', false).removeClass('readonly-input');
            });

            // customer selection and report's

              $('#customerSelect').select2({
                dropdownParent: $('#customerSelectModal'),
                width: '100%'
             });

               // Auto-open customer modal when page loads if no customer selected
            @if (isset($preselectedCustomer))
                $('#customerId').val({{ $preselectedCustomer->id }});
                $('#customerName').val('{{ $preselectedCustomer->company_name ?? $preselectedCustomer->name }}');
                $('#customerSelect').val({{ $preselectedCustomer->id }}).trigger('change');
                fetchSaleOrdersForCustomer({{ $preselectedCustomer->id }});
                fetchQuotationsForCustomer({{ $preselectedCustomer->id }});
            @else
                if (!$('#customerId').val()) {
                    $('#customerSelectModal').modal('show');
                    $('#customerSelectModal').on('shown.bs.modal', function () {
                        $('#customerSelect').select2('open');
                    });
                } else {
                    var existing = $('#customerId').val();
                    if (existing) {
                        $('#customerSelect').val(existing).trigger('change');
                    }
                }
            @endif

            // Change customer button
            $('#changeCustomerBtn').on('click', function () {
                $('#customerSelectModal').modal('show');
            });

            // Confirm selection
            $('#confirmCustomerSelect').on('click', function () {
                var id = $('#customerSelect').val();
                if (!id) {
                    alert('Please select a customer');
                    return;
                }
                var name = $('#customerSelect').find('option:selected').data('name')
                        || $('#customerSelect').find('option:selected').text();
                $('#customerId').val(id);
                $('#customerName').val(name);
                $('#customerSelectModal').modal('hide');
                fetchSaleOrdersForCustomer(id);
                fetchQuotationsForCustomer(id);
            });


        });

           function renderSaleOrders(saleOrders) {
                var container = $('#customerSaleOrders');
                if (!saleOrders || saleOrders.length === 0) {
                    container.html('<div class="alert alert-info">No sale orders found for selected customer.</div>');
                    return;
                }
                var html = '<div class="table-responsive">';
                html += '<table id="saleOrdersTable" class="table table-sm table-striped">';
                html += '<thead><tr><th>#</th><th>Work Order</th><th>Machine</th><th>Application</th><th>Order Date</th><th>Delivery Date</th><th>Status</th><th>Payment</th><th>Action</th></tr></thead>';
                html += '<tbody>';
                saleOrders.forEach(function (order, idx) {
                    var workNo       = order.work_order_no || 'N/A';
                    var machine      = (order.quotation && order.quotation.machine)      ? order.quotation.machine.name      : 'N/A';
                    var application  = (order.quotation && order.quotation.application)  ? order.quotation.application.name  : 'N/A';
                    var orderDate    = order.order_date    ? new Date(order.order_date).toLocaleDateString('en-IN')    : '-';
                    var deliveryDate = order.delivery_date ? new Date(order.delivery_date).toLocaleDateString('en-IN') : '-';
                    var status        = order.status         || 'N/A';
                    var paymentStatus = order.payment_status || 'N/A';
                    var showUrl = '/sale-order/' + order.id;

                    var statusBadge  = '<span class="badge badge-info">'    + status        + '</span>';
                    var paymentBadge = paymentStatus === 'paid'
                        ? '<span class="badge badge-success">' + paymentStatus + '</span>'
                        : '<span class="badge badge-warning">' + paymentStatus + '</span>';

                    html += '<tr>';
                    html += '<td>' + (idx + 1)  + '</td>';
                    html += '<td>' + workNo      + '</td>';
                    html += '<td>' + machine     + '</td>';
                    html += '<td>' + application + '</td>';
                    html += '<td>' + orderDate   + '</td>';
                    html += '<td>' + deliveryDate + '</td>';
                    html += '<td>' + statusBadge  + '</td>';
                    html += '<td>' + paymentBadge + '</td>';
                    html += '<td><a class="btn btn-sm btn-outline-primary" href="' + showUrl + '">View</a></td>';
                    html += '</tr>';
                });
                html += '</tbody></table></div>';
                container.html(html);

                if ($.fn.DataTable.isDataTable('#saleOrdersTable')) {
                    $('#saleOrdersTable').DataTable().destroy();
                }
                $('#saleOrdersTable').DataTable({ paging: true, searching: true, ordering: true, info: true, lengthChange: true, pageLength: 10 });
            }

            function fetchSaleOrdersForCustomer(customerId) {
                var url = '{{ url("/api/customers") }}' + '/' + customerId + '/sale-orders';
                $.get(url).done(function (resp) {
                    if (resp && resp.success) {
                        renderSaleOrders(resp.data);
                    } else {
                        $('#customerSaleOrders').html('<div class="alert alert-warning">Could not fetch sale orders.</div>');
                    }
                }).fail(function () {
                    $('#customerSaleOrders').html('<div class="alert alert-danger">Error fetching sale orders.</div>');
                });
            }

            /* ── Quotations ── */
            function renderQuotations(quotations) {
                var container = $('#customerQuotations');
                if (!quotations || quotations.length === 0) {
                    container.html('<div class="alert alert-info">No quotations found for selected customer.</div>');
                    return;
                }
                var html = '<div class="table-responsive">';
                html += '<table id="quotationsTable" class="table table-sm table-striped">';
                html += '<thead><tr><th>#</th><th>Reference</th><th>Machine</th><th>Application</th><th>Created Date</th><th>Status</th><th>Action</th></tr></thead>';
                html += '<tbody>';
                quotations.forEach(function (quotation, idx) {
                    var ref         = quotation.reference_no || 'N/A';
                    var machine     = quotation.machine     ? quotation.machine.name     : 'N/A';
                    var application = quotation.application ? quotation.application.name : 'N/A';
                    var createdDate = quotation.created_at  ? new Date(quotation.created_at).toLocaleDateString('en-IN') : '-';
                    var status      = quotation.status      || 'pending';
                    var showUrl     = '/quotaion/pdf/' + quotation.id;
                    var customerId  = $('#customerId').val();
                    var reorderUrl  = '/quotation/' + quotation.id + '/edit?reorder=1&customer_id=' + customerId;

                    var statusBadge = '<span class="badge badge-secondary">' + status + '</span>';

                    html += '<tr>';
                    html += '<td>' + (idx + 1)  + '</td>';
                    html += '<td>' + ref         + '</td>';
                    html += '<td>' + machine     + '</td>';
                    html += '<td>' + application + '</td>';
                    html += '<td>' + createdDate + '</td>';
                    html += '<td>' + statusBadge + '</td>';
                    html += '<td>';
                    html += '<a class="btn btn-sm btn-outline-primary" href="' + showUrl + '" title="View Quotation">View</a> ';
                    html += '<a class="btn btn-sm btn-outline-success" href="' + reorderUrl + '" title="Reorder"><i class="fas fa-redo"></i> Reorder</a>';
                    html += '</td>';
                    html += '</tr>';
                });
                html += '</tbody></table></div>';
                container.html(html);

                if ($.fn.DataTable.isDataTable('#quotationsTable')) {
                    $('#quotationsTable').DataTable().destroy();
                }
                $('#quotationsTable').DataTable({ paging: true, searching: true, ordering: true, info: true, lengthChange: true, pageLength: 10 });
            }

            function fetchQuotationsForCustomer(customerId) {
                var url = '{{ url("/api/customers") }}' + '/' + customerId + '/quotations';
                $.get(url).done(function (resp) {
                    if (resp && resp.success) {
                        renderQuotations(resp.data);
                    } else {
                        $('#customerQuotations').html('<div class="alert alert-warning">Could not fetch quotations.</div>');
                    }
                }).fail(function () {
                    $('#customerQuotations').html('<div class="alert alert-danger">Error fetching quotations.</div>');
                });
            }

    </script>
@endpush