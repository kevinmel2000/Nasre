
<body style="background-color: #e6e6e6!important; padding: 10px;">
<span style="float: left; width: 100%;">{{__('Estimate')}} - #{{@$estimate->estimate_number}} 
  <span style="float: right; ">{{@$estimate->estimate_date}}</span>
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
<span class="darkBlue">{{__('Subject')}}: {{@$estimate->estimate_title}}</span> 
<br/>
<br/>
{{-- Prepared for table starts --}}
<table width="100%">
  <tr>
    <td class="width30">{{__('Prepared For')}}:</td>
    <td class="width70">{{@$estimate->customer->first_contact->first_name}}{{@$estimate->customer->first_contact->last_name}}
    </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$estimate->customer->first_contact->title->name}} </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$estimate->customer->company_name}} </td>
  </tr>
</table>
{{-- Prepared for table ends --}}
<br>
{{-- Prepared for table starts --}}
<table width="100%">
  <tr>
    <td class="width30">{{__('Prepared By')}}:</td>
    <td class="width70 textLeft">
      {{@$estimate->user->name}} 
    </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$estimate->user->email}} </td>
  </tr>
  <tr>
    <td class="width30"></td>
    <td class="width70">{{@$estimate->user->phone}}</td>
  </tr>
</table>
<hr>
<span class="darkBlue">{{__('Description')}}:</span>  <br/>{{@$estimate->customer_notes}}
<br>
<br>
</strong>
{{-- Prepared for table ends --}}

{{-- estimate Products Table starts --}}
{{-- @php
    print_r($products);
@endphp --}}
<table width='100%' class=" borderGray fontTable">
  <tr class="tr1" >
    <td width="35%" class="borderGray">{{__('Name')}}</td>
    <td width="18%" class="borderGray">{{__('Price')}}</td>
    <td width="10%" class="borderGray">{{__('Qty')}}</td>
    <td width="18%" class="borderGray">{{__('Tax')}}</td>
    <td width="20%" class="borderGray">{{__('Amount')}}</td>
  </tr>
  
@foreach ($estimate->estimateProducts as $product)<tr class="width100">
    <td width="36%" class="borderGray">{{$product['product_name']}}</td>
    <td width="18%" class="borderGray">{{@$estimate->currency->symbol}} {{$product['product_price']}}</td>
    <td width="12%" class="borderGray">{{$product['product_qty']}}</td>
    <td width="18%" class="borderGray">{{$product['product_tax']}} %</td>
    <td width="20%" class="borderGray">{{@$estimate->currency->symbol}} {{$product['product_amount']}}</td>
</tr>
@endforeach
<tr class="tr">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Sub Total')}}</td>
  <td width="20%" class="borderGray">{{@$estimate->currency->symbol}} {{@$estimate->sub_total}}</td>
</tr>
<tr class="width100">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Discount')}}</td>
  <td width="10%" class="borderGray">{{@$estimate->discount_type}}</td>
  <td width="18%" class="borderGray">{{@$estimate->discount_percentage}} %</td>
  <td width="20%" class="borderGray">{{@$estimate->currency->symbol}} {{@$estimate->discount_total}}</td>
</tr>
<tr class="tr">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Adjustments')}}</td>
  <td width="20%" class="borderGray">{{@$estimate->currency->symbol}} {{@$estimate->adjustments}}</td>
</tr>
<tr class="width100">
  <td width="35%" class="borderGray"></td>
  <td width="18%" class="borderGray"></td>
  <td width="10%" class="borderGray"></td>
  <td width="18%" class="borderGray">{{__('Total Amount')}}</td>
  <td width="20%" class="borderGray font15">{{@$estimate->currency->symbol}} {{@$estimate->total_amount}}</td>
</tr>
</table>
{{-- estimate Products Table ends --}}

<p><span>{{__('Note')}}:</span>{{__('Estimate Due Date')}}: {{@$estimate->due_date}}</p>

@php
    $url = config('app.url');
@endphp


{{__('Thanks')}},<br>
{{ config('app.name') }}
</body>