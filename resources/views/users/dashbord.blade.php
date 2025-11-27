@extends('layouts.app')

@section('title', 'User Summary')

@section('content_header')
    <div class="text-center mb-4">
        <h1 class="font-weight-bold text-dark">📊 User's Overview</h1>
       
    </div>
@stop

@section('content')
@php
    function statusCounti($collection, $status) {
        return $collection?->where('status', $status)->count() ?? 0;
    }
    function totalCount($collection) {
        return $collection?->count() ?? 0;
    }
@endphp

<style>
    :root{
        --card-bg:#fff; --card-border:#eef0f4;
        --text-1:#0f172a; --text-2:#64748b;
        --ok:#16a34a; --warn:#f59e0b; --bad:#ef4444; --info:#0ea5e9; --muted:#94a3b8;
    }
    .u-wrap{max-width:1200px;margin:0 auto}
    .u-card{background:var(--card-bg);border:1px solid var(--card-border);border-radius:16px;box-shadow:0 8px 20px rgba(2,6,23,.06);overflow:hidden;margin-bottom:16px}
    .u-head{display:flex;align-items:center;gap:14px;padding:14px 18px;cursor:pointer;position:relative;background:#f8fafc}
    .u-avatar{width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#0ea5e9);color:#fff;display:grid;place-items:center;font-weight:700}
    .u-meta{flex:1}
    .u-title{margin:0;font-weight:700;color:var(--text-1)}
    .u-sub{margin:0;color:var(--text-2);font-size:12px}
    .u-toggle{position:absolute;right:14px;top:50%;transform:translateY(-50%);width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff;border:1px solid var(--card-border);transition:transform .25s ease}
    .u-toggle.rotate{transform:translateY(-50%) rotate(180deg)}
    .u-body{padding:14px 18px;border-top:1px solid var(--card-border);background:#fff}

    /* our custom collapse (no Bootstrap needed) */
    .u-collapse{display:none}
    .u-collapse.show{display:block}

    .section{margin-bottom:12px;border:1px solid var(--card-border);border-radius:12px;overflow:hidden}
    .section-h{padding:10px 12px;background:#f1f5f9;font-weight:700;color:var(--text-1)}
    .section-b{padding:10px 12px}
    .badge-row{display:flex;flex-wrap:wrap;gap:8px}
    .badge-pill{padding:6px 10px;border-radius:999px;font-size:12px;font-weight:700;color:#fff}
    /* Lead */
    .b-new{background:var(--info)}
    .b-con{background:var(--warn)}
    .b-qua{background:var(--ok)}
    .b-dis{background:var(--bad)}
    /* Quotation */
    .b-drf{background:var(--muted);color:#111827}
    .b-snt{background:var(--info)}
    .b-acc{background:var(--ok)}
    .b-rej{background:var(--bad)}
    /* Sale Order */
    .b-pnd{background:var(--warn)}
    .b-proc{background:var(--info)}
    .b-shp{background:#3b82f6}
    .b-del{background:var(--ok)}
    .b-can{background:var(--bad)}
</style>

<div class="u-wrap">
    @foreach($users as $user)
        @php
            // Totals
            $qt = totalCount($user->quotationFollows);
            $lt = totalCount($user->leadFollows);
            $st = totalCount($user->saleOrderFollows);

            // Lead statuses
            $l_new = statusCounti($user->leadFollows,'new');
            $l_con = statusCounti($user->leadFollows,'contacted');
            $l_qua = statusCounti($user->leadFollows,'qualified');
            $l_dis = statusCounti($user->leadFollows,'disqualified');

            // Quotation statuses
            $q_drf = statusCounti($user->quotationFollows,'Draft');
            $q_snt = statusCounti($user->quotationFollows,'Sent');
            $q_acc = statusCounti($user->quotationFollows,'Accepted');
            $q_rej = statusCounti($user->quotationFollows,'Rejected');

            // Sale Order statuses
            $s_pnd  = statusCounti($user->saleOrderFollows,'pending');
            $s_proc = statusCounti($user->saleOrderFollows,'processing');
            $s_shp  = statusCounti($user->saleOrderFollows,'shipped');
            $s_del  = statusCounti($user->saleOrderFollows,'delivered');
            $s_can  = statusCounti($user->saleOrderFollows,'canceled');

            $initials = collect(explode(' ', trim($user->name)))->map(fn($p)=>mb_strtoupper(mb_substr($p,0,1)))->take(2)->implode('');
        @endphp

        <div class="u-card">
            <!-- Header (click to toggle) -->
            <div class="u-head" data-target="#userCollapse{{ $user->id }}">
                <div class="u-avatar">{{ $initials }}</div>
                <div class="u-meta">
                    <h5 class="u-title mb-0">{{ $user->name }}</h5>
                    <p class="u-sub mb-0">{{ $lt }} Leads • {{ $qt }} Quotations • {{ $st }} Sale Orders</p>
                </div>
                <div class="u-toggle"><i class="fas fa-chevron-down"></i></div>
            </div>

            <!-- Collapsible Body -->
            <div id="userCollapse{{ $user->id }}" class="u-collapse u-body">
                <!-- Leads -->
                <div class="section">
                    <div class="section-h">Leads</div>
                    <div class="section-b">
                        <div class="badge-row">
                            <span class="badge-pill b-new">New: {{ $l_new }}</span>
                            <span class="badge-pill b-con">Contacted: {{ $l_con }}</span>
                            <span class="badge-pill b-qua">Qualified: {{ $l_qua }}</span>
                            <span class="badge-pill b-dis">Disqualified: {{ $l_dis }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quotations -->
                <div class="section">
                    <div class="section-h">Quotations</div>
                    <div class="section-b">
                        <div class="badge-row">
                            <span class="badge-pill b-drf">Draft: {{ $q_drf }}</span>
                            <span class="badge-pill b-snt">Sent: {{ $q_snt }}</span>
                            <span class="badge-pill b-acc">Accepted: {{ $q_acc }}</span>
                            <span class="badge-pill b-rej">Rejected: {{ $q_rej }}</span>
                        </div>
                    </div>
                </div>

                <!-- Sale Orders -->
                <div class="section" style="margin-bottom:0">
                    <div class="section-h">Sale Orders</div>
                    <div class="section-b">
                        <div class="badge-row">
                            <span class="badge-pill b-pnd">Pending: {{ $s_pnd }}</span>
                            <span class="badge-pill b-proc">Processing: {{ $s_proc }}</span>
                            <span class="badge-pill b-shp">Shipped: {{ $s_shp }}</span>
                            <span class="badge-pill b-del">Delivered: {{ $s_del }}</span>
                            <span class="badge-pill b-can">Canceled: {{ $s_can }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('js')
<script>
/* PURE JS COLLAPSE (works without Bootstrap) */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.u-head[data-target]').forEach(function(head){
        const sel = head.getAttribute('data-target');
        const target = document.querySelector(sel);
        const toggle = head.querySelector('.u-toggle');

        head.addEventListener('click', function(){
            if(!target) return;
            target.classList.toggle('show');       // toggle visibility
            if(toggle) toggle.classList.toggle('rotate');
        });
    });
});
</script>
@endsection
