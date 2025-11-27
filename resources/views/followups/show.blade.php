@extends('layouts.app')

@section('title', "Follow Ups for " . $customer->name)

@section('content_header')
    <h1 class="text-center text-dark font-weight-bold">
        <i class="fas fa-user-tie mr-2"></i> Follow Ups for {{ $customer->name }}
    </h1>
@stop

@section('content')

    <x-alert-components class="my-3" />

    <!-- Customer Details (Optional) -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h4 class="card-title mb-0">
                <i class="fas fa-info-circle mr-2"></i> Customer Details
            </h4>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $customer->company_name }}</p>
            <p><strong>Email:</strong> {{ $customer->contact_person_1_email??'N.A' }}</p>
            <p><strong>Phone:</strong> {{ $customer->contact_no }}</p>
        </div>
    </div>

    <!-- Follow-Up List (Simple Grid Layout) -->
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-gradient-primary text-white rounded-top">
            <h3 class="card-title mb-0">
                <i class="fas fa-comments mr-2"></i> Follow-Up Communication
            </h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <i class="fas fa-calendar-day mr-2 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($followup->follow_up_date)->format('d M Y h:i A') }}
                                </td>
                                <td>{{ Str::limit($followup->notes, 60, '...') }}</td>
                                <td>
                                    <i class="fas fa-calendar-alt mr-2 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($followup->next_follow_up_date)->format('d M Y h:i A') }}
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
    <style>
        .card-title {
            font-size: 1.3rem;
            font-weight: bold;
        }
        .table th, .table td {
            vertical-align: middle !important;
            text-align: left;
        }
        .table td {
            font-size: 0.9rem;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .table td i {
            font-size: 1rem;
        }
    </style>
@endpush

@push('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
