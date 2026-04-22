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
        return $collection?->where('stage', $status)->count() ?? 0;
    }
    function totalCount($collection) {
        return $collection?->count() ?? 0;
    }

    function quotationCounti($collection,$status){
            return $collection?->where('status', $status)->count() ?? 0;
    }

    function leadCounti($collection,$status){
            return $collection?->where('status', $status)->count() ?? 0;
    }

    function saleOrderPaymentStatus($collection, $status){
        return $collection?->where('payment_status',$status)->count() ?? 0;
    }
@endphp

<style>
    :root{
        --card-bg:#fff; --card-border:#eef0f4;
        --text-1:#0f172a; --text-2:#64748b;
        --ok:#16a34a; --warn:#f59e0b; --bad:#ef4444;
        --info:#0ea5e9; --muted:#94a3b8;
        --purple:#7c3aed; --teal:#0d9488; --orange:#ea580c;
    }
    .u-wrap{max-width:1200px;margin:0 auto}
    .u-card{
        background:var(--card-bg);border:1px solid var(--card-border);
        border-radius:16px;box-shadow:0 8px 20px rgba(2,6,23,.06);
        overflow:hidden;margin-bottom:16px;
    }
    .u-head{
        display:flex;align-items:center;gap:14px;padding:14px 18px;
        cursor:pointer;position:relative;background:#f8fafc;
    }
    .u-avatar{
        width:44px;height:44px;border-radius:10px;
        background:linear-gradient(135deg,#4f46e5,#0ea5e9);
        color:#fff;display:grid;place-items:center;
        font-weight:700;font-size:15px;flex-shrink:0;
    }
    .u-meta{flex:1;min-width:0}
    .u-title{margin:0;font-weight:700;color:var(--text-1);font-size:15px}
    .u-sub{margin:0;color:var(--text-2);font-size:12px;margin-top:3px}
    .u-toggle{
        flex-shrink:0;width:28px;height:28px;border-radius:8px;
        display:grid;place-items:center;background:#fff;
        border:1px solid var(--card-border);
        transition:transform .25s ease;
    }
    .u-toggle.rotate{transform:rotate(180deg)}
    .u-body{padding:14px 18px;border-top:1px solid var(--card-border);background:#fff}
    .u-collapse{display:none}
    .u-collapse.show{display:block}

    .section-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:12px;
    }
    @media(max-width:640px){
        .section-grid{grid-template-columns:1fr}
    }
    .section{border:1px solid var(--card-border);border-radius:12px;overflow:hidden}
    .section-h{
        padding:9px 12px;background:#f1f5f9;
        font-weight:700;color:var(--text-1);font-size:13px;
        display:flex;align-items:center;gap:6px;
        border-bottom:1px solid var(--card-border);
    }
    .section-b{padding:10px 12px}
    .stat-row{
        display:flex;justify-content:space-between;align-items:center;
        padding:5px 0;border-bottom:1px solid #f1f5f9;font-size:13px;
    }
    .stat-row:last-child{border-bottom:none;padding-bottom:0}
    .stat-label{color:var(--text-2);display:flex;align-items:center;gap:6px}
    .stat-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
    .stat-val{
        font-weight:700;color:var(--text-1);
        background:#f1f5f9;padding:2px 8px;
        border-radius:999px;font-size:12px;
        min-width:28px;text-align:center;
    }
    .stat-total{
        margin-top:8px;padding-top:8px;
        border-top:2px solid var(--card-border);
        display:flex;justify-content:space-between;
        align-items:center;font-size:13px;font-weight:700;color:var(--text-1);
    }
    .stat-total-val{
        background:var(--text-1);color:#fff;
        padding:2px 10px;border-radius:999px;font-size:12px;
    }
    /* dots */
    .dot-new{background:var(--info)}
    .dot-contacted{background:var(--warn)}
    .dot-qualified{background:var(--ok)}
    .dot-disqualified{background:var(--bad)}
    .dot-draft{background:var(--muted)}
    .dot-sent{background:var(--info)}
    .dot-accepted{background:var(--ok)}
    .dot-rejected{background:var(--bad)}
    .dot-pending{background:var(--warn)}
    .dot-processing{background:var(--info)}
    .dot-shipped{background:#3b82f6}
    .dot-delivered{background:var(--ok)}
    .dot-canceled{background:var(--bad)}
    .dot-proposal{background:var(--purple)}
    .dot-quoted{background:var(--orange)}
    .dot-won{background:var(--ok)}
    .dot-customer{background:var(--teal)}
</style>

<div class="u-wrap">
    @foreach($users as $user)
        @php
            // ── followed_by = user_id ──

            // Leads (customers table, source = lead)
            $lt     = totalCount($user->leadFollows);
            $l_new  = leadCounti($user->leadFollows, 'new');
            $l_con  = leadCounti($user->leadFollows, 'contacted');
            $l_qua  = leadCounti($user->leadFollows, 'qualified');
            $l_dis  = leadCounti($user->leadFollows, 'disqualified');

            // Customers (customers table, source = customer)
            $ct     = totalCount($user->customerFollows);

            // Opportunities
            $ot     = totalCount($user->opportunityFollows);
            $o_pro  = statusCounti($user->opportunityFollows, 'proposal');
            $o_quo  = statusCounti($user->opportunityFollows, 'quoted');
            $o_won  = statusCounti($user->opportunityFollows, 'won');

            // Quotations
            $qt     = totalCount($user->quotationFollows);
            $q_drf  = quotationCounti($user->quotationFollows, 'Draft');
            $q_snt  = quotationCounti($user->quotationFollows, 'Sent');
            $q_acc  = quotationCounti($user->quotationFollows, 'Approved');
            $q_rej  = quotationCounti($user->quotationFollows, 'Rejected');

            // Sale Orders
            $st     = totalCount($user->saleOrderFollows);
            $s_pnd  = saleOrderPaymentStatus($user->saleOrderFollows, 'pending');
            $s_recieved = saleOrderPaymentStatus($user->saleOrderFollows, 'received');
            $s_can  = saleOrderPaymentStatus($user->saleOrderFollows, 'cancelled');

            $initials = collect(explode(' ', trim($user->name)))
                ->map(fn($p) => mb_strtoupper(mb_substr($p,0,1)))
                ->take(2)->implode('');
        @endphp

        <div class="u-card">
            <div class="u-head" data-target="#uC{{ $user->id }}">
                <div class="u-avatar">{{ $initials }}</div>
                <div class="u-meta">
                    <h5 class="u-title">{{ $user->name }}</h5>
                    <p class="u-sub">
                        {{ $lt }} Leads &bull;
                        {{ $ct }} Customers &bull;
                        {{ $ot }} Opportunities &bull;
                        {{ $qt }} Quotations &bull;
                        {{ $st }} Sale Orders
                    </p>
                </div>
                <div class="u-toggle"><i class="fas fa-chevron-down"></i></div>
            </div>

            <div id="uC{{ $user->id }}" class="u-collapse u-body">
                <div class="section-grid">

                    {{-- Leads --}}
                    <div class="section">
                        <div class="section-h">🎯 Leads</div>
                        <div class="section-b">
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-new"></span>New</span>
                                <span class="stat-val">{{ $l_new }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-contacted"></span>Contacted</span>
                                <span class="stat-val">{{ $l_con }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-qualified"></span>Qualified</span>
                                <span class="stat-val">{{ $l_qua }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-disqualified"></span>Disqualified</span>
                                <span class="stat-val">{{ $l_dis }}</span>
                            </div>
                            <div class="stat-total">
                                <span>Total</span>
                                <span class="stat-total-val">{{ $lt }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Customers --}}
                    <div class="section">
                        <div class="section-h">👥 Customers</div>
                        <div class="section-b">
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-customer"></span>Direct Clients</span>
                                <span class="stat-val">{{ $ct }}</span>
                            </div>
                            <div class="stat-total">
                                <span>Total</span>
                                <span class="stat-total-val">{{ $ct }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Opportunities --}}
                    <div class="section">
                        <div class="section-h">💡 Opportunities</div>
                        <div class="section-b">
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-proposal"></span>Proposal</span>
                                <span class="stat-val">{{ $o_pro }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-quoted"></span>Quoted</span>
                                <span class="stat-val">{{ $o_quo }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-won"></span>Won</span>
                                <span class="stat-val">{{ $o_won }}</span>
                            </div>
                            <div class="stat-total">
                                <span>Total</span>
                                <span class="stat-total-val">{{ $ot }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Quotations --}}
                    <div class="section">
                        <div class="section-h">📄 Quotations</div>
                        <div class="section-b">
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-draft"></span>Draft</span>
                                <span class="stat-val">{{ $q_drf }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-sent"></span>Sent</span>
                                <span class="stat-val">{{ $q_snt }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-accepted"></span>Accepted</span>
                                <span class="stat-val">{{ $q_acc }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label"><span class="stat-dot dot-rejected"></span>Rejected</span>
                                <span class="stat-val">{{ $q_rej }}</span>
                            </div>
                            <div class="stat-total">
                                <span>Total</span>
                                <span class="stat-total-val">{{ $qt }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Sale Orders --}}
                    <div class="section" style="grid-column:1/-1">
                        <div class="section-h">🛒 Sale Orders</div>
                        <div class="section-b">
                            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:6px">
                                <div class="stat-row">
                                    <span class="stat-label"><span class="stat-dot dot-pending"></span>Pending</span>
                                    <span class="stat-val">{{ $s_pnd }}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label"><span class="stat-dot dot-shipped"></span>Recieved</span>
                                    <span class="stat-val">{{ $s_recieved }}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label"><span class="stat-dot dot-canceled"></span>Canceled</span>
                                    <span class="stat-val">{{ $s_can }}</span>
                                </div>
                            </div>
                            <div class="stat-total">
                                <span>Total</span>
                                <span class="stat-total-val">{{ $st }}</span>
                            </div>
                        </div>
                    </div>

                </div>{{-- /section-grid --}}
            </div>{{-- /u-collapse --}}
        </div>{{-- /u-card --}}
    @endforeach
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.u-head[data-target]').forEach(function(head) {
        const target = document.querySelector(head.getAttribute('data-target'));
        const toggle = head.querySelector('.u-toggle');
        head.addEventListener('click', function() {
            if (!target) return;
            target.classList.toggle('show');
            if (toggle) toggle.classList.toggle('rotate');
        });
    });
});
</script>
@endsection