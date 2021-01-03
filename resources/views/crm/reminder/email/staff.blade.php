@component('mail::message')
# {{__('Reminder')}} - {{@$reminder->id}}
<hr>
<strong>
<table width='100%';>
  <tr class="width100">
    <td width="50%">{{@$reminder->relation}}</td>
    <td width="50%">@if (@$reminder->relation == 'Customer')
      {{@$reminder->customer->first_name}} {{@$reminder->customer->last_name}} 
  @else
      {{@$reminder->lead->first_name}} {{@$reminder->lead->last_name}}   
  @endif</td>
  </tr>

  <tr class="width100">
    <td width="50%">{{__('Date')}}</td>
    <td width="50%">{{@$reminder->date}}</td>
  </tr>

  <tr class="width100">
    <td width="50%">{{__('Time')}}</td>
    <td width="50%">{{@$reminder->time}}</td>
  </tr>

</table>
</strong>
<hr>

## {{__('Description')}}
{{@$reminder->description}}
@php
    $url = config('app.url');
@endphp
@component('mail::button', ['url' => $url.'/reminder'])
{{__('View Reminder')}}
@endcomponent

{{__('Thanks')}},<br>
{{ config('app.name') }}
@endcomponent