@component('mail::message')
# {{__('Hello!')}}
{{__('You are receiving this email because we received a password reset request for your account.')}}

@component('mail::button', ['url' => url('client/password/reset/'.$token)])
{{__('Reset Password')}}
@endcomponent

{{__('If you did not request a password reset, no further action is required.')}}

{{__('Thanks,')}}<br>
{{ config('app.name') }}
@endcomponent
