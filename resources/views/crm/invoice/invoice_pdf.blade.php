
<body style="background-color: #e6e6e6!important; padding: 10px;">
<span style="float: left; width: 100%;">{{__('Invoice')}} - #{{@$invoice->id}} 
  <span style="float: right; ">{{@$invoice->invoice_date}}</span>
</span>
<br/>
<br/>
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
<span class="darkBlue">{{__('Subject')}}: {{@$invoice->invoice_title}}</span> 
<br/>
<br/>
{{-- Prepared for table starts --}}
<table width="100%">
  <tr>
    <td class="width30">{{__('Prepared For')}}:</td>
    <td class="width70">{{@$invoice->customer->first_contact->first_name}}{{@$invoice->customer->first_contact->last_name}}
    </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$invoice->customer->first_contact->title->name}} </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$invoice->customer->company_name}} </td>
  </tr>
</table>
{{-- Prepared for table ends --}}
<br>
{{-- Prepared for table starts --}}
<table width="100%">
  <tr>
    <td class="width30">{{__('Prepared By')}}:</td>
    <td class="width70 textLeft">
      {{@$invoice->user->name}} 
    </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$invoice->user->email}} </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$invoice->user->phone}}</td>
  </tr>
</table>
<hr>
<span class="darkBlue">{{__('Description')}}:</span>  <br/>{{@$invoice->customer_notes}}
<br>
<br>
</strong>
{{-- Prepared for table ends --}}

{{-- invoice Products Table starts --}}

<table width='100%' class="borderGray fontTable">
  <tr class="width100 fontBold">
    <td width="35%" class="borderGray">{{__('Name')}}</td>
    <td width="18%" class="borderGray">{{__('Price')}}</td>
    <td width="10%" class="borderGray">{{__('Qty')}}</td>
    <td width="18%" class="borderGray">{{__('Tax')}}</td>
    <td width="20%" class="borderGray">{{__('Amount')}}</td>
  </tr>
  
@foreach ($invoice->invoiceProducts as $product)<tr class="width100">
    <td width="36%" class="borderGray">{{$product['product_name']}}</td>
    <td width="18%" class="borderGray">{{@$invoice->currency->symbol}} {{$product['product_price']}}</td>
    <td width="12%" class="borderGray">{{$product['product_qty']}}</td>
    <td width="18%" class="borderGray">{{$product['product_tax']}} %</td>
    <td width="20%" class="borderGray">{{@$invoice->currency->symbol}} {{$product['product_amount']}}</td>
</tr>
@endforeach
<tr class="width100">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Sub Total')}}</td>
  <td width="20%" class="borderGray">{{@$invoice->currency->symbol}} {{@$invoice->sub_total}}</td>
</tr>
<tr class="width100">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Discount')}}</td>
  <td width="10%" class="borderGray">{{@$invoice->discount_type}}</td>
  <td width="18%" class="borderGray">{{@$invoice->discount_percentage}} %</td>
  <td width="20%" class="borderGray">{{@$invoice->currency->symbol}} {{@$invoice->discount_total}}</td>
</tr>
<tr class="width100">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Adjustments')}}</td>
  <td width="20%" class="borderGray">{{@$invoice->currency->symbol}} {{@$invoice->adjustments}}</td>
</tr>
<tr class="width100">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Total Amount')}}</td>
  <td width="20%" class="borderGray font15">{{@$invoice->currency->symbol}} {{@$invoice->total_amount}}</td>
</tr>
</table>
{{-- invoice Products Table ends --}}

<p><span>{{__('Note')}}:</span>{{__('Invoice Due Date')}}: {{@$invoice->due_date}}</p>

@php
    $url = config('app.url');
@endphp


{{__('Thanks')}},<br>
{{ config('app.name') }}

</body>