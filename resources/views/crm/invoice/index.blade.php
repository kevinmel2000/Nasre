@extends('crm.layouts.app')

@section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

  <style>
    .font15{
      font-size:15px;
    }
    .tr2{
      border: 1px solid grey;  font-size:13px; font-weight:bold;
    }
    .darkBlue{
      color: #083561;
    }
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
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Manage Invoices')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right" href="{{url('invoice/create')}}">{{__('New Invoice')}} </a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">

                  
                  <table id="invoicesTable" class="table table-bordered ">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Title')}}</th>
                      <th>{{__('Due Date')}}</th>
                      <th>{{__('To')}}</th>
                      <th>{{__('Invoice Date')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Paid')}}</th>
                      <th>{{__('Due Amount')}}</th>
                      <th>{{__('Total Amount')}}</th>
                      <th>{{__('Assigned To')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$invoices as $invoice)
                            <tr {!! $extraButtons[$invoice->id] !!}>
                              <td
                              @if (@$invoice->payment_confirmed == 'yes')
                                class="bg-success"  
                              @elseif(@$invoice->invoice_paid == 'yes') 
                                class="bg-info"                                   
                              @endif
                              >{{@$invoice->id}}</td>
                              <td>
                                {{@$invoice->invoice_title}}
                                @include('crm.invoice.invoice_modal')
                                <br>
                                <div class="d-hide" id="extraButtons{{@$invoice->id}}">
                                  <a class="text-primary text-bold font13 pr-2" href="#" data-toggle="modal" data-target="#viewinvoice{{@$invoice->id}}">
                                    View
                                  </a>
                                  <a class="text-primary text-bold font13 pr-2" href="{{url('invoice/invoice_pdf', $invoice)}}" target="_blank">
                                    PDF
                                  </a>
                                  <a class="text-primary text-bold font13" href="{{url('invoice/email/'.$invoice->id )}}">
                                    Email
                                  </a>
                                </div>

                              </td>
                              
                              <td>{{@$invoice->due_date}}</td>
                              <td>
                                  <span class="badge badge-success">{{@$invoice->relation}}</span>
                                    {{@$invoice->customer->username}} | {{@$invoice->customer->first_contact->email}}
                              </td>
                              <td>{{@$invoice->invoice_date}}</td>
                              <td>{{@$invoice->status}}</td>
                              <td>{{@$invoice->currency->symbol}} {{@$invoice->amount_paid}}</td>
                              <td>{{@$invoice->currency->symbol}} {{@$invoice->amount_due}}</td>
                              <td>{{@$invoice->currency->symbol}} {{@$invoice->total_amount}}</td>
                              <td>{{@$invoice->user->name}}</td>
                                <td>
                                  <span>
                                    <a class="text-secondary mr-2" href="{{url('invoice/email/'.$invoice->id )}}">
                                      <i class="fas fa-mail-bulk"></i>
                                    </a>
                                    @can('update-contact', User::class)
                                      <a class="text-primary mr-2" href="{{url('/invoice/edit', $invoice)}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    @endcan
  
                                    @can('delete-contact', User::class)
                                    <span id="delbtn{{@$invoice->id}}"></span>
                                      <form id="delete-contact-{{$invoice->id}}"
                                          action="{{ url('invoice/destroy', $invoice) }}"
                                          method="POST">
                                          @method('DELETE')
                                          @csrf
                                      </form>
                                    @endcan  
                                  </span>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Title')}}</th>
                      <th>{{__('Due Date')}}</th>
                      <th>{{__('To')}}</th>
                      <th>{{__('Invoice Date')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Paid')}}</th>
                      <th>{{__('Due Amount')}}</th>
                      <th>{{__('Total Amount')}}</th>
                      <th>{{__('Assigned To')}}</th>
                      <th>{{__('Actions')}}</th>
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
@include('crm.invoice.index_js')
@endsection



