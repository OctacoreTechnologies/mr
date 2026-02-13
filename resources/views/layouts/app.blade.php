@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle')
        | @yield('subtitle')
    @endif
@stop

{{-- Apply Custom CSS in Side BAR --}}
@push('css')
    <link rel="stylesheet" href="{{ asset('style/customer.css') }}">
    <style>
        .sidebar-dark-primary {
            /* background: linear-gradient(180deg, #B71C1C 0%, #8B1010 100%) !important; */
            background: linear-gradient(to bottom, #4169E1, #007FFF) !important;
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
            border-bottom: 1px solid #007FFF !important;
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
            background-color: #007FFF !important;
            border: 1px solid #fff !important;
            color: #fff !important;
        }


        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            /* background-color: #751010; */
            background-color: #007FFF !important;
            border-radius: 4px;
        }

        .sidebar-dark-primary .nav-sidebar .nav-item>.nav-link .right {
            color: #ccc !important;
        }

        .nav-treeview {
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>


    <script src="{{ asset('js/index.js') }}"></script>

    <script>
        $(document).ready(function() {

            //  $('.js-example-basic-single').select2();
            //  $(".selection").children('.select2-selection').addClass('h-100')
            //  $('.select2').addClass('w-100');

            $('.edit').on('click', function(e) {
                if (!confirm('Are you sure you want to edit this?')) {
                    e.preventDefault(); // stop the link from navigating
                }
            });

            // For Delete buttons in forms
            $('.delete').on('click', function(e) {
                if (!confirm('Are you sure you want to delete this?')) {
                    e.preventDefault(); // stop form from submitting
                }
            });

            $('.select2').select2({
                tags: true,
                placeholder: "Select",
                allowClear: true,
                outerHeight: 100
            });
            $('.select2-selection--single').addClass('h-100');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Aaj ki date YYYY-MM-DD format me
            let today = new Date();
            let yyyy = today.getFullYear();
            let mm = String(today.getMonth() + 1).padStart(2, '0');
            let dd = String(today.getDate()).padStart(2, '0');

            let formattedDate = yyyy + '-' + mm + '-' + dd;

            // Sare date inputs select karo
            document.querySelectorAll('input[type="date"]').forEach(function(input) {

                // Agar already value nahi hai tabhi set karo
                if (!input.value) {
                    input.value = formattedDate;
                }

            });


            function formatIndianNumber(value) {
                if (!value) return '';

                value = value.toString().replace(/,/g, '');

                // Decimal handling
                let parts = value.split('.');
                let integerPart = parts[0];
                let decimalPart = parts[1] ? parts[1].substring(0, 2) : '';

                let lastThree = integerPart.slice(-3);
                let otherNumbers = integerPart.slice(0, -3);

                if (otherNumbers !== '') {
                    lastThree = ',' + lastThree;
                }

                let formatted = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
                return decimalPart ? formatted + '.' + decimalPart : formatted;
            }


            function formatContactNumber(value) {
                if (!value) return '';

                // Remove all spaces & non digits
                value = value.replace(/\D/g, '');

                // Indian mobile (10 digit) format: 5-5
                if (value.length <= 5) {
                    return value;
                } else if (value.length <= 10) {
                    return value.slice(0, 5) + ' ' + value.slice(5);
                }
                // If country code included (like 91XXXXXXXXXX)
                else if (value.length > 10) {
                    return value.slice(0, value.length - 10) + ' ' +
                        value.slice(-10, -5) + ' ' +
                        value.slice(-5);
                }

                return value;
            }

            // Apply to contact-number class
            document.querySelectorAll('.contact-number').forEach(function(input) {

                input.addEventListener('input', function() {
                    let cursorPosition = input.selectionStart;
                    let originalLength = input.value.length;

                    input.value = formatContactNumber(input.value);

                    let newLength = input.value.length;
                    input.selectionEnd = cursorPosition + (newLength - originalLength);
                });

            });

            // Format all fields with format-number class on page load
            document.querySelectorAll('.format-number').forEach(function(input) {
                if (input.value) {
                    input.value = formatIndianNumber(input.value);
                }

                // Only attach input event if not readonly
                if (!input.hasAttribute('readonly')) {
                    input.addEventListener('input', function() {
                        let cursorPosition = input.selectionStart;
                        let originalLength = input.value.length;
                        input.value = formatIndianNumber(input.value);
                        let newLength = input.value.length;
                        input.selectionEnd = cursorPosition + (newLength - originalLength);
                    });
                }


            });

            document.addEventListener('input', function(e) {

                if (e.target.classList.contains('contact-number')) {

                    let input = e.target;

                    let cursorPosition = input.selectionStart;
                    let originalLength = input.value.length;

                    input.value = formatContactNumber(input.value);

                    let newLength = input.value.length;
                    input.selectionEnd = cursorPosition + (newLength - originalLength);
                }

            });


            document.addEventListener('submit', function(e) {

                const form = e.target;

                if (form.tagName === 'FORM') {

                    // Remove spaces from contact numbers
                    form.querySelectorAll('.contact-number').forEach(function(input) {
                        input.value = input.value.replace(/\s/g, '');
                    });

                    // Remove commas from formatted numbers
                    form.querySelectorAll('.format-number').forEach(function(input) {
                        input.value = input.value.replace(/,/g, '');
                    });

                }

            });




        });
    </script>
@endpush

{{-- Add common CSS customizations --}}
