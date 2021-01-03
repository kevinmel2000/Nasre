@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('crm.layouts.breadcrumb')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header  bg-gray">
                  <h3 class="card-title">{{__('Payment Modes')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right"  data-toggle="modal" data-target="#addPaymentMode">{{__('New Payment Mode')}} </a>
                </div>
                <div class="card-body">
                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <div class="text text-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                  <table id="paymentModesTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Payment Mode Name')}}</th>
                      <th>{{__('Details')}}</th>
                      <th>{{__('Active')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$paymentModes as $paymentMode)
                            <tr>
                              <td>{{@$paymentMode->name}}
                              @if (@$paymentMode->is_default == 'yes')
                                  [ {{__('Default')}} ]
                              @endif
                              </td>
                              <td>{{@$paymentMode->details}}</td>
                              <td>{{@$paymentMode->is_active}}</td>
                                <td>
                                  <span>
                                    <a href="#" data-toggle="tooltip" data-title="{{$paymentMode->created_at->toDayDateTimeString()}}" class="mr-2">
                                      <i class="fas fa-clock text-info"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-title="{{$paymentMode->updated_at->toDayDateTimeString()}}" class="mr-2">
                                      <i class="fas fa-history text-primary"></i>
                                    </a>
                                    
                                    @can('update-office', User::class)
                                    
                                    <a href="#" class="text-primary mr-2" data-toggle="modal" data-target="#editPaymentMode{{$paymentMode->id}}"> 
                                        <i class="fas fa-edit"></i> 
                                    </a>

                                    {{-- SECTION Edit Modal Starts Here --}}
                                    <div class="modal fade" id="editPaymentMode{{$paymentMode->id}}" tabindex="-1" role="dialog" aria-labelledby="addpaymentModeLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content  bg-light-gray">
                                            <div class="modal-header  bg-gray">
                                            <h5 class="modal-paymentMode" id="addpaymentModeLabel">{{__('Update Payment Mode')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="{{url('office/paymentmode', $paymentMode)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="">{{__('Enter Payment Mode Name')}} </label>
                                                    <input type="text" name="name" class="form-control" value="{{@$paymentMode->name}}" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{__('Enter a details')}}</label>
                                                    <textarea name="details" class="form-control" rows="5">{{@$paymentMode->details}}</textarea>
                                                </div> 
                                                <div class="form-group">
                                                  <label for="">{{__('Status')}}</label>
                                                  <select name="is_active" class="form-control">
                                                    @if ($paymentMode->is_active=='yes')
                                                      <option value="yes" selected>{{__('Yes')}}</option>
                                                      <option value="no"  >{{__('No')}}</option>
                                                    @else 
                                                      <option value="yes" >{{__('Yes')}}</option>
                                                      <option value="no" selected>{{__('No')}}</option>
                                                    @endif
                                                    
                                                  </select>
                                                </div>
                                                <div class="form-group">
                                                  <label for="">{{__('Default')}}</label>
                                                  <select name="is_default" class="form-control">
                                                    @if ($paymentMode->is_default=='yes')
                                                      <option value="yes" selected>{{__('Yes')}}</option>
                                                      <option value="no">{{__('No')}}</option>
                                                    @else 
                                                    <option value="yes" >{{__('Yes')}}</option>
                                                    <option value="no" selected>{{__('No')}}</option>
                                                    @endif
                                                    
                                                  </select>
                                                </div>   
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                                <button type="submit" class="btn btn-info">{{__('Update Payment Mode')}}</button>
                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    {{-- !SECTION Edit Modal Ends here --}}

                                    @endcan
  
                                    @can('delete-office', User::class)
                                    <span id="delbtn{{@$paymentMode->id}}"></span>
                                      <form id="delete-paymentMode-{{$paymentMode->id}}"
                                          action="{{ url('office/paymentmode/destroy', $paymentMode) }}"
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
                   
                  </table>
                </div>
                <!-- /.card-body -->
              </div>


          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


{{-- SECTION Add paymentmode modal Starts Here --}}
<div class="modal fade" id="addPaymentMode" tabindex="-1" role="dialog" aria-labelledby="addPaymentModeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addPaymentModeLabel">{{__('Add Payment Mode')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-light-gray">
          <form action="{{url('office/paymentmode/store')}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="">{{__('Enter Payment Mode Name')}} </label>
                <input type="text" name="name" class="form-control" required/>
              </div>
              <div class="form-group">
                <label for="">{{__('Enter details')}} </label>
                <textarea name="details" class="form-control" cols="30" rows="5"></textarea>
              </div>
              <div class="form-group">
                <label for="">{{__('Status')}}</label>
                <select name="is_active" class="form-control">
                  <option value="yes" selected>{{__('Yes')}}</option>
                  <option value="no">{{__('No')}}</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">{{__('Default')}}</label>
                <select name="is_default" class="form-control">
                  <option value="yes" >{{__('Yes')}}</option>
                  <option value="no" selected>{{__('No')}}</option>
                </select>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="submit" class="btn btn-info">{{__('Add')}}</button>
            </div>
          </form>
      </div>
    </div>
</div>
{{-- !SECTION ADD taxrate modal ends here --}}

@endsection

@section('scripts')
@include('crm.office.paymentmode_js')
@endsection



