{{--@component('mail::message')--}}
# Hello {{ $customerName }},

{!! nl2br(e($messageText)) !!}

Thanks,<br>
{{-- {{ config('app.name') }}--}}
{{--@endcomponent--}}
