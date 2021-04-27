@component('mail::message')
# <span class="darkBlue width100">{{__('Customer')}} - #{{@$customer->id}} <span class="floatRight">{{@$customer->estimate_date}}</span></span>
<strong>
{{-- Address Table starts --}}
<table width="100%">
  <tr><td class="textRight">{{@$company_details[0]['field_value']}}</td></tr>
  <tr><td class="textRight">{{@$company_details[1]['field_value']}}</td></tr>
  <tr><td class="textRight">{{@$company_details[2]['field_value']}}, {{@$company_details[3]['field_value']}}, {{@$company_details[4]['field_value']}} [{{@$company_details[5]['field_value']}}]</td></tr>
 
  <tr><td class="textRight">{{@$company_details[6]['field_value']}}</td></tr>
  <tr><td class="textRight">{{@$company_details[7]['field_value']}}</td></tr>
</table>
{{-- Address Table ends --}}
<hr>
<span class="darkBlue">Welcome {{@$customer->username}}</span> 
<br/>
<br/>{{__('Your account has been created succesfully on')}} {{config('app.name')}}. {{__('You can login using given credentials below.')}}<br/> 
<br/>{{__('Username')}}: {{@$customer->username}}  
<br/>{{__('Password')}}: {{@$password}}
<hr>
</strong>
<br/>
<p><span>{{__('Note')}}:</span> {{__('You can reset your password in the profile section!')}}</p>

@php
    $url = config('app.url');
@endphp
@component('mail::button', ['url' => $url.'/customer/login'])
{{__('Login')}}
@endcomponent

{{__('Thanks')}},<br>
{{ config('app.name') }}
@endcomponent