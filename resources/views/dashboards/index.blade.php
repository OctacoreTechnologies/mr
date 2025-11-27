@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="text-center mb-4">
        <h1 class="font-weight-bold text-dark">📊 Dashboard Overview</h1>
        <p class="text-muted">Financial Year: {{ $financialYear }}</p>
    </div>
@stop

@section('content')
<div class="row">

    @php
        // Static cards
        $cards = [
            [
                'title' => 'Leads',
                'count' => $leads->count(),
                'icon' => 'user-friends',
                'route' => route('lead.index'),
                'color' => '#d39e00',
                'button' => 'Track Leads',
                 'sub' => [
                           ['label' => 'New', 'value' => (clone $leads)->where('status', 'new')->count()],
                           ['label' => 'Contacted', 'value' => (clone $leads)->where('status', 'contacted')->count()],
                           ['label' => 'Qualified', 'value' => (clone $leads)->where('status', 'qualified')->count()],
                           ['label' => 'Delivered', 'value' => (clone $leads)->where('status', 'delivered')->count()],
                           ['label' => 'Disqualified', 'value' => (clone $leads)->where('status', 'disqualifies')->count()],
                    ]
            ],
            [
                'title' => 'Opportunities',
                'count' => $opportunities->count()??'0',
                'icon' => 'fas fa-fw fa-hand-holding-usd',
                'route' => route('opportunity.index'),
                'color' => '#6f42c1',
                'button' => 'Track Opportunities',
                'sub' => [ 
                           ['label' => 'New Buisness', 'value' => (clone $opportunities)->where('type', 'new_business')->count()],
                           ['label' => 'Upsell', 'value' => (clone $opportunities)->where('type', 'upsell')->count()],
                           ['label' => 'Cross Sell', 'value' => (clone $opportunities)->where('type', 'cross_sell')->count()],
                           ['label' => 'Renewal', 'value' => (clone $opportunities)->where('type', 'renewal')->count()],
                    ]

            ],
            [
                'title' => 'Quotations',
                'count' => $quotations->count(),
                'icon' => 'file-alt',
                'route' => route('quotation.index'),
                'color' => '#0056b3',
                'button' => 'View All',
                'sub' => [  
                           ['label' => 'Draft', 'value' => (clone $quotations)->where('status', 'Draft')->count()],
                           ['label' => 'Send', 'value' => (clone $quotations)->where('status', 'Sent')->count()],
                           ['label' => 'Approved', 'value' => (clone $quotations)->where('status', 'Accepted')->count()],
                           ['label' => 'Reject', 'value' => (clone $quotations)->where('status', 'Rejected')->count()],
                    ]

            ],
            [
                'title' => 'Sale Orders',
                'count' => $saleOrders->get()->count(),
                'icon' => 'fas fa-file-signature',
                'route' => route('sale-order.index'),
                'color' => '#0056b3',
                'button' => 'View All',
                'sub' => [
                           ['label' => 'Pending', 'value' => (clone $saleOrders)->where('status', 'pending')->count()],
                           ['label' => 'Processing', 'value' => (clone $saleOrders)->where('status', 'processing')->count()],
                           ['label' => 'Shipped', 'value' => (clone $saleOrders)->where('status', 'shipped')->count()],
                           ['label' => 'Delivered', 'value' => (clone $saleOrders)->where('status', 'delivered')->count()],
                           ['label' => 'Canceled', 'value' => (clone $saleOrders)->where('status', 'canceled')->count()],
                    ]

            ],
            [
                'title' => 'Customers',
                'count' => $customers->count(),
                'icon' => 'users',
                'route' => route('customer.index'),
                'color' => '#218838',
                'button' => 'Explore',
                'sub' => [
                    ['label' => 'Leads', 'value' => $totalCustomerLeads->count() ?? 0],
                    ['label' => 'Quoted', 'value' => $totalCustomerQuoted->count() ?? 0],
                    ['label' => 'Existing', 'value' => $totalCustomerInvoiced->count() ?? 0],
                ]
            ],
            [
                'title' => 'Users',
                'count' => $users,
                'icon' => 'file-alt',
                'route' => route('dashbord.user'),
                'color' => '#0056b4',
                'button' => 'View All',
                'sub' => []
            ],
        ];
    @endphp

    <!-- Loop through static cards -->
    @foreach ($cards as $card)
        <div class="col-xl-4 col-md-6 mb-4 d-flex align-items-stretch">
            <div class="card shadow w-100 d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-uppercase text-muted">{{ $card['title'] }}</h6>
                            <h2 class="text-dark font-weight-bold">{{ $card['count'] }}</h2>
                        </div>
                        <div class="icon-circle" style="background-color: {{ $card['color'] }};">
                            <i class="fas fa-{{ $card['icon'] }} text-white fa-2x"></i>
                        </div>
                    </div>

                    @if (!empty($card['sub']))
                        <div class="row text-center mb-3">
                            @foreach ($card['sub'] as $sub)
                                <div class="col-4">
                                    <h6 class="mb-0 text-dark font-weight-bold">{{ $sub['value'] }}</h6>
                                    <small class="text-muted">{{ $sub['label'] }}</small>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="text-center mt-auto">
                        <a href="{{ $card['route'] }}" class="btn btn-sm text-white px-4 rounded-pill" style="background-color: {{ $card['color'] }};">
                            {{ $card['button'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach 

    <!-- Loop through users and generate dynamic cards -->
 {{--  @foreach ($users as $user)
        <div class="col-xl-4 col-md-6 mb-4 d-flex align-items-stretch">
            <div class="card shadow w-100 d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-uppercase text-muted">{{ $user->name }}</h6>
                            <h2 class="text-dark font-weight-bold">{{ $user->draft_count+$user->sent_count+$user->accepted_count+$user->rejected_count }}</h2>
                        </div>
                        <div class="icon-circle" style="background-color: #007bff;">
                            <i class="fas fa-user-circle text-white fa-2x"></i>
                        </div>
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <h6 class="mb-0 text-dark font-weight-bold">{{ $user->draft_count }}</h6>
                            <small class="text-muted">Draft</small>
                        </div>
                        <div class="col-6">
                            <h6 class="mb-0 text-dark font-weight-bold">{{ $user->sent_count }}</h6>
                            <small class="text-muted">Sent</small>
                        </div>
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <h6 class="mb-0 text-dark font-weight-bold">{{ $user->accepted_count }}</h6>
                            <small class="text-muted">Accepted</small>
                        </div>
                        <div class="col-6">
                            <h6 class="mb-0 text-dark font-weight-bold">{{ $user->rejected_count }}</h6>
                            <small class="text-muted">Rejected</small>
                        </div>
                    </div>

                    <div class="text-center mt-auto">
                        <a href="#" class="btn btn-sm text-white px-4 rounded-pill" style="background-color: #28a745;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach--}}

</div>
@stop

@section('css')
    <style>
        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 12px;
            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .card-body {
            padding: 20px 25px;
        }
    </style>
@stop

@section('js')
    <!-- JS Plugins if needed -->
@stop