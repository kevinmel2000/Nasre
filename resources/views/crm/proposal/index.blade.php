

@extends('crm.layouts.app')

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
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Manage Proposals')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right" href="{{url('proposal/create')}}">{{__('New Proposal')}} </a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="proposalsTable" class="table table-bordered">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Subject')}}</th>
                      <th>{{__('To')}}</th>
                      <th>{{__('Proposal Date')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Amount')}}</th>
                      <th>{{__('Sales Agent')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$proposals as $proposal)
                            <tr {!! $extraButtons[$proposal->id] !!}>
                              <td>{{@$proposal->id}}</td>
                              <td>
                                  {{@$proposal->subject}}
                                @include('crm.proposal.proposal_modal')
                                <br>
                                <div class="d-hide" id="extraButtons{{@$proposal->id}}">
                                  <a class="text-primary text-bold font13 pr-2" href="#" data-toggle="modal" data-target="#viewProposal{{@$proposal->id}}">
                                    View
                                  </a>
                                  <a class="text-primary text-bold font13 pr-2" href="{{url('proposal/proposal_pdf', $proposal)}}" target="_blank">
                                    PDF
                                  </a>
                                  <a class="text-primary text-bold font13" href="{{url('proposal/email/'.$proposal->id )}}">
                                    Email
                                  </a>
                                </div>
                              </td>
                              <td>
                                @if ($proposal->relation == 'Lead')
                                    <span class="badge badge-warning">{{@$proposal->relation}}</span>
                                    {{ @$proposal->lead->first_name }} {{ @$proposal->lead->last_name }} | {{ @$proposal->lead->email }}
                                @else
                                  <span class="badge badge-success">{{@$proposal->relation}}</span>
                                    {{@$proposal->customer->username}} | {{@$proposal->customer->first_contact->email}}
                                @endif
                              </td>
                              <td>{{@$proposal->proposal_date}}</td>
                              <td>{{@$proposal->status}}</td>
                              <td>{{@$proposal->currency->name}} {{@$proposal->totalAmount}}</td>
                              <td>{{@$proposal->user->name}}</td>
                                <td>
                                  <span>
                                    <a class="text-secondary mr-2" href="{{url('proposal/email/'.$proposal->id )}}">
                                      <i class="fas fa-mail-bulk"></i>
                                    </a>	
                                    @can('update-lead', User::class)
                                      <a class="text-primary mr-2" href="{{url('/proposal/edit', $proposal)}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    @endcan
  
                                    @can('delete-lead', User::class)
                                    <span id="delbtn{{@$proposal->id}}"></span>
                                      <form id="delete-proposal-{{$proposal->id}}"
                                          action="{{ url('proposal/destroy', $proposal) }}"
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
                      <th>{{__('Subject')}}</th>
                      <th>{{__('To')}}</th>
                      <th>{{__('Proposal Date')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Amount')}}</th>
                      <th>{{__('Sales Agent')}}</th>
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


{{-- ANCHOR MODAL VIEW proposal --}}


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>

{{-- MODAL VIEW proposal ENDS --}}

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
{{-- !SECTION ADD Currency modal ends here --}}

@endsection

@section('scripts')
@include('crm.proposal.index_js')
@endsection



