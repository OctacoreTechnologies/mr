@extends('layouts.app')

@section('title', 'Permissions')

@section('content_header')
<div class="pm-topbar">
    <div>
        <div class="pm-page-title">
            <div class="pm-icon-box">
                <i class="fas fa-lock"></i>
            </div>
            Permission Management
        </div>
        <div class="pm-subtitle">System access permissions — read only</div>
    </div>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

{{-- STAT CARDS --}}
<div class="pm-stats">
    <div class="pm-stat">
        <div class="pm-stat-label">Total permissions</div>
        <div class="pm-stat-val">{{ count($permissions) }}</div>
        <div class="pm-stat-sub">system wide</div>
    </div>
    <div class="pm-stat">
        <div class="pm-stat-label">Modules covered</div>
        <div class="pm-stat-val">
            {{-- Count unique prefixes (e.g. manage-users → users) --}}
            {{ $permissions->map(fn($p) => explode('-', $p->name, 2)[1] ?? $p->name)->unique()->count() }}
        </div>
        <div class="pm-stat-sub">unique modules</div>
    </div>
    <div class="pm-stat">
        <div class="pm-stat-label">Assigned to roles</div>
        <div class="pm-stat-val">{{ $assignedCount ?? '—' }}</div>
        <div class="pm-stat-sub">out of {{ count($permissions) }}</div>
    </div>
</div>

{{-- MAIN CARD --}}
<div class="pm-card">

    {{-- CARD HEADER --}}
    <div class="pm-card-head">
        <div class="pm-card-head-left">
            <span class="pm-card-label">All Permissions</span>
            <span class="pm-chip">{{ count($permissions) }} total</span>
        </div>
        <div class="pm-search-box">
            <i class="fas fa-search pm-search-icon"></i>
            <input type="text" id="permSearch" placeholder="Search permissions..." />
        </div>
    </div>

    {{-- TABLE --}}
    <div class="pm-table-wrap">

        @if($permissions->isEmpty())
            <div class="pm-empty">
                <i class="fas fa-folder-open"></i>
                <p>No permissions found</p>
            </div>
        @else
            <table id="permTable">
                <thead>
                    <tr>
                        <th style="width:80px">ID</th>
                        <th>Permission name</th>
                        <th style="width:140px">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                    @php
                        // Derive category from permission name prefix
                        $parts    = explode('-', $permission->name);
                        $module   = strtolower(end($parts));
                        $catMap   = [
                            'users'    => ['label' => 'Users',    'class' => 'cat-users'],
                            'user'     => ['label' => 'Users',    'class' => 'cat-users'],
                            'roles'    => ['label' => 'Roles',    'class' => 'cat-roles'],
                            'role'     => ['label' => 'Roles',    'class' => 'cat-roles'],
                            'reports'  => ['label' => 'Reports',  'class' => 'cat-reports'],
                            'report'   => ['label' => 'Reports',  'class' => 'cat-reports'],
                            'billing'  => ['label' => 'Billing',  'class' => 'cat-billing'],
                            'invoices' => ['label' => 'Billing',  'class' => 'cat-billing'],
                            'lead'     => ['label' => 'Leads',    'class' => 'cat-leads'],
                            'leads'    => ['label' => 'Leads',    'class' => 'cat-leads'],
                            'settings' => ['label' => 'System',   'class' => 'cat-system'],
                        ];
                        $cat   = $catMap[$module] ?? ['label' => 'General', 'class' => 'cat-general'];
                        $dotColors = [
                            'cat-users'   => '#1d4ed8',
                            'cat-roles'   => '#7c3aed',
                            'cat-reports' => '#15803d',
                            'cat-billing' => '#b45309',
                            'cat-leads'   => '#0f766e',
                            'cat-system'  => '#b91c1c',
                            'cat-general' => '#64748b',
                        ];
                        $dotColor = $dotColors[$cat['class']] ?? '#64748b';
                    @endphp
                    <tr>

                        {{-- ID --}}
                        <td>
                            <span class="pm-id">#{{ str_pad($permission->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </td>

                        {{-- PERMISSION NAME --}}
                        <td>
                            <div class="pm-name-cell">
                                <span class="pm-dot" style="background:{{ $dotColor }}"></span>
                                <span class="pm-name">{{strtoupper(str_replace('_', ' ', $permission->name))}}</span>
                            </div>
                        </td>
                        {{-- DATE --}}
                        <td>
                            <div class="pm-date">
                                <i class="far fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($permission->created_at)->format('d M Y') }}
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    {{-- FOOTER --}}
    @if(!$permissions->isEmpty())
    <div class="pm-footer">
        <div class="pm-info" id="pm-count-info">
            Showing all {{ count($permissions) }} permissions
        </div>
    </div>
    @endif

</div>

@stop

@push('css')
<style>
*,*::before,*::after{box-sizing:border-box}

/* ── TOP BAR ── */
.pm-topbar{display:flex;align-items:center;justify-content:space-between;padding:4px 0 16px;flex-wrap:wrap;gap:10px}
.pm-page-title{font-size:1.2rem;font-weight:600;color:#1e293b;display:flex;align-items:center;gap:10px}
.pm-icon-box{width:34px;height:34px;border-radius:8px;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-size:.82rem;flex-shrink:0}
.pm-subtitle{font-size:.78rem;color:#64748b;margin-top:3px;padding-left:44px}

/* ── STAT CARDS ── */
.pm-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:1.2rem}
.pm-stat{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px 18px}
.pm-stat-label{font-size:.7rem;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px}
.pm-stat-val{font-size:1.6rem;font-weight:600;color:#1e293b;line-height:1.1}
.pm-stat-sub{font-size:.7rem;color:#94a3b8;margin-top:3px}

/* ── MAIN CARD ── */
.pm-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden}

/* Card header */
.pm-card-head{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #f1f5f9;flex-wrap:wrap;gap:10px}
.pm-card-head-left{display:flex;align-items:center;gap:8px}
.pm-card-label{font-size:.9rem;font-weight:600;color:#1e293b}
.pm-chip{background:#ede9fe;color:#7c3aed;font-size:.7rem;font-weight:600;padding:2px 9px;border-radius:20px}
.pm-search-box{display:flex;align-items:center;gap:7px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:7px;padding:6px 12px}
.pm-search-icon{font-size:.72rem;color:#94a3b8}
.pm-search-box input{background:none;border:none;outline:none;font-size:.82rem;color:#1e293b;width:160px}
.pm-search-box input::placeholder{color:#94a3b8}

/* Table wrap */
.pm-table-wrap{overflow-x:auto}

/* ── TABLE ── */
#permTable{width:100%;border-collapse:collapse;font-size:.85rem}
#permTable thead tr{background:#f8fafc;border-bottom:1px solid #e2e8f0}
#permTable thead th{font-size:.7rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:#64748b;padding:10px 20px;text-align:left;white-space:nowrap}
#permTable tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s}
#permTable tbody tr:last-child{border-bottom:none}
#permTable tbody tr:hover{background:#faf5ff}
#permTable tbody td{padding:11px 20px;vertical-align:middle;color:#1e293b}

/* ID pill */
.pm-id{background:#f1f5f9;border:1px solid #e2e8f0;color:#64748b;font-size:.7rem;font-family:'Courier New',monospace;padding:3px 9px;border-radius:20px;font-weight:600}

/* Name cell */
.pm-name-cell{display:flex;align-items:center;gap:10px}
.pm-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
.pm-name{font-weight:500;font-size:.85rem;color:#1e293b;font-family:'Courier New',monospace}

/* Category badges */
.pm-cat{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:20px;font-size:.7rem;font-weight:600;white-space:nowrap}
.pm-cat i{font-size:.6rem}
.cat-users  {background:#dbeafe;color:#1d4ed8}
.cat-roles  {background:#ede9fe;color:#6d28d9}
.cat-reports{background:#dcfce7;color:#15803d}
.cat-billing{background:#fef3c7;color:#b45309}
.cat-leads  {background:#ccfbf1;color:#0f766e}
.cat-system {background:#fee2e2;color:#b91c1c}
.cat-general{background:#f1f5f9;color:#64748b}

/* Date */
.pm-date{display:inline-flex;align-items:center;gap:5px;font-size:.78rem;color:#64748b;white-space:nowrap}
.pm-date i{font-size:.65rem;color:#94a3b8}

/* Empty state */
.pm-empty{text-align:center;padding:50px 0;color:#94a3b8}
.pm-empty i{font-size:2.2rem;margin-bottom:10px;display:block;opacity:.5}
.pm-empty p{font-size:.85rem}

/* Footer */
.pm-footer{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-top:1px solid #f1f5f9;flex-wrap:wrap;gap:8px}
.pm-info{font-size:.75rem;color:#94a3b8}

/* ── RESPONSIVE ── */
@media(max-width:767px){
    .pm-stats{grid-template-columns:1fr}
    .pm-topbar,.pm-card-head{flex-direction:column;align-items:flex-start}
    .pm-search-box input{width:120px}
}
</style>
@endpush

@push('js')
<script>
$(document).ready(function () {

    // Live search
    $('#permSearch').on('keyup', function () {
        var val   = $(this).val().toLowerCase();
        var shown = 0;

        $('#permTable tbody tr').each(function () {
            var match = $(this).text().toLowerCase().indexOf(val) > -1;
            $(this).toggle(match);
            if (match) shown++;
        });

        var total = {{ count($permissions) }};
        $('#pm-count-info').text(
            val ? 'Showing ' + shown + ' of ' + total + ' permissions' : 'Showing all ' + total + ' permissions'
        );
    });

});
</script>
@endpush