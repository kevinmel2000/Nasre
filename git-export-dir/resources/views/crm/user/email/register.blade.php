@component('mail::message')
# <span class="darkBlue width100">{{__('New staff account has been registered successfully.')}}</span>
<strong>

<hr>
<span class="darkBlue">{{__('Welcome')}} @if (@$user->name != null)
    {{@$user->name}}
@else
  {{@$user->email}}
@endif  
</span> 
<br/>
<br/>{{__('Your account has been created succesfully on')}} {{config('app.name')}}. {{__('You can login using given credentials below.')}}<br/> 
<br/>{{__('Email')}}: {{@$user->email}}  
<br/>{{__('Password')}}: {{@$password}}
<hr>
</strong>
<br/>
<p><span>{{__('Note')}}:</span> {{__('You can reset your password in the profile section!')}}</p>

@php
    $url = config('app.url');
@endphp
@component('mail::button', ['url' => $url.'/login'])
{{__('Login')}}
@endcomponent

{{__('Thanks')}},<br>
{{ config('app.name') }}
@endcomponent