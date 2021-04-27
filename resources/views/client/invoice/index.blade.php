@extends('client.layouts.app')

@section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <style>
    .floatRgiht{
      float: right;
    }
  </style>
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
                  <h3 class="card-title">{{__('Manage Invoices')}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="invoicesTable" class="table table-bordered">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Title')}}</th>
                      <th>{{__('Due Date')}}</th>
                      <th>{{__('Invoice Date')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Paid')}}</th>
                      <th>{{__('Due Amount')}}</th>
                      <th>{{__('Total Amount')}}</th>
                      <th>{{__('Sales Agent')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$invoices as $invoice)
                            <tr>
                              <td>{{@$invoice->id}}</td>
                              <td>
                                <a href="#" data-toggle="modal" data-target="#viewinvoice{{@$invoice->id}}">
                                  {{@$invoice->invoice_title}}
                                </a>
                              {{-- View invoice Modal Starts --}}
                              <div class="modal fade" id="viewinvoice{{@$invoice->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content bg-light-gray">
                                    <div class="modal-header bg-gray">
                                      <h5 class="modal-title">#{{@$invoice->id}} |  {{__('Invoice')}} - {{@$invoice->invoice_title}} </h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
<div class="modal-body">
  <span class="width100 darkBlue font14">{{__('Invoice')}} - #{{@$invoice->invoice_number}} <span class="floatRight font14">{{@$invoice->invoice_date}}</span></span>

  @if (@$invoice->invoice_paid == 'yes')
    <span class="bg-default px-2">
      <i class="fas fa-check text-success"> {{__('Invoice Paid')}}</i>  
    </span>
    @if (@$invoice->payment_confirmed == 'no')
      <i class="fas fa-question text-danger"> {{__('Confirmation pending')}}</i>
      
    @else
    <i class="fas fa-check text-success"> {{__('Payment Confirmed')}}</i>    
    @endif

    <br>
    {{__('By')}} {{@$invoice->payment_mode->name}}
    <br>
    {{__('Time')}}: {{@$invoice->payment_time}}
    <br>
    {{__('Txn No.')}} {{@$invoice->txn_number}}

    @if (@$invoice->txn_receipt != null)
      <br>
      <a href="storage/invoice_receipts/{{@$invoice->txn_receipt}}">{{__('Receipt')}}</a>
    @endif

  @else 
    <a href="#" data-toggle="modal" data-target="#payment{{@$invoice->id}}" class="btn btn-sm btn-primary mt-1 ml-2">Pay</a>
  @endif

{{-- SECTION  modal Starts Here --}}
<div class="modal fade" id="payment{{@$invoice->id}}" tabindex="-1" role="dialog" aria-labelledby="payment{{@$invoice->id}}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" >{{__('Payment Options')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('client/invoice/pay')}}" method="POST"  enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <input type="hidden" name="invoice_number" value="{{@$invoice->id}}">
                <label for="">{{__('Select Payment Mode')}}</label>
                <select name="payment_mode_id" id="payment_mode"  class="form-control">
                  <option disabled selected>{{__('Select Payment Mode')}}</option>
                  @foreach ($payment_modes as $payment_mode)
                      <option value="{{@$payment_mode->id}}">{{@$payment_mode->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group d-hide" id="details_card">
                <textarea id="payment_details" class="form-control" disabled readonly></textarea>
              </div>
              <div class="form-group">
                <label for="">{{__('Transaction Number')}}</label>
                <input type="text" name="txn_number" class="form-control form-control-sm">
              </div>
              <div class="form-group">
                <label for="">{{__('Transaction Receipt')}}</label>
                <input type="file" name="txn_receipt" class="form-control form-control-sm">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="submit" class="btn btn-info">{{__('Checkout')}}</button>
            </div>
          </form>
      </div>
    </div>
</div>
{{-- !SECTION  modal ends here --}}

<strong>
{{-- Address Table starts --}}
<table width="100%">
  <tr><td class="floatRight">{{@$company_details[0]['field_value']}}</td></tr>
  <tr><td class="floatRight">{{@$company_details[1]['field_value']}}</td></tr>
  <tr><td class="floatRight">{{@$company_details[2]['field_value']}}, {{@$company_details[3]['field_value']}}, {{@$company_details[4]['field_value']}} [{{@$company_details[5]['field_value']}}]</td></tr>
 
  <tr><td class="floatRight">{{@$company_details[6]['field_value']}}</td></tr>
  <tr><td class="floatRight">{{@$company_details[7]['field_value']}}</td></tr>
</table>
{{-- Address Table ends --}}
<hr>
<span class="darkBlue">{{__('Subject')}}: {{@$invoice->invoice_title}}</span> 
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
</strong>
{{-- Prepared for table ends --}}

{{-- invoice Products Table starts --}}
<table width='100%' class="borderGray font13 fontBold">
  <tr class="width100 tr1">
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
<tr class="tr">
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
<tr class="tr">
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
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">{{__('Terms and Conditions')}} </label>
            <textarea name="termsandconditions" class="form-control form-control-sm" rows="5" readonly>{{@$invoice->termsandconditions}}</textarea>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">{{__('Customer Notes')}} </label>
            <textarea name="customer_notes" class="form-control form-control-sm" rows="5" readonly>{{@$invoice->customer_notes}}</textarea>
          </div>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                              {{-- View invoice Modal Ends --}}
                              </td>
                              <td>{{@$invoice->due_date}}</td>
                              <td>{{@$invoice->invoice_date}}</td>
                              <td>{{@$invoice->status}}</td>
                              <td>{{@$invoice->currency->symbol}} {{@$invoice->amount_paid}}</td>
                              <td>{{@$invoice->currency->symbol}} {{@$invoice->amount_due}}</td>
                              <td>{{@$invoice->currency->symbol}} {{@$invoice->total_amount}}</td>
                              <td>{{@$invoice->user->name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Title')}}</th>
                      <th>{{__('Due Date')}}</th>
                      <th>{{__('Invoice Date')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Paid')}}</th>
                      <th>{{__('Due Amount')}}</th>
                      <th>{{__('Total Amount')}}</th>
                      <th>{{__('Sales Agent')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>


{{-- ANCHOR MODAL VIEW invoice --}}


<div class="modal fade bd-example-modal-lg" id="testmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>
{{-- MODAL VIEW invoice ENDS --}}



@endsection

@section('scripts')
  @include('client.invoice.index_js')
@endsection



