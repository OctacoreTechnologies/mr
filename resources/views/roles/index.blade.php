@extends('layouts.app')

@section('title', 'Roles')

@section('content_header')
<div class="rm-topbar">
    <div class="rm-title-group">
        <div class="rm-page-title">
            <div class="rm-icon-box">
                <i class="fas fa-shield-alt"></i>
            </div>
            Role Management
        </div>
        <div class="rm-subtitle">Manage user roles and access permissions</div>
    </div>

    <a href="{{ route('admin.role.create') }}" class="rm-add-btn">
        <i class="fas fa-plus"></i> Add Role
    </a>
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

{{-- STAT CARDS --}}
<div class="rm-stats">
    <div class="rm-stat">
        <div class="rm-stat-label">Total roles</div>
        <div class="rm-stat-val">{{ $roles->total() }}</div>
        <div class="rm-stat-sub">across all departments</div>
    </div>
    <div class="rm-stat">
        <div class="rm-stat-label">Permissions assigned</div>
        <div class="rm-stat-val">{{ $totalPermissions ?? '—' }}</div>
        <div class="rm-stat-sub">across all roles</div>
    </div>
    <div class="rm-stat">
        <div class="rm-stat-label">Users with roles</div>
        <div class="rm-stat-val">{{ $totalUsers ?? '—' }}</div>
        <div class="rm-stat-sub">active users</div>
    </div>
</div>

{{-- MAIN CARD --}}
<div class="rm-card">

    {{-- CARD HEADER --}}
    <div class="rm-card-head">
        <div class="rm-card-head-left">
            <span class="rm-card-head-label">All Roles</span>
            <span class="rm-count-chip">{{ $roles->total() }} total</span>
        </div>
        <div class="rm-search-box">
            <i class="fas fa-search rm-search-icon"></i>
            <input type="text" id="roleSearch" placeholder="Search roles..." />
        </div>
    </div>

    {{-- TABLE --}}
    <div class="rm-table-wrap">
        <table id="roleTable">
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th>Role</th>
                    <th style="width:280px">Permissions</th>
                    <th style="width:130px">Created</th>
                    <th style="width:100px;text-align:center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                @php
                    $perms    = $role->permissions->pluck('name');
                    $words    = array_slice(explode(' ', $role->name), 0, 2);
                    $initials = strtoupper(implode('', array_map(fn($w) => $w[0], $words)));
                    $colorMap = ['blue','green','purple','coral','teal','amber'];
                    $color    = $colorMap[$loop->index % count($colorMap)];
                @endphp
                <tr>

                    {{-- INDEX --}}
                    <td class="rm-sr">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>

                    {{-- ROLE --}}
                    <td>
                        <div class="rm-role-cell">
                            <div class="rm-avatar rm-avatar-{{ $color }}">{{ $initials }}</div>
                            <div>
                                <div class="rm-role-name">{{ $role->name }}</div>
                                <div class="rm-role-slug">{{ Str::slug($role->name) }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- PERMISSIONS --}}
                    <td>
                        @if($perms->count())
                            <div class="rm-perm-list">
                                @foreach($perms->take(2) as $perm)
                                    <span class="rm-badge rm-badge-blue">
                                        <i class="fas fa-key"></i>{{ $perm }}
                                    </span>
                                @endforeach
                                @if($perms->count() > 2)
                                    <span class="rm-badge rm-badge-gray"
                                          data-toggle="tooltip"
                                          data-placement="top"
                                          title="{{ $perms->slice(2)->implode(', ') }}">
                                        +{{ $perms->count() - 2 }} more
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="rm-badge rm-badge-gray rm-no-perms">
                                <i class="fas fa-ban"></i> No permissions
                            </span>
                        @endif
                    </td>

                    {{-- DATE --}}
                    <td>
                        <div class="rm-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($role->created_at)->format('d M Y') }}
                        </div>
                    </td>

                    {{-- ACTIONS --}}
                    <td>
                        <div class="rm-actions">
                            <a href="{{ route('admin.role.show', $role->id) }}"
                               class="rm-btn rm-btn-view"
                               data-toggle="tooltip" title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.role.edit', $role->id) }}"
                               class="rm-btn rm-btn-edit"
                               data-toggle="tooltip" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.role.destroy', $role->id) }}"
                                  onsubmit="return confirm('Delete this role?')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rm-btn rm-btn-del"
                                        data-toggle="tooltip" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="rm-footer">
        <div class="rm-info">
            Showing {{ $roles->firstItem() }}–{{ $roles->lastItem() }} of {{ $roles->total() }} roles
        </div>
        <div class="rm-pagination">
            {{ $roles->links('pagination::bootstrap-4') }}
        </div>
    </div>

</div>
@stop

@push('css')
<style>
*,*::before,*::after{box-sizing:border-box}

/* ── TOP BAR ── */
.rm-topbar{display:flex;align-items:center;justify-content:space-between;padding:4px 0 16px;flex-wrap:wrap;gap:10px}
.rm-page-title{font-size:1.2rem;font-weight:600;color:#1e293b;display:flex;align-items:center;gap:10px}
.rm-icon-box{width:34px;height:34px;border-radius:8px;background:#dbeafe;color:#1d4ed8;display:flex;align-items:center;justify-content:center;font-size:.82rem;flex-shrink:0}
.rm-subtitle{font-size:.78rem;color:#64748b;margin-top:3px;padding-left:44px}
.rm-add-btn{display:inline-flex;align-items:center;gap:6px;background:#1e293b;color:#fff;border:none;border-radius:8px;padding:8px 16px;font-size:.82rem;font-weight:600;text-decoration:none;transition:opacity .15s;cursor:pointer}
.rm-add-btn:hover{opacity:.85;color:#fff;text-decoration:none}

/* ── STAT CARDS ── */
.rm-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:1.2rem}
.rm-stat{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px 18px}
.rm-stat-label{font-size:.7rem;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px}
.rm-stat-val{font-size:1.6rem;font-weight:600;color:#1e293b;line-height:1.1}
.rm-stat-sub{font-size:.7rem;color:#94a3b8;margin-top:3px}

/* ── MAIN CARD ── */
.rm-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden}

/* Card header */
.rm-card-head{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #f1f5f9;gap:10px;flex-wrap:wrap}
.rm-card-head-left{display:flex;align-items:center;gap:8px}
.rm-card-head-label{font-size:.9rem;font-weight:600;color:#1e293b}
.rm-count-chip{background:#dbeafe;color:#1d4ed8;font-size:.7rem;font-weight:600;padding:2px 9px;border-radius:20px}
.rm-search-box{display:flex;align-items:center;gap:7px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:7px;padding:6px 12px}
.rm-search-icon{font-size:.72rem;color:#94a3b8}
.rm-search-box input{background:none;border:none;outline:none;font-size:.82rem;color:#1e293b;width:160px}
.rm-search-box input::placeholder{color:#94a3b8}

/* Table wrap */
.rm-table-wrap{overflow-x:auto}

/* ── TABLE ── */
#roleTable{width:100%;border-collapse:collapse;font-size:.85rem}
#roleTable thead tr{background:#f8fafc;border-bottom:1px solid #e2e8f0}
#roleTable thead th{font-size:.7rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:#64748b;padding:10px 20px;text-align:left;white-space:nowrap}
#roleTable tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s}
#roleTable tbody tr:last-child{border-bottom:none}
#roleTable tbody tr:hover{background:#f8fafc}
#roleTable tbody td{padding:12px 20px;vertical-align:middle;color:#1e293b}
.rm-sr{font-family:'Courier New',monospace;font-size:.75rem !important;color:#94a3b8 !important;font-weight:600}

/* ── ROLE CELL ── */
.rm-role-cell{display:flex;align-items:center;gap:10px}
.rm-avatar{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0;letter-spacing:.04em}
.rm-avatar-blue  {background:#dbeafe;color:#1d4ed8}
.rm-avatar-green {background:#dcfce7;color:#15803d}
.rm-avatar-purple{background:#ede9fe;color:#6d28d9}
.rm-avatar-coral {background:#fee2e2;color:#b91c1c}
.rm-avatar-teal  {background:#ccfbf1;color:#0f766e}
.rm-avatar-amber {background:#fef3c7;color:#b45309}
.rm-role-name{font-weight:600;font-size:.85rem;color:#1e293b}
.rm-role-slug{font-size:.7rem;color:#94a3b8;font-family:'Courier New',monospace;margin-top:1px}

/* ── PERMISSION BADGES ── */
.rm-perm-list{display:flex;flex-wrap:wrap;gap:4px;align-items:center}
.rm-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:20px;font-size:.7rem;font-weight:600;white-space:nowrap}
.rm-badge i{font-size:.6rem}
.rm-badge-blue  {background:#dbeafe;color:#1d4ed8}
.rm-badge-gray  {background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0}
.rm-no-perms    {color:#94a3b8 !important}

/* ── DATE ── */
.rm-date{display:inline-flex;align-items:center;gap:5px;font-size:.78rem;color:#64748b;white-space:nowrap}
.rm-date i{font-size:.65rem;color:#94a3b8}

/* ── ACTION BUTTONS ── */
.rm-actions{display:flex;align-items:center;justify-content:center;gap:4px}
.rm-btn{width:30px;height:30px;border-radius:7px;border:1px solid #e2e8f0;background:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;color:#64748b;text-decoration:none;cursor:pointer;transition:all .13s;padding:0}
.rm-btn:hover{text-decoration:none}
.rm-btn-view:hover{background:#dbeafe;border-color:#93c5fd;color:#1d4ed8}
.rm-btn-edit:hover{background:#dcfce7;border-color:#86efac;color:#15803d}
.rm-btn-del:hover {background:#fee2e2;border-color:#fca5a5;color:#dc2626}

/* ── FOOTER ── */
.rm-footer{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-top:1px solid #f1f5f9;flex-wrap:wrap;gap:8px}
.rm-info{font-size:.75rem;color:#94a3b8}
.rm-pagination .pagination{margin:0;gap:3px;display:flex;flex-wrap:wrap}
.rm-pagination .page-item .page-link{width:30px;height:30px;padding:0;display:flex;align-items:center;justify-content:center;border-radius:7px !important;border:1px solid #e2e8f0;font-size:.78rem;color:#64748b;background:#fff;transition:all .12s;text-decoration:none}
.rm-pagination .page-item.active .page-link{background:#1e293b;border-color:#1e293b;color:#fff}
.rm-pagination .page-item .page-link:hover{background:#f8fafc;border-color:#94a3b8;color:#1e293b}
.rm-pagination .page-item.disabled .page-link{opacity:.4;cursor:not-allowed}

/* ── RESPONSIVE ── */
@media(max-width:767px){
    .rm-stats{grid-template-columns:1fr}
    .rm-topbar,.rm-card-head{flex-direction:column;align-items:flex-start}
    .rm-search-box input{width:120px}
    .rm-footer{flex-direction:column;align-items:center}
}
</style>
@endpush

@push('js')
<script>
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#roleSearch').on('keyup', function () {
        var val = $(this).val().toLowerCase();
        $('#roleTable tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
        });
    });
});
</script>
@endpush