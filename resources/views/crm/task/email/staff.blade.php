@component('mail::message')
# {{__('Task')}} - {{@$task->id}}
<hr>
<strong>
<table width='100%';>
  <tr class="width100">
    <td width="50%">{{@$task->relation}}</td>
    <td width="50%">@if (@$task->relation == 'Customer')
      {{@$task->customer->first_name}} {{@$task->customer->last_name}} 
  @else
      {{@$task->lead->first_name}} {{@$task->lead->last_name}}   
  @endif</td>
  </tr>

  <tr class="width100">
    <td width="50%" >{{__('Priority')}}</td>
    <td width="50%">{{@$task->priority}}</td>
  </tr>

  <tr class="width100">
    <td width="50%">{{__('Type')}}</td>
    <td width="50%">{{@$task->type}}</td>
  </tr>

  <tr class="width100">
    <td width="50%">{{__('Status')}}</td>
    <td width="50%">{{@$task->status}}</td>
  </tr>

  <tr class="width100">
    <td width="50%">{{__('Billable Task')}}</td>
    <td width="50%">{{ucfirst(@$task->billable)}}</td>
  </tr>
  @if (@$task->billable == 'yes')
    <tr class="width100">
      <td width="50%">{{__('Bill Amount')}}</td>
      <td width="50%">{{@$currency->name}} {{ucfirst(@$task->bill_amount)}}</td>
    </tr>
  @endif
  <tr class="width100">
    <td width="50%">{{__('Task Starts on')}}</td>
    <td width="50%">{{@$task->start_date}} @if (@$task->is_all_day == 'yes')
      ({{__('Full Day Task')}})
    @endif</td>
  </tr>

  @if (@$task->is_all_day == 'no')<tr class="width100">
    <td width="50%">{{__('Time')}}</td>
    <td width="50%">{{@$task->start_time}} {{__('To')}} {{ucfirst(@$task->end_time)}}</td>
  </tr>
  @endif

  @if (@$task->repeat_task=='yes')<tr class="width100">
      <td width="50%">{{__('Repeat Task')}}</td>
      <td width="50%">{{__('Every')}} {{ucfirst(@$task->repeat_every)}} <br/> {{ucfirst(@$task->repeat_day_month)}}</td>
    </tr>
    <tr class="width100">
      <td width="50%">{{__('Task End Date')}}</td>
      <td width="50%">{{ucfirst(@$task->end_date)}}</td>
    </tr>
  @endif

</table>
</strong>
<hr>

## {{__('Description')}}
{{@$task->description}}
@php
    $url = config('app.url');
@endphp
@component('mail::button', ['url' => $url.'/task'])
{{__('View Task')}}
@endcomponent

{{__('Thanks')}},<br>
{{ config('app.name') }}
@endcomponent