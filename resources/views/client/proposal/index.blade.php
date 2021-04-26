@extends('client.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <style>
  .tr{
    width: 100%; background-color:rgb(223, 223, 223);
  }
  .tr1{
    width: 100%; background-color:rgb(223, 223, 223); font-weight:bold;
  }
  .textLeft{
    text-align:left;
  }
  .fontTable{
    font-size:13px; font-weight:bold;
  }
.floatRight{
  float:right;
} 
.textRight{
  text-align:right;
} 
.color1{
  color: #083561;
}
.width100{
  width=100%;
}
.borderGray{
  border: 1px solid grey;
}

.width30{
  width:30%;
}
.width70{
  width:70%
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
                  <h3 class="card-title">{{__('Manage Proposals')}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="proposalsTable" class="table table-bordered">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Subject')}}</th>
                      <th>{{__('Proposal Date')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Amount')}}</th>
                      <th>{{__('Sales Agent')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$proposals as $proposal)
                            <tr>
                              <td>{{@$proposal->id}}</td>
                              <td>
                                <a href="#" data-toggle="modal" data-target="#viewProposal{{@$proposal->id}}">
                                  {{@$proposal->subject}}
                                </a>
{{-- View Proposal Modal Starts --}}

<div class="modal fade" id="viewProposal{{@$proposal->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-light-gray">
      <div class="modal-header bg-gray">
        <h5 class="modal-title">#{{@$proposal->id}} |  {{__('Proposal')}} - {{$proposal->subject}} </h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
{{-- ********* --}}
<span class="darkBlue width100">{{__('Proposal')}} - #{{@$proposal->id}} <span class="floatRight">{{@$proposal->proposal_date}}</span></span>

<strong>
{{-- Address Table starts --}}
<table width="100%">
  <tr><td class="floatRight">{{@$company_details[0]['field_value']}}</td></tr>
  <tr><td class="floatRight">{{@$company_details[1]['field_value']}}</td></tr>
  <tr><td class="floatRight">{{@$company_details[2]['field_value']}}, [{{@$company_details[5]['field_value']}}]</td></tr>
  <tr><td class="floatRight">{{@$company_details[3]['field_value']}}</td></tr>
  <tr><td class="floatRight">{{@$company_details[4]['field_value']}}</td></tr>
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

<table width='100%' class="borderGray fontTable">
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
{{-- ********* --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
      </div>
    </div>
  </div>
</div>

{{-- View Proposal Modal Ends --}}

                  

                              </td>
                              <td>{{@$proposal->proposal_date}}</td>
                              <td>{{@$proposal->status}}</td>
                              <td>{{@$proposal->currency->name}} {{@$proposal->totalAmount}}</td>
                              <td>{{@$proposal->user->name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Subject')}}</th>
                      <th>{{__('Proposal Date')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Amount')}}</th>
                      <th>{{__('Sales Agent')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                </div>
                <!-- /.card-body -->
              </div>


          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


{{-- SECTION Add Currency modal Starts Here --}}
<div class="modal fade" id="addproposal" tabindex="-1" role="dialog" aria-labelledby="addproposalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addproposalLabel">{{__('Add proposal')}}</h5>
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

@endsection

@section('scripts')
  @include('client.proposal.index_js')
@endsection



