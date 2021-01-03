@component('mail::message')
# <span class="width100 darkBlue">{{__('Proposal')}} - #{{@$proposal->id}} <span class="floatRight">{{@$proposal->proposal_date}}</span></span>

<strong>
{{-- Address Table starts --}}
<table width="100%">
  <tr><td class="textRight">{{@$company_details[0]['field_value']}}</td></tr>
  <tr><td class="textRight">{{@$company_details[1]['field_value']}}</td></tr>
  <tr><td class="textRight">{{@$company_details[2]['field_value']}}, [{{@$company_details[5]['field_value']}}]</td></tr>
  <tr><td class="textRight">{{@$company_details[3]['field_value']}}</td></tr>
  <tr><td class="textRight">{{@$company_details[4]['field_value']}}</td></tr>
</table>
{{-- Address Table ends --}}
<hr>
<span class="darkBlue">{{__('Subject')}}: {{@$proposal->subject}}</span> 
<br/>
<br/>
{{-- Prepared for table starts --}}
<table width="100%">
  <tr>
    <td class="width30">{{__('Prepared For')}}:</td>
    <td class="width70 textLeft">@if (@$proposal->relation == 'Customer')
      {{@$proposal->customer->first_contact->first_name}} {{@$proposal->customer->first_contact->last_name}} 
      <br>
      {{@$estimate->customer->first_contact->title->name}} 
  @else
      {{@$proposal->lead->first_name}} {{@$proposal->lead->last_name}} 
  @endif</td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$proposal->lead->contactTitle->name}}</td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$proposal->lead->company_name}}</td>
  </tr>
</table>
{{-- Prepared for table ends --}}
<br>
{{-- Prepared for table starts --}}
<table width="100%">
  <tr>
    <td class="width30">{{__('Prepared By')}}:</td>
    <td class="width70 textLeft">
      {{@$proposal->user->name}} 
    </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$proposal->user->email}} </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$proposal->user->phone}}</td>
  </tr>
</table>
<hr>
<span class="darkBlue">{{__('Description')}}:</span>  <br/>{{@$proposal->message}}
<br>
<br>
</strong>
{{-- Prepared for table ends --}}

{{-- Proposal Products Table starts --}}

<table class="width100 borderGray fontTable">
  <tr class="tr1">
    <td width="35%" class="borderGray">{{__('Name')}}</td>
    <td width="18%" class="borderGray">{{__('Price')}}</td>
    <td width="10%" class="borderGray">{{__('Qty')}}</td>
    <td width="18%" class="borderGray">{{__('Tax')}}</td>
    <td width="20%" class="borderGray">{{__('Amount')}}</td>
  </tr>
  
@foreach ($proposal->proposalProducts as $product)<tr class="width100">
    <td width="36%" class="borderGray">{{$product['product_name']}}</td>
    <td width="18%" class="borderGray">{{@$proposal->currency->symbol}} {{$product['product_price']}}</td>
    <td width="12%" class="borderGray">{{$product['product_qty']}}</td>
    <td width="18%" class="borderGray">{{$product['product_tax']}} %</td>
    <td width="20%" class="borderGray">{{@$proposal->currency->symbol}} {{$product['product_amount']}}</td>
</tr>
@endforeach
<tr class="tr">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Sub Total')}}</td>
  <td width="20%" class="borderGray">{{@$proposal->currency->symbol}} {{@$proposal->sub_total}}</td>
</tr>
<tr class="width100">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Discount')}}</td>
  <td width="10%" class="borderGray">{{@$proposal->discount_type}}</td>
  <td width="18%" class="borderGray">{{@$proposal->total_discount_percentage}} %</td>
  <td width="20%" class="borderGray">{{@$proposal->currency->symbol}} {{@$proposal->discountTotal}}</td>
</tr>
<tr class="tr">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Adjustments')}}</td>
  <td width="20%" class="borderGray">{{@$proposal->currency->symbol}} {{@$proposal->adjustments}}</td>
</tr>
<tr class="width100">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Total Amount')}}</td>
  <td width="20%" class="borderGray">{{@$proposal->currency->symbol}} {{@$proposal->totalAmount}}</td>
</tr>
</table>
{{-- Proposal Products Table ends --}}

<p><span>{{__('Note')}}:</span>{{__('This proposal will expire on')}} {{@$proposal->open_till_date}}</p>

@php
    $url = config('app.url');
@endphp
@component('mail::button', ['url' => $url.'/'])
{{__('Visit Website')}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent