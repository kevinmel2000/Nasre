@extends('client.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Manage Estimates')}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="estimatesTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th><label for="">{{__('ID')}}</label></th>
                      <th><label for="">{{__('Title')}}</label></th>
                      <th><label for="">{{__('Due Date')}}</label></th>
                      <th><label for="">{{__('Estimate Date')}}</label></th>
                      <th><label for="">{{__('Status')}}</label></th>
                      <th><label for="">{{__('Total Amount')}}</label></th>
                      <th><label for="">{{__('Sales Agent')}}</label></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$estimates as $estimate)
                            <tr>
                              <td
                              @if ($estimate->is_invoiced == 'yes')
                                class="bg-success"
                                data-toggle="tooltip"
                                data-target="top"
                                title="Invoiced"
                              @endif
                              >{{@$estimate->id}}</td>
                              <td>
                                <a href="#" data-toggle="modal" data-target="#viewestimate{{@$estimate->id}}">
                                  {{@$estimate->estimate_title}}
                                </a>
                               
                              <div class="modal fade" id="viewestimate{{@$estimate->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content bg-light-gray">
                                    <div class="modal-header bg-gray">
                                      <div>
                                        <span class="modal-title float-left">#{{@$estimate->id}} |  {{__('Estimate')}} - {{$estimate->estimate_title}} </span>
                                      @php
                                          $url = config('app.url').'/client/estimate/toInvoice/'.$estimate->id.'/'.$estimate->invoiced_token;
                                      @endphp
                                      @if (@$estimate->is_invoiced == 'yes')
                                        <span class="text-success"><i class="fas fa-check"></i> {{__('Invoiced')}}</span>
                                      @else 
                                        <a href="{{$url}}" class="btn btn-sm btn-primary">{{__('Convert To Invoice')}}</a>
                                      @endif
                                      </div>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
{{-- ******************** --}}
# <span class="darkBlue width100">{{__('Estimate')}} - #{{@$estimate->estimate_number}} <span class="floatRight">{{@$estimate->estimate_date}}</span></span>
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

<span class="darkBlue">{{__('Description')}}:</span>  <br/>{{@$estimate->customer_notes}}
<br>
<br>
</strong>
{{-- Prepared for table ends --}}

{{-- estimate Products Table starts --}}
{{-- @php
    print_r($products);
@endphp --}}
<table width='100%' class="borderGray font13 fontBold">
  <tr class="width100 tr1" >
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
<tr class="tr1">
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


{{-- ******************* --}}
  
                                    </div>
                                    <div class="modal-footer">
                                      {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              {{-- View estimate Modal Ends --}}

                              </td>
                              
                              <td>{{@$estimate->due_date}}</td>
                              <td>{{@$estimate->estimate_date}}</td>
                              <td>{{@$estimate->status}}</td>
                              <td>{{@$estimate->currency->symbol}} {{@$estimate->total_amount}}</td>
                              <td>{{@$estimate->user->name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th><label for="">{{__('ID')}}</label></th>
                      <th><label for="">{{__('Title')}}</label></th>
                      <th><label for="">{{__('Due Date')}}</label></th>
                      <th><label for="">{{__('Estimate Date')}}</label></th>
                      <th><label for="">{{__('Status')}}</label></th>
                      <th><label for="">{{__('Total Amount')}}</label></th>
                      <th><label for="">{{__('Sales Agent')}}</label></th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>


          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


{{-- ANCHOR MODAL VIEW estimate --}}


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>

{{-- MODAL VIEW estimate ENDS --}}

{{-- SECTION Add Currency modal Starts Here --}}
<div class="modal fade" id="addestimate" tabindex="-1" role="dialog" aria-labelledby="addestimateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addestimateLabel">{{__('Add estimate')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('office/currency/store')}}" method="POST">
              @csrf

              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="submit" class="btn btn-info">{{__('Add')}}</button>
            </div>
          </form>
      </div>
    </div>
</div>
{{-- !SECTION ADD Currency modal ends here --}}

@endsection

@section('scripts')
@include('client.estimate.index_js')
@endsection



