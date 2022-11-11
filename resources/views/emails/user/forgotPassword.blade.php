@component('mail::message')

    Your forgot password code: {{$code}}

    Thanks,
    Team {{ config('app.name') }}
@endcomponent
