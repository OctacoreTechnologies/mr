@php
    $heads = [
        'Sr.No',
        'Company Name',
        'Email', 
        'Status',
        'Phone',
        'FollowUp',
        ['label' => 'Actions', 'no-export' => false],
    ];
    $srno = 1;
@endphp

@extends('layouts.app')

@section('title', 'Leads')

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-users"></i>
        Leads
    </h1>
    @can('create lead')
     <a href="{{ route('lead.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus-circle"></i> Create Lead
     </a>
    @endcan
</div>
@stop

@section('content')

<x-alert-components class="mb-3" />

<div class="crm-card">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i> Lead List
        </h3>
    </div>

    <div class="crm-card-body">

        <div class="table-responsive">
            <table id="leadTable" class="table table-sm table-striped">
                <thead>
                    <tr>
                        @foreach ($heads as $head)
                            @if(is_array($head))
                                <th>{{ $head['label'] }}</th>
                            @else
                                <th>{{ $head }}</th>
                            @endif
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach ($leads as $lead)
                        <tr class="{{ $lead->status }}">
                            <td>{{ $srno++ }}</td>

                            <td>{{ $lead->company_name }}</td>

                            <td>{{ $lead->contact_person_1_email }}</td>

                            {{-- Status --}}
                            <td>
                                @php
                                    $statusClass = match($lead->status) {
                                        'new' => 'badge badge-warning',
                                        'contacted' => 'badge badge-info',
                                        'qualified' => 'badge badge-success',
                                        'disqualified' => 'badge badge-danger',
                                        default => 'badge badge-secondary',
                                    };
                                @endphp

                                <span class="{{ $statusClass }}">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </td>

                            {{-- Phone --}}
                            <td class="format-number">
                                {{ $lead->contact_person_1_contact }}
                            </td>

                            {{-- Follow Up --}}
                            <td>
                            @can('edit customer-followup')
                                <a href="{{ route('followup.edit', $lead->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   target="_blank">
                                    <i class="fas fa-phone-alt"></i> Follow Up
                                </a>
                            @endcan
                            </td>

                            {{-- Actions --}}
                            <td>
                                <nobr>

                                   @can('edit lead')
                                     <a href="{{ route('lead.edit', $lead->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                     </a>
                                    @endcan
                                    {{-- Delete --}}

                                    @can('delete lead')
                                      <form action="{{ route('customer.destroy', $lead->id) }}"
                                            method="POST"
                                            class="d-inline-block">
                                          @csrf
                                          @method('DELETE')
                                          <button class="btn btn-sm btn-outline-danger delete-project"
                                                  data-url="{{ route('customer.destroy', $lead->id) }}"
                                                  onclick="return confirm('Are you sure you want to delete this lead?')">
                                              <i class="fas fa-trash-alt"></i>
                                          </button>
                                      </form>
                                    @endcan

                                   @can('show lead')
                                       <a href="{{ route('customer.show', $lead->id) }}"
                                          class="btn btn-sm btn-outline-secondary">
                                           <i class="fas fa-eye"></i>
                                       </a>
                                    @endcan

                                </nobr>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@stop

@push('css')
<link rel="stylesheet" href="{{ asset('style/common.css') }}">
@endpush

@push('js')
<script>
    $(document).ready(function () {

        $('#leadTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10
        });

    });
</script>
@endpush