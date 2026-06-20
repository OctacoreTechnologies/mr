@php
    $heads = [
        '#',
        'Company',
        'Contact Person',
        'Email',
        'Phone',
        'Status',
        ['label' => 'Actions', 'no-export' => true, 'width' => 14],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Leads')

@section('content_header')
    <div class="crm-page-header">
        <h1>
            <i class="fas fa-funnel-dollar"></i> Leads
        </h1>
        @can('lead_create')
            <a href="{{ route('lead.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Create Lead
            </a>
        @endcan
    </div>
@stop

@section('content')
<div class="leads-wrapper pb-3">

    <x-alert-components class="mb-2" />

    {{-- Summary Cards --}}
    @php
        $total        = $leads->count();
        $newCount     = $leads->where('status', 'new')->count();
        $contacted    = $leads->where('status', 'contacted')->count();
        $qualified    = $leads->where('status', 'qualified')->count();
        $disqualified = $leads->where('status', 'disqualified')->count();
    @endphp

    <div class="row mb-2">
        <div class="col-6 col-sm-4 col-md mb-3 mb-md-0">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#eff6ff; color:#2563eb">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $total }}</div>
                    <div class="ci-stat-text">Total</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md mb-3 mb-md-0">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#fffbeb; color:#d97706">
                    <i class="fas fa-star"></i>
                </div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $newCount }}</div>
                    <div class="ci-stat-text">New</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md mb-3 mb-md-0">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#f0f9ff; color:#0284c7">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $contacted }}</div>
                    <div class="ci-stat-text">Contacted</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md mb-3 mb-md-0">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#f0fdf4; color:#16a34a">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $qualified }}</div>
                    <div class="ci-stat-text">Qualified</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md">
            <div class="ci-stat">
                <div class="ci-stat-icon" style="background:#fff1f2; color:#e11d48">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="ci-stat-body">
                    <div class="ci-stat-num">{{ $disqualified }}</div>
                    <div class="ci-stat-text">Disqualified</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Leads Table --}}
    <div class="crm-card">
        <div class="crm-card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> Lead List</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <x-adminlte-datatable id="leadTable" :heads="$heads" striped hoverable with-buttons>
                    @foreach ($leads as $key => $lead)
                        @php
                            $avatarName = $lead->company_name ?: 'NA';
                            $words    = preg_split('/\s+/', trim($avatarName));
                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            $colors   = ['#3b82f6','#0ea5e9','#10b981','#f59e0b','#8b5cf6','#ec4899','#06b6d4','#84cc16'];
                            $bg       = $colors[$key % count($colors)];

                            $statusMap = [
                                'new'          => ['ci-new',          'New'],
                                'contacted'    => ['ci-contacted',    'Contacted'],
                                'qualified'    => ['ci-qualified',    'Qualified'],
                                'disqualified' => ['ci-disqualified', 'Disqualified'],
                            ];
                            [$stClass, $stLabel] = $statusMap[$lead->status]
                                ?? ['ci-other', ucfirst($lead->status)];
                        @endphp
                        <tr>
                            {{-- # --}}
                            <td class="text-muted" style="font-size:.8rem; width:40px">
                                {{ $key + 1 }}
                            </td>

                            {{-- Company --}}
                            <td>
                                <div class="d-flex align-items-center" style="gap:10px">
                                    <div class="ci-avatar" style="background:{{ $bg }}">{{ $initials }}</div>
                                    <span class="font-weight-semibold">
                                        {{ $lead->company_name ?: 'NA' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Contact Person --}}
                            <td class="text-muted" style="font-size:.85rem">
                                {{ $lead->contact_person_1_name ?: 'NA' }}
                            </td>

                            {{-- Email --}}
                            <td class="text-muted" style="font-size:.85rem">
                                {{ $lead->contact_person_1_email ?? '—' }}
                            </td>

                            {{-- Phone --}}
                            <td class="text-muted" style="font-size:.85rem">
                                {{ $lead->contact_person_1_contact ?? '—' }}
                            </td>

                            {{-- Status --}}
                            <td>
                                @can('lead_edit')
                                <div class="lead-status-wrapper" style="position:relative;display:inline-block">
                                    <span class="ci-badge {{ $stClass }} lead-status-trigger"
                                          data-id="{{ $lead->id }}"
                                          data-status="{{ $lead->status }}"
                                          style="cursor:pointer;user-select:none"
                                          title="Click to change status">
                                        {{ $stLabel }} <i class="fas fa-chevron-down" style="font-size:.6rem;margin-left:3px;opacity:.7"></i>
                                    </span>
                                    <div class="lead-status-dropdown" style="display:none;position:absolute;top:calc(100% + 4px);left:0;z-index:999;background:#fff;border:1px solid #e2e8f0;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,.12);min-width:148px;overflow:hidden">
                                        <div class="lead-status-opt" data-value="new"          style="padding:8px 14px;cursor:pointer;font-size:.78rem;font-weight:600;color:#854d0e;background:#fef9c3">New</div>
                                        <div class="lead-status-opt" data-value="contacted"    style="padding:8px 14px;cursor:pointer;font-size:.78rem;font-weight:600;color:#0369a1;background:#e0f2fe">Contacted</div>
                                        <div class="lead-status-opt" data-value="qualified"    style="padding:8px 14px;cursor:pointer;font-size:.78rem;font-weight:600;color:#15803d;background:#dcfce7">Qualified</div>
                                        <div class="lead-status-opt" data-value="disqualified" style="padding:8px 14px;cursor:pointer;font-size:.78rem;font-weight:600;color:#be123c;background:#ffe4e6">Disqualified</div>
                                    </div>
                                </div>
                                @else
                                <span class="ci-badge {{ $stClass }}">{{ $stLabel }}</span>
                                @endcan
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="ci-actions">

                                    @can('followup_customer')
                                        <a href="{{ route('followup.edit', $lead->id) }}?type='lead'"
                                           class="ci-btn" style="color:#2563eb" title="Follow Up"
                                        >
                                            <i class="fas fa-phone-alt"></i>
                                        </a>
                                    @endcan

                                    @can('lead_show')
                                        <a href="{{ route('customer.show', $lead->id) }}"
                                           class="ci-btn" style="color:#0284c7" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan

                                    @can('lead_edit')
                                        <a href="{{ route('lead.edit', $lead->id) }}"
                                           class="ci-btn" style="color:#d97706" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @if ($lead->sale_formats_count() != 0)
                                        <a href="{{ route('sale-formats.show', $lead->sale_formats->id) }}"
                                           class="ci-btn" style="color:#7c3aed" title="View Sale Formats">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('sale-formats.create', ['customer_id' => $lead->id]) }}"
                                           class="ci-btn" style="color:#2563eb" title="New Sale Format">
                                            <i class="fas fa-plus-square"></i>
                                        </a>
                                    @endif

                                    @can('lead_delete')
                                        <form action="{{ route('customer.destroy', $lead->id) }}"
                                              method="POST" class="d-inline m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="ci-btn delete-lead"
                                                    style="color:#e11d48" title="Delete">
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

</div>

{{-- Convert to Opportunity Modal --}}
<div class="modal fade" id="convertOpportunityModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px" role="document">
        <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 8px 32px rgba(0,0,0,.15)">
            <div class="modal-body text-center" style="padding:32px 28px 20px">
                <div style="width:56px;height:56px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-rocket" style="font-size:1.4rem;color:#16a34a"></i>
                </div>
                <h5 style="font-weight:700;color:#1e293b;margin-bottom:8px">Lead Qualified!</h5>
                <p style="color:#64748b;font-size:.88rem;margin-bottom:0">
                    <strong id="convertLeadName"></strong> is now marked as <span class="ci-badge ci-qualified">Qualified</span>.<br>
                    Do you want to convert this lead into an <strong>Opportunity</strong>?
                </p>
            </div>
            <div class="modal-footer" style="border:none;padding:4px 28px 24px;justify-content:center;gap:10px">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" style="min-width:110px">
                    <i class="fas fa-times"></i> Not Now
                </button>
                <a href="#" id="convertOpportunityBtn" class="btn btn-success" style="min-width:150px">
                    <i class="fas fa-rocket"></i> Convert
                </a>
            </div>
        </div>
    </div>
</div>

@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
    <style>
        /* Summary stat cards — compact */
        .ci-stat {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
            height: 100%;
            transition: box-shadow .2s, transform .15s;
        }
        .ci-stat:hover {
            box-shadow: 0 3px 12px rgba(37,99,235,.1);
            transform: translateY(-1px);
        }
        .ci-stat-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: .88rem;
            flex-shrink: 0;
        }
        .ci-stat-num  { font-size: 1.25rem; font-weight: 700; line-height: 1; color: #1e293b; }
        .ci-stat-text { font-size: .68rem; font-weight: 600; text-transform: uppercase;
                        letter-spacing: .06em; color: #94a3b8; margin-top: 3px; }

        /* Avatar */
        .ci-avatar {
            width: 30px; height: 30px; border-radius: 6px;
            color: #fff; font-size: .68rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .font-weight-semibold { font-weight: 600; color: #1e293b; }

        /* Status badges */
        .ci-badge {
            display: inline-block;
            font-size: .72rem; font-weight: 600;
            padding: 4px 12px; border-radius: 20px;
            white-space: nowrap;
        }
        .ci-new          { background: #fef9c3; color: #854d0e; }
        .ci-contacted    { background: #e0f2fe; color: #0369a1; }
        .ci-qualified    { background: #dcfce7; color: #15803d; }
        .ci-disqualified { background: #ffe4e6; color: #be123c; }
        .ci-other        { background: #f1f5f9; color: #64748b; }

        /* Action buttons */
        .ci-actions { display: flex; align-items: center; gap: 2px; flex-wrap: nowrap; }
        .ci-btn {
            width: 30px; height: 30px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 6px; border: none; background: transparent;
            cursor: pointer; font-size: .84rem;
            text-decoration: none !important;
            transition: background .15s, color .15s;
        }
        .ci-btn:hover { background: #f1f5f9; }

        /* Table spacing */
        #leadTable_wrapper { padding: 12px 14px 6px; }

        /* Footer gap */
        .content-wrapper { padding-bottom: 24px !important; }
    </style>
@endpush

@push('js')
    <script>
        $(document).on('click', '.delete-lead', function () {
            const form = $(this).closest('form');
            if (confirm('Delete this lead? This cannot be undone.')) {
                form.submit();
            }
        });

        // ── Inline Status Update ──────────────────────────────────────────
        const statusMeta = {
            new:          { cls: 'ci-new',          label: 'New' },
            contacted:    { cls: 'ci-contacted',    label: 'Contacted' },
            qualified:    { cls: 'ci-qualified',    label: 'Qualified' },
            disqualified: { cls: 'ci-disqualified', label: 'Disqualified' },
        };

        // Open / close dropdown
        $(document).on('click', '.lead-status-trigger', function (e) {
            e.stopPropagation();
            const $wrap = $(this).closest('.lead-status-wrapper');
            const $dd   = $wrap.find('.lead-status-dropdown');
            // close all others first
            $('.lead-status-dropdown').not($dd).hide();
            $dd.toggle();
        });

        // Close on outside click
        $(document).on('click', function () {
            $('.lead-status-dropdown').hide();
        });

        // Pick a new status
        $(document).on('click', '.lead-status-opt', function (e) {
            e.stopPropagation();
            const $opt    = $(this);
            const $wrap   = $opt.closest('.lead-status-wrapper');
            const $badge  = $wrap.find('.lead-status-trigger');
            const leadId  = $badge.data('id');
            const newStatus = $opt.data('value');
            const oldStatus = $badge.data('status');

            if (newStatus === oldStatus) { $wrap.find('.lead-status-dropdown').hide(); return; }

            $badge.css('opacity', '.5').prop('disabled', true);

            $.ajax({
                url:    '{{ route("lead.updateStatus", ":id") }}'.replace(':id', leadId),
                method: 'POST',
                data:   { _token: '{{ csrf_token() }}', _method: 'PUT', status: newStatus },
                success: function () {
                    const meta = statusMeta[newStatus];
                    $badge
                        .removeClass('ci-new ci-contacted ci-qualified ci-disqualified ci-other')
                        .addClass(meta.cls)
                        .data('status', newStatus)
                        .html(meta.label + ' <i class="fas fa-chevron-down" style="font-size:.6rem;margin-left:3px;opacity:.7"></i>');
                    $badge.css({'opacity':'1','outline':'2px solid #22c55e','outline-offset':'2px'});
                    setTimeout(() => $badge.css('outline',''), 1200);

                    if (newStatus === 'qualified') {
                        const companyName = $badge.closest('tr').find('td:nth-child(2) .font-weight-semibold').text().trim();
                        $('#convertLeadName').text(companyName);
                        $('#convertOpportunityBtn').attr('href', '{{ route("opportunity.create") }}?lead_id=' + leadId);
                        $('#convertOpportunityModal').modal('show');
                    }
                },
                error: function () {
                    $badge.css('opacity','1');
                    alert('Status update failed. Please try again.');
                },
                complete: function () {
                    $badge.prop('disabled', false);
                    $wrap.find('.lead-status-dropdown').hide();
                }
            });
        });

        // Highlight current active option when dropdown opens
        $(document).on('click', '.lead-status-trigger', function () {
            const cur  = $(this).data('status');
            $(this).closest('.lead-status-wrapper').find('.lead-status-opt').each(function () {
                $(this).css('font-weight', $(this).data('value') === cur ? '700' : '600');
                $(this).find('.fa-check').remove();
                if ($(this).data('value') === cur) {
                    $(this).prepend('<i class="fas fa-check" style="margin-right:6px;font-size:.7rem"></i>');
                }
            });
        });
    </script>
@endpush
