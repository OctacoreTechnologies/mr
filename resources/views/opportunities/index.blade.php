@php
    $heads = [
        'Sr.No',
        'Name',
        'Date',
        'Priority',
        'Stage',
        'Type',
        ['label' => 'Actions', 'no-export' => true],
    ];
    $i = 1;
@endphp

@extends('layouts.app')

@section('title', 'Opportunities')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-briefcase"></i>
        Opportunity List
    </h1>
    <a href="{{ route('opportunity.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Create Opportunity
    </a>
</div>
@stop

@section('content')

    <x-alert-components class="my-2" />

    <div class="crm-index-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list-alt"></i> All Opportunities
            </h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <x-adminlte-datatable id="opportunityTable" :heads="$heads" striped hoverable with-buttons>
                    @foreach ($opportunities as $opportunity)
                        <tr>
                            <td class="sr-no">{{ $i++ }}</td>

                            <td>{{ $opportunity->customer->company_name ?? '—' }}</td>

                            <td>{{ $opportunity->created_at ? \Carbon\Carbon::parse($opportunity->created_at)->format('d M Y') : '—' }}</td>

                            <td>
                                @php
                                    $priority = $opportunity->priority ?? null;
                                    $priorityBadge = match($priority) {
                                        'high' => 'crm-badge-high',
                                        'medium' => 'crm-badge-medium',
                                        'low' => 'crm-badge-low',
                                        default => '',
                                    };
                                    $priorityLabel = $priority ? ucfirst($priority) : '—';
                                    echo '<span class="crm-badge ' . $priorityBadge . '">' . $priorityLabel . '</span>';
                                @endphp
                            </td>

                            {{-- Stage badge --}}
                            <td>
                                @php
                                    $stage = $opportunity->stage ?? null;
                                    $stageBadge = match($stage) {
                                        'qualification' => 'crm-badge-qualification',
                                        'proposal'      => 'crm-badge-proposal',
                                        'negotiation'   => 'crm-badge-negotiation',
                                        'closed_won'    => 'crm-badge-closed-won',
                                        'closed_lost'   => 'crm-badge-closed-lost',
                                        default         => '',
                                    };
                                    $stageLabel = $stage ? ucfirst(str_replace('_', ' ', $stage)) : '—';
                                @endphp
                                @if($stage)
                                    <span class="crm-badge {{ $stageBadge }}">{{ $stageLabel }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Type badge --}}
                            <td>
                                @php
                                    $type = $opportunity->type ?? null;
                                    $typeBadge = match($type) {
                                        'new_business' => 'crm-badge-new-business',
                                        'upsell'       => 'crm-badge-upsell',
                                        'cross_sell'   => 'crm-badge-cross-sell',
                                        'renewal'      => 'crm-badge-renewal',
                                        default        => '',
                                    };
                                    $typeLabel = $type ? ucfirst(str_replace('_', ' ', $type)) : '—';
                                @endphp
                                @if($type)
                                    <span class="crm-badge {{ $typeBadge }}">{{ $typeLabel }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    {{-- Edit --}}
                                    <a href="{{ route('opportunity.edit', $opportunity->id) }}"
                                        class="btn btn-default text-primary"
                                        title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('opportunity.destroy', $opportunity->id) }}"
                                        method="POST" class="d-inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this opportunity?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-default text-danger"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    {{-- View --}}
                                    <a href="{{ route('opportunity.show', $opportunity->id) }}"
                                        class="btn btn-default text-teal"
                                        title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>

@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
@endpush