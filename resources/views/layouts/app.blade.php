@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
{{ config('adminlte.title') }}
@hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Apply Custom CSS in Side BAR --}}
@push('css')
<link rel="stylesheet" href="{{ asset('style/customer.css') }}">
<style>

.sidebar-dark-primary {
    /* background: linear-gradient(180deg, #B71C1C 0%, #8B1010 100%) !important; */
    background:linear-gradient(to bottom, #4169E1, #007FFF)!important;
    color: #FFFFFF !important;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.15);
}


.sidebar-dark-primary .brand-link {
    background-color: transparent !important;
    color: #FFF !important;
    font-weight: 600;
    font-size: 20px;
    letter-spacing: 0.5px;
    /* border-bottom: 1px solid rgba(255, 255, 255, 0.1); */
    border-bottom: 1px solid  #007FFF !important;
    text-align: center;
    padding: 1rem;
}


.sidebar-dark-primary .nav-sidebar .nav-link {
    
    /* color: #F5F5F5 !important; */
    color: #ffffff !important;
    font-size: 15px;
    font-weight: 500;
    padding: 10px 18px;
    transition: all 0.3s ease-in-out;
    border-left: 3px solid transparent;
}


.sidebar-dark-primary .nav-sidebar .nav-link:hover {
    /* background-color: #6A0C0C !important; */
    background-color: #007FFF !important;
    color: #FFFFFF !important;
    border-left: 3px solid #FFFFFF;
}

.sidebar-dark-primary .nav-sidebar .nav-link.active {
    /* background-color: #570909 !important; */
    background-color: #007FFF !important;
    /* color: #FFFFFF !important; */
    color: #ffffff !important;
    font-weight: 550;
    border-left: 3px solid #FFF;
}


.sidebar-dark-primary .nav-icon {
    color: #ffffffd9 !important;
    margin-right: 8px;
    font-size: 16px;
    opacity: 0.85;
}

.sidebar-dark-primary .form-control-sidebar {
    /* background-color: #911010 !important; */
    background-color: #007FFF !important;
    border: 1px solid #fff !important;
    color: #fff !important;
    padding: 6px 12px;
}

.sidebar-dark-primary .btn-sidebar {
    /* background-color: #6A0C0C !important; */
    background-color:  #007FFF !important;
    border: 1px solid #fff !important;
    color: #fff !important;
}


.sidebar::-webkit-scrollbar {
    width: 6px;
}
.sidebar::-webkit-scrollbar-thumb {
    /* background-color: #751010; */
    background-color:  #007FFF!important;
    border-radius: 4px;
}

.sidebar-dark-primary .nav-sidebar .nav-item > .nav-link .right {
    color: #ccc !important;
}
.nav-treeview{
    position: relative;
    left: 12px;
}
</style>

@endpush

{{-- Extend and customize the page content header --}}

@section('content_header')
@hasSection('content_header_title')
    <h1 class="text-muted">
        @yield('content_header_title')

        @hasSection('content_header_subtitle')
            <small class="text-dark">
                <i class="fas fa-xs fa-angle-right text-muted"></i>
                @yield('content_header_subtitle')
            </small>
        @endif
    </h1>
@endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
@yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')

<div class="w-100 text-right">
    Developed by
    <a href="{{ config('app.company_url', '#') }}" class="w-100 text-right">OctaCore Technologies</a>.
</div>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
  
<script src="{{ asset('js/index.js') }}"></script>

    <script>

        $(document).ready(function () {

            //  $('.js-example-basic-single').select2();
            //  $(".selection").children('.select2-selection').addClass('h-100')
            //  $('.select2').addClass('w-100');
                 
            $('.edit').on('click', function (e) {
                if (!confirm('Are you sure you want to edit this?')) {
                    e.preventDefault(); // stop the link from navigating
                }
            });

            // For Delete buttons in forms
            $('.delete').on('click', function (e) {
                if (!confirm('Are you sure you want to delete this?')) {
                    e.preventDefault(); // stop form from submitting
                }
            });

           $('.select2').select2({
               tags: true,
               placeholder: "Select",
               allowClear: true,
               outerHeight:100
           });
           $('.select2-selection--single').addClass('h-100');
        });

    </script>
@endpush

{{-- Add common CSS customizations --}}

