@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <style>
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Manage Estimates')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right" href="{{url('estimate/create')}}">{{__('New Estimate')}} </a>
                </div>
                <div class="card-body">
                  <table id="estimatesTable" class="table table-bordered">
                    <thead>
                    <tr>
                      <th><label for="">{{__('ID')}}</label></th>
                      <th><label for="">{{__('Title')}}</label></th>
                      <th><label for="">{{__('Due Date')}}</label></th>
                      <th><label for="">{{__('To')}}</label></th>
                      <th><label for="">{{__('Estimate Date')}}</label></th>
                      <th><label for="">{{__('Status')}}</label></th>
                      <th><label for="">{{__('Total Amount')}}</label></th>
                      <th><label for="">{{__('Sales Agent')}}</label></th>
                      <th><label for="">{{__('Actions')}}</label></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$estimates as $estimate)
                            <tr {!! $extraButtons[$estimate->id] !!}>
                              <td
                              @if ($estimate->is_invoiced == 'yes')
                                class="bg-success"
                                data-toggle="tooltip"
                                data-target="top"
                                title="Invoiced"
                              @endif
                              >{{@$estimate->id}}
                            </td>
                            <td>
                                {{@$estimate->estimate_title}}
                                @include('crm.estimate.estimate_modal')
                                <br>
                                <div class="d-hide" id="extraButtons{{@$estimate->id}}">
                                  <a class="text-primary text-bold font13 pr-2" href="#" data-toggle="modal" data-target="#viewestimate{{@$estimate->id}}">
                                    View
                                  </a>
                                  <a class="text-primary text-bold font13 pr-2" href="{{url('estimate/estimate_pdf', $estimate)}}" target="_blank">
                                    PDF
                                  </a>
                                  <a class="text-primary text-bold font13" href="{{url('estimate/email/'.$estimate->id )}}">
                                    Email
                                  </a>
                                </div>
                                


                              </td>
                              
                              <td>{{@$estimate->due_date}}</td>
                              <td>
                                  <span class="badge badge-success">{{@$estimate->relation}}</span>
                                    {{@$estimate->customer->username}} | {{@$estimate->customer->first_contact->email}}
                              </td>
                              <td>{{@$estimate->estimate_date}}</td>
                              <td>{{@$estimate->status}}</td>
                              <td>{{@$estimate->currency->symbol}} {{@$estimate->total_amount}}</td>
                              <td>{{@$estimate->user->name}}</td>
                                <td>
                                  <span>
                                    <a href="#" data-toggle="tooltip" data-title="{{$estimate->created_at->toDayDateTimeString()}}" class="mr-2">
                                      <i class="fas fa-clock text-info"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-title="{{$estimate->updated_at->toDayDateTimeString()}}" class="mr-2">
                                      <i class="fas fa-history text-primary"></i>
                                    </a>
                                    <a class="text-secondary mr-2" href="{{url('estimate/email/'.$estimate->id )}}">
                                      <i class="fas fa-mail-bulk"></i>
                                    </a>
                                    @can('update-contact', User::class)
                                      <a class="text-primary mr-2" href="{{url('/estimate/edit', $estimate)}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    @endcan
  
                                    @can('delete-contact', User::class)
                                    
                                    <span id="delbtn{{@$estimate->id}}"></span>
                                      <form id="delete-contact-{{$estimate->id}}"
                                          action="{{ url('estimate/destroy', $estimate) }}"
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
                      <th><label for="">{{__('ID')}}</label></th>
                      <th><label for="">{{__('Title')}}</label></th>
                      <th><label for="">{{__('Due Date')}}</label></th>
                      <th><label for="">{{__('To')}}</label></th>
                      <th><label for="">{{__('Estimate Date')}}</label></th>
                      <th><label for="">{{__('Status')}}</label></th>
                      <th><label for="">{{__('Total Amount')}}</label></th>
                      <th><label for="">{{__('Sales Agent')}}</label></th>
                      <th><label for="">{{__('Actions')}}</label></th>
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





@endsection

@section('scripts')
@include('crm.estimate.index_js')
@endsection



