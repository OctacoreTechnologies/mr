@extends('layouts.app')

@section('title', 'Edit Follow-up')

@php
    $quotation_id = request()->query('quotation_id') ?? null;
@endphp

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-calendar-check"></i>
        Quotation Follow-ups
    </h1>
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger mb-3">
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

{{-- ── Follow-up History (Collapsible) ── --}}
<div class="crm-index-card mb-4">
    <div class="card-header fu-history-toggle" id="historyToggle" title="Click to expand / collapse">
        <h3 class="card-title mb-0">
            <i class="fas fa-history"></i> Follow-up History
            @if(!$followups->isEmpty())
                <span class="fu-count-badge">{{ $followups->count() }}</span>
            @endif
        </h3>
        <div class="d-flex align-items-center" style="gap:10px;">
            <span class="fu-toggle-hint" id="toggleHint">Click to expand</span>
            <i class="fas fa-chevron-down fu-chevron" id="historyChevron"></i>
        </div>
    </div>

    <div class="fu-history-body" id="historyBody" style="display:none;">
        @if($followups->isEmpty())
            <div style="padding:16px 20px;">
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle mr-2"></i> No follow-up history found.
                </div>
            </div>
        @else
            <div class="fu-table-scroll">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Follow-Up Date</th>
                            <th>Notes</th>
                            <th>Next Follow-Up Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($followups as $index => $followup)
                            <tr>
                                <td class="sr-no">{{ $index + 1 }}</td>
                                <td>
                                    <span class="crm-date-cell">
                                        <i class="fas fa-calendar-day"></i>
                                        {{ \Carbon\Carbon::parse($followup->follow_up_date)->format('d M Y, h:i A') }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($followup->notes, 60, '...') }}</td>
                                <td>
                                    <span class="crm-date-cell">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($followup->next_follow_up_date)->format('d M Y, h:i A') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- ── Follow-up Form ── --}}
<div class="crm-card" style="margin-bottom: 80px;">{{-- bottom margin for sticky bar --}}
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Manage Follow-up Entries
        </h3>
        <span class="fu-entry-count" id="entryCount"></span>
    </div>

    <div class="crm-card-body">
        <form action="{{ route('followup.update', $customer_id) }}" method="POST" id="followupForm">
            @csrf
            @method('PUT')

            <div id="followup-container">

                {{-- New (blank) row --}}
                <div class="followup-row followup-row--new">
                    <div class="followup-row-header">
                        <span class="followup-row-label">
                            <i class="fas fa-plus-circle"></i> New Entry
                        </span>
                        <button type="button" class="crm-remove-btn remove-followup">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    <input type="hidden" name="follow_up_id[]">
                    <input type="hidden" name="quotation_id" value="{{ $quotation_id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input type="date" name="follow_up_date[]" label="Follow-Up Date" fgroup-class="mb-3" />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input type="text" name="next_follow_up_date[]" label="Next Follow-Up Date" fgroup-class="mb-3" />
                        </div>
                        <div class="col-md-12">
                            <x-adminlte-textarea name="notes[]" label="Notes" fgroup-class="mb-0"></x-adminlte-textarea>
                        </div>
                    </div>
                </div>

                {{-- Existing rows --}}
                @foreach ($ofollowups as $index => $followup)
                    <div class="followup-row">
                        <div class="followup-row-header">
                            <span class="followup-row-label">
                                <i class="fas fa-calendar-check"></i> Entry #{{ $index + 1 }}
                            </span>
                            <button type="button" class="crm-remove-btn remove-followup">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                        <input type="hidden" name="follow_up_id[]" value="{{ $followup->id }}">
                        <input type="hidden" name="quotation_id" value="{{ $quotation_id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input type="date" name="follow_up_date[]" label="Follow-Up Date"
                                    value="{{ $followup->follow_up_date }}" fgroup-class="mb-3" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input type="datetime-local" name="next_follow_up_date[]"
                                    label="Next Follow-Up Date"
                                    value="{{ $followup->next_follow_up_date }}" fgroup-class="mb-3" />
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-textarea name="notes[]" label="Notes" fgroup-class="mb-0">{{ $followup->notes }}</x-adminlte-textarea>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>{{-- /followup-container --}}
        </form>
    </div>
</div>

{{-- ══ STICKY SAVE BAR ══ --}}
<div class="fu-sticky-bar" id="stickyBar">
    <div class="fu-sticky-inner">
        <div class="fu-sticky-info">
            <i class="fas fa-layer-group"></i>
            <span id="stickyInfo">— entries to save</span>
        </div>
        <div class="fu-sticky-actions">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" form="followupForm" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </div>
</div>

@stop

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <style>
        /* ─── History collapsible header ─── */
        .fu-history-toggle {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
        }
        .fu-history-toggle:hover { opacity: .92; }

        .fu-count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 20px;
            background: rgba(255,255,255,.25);
            color: #fff;
            font-size: .72rem;
            font-weight: 700;
        }
        .fu-toggle-hint {
            font-size: .73rem;
            font-weight: 500;
            color: rgba(255,255,255,.72);
        }
        .fu-chevron {
            color: rgba(255,255,255,.85);
            font-size: .85rem;
            transition: transform .25s ease;
        }
        .fu-chevron.open { transform: rotate(180deg); }

        /* ─── Scrollable table container — max 300px ─── */
        .fu-table-scroll {
            max-height: 300px;
            overflow-y: auto;
            padding: 0 20px 14px;
            border-top: 1px solid var(--crm-border);
        }
        .fu-table-scroll::-webkit-scrollbar { width: 4px; }
        .fu-table-scroll::-webkit-scrollbar-thumb {
            background: var(--crm-primary);
            border-radius: 4px;
        }

        /* ─── Form card header pill ─── */
        .fu-entry-count {
            font-family: var(--crm-mono);
            font-size: .74rem;
            font-weight: 600;
            color: rgba(255,255,255,.8);
            background: rgba(255,255,255,.15);
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* ─── Follow-up rows ─── */
        .followup-row {
            background: var(--crm-bg);
            border: 1.5px solid var(--crm-border);
            border-radius: var(--crm-radius);
            padding: 18px 18px 14px;
            margin-bottom: 14px;
            transition: border-color var(--crm-transition), box-shadow var(--crm-transition);
        }
        .followup-row:hover {
            border-color: var(--crm-primary);
            box-shadow: 0 2px 12px rgba(37,99,235,.08);
        }
        .followup-row--new {
            border-color: var(--crm-primary);
            background: var(--crm-primary-light);
        }
        .followup-row-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .followup-row-label {
            font-family: var(--crm-font);
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--crm-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .crm-remove-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            font-family: var(--crm-font);
            font-size: .76rem;
            font-weight: 600;
            color: var(--crm-danger);
            background: #fee2e2;
            border: 1.5px solid transparent;
            border-radius: var(--crm-radius-sm);
            cursor: pointer;
            transition: all var(--crm-transition);
        }
        .crm-remove-btn:hover {
            border-color: var(--crm-danger);
            box-shadow: 0 2px 8px rgba(220,38,38,.2);
            transform: translateY(-1px);
        }

        /* ─── Date cell ─── */
        .crm-date-cell {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .84rem;
        }
        .crm-date-cell i { color: var(--crm-primary); font-size: .78rem; }

        /* ─── STICKY BAR ─── */
        .fu-sticky-bar {
            position: fixed;
            bottom: 0;
            left: 250px; /* AdminLTE sidebar width */
            right: 0;
            z-index: 1030;
            background: var(--crm-card-bg);
            border-top: 2px solid var(--crm-primary);
            box-shadow: 0 -4px 20px rgba(37,99,235,.13);
            padding: 11px 28px;
            transition: left .3s ease;
        }
        /* Collapsed sidebar */
        .sidebar-collapse .fu-sticky-bar { left: 74px; }
        /* Mobile */
        @media (max-width: 767px) {
            .fu-sticky-bar { left: 0 !important; padding: 10px 16px; }
            .fu-sticky-info { display: none; }
        }

        .fu-sticky-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .fu-sticky-info {
            display: flex;
            align-items: center;
            gap: 7px;
            font-family: var(--crm-font);
            font-size: .82rem;
            color: var(--crm-text-muted);
        }
        .fu-sticky-info i { color: var(--crm-primary); }
        .fu-sticky-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ─── Flatpickr ─── */
        .flatpickr-calendar {
            font-family: var(--crm-font) !important;
            border-radius: var(--crm-radius) !important;
            box-shadow: 0 8px 24px rgba(0,0,0,.1) !important;
            border: 1.5px solid var(--crm-border) !important;
        }
        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: var(--crm-primary) !important;
            border-color: var(--crm-primary) !important;
        }
        .flatpickr-day:hover { background: var(--crm-primary-light) !important; }
    </style>
@endpush

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ── History toggle ── */
            const toggle  = document.getElementById('historyToggle');
            const body    = document.getElementById('historyBody');
            const chevron = document.getElementById('historyChevron');
            const hint    = document.getElementById('toggleHint');

            toggle.addEventListener('click', function () {
                const open = body.style.display !== 'none';
                body.style.display = open ? 'none' : 'block';
                chevron.classList.toggle('open', !open);
                hint.textContent = open ? 'Click to expand' : 'Click to collapse';
            });

            /* ── Remove row (delegated) ── */
            document.getElementById('followup-container').addEventListener('click', function (e) {
                if (e.target.closest('.remove-followup')) {
                    e.target.closest('.followup-row').remove();
                    updateCount();
                }
            });

            /* ── Entry count ── */
            function updateCount() {
                const n = document.querySelectorAll('#followup-container .followup-row').length;
                document.getElementById('entryCount').textContent = n + (n === 1 ? ' entry' : ' entries');
                document.getElementById('stickyInfo').textContent = n + (n === 1 ? ' entry to save' : ' entries to save');
            }
            updateCount();

            /* ── Flatpickr ── */
            flatpickr("input[name='next_follow_up_date[]']", {
                enableTime: true,
                dateFormat: "Y-m-d h:i K",
                time_24hr: false
            });

        });
    </script>
@stop