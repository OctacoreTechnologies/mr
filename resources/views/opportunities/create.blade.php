@extends('layouts.app')

@section('title', 'Create Opportunity')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-plus-circle"></i> Create Opportunity</h1>
    <a href="{{ route('opportunity.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Back to Opportunities
    </a>
</div>
@stop

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-info-circle"></i> Opportunity Information</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('opportunity.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- Customer selector with change button --}}
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

                {{-- Lead --}}
                <div class="col-md-6">
                    <x-adminlte-select name="lead_id" label="Lead" fgroup-class="mb-3" class="select2">
                        @foreach ($leads as $lead)
                            <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                {{ $lead->full_name }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- Opportunity Name --}}
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Opportunity Name" value="{{ old('name') }}"
                        placeholder="Enter Opportunity Name" fgroup-class="mb-3" />
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stage --}}
                <div class="col-md-6">
                    <x-adminlte-select name="stage" label="Stage" fgroup-class="mb-3">
                        <option value="qualification" {{ old('stage') == 'qualification' ? 'selected' : '' }}>
                            Qualification</option>
                        <option value="proposal" {{ old('stage') == 'proposal' ? 'selected' : '' }}>Proposal</option>
                        <option value="negotiation" {{ old('stage') == 'negotiation' ? 'selected' : '' }}>Negotiation
                        </option>
                        <option value="closed_won" {{ old('stage') == 'closed_won' ? 'selected' : '' }}>Closed Won
                        </option>
                        <option value="closed_lost" {{ old('stage') == 'closed_lost' ? 'selected' : '' }}>Closed Lost
                        </option>
                    </x-adminlte-select>
                    @error('stage')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Expected Close Date --}}
                <div class="col-md-6">
                    <x-adminlte-input name="expected_close_date" label="Expected Close Date"
                        value="{{ old('expected_close_date') }}" type="date" fgroup-class="mb-3" />
                    @error('expected_close_date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Probability --}}
                <div class="col-md-6">
                    <x-adminlte-input name="probability" label="Probability (%)" value="{{ old('probability') }}"
                        type="number" min="0" max="100" placeholder="Enter probability" fgroup-class="mb-3" />
                    @error('probability')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Opportunity Type --}}
                <div class="col-md-6">
                    <x-adminlte-select name="type" label="Opportunity Type" fgroup-class="mb-3">
                        <option value="new_business" {{ old('opportunity_type') == 'new_business' ? 'selected' : '' }}>New
                            Enquiry</option>
                        <option value="upsell" {{ old('opportunity_type') == 'upsell' ? 'selected' : '' }}>Upsell</option>
                        <option value="cross_sell" {{ old('opportunity_type') == 'cross_sell' ? 'selected' : '' }}>Cross
                            Sell</option>
                        <option value="renewal" {{ old('opportunity_type') == 'renewal' ? 'selected' : '' }}>Renewal
                        </option>
                    </x-adminlte-select>
                    @error('opportunity_type')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6">
                    <x-adminlte-textarea label="Remark 1" name="remark1">{{ old('remark1') }}</x-admintlte-textarea>
                </div>
                <div class="col-md-6">
                    <x-adminlte-textarea label="Remark 2" name="remark2">{{ old('remark2') }}</x-admintlte-textarea>
                </div>

                {{-- Assigned To --}}
                <div class="col-md-6">
                    <x-adminlte-select name="assigned_to" label="Assigned To" fgroup-class="mb-3"
                        class="js-example-basic-single">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                    @error('assigned_to')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Priority --}}
                <div class="col-md-6">
                    <x-adminlte-select name="priority" label="Priority" fgroup-class="mb-3">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </x-adminlte-select>
                    @error('priority')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                {{-- <div class="col-md-6">
                    <x-adminlte-textarea name="notes" label="Opportunity Description" fgroup-class="mb-3">
                        {{ old('notes') }}
                    </x-adminlte-textarea>
                    @error('notes')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>--}}

            </div>

            <div class="mt-4">
                <a href="{{ route('opportunity.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> Create Opportunity
                </button>
            </div>
        </form>

        <!-- Tabs for Customer Details -->
        <div class="mt-4">
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
    </div>
</div>
</div>


<!-- Customer Select Modal -->
<div class="modal fade" id="customerSelectModal" tabindex="-1" role="dialog" aria-labelledby="customerSelectModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerSelectModalLabel">Select Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmCustomerSelect">Select Customer</button>
            </div>
        </div>
    </div>
</div>

@stop
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush
@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();

            // Initialize customer dropdown inside modal with Select2 and ensure dropdown renders inside modal
            $('#customerSelect').select2({
                dropdownParent: $('#customerSelectModal'),
                width: '100%'
            });

            // Auto-open customer modal when page loads if no customer selected
            @if ($preselectedCustomer)
                // Pre-select customer from query parameter
                $('#customerId').val({{ $preselectedCustomer->id }});
                $('#customerName').val('{{ $preselectedCustomer->company_name ?? $preselectedCustomer->name }}');
                $('#customerSelect').val({{ $preselectedCustomer->id }}).trigger('change');
                // Fetch sale orders and quotations for pre-selected customer
                fetchSaleOrdersForCustomer({{ $preselectedCustomer->id }});
                fetchQuotationsForCustomer({{ $preselectedCustomer->id }});
            @else
                                if (!$('#customerId').val()) {
                    $('#customerSelectModal').modal('show');
                    // open select2 dropdown after modal shown
                    $('#customerSelectModal').on('shown.bs.modal', function () {
                        $('#customerSelect').select2('open');
                    });
                } else {
                    // If customer_id exists, pre-select it in the dropdown
                    var existing = $('#customerId').val();
                    if (existing) {
                        $('#customerSelect').val(existing).trigger('change');
                    }
                }
            @endif

            // Change customer button: re-open modal
            $('#changeCustomerBtn').on('click', function () {
                $('#customerSelectModal').modal('show');
            });

            // Confirm button: set selected customer into the form
            $('#confirmCustomerSelect').on('click', function () {
                var id = $('#customerSelect').val();
                if (!id) {
                    // no selection
                    alert('Please select a customer');
                    return;
                }
                var name = $('#customerSelect').find('option:selected').data('name') || $('#customerSelect').find('option:selected').text();
                $('#customerId').val(id);
                $('#customerName').val(name);
                $('#customerSelectModal').modal('hide');
                // fetch sale orders and quotations for this customer
                fetchSaleOrdersForCustomer(id);
                fetchQuotationsForCustomer(id);
            });

            function renderSaleOrders(saleOrders) {
                var container = $('#customerSaleOrders');
                if (!saleOrders || saleOrders.length === 0) {
                    container.html('<div class="alert alert-info">No sale orders found for selected customer.</div>');
                    return;
                }
                var html = '<h5>Customer Sale Orders</h5>';
                html += '<div class="table-responsive">';
                html += '<table id="saleOrdersTable" class="table table-sm table-striped">';
                html += '<thead><tr><th>#</th><th>Work Order</th><th>Machine</th><th>Application</th><th>Order Date</th><th>Delivery Date</th><th>Status</th><th>Payment</th><th>Action</th></tr></thead>';
                html += '<tbody>';
                saleOrders.forEach(function (order, idx) {
                    var workNo = order.work_order_no || 'N/A';
                    var machine = (order.quotation && order.quotation.machine) ? order.quotation.machine.name : 'N/A';
                    var application = (order.quotation && order.quotation.application) ? order.quotation.application.name : 'N/A';
                    var orderDate = order.order_date ? new Date(order.order_date).toLocaleDateString('en-IN') : '-';
                    var deliveryDate = order.delivery_date ? new Date(order.delivery_date).toLocaleDateString('en-IN') : '-';
                    var status = order.status || 'N/A';
                    var paymentStatus = order.payment_status || 'N/A';
                    var showUrl = '/sale-order/' + order.id;

                    var statusBadge = '<span class="badge badge-info">' + status + '</span>';
                    var paymentBadge = paymentStatus === 'paid' ? '<span class="badge badge-success">' + paymentStatus + '</span>' : '<span class="badge badge-warning">' + paymentStatus + '</span>';

                    html += '<tr>';
                    html += '<td>' + (idx + 1) + '</td>';
                    html += '<td>' + workNo + '</td>';
                    html += '<td>' + machine + '</td>';
                    html += '<td>' + application + '</td>';
                    html += '<td>' + orderDate + '</td>';
                    html += '<td>' + deliveryDate + '</td>';
                    html += '<td>' + statusBadge + '</td>';
                    html += '<td>' + paymentBadge + '</td>';
                    html += '<td><a class="btn btn-sm btn-outline-primary" href="' + showUrl + '">View</a></td>';
                    html += '</tr>';
                });
                html += '</tbody></table></div>';
                container.html(html);

                // Initialize DataTable after rendering
                if ($.fn.DataTable.isDataTable('#saleOrdersTable')) {
                    $('#saleOrdersTable').DataTable().destroy();
                }
                $('#saleOrdersTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    lengthChange: true,
                    pageLength: 10
                });
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

            function renderQuotations(quotations) {
                var container = $('#customerQuotations');
                if (!quotations || quotations.length === 0) {
                    container.html('<div class="alert alert-info">No quotations found for selected customer.</div>');
                    return;
                }
                var html = '<h5>Customer Quotations</h5>';
                html += '<div class="table-responsive">';
                html += '<table id="quotationsTable" class="table table-sm table-striped">';
                html += '<thead><tr><th>#</th><th>Reference</th><th>Machine</th><th>Application</th><th>Created Date</th><th>Status</th><th>Action</th></tr></thead>';
                html += '<tbody>';
                quotations.forEach(function (quotation, idx) {
                    var ref = quotation.reference_no || 'N/A';
                    var machine = (quotation.machine) ? quotation.machine.name : 'N/A';
                    var application = (quotation.application) ? quotation.application.name : 'N/A';
                    var createdDate = quotation.created_at ? new Date(quotation.created_at).toLocaleDateString('en-IN') : '-';
                    var status = quotation.status || 'pending';
                    var showUrl = '/quotation/' + quotation.id;
                    var customerId = $('#customerId').val();
                    var reorderUrl = '{{ route("opportunity.create") }}?customer_id=' + customerId;

                    var statusBadge = '<span class="badge badge-secondary">' + status + '</span>';

                    html += '<tr>';
                    html += '<td>' + (idx + 1) + '</td>';
                    html += '<td>' + ref + '</td>';
                    html += '<td>' + machine + '</td>';
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

                // Initialize DataTable after rendering
                if ($.fn.DataTable.isDataTable('#quotationsTable')) {
                    $('#quotationsTable').DataTable().destroy();
                }
                $('#quotationsTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    lengthChange: true,
                    pageLength: 10
                });
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
        });
    </script>
@endpush