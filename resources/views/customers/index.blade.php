@php
    $heads = [
        '#',
        'Company',
        'Contact Person',
        'Country',
        'Status',
        'Followed By',
        ['label' => 'Actions', 'no-export' => true, 'width' => 14],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Customers')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-users"></i> Customers
    </h1>
    <div class="d-flex" style="gap:8px">
        @can('customer_create')
            <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle"></i> Add Customer
            </a>
        @endcan
        @can('customer_import')
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#customerImport">
                <i class="fas fa-file-excel"></i> Import
            </button>
        @endcan
    </div>
</div>
@stop

@section('content')

    <x-alert-components class="my-3" />

    {{-- Summary Cards --}}
    @php
        $total = $customers->count();
        $leads = $customers->where('customer_status', 'lead')->count();
        $quoted = $customers->where('customer_status', 'quoted')->count();
        $existing = $customers->where('customer_status', 'existing')->count();
    @endphp

    <div class="row mb-2">
        <div class="col-6 col-md-3 mb-2 mb-md-0">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#eff6ff; color:#2563eb"><i class="fas fa-users"></i></div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $total }}</div>
                    <div class="ci-stat-text">Total</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-2 mb-md-0">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#fffbeb; color:#d97706"><i class="fas fa-user-clock"></i></div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $leads }}</div>
                    <div class="ci-stat-text">Leads</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#f0f9ff; color:#0284c7"><i class="fas fa-file-invoice"></i>
                </div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $quoted }}</div>
                    <div class="ci-stat-text">Quoted</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#f0fdf4; color:#16a34a"><i class="fas fa-user-check"></i></div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $existing }}</div>
                    <div class="ci-stat-text">Existing</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Customer Table --}}
    <div class="crm-card">
        <div class="crm-card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> Customer List</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <x-adminlte-datatable id="customer-table" :heads="$heads" striped hoverable with-buttons>
                    @foreach ($customers as $key => $customer)
                        @php
                            $avatarName = $customer->company_name ?: 'NA';
                            $words = preg_split('/\s+/', trim($avatarName));
                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            $colors = ['#3b82f6', '#0ea5e9', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16'];
                            $bg = $colors[$key % count($colors)];

                            $statusMap = [
                                'lead' => ['ci-lead', 'Lead'],
                                'quoted' => ['ci-quoted', 'Quoted'],
                                'existing' => ['ci-existing', 'Existing'],
                            ];
                            [$stClass, $stLabel] = $statusMap[$customer->customer_status]
                                ?? ['ci-other', ucfirst($customer->customer_status)];
                        @endphp
                        <tr>
                            <td class="text-muted" style="font-size:.8rem">{{ $key + 1 }}</td>

                            <td>
                                <div class="d-flex align-items-center" style="gap:10px">
                                    <div class="ci-avatar" style="background:{{ $bg }}">{{ $initials }}</div>
                                    <strong>
                                        {{ $customer->company_name ?: 'NA' }}
                                    </strong>
                                </div>
                            </td>
                            <td class="text-muted" style="font-size:.85rem">
                                {{ $customer->contact_person_1_name ?: 'NA' }}
                            </td>

                            <td>
                                <span class="ci-country">{{ strtoupper($customer->country) }}</span>
                            </td>

                            <td>
                                <span class="ci-badge {{ $stClass }}">{{ $stLabel }}</span>
                            </td>

                            <td class="text-muted">{{ $customer->followedBy->name ?? '—' }}</td>

                            <td>
                                <div class="ci-actions">

                                    @can('followup_track')
                                        <a href="{{ route('followup.customers.show', $customer->id) }}" class="ci-btn"
                                            style="color:#16a34a" title="Track Followup">
                                            <i class="fas fa-chart-line"></i>
                                        </a>
                                    @endcan

                                    @can('followup_customer')
                                        <a href="{{ route('followup.edit', $customer->id) }}" class="ci-btn" style="color:#2563eb"
                                            title="Follow Up">
                                            <i class="fas fa-phone-alt"></i>
                                        </a>
                                    @endcan

                                    @can('customer_show')
                                        <a href="{{ route('customer.show', $customer->id) }}" class="ci-btn" style="color:#0284c7"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan

                                    @can('customer_edit')
                                        <a href="{{ route('customer.edit', $customer->id) }}" class="ci-btn" style="color:#d97706"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @if ($customer->sale_formats_count() != 0)
                                        <a href="{{ route('sale-formats.show', $customer->sale_formats->id) }}" class="ci-btn"
                                            style="color:#7c3aed" title="View Sale Formats">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('sale-formats.create', ['customer_id' => $customer->id]) }}"
                                            class="ci-btn" style="color:#2563eb" title="New Sale Format">
                                            <i class="fas fa-plus-square"></i>
                                        </a>
                                    @endif

                                    @can('customer_delete')
                                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST"
                                            class="d-inline m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="ci-btn delete-customer" style="color:#e11d48"
                                                title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>

    {{-- Import Modal --}}
    <x-adminlte-modal id="customerImport" title="Import Customer Excel File" theme="info" icon="fas fa-file-excel">
        <div class="alert alert-info mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Download Sample File</strong><br>
                    <small>Follow the format before uploading.</small>
                </div>
                <a href="{{ route('customer.excel.sample') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-download"></i> Sample
                </a>
            </div>
        </div>
        <form action="{{ route('customer.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="import-file" class="font-weight-bold">Select Excel File</label>
                <input type="file" id="import-file" name="file" class="form-control" required>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </form>
    </x-adminlte-modal>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
    <style>
        /* Summary cards */
        .ci-stat {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        .ci-stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .ci-stat-num {
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1;
            color: #1e293b;
        }

        .ci-stat-text {
            font-size: .68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #94a3b8;
            margin-top: 2px;
        }

        .btn-sm {
            padding: 5px 12px !important;
            font-size: .8rem !important;
        }

        /* Avatar */
        .ci-avatar {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            color: #fff;
            font-size: .7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Country */
        .ci-country {
            display: inline-block;
            font-size: .75rem;
            font-weight: 500;
            background: #f1f5f9;
            color: #64748b;
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* Status badges */
        .ci-badge {
            display: inline-block;
            font-size: .72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .ci-lead {
            background: #fef9c3;
            color: #854d0e;
        }

        .ci-quoted {
            background: #e0f2fe;
            color: #0369a1;
        }

        .ci-existing {
            background: #dcfce7;
            color: #15803d;
        }

        .ci-other {
            background: #f1f5f9;
            color: #64748b;
        }

        /* Action buttons */
        .ci-actions {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .ci-btn {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: .82rem;
            text-decoration: none !important;
            transition: background .15s;
        }

        .ci-btn:hover {
            background: #f1f5f9;
        }

        .content {
            padding-bottom: 40px !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).on('click', '.delete-customer', function () {
            const form = $(this).closest('form');
            if (confirm('Delete this customer? This cannot be undone.')) {
                form.submit();
            }
        });
    </script>
@endpush