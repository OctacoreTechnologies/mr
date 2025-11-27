@php
    $heads = [
        'Sr. No',
        'Machine',
        'Application',
        'Subject',
        ['label' => 'Actions', 'no-export' => true, 'width' => 10],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Emails')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0 text-primary font-weight-bold">
            <i class="fas fa-envelope-open-text mr-1"></i> Emails
        </h1>
   <a href="{{ route('mail.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center"
   data-bs-toggle="tooltip" title="Compose a new email">
    <i class="fas fa-plus-circle me-2"></i>
    <span>Add Email</span>
</a>

    </div>
@stop

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0 font-weight-bold">
                <i class="fas fa-paper-plane mr-1"></i> Emails
            </h3>
        </div>

        <div class="card-body bg-light">
            <div class="table-responsive">
                <x-adminlte-datatable 
                    id="table1" 
                    :heads="$heads" 
                    theme="light"
                    striped 
                    hoverable 
                    bordered 
                >
                    @foreach ($mails as $index => $mail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mail->machine->name ?? '-' }}</td>
                            <td>{{ $mail->application->name ?? '-' }}</td>
                            <td>{{ $mail->subject }}</td>
                            <td class="text-center">
                                <nobr>
                                    <a href="{{ route('mail.edit', $mail->id) }}" class="btn btn-sm btn-outline-warning mx-1 shadow" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('mail.destroy', $mail->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this email?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger mx-1 shadow delete-customer" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </nobr>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>
@stop

@push('css')
<link rel="stylesheet"  href="{{asset('style/customer.css')}}">
@endpush