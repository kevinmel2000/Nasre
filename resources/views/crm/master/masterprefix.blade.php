@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/prefix/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Master Prefix Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" id="code" style="width: 25%;" name="code" class="form-control form-control-sm" value="{{ $number_prefixdata }}" placeholder="enter code manually if not have parent data" data-validation="length" readonly="readonly" data-validation-length="1-16" required/>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Prefix')}}</label>
                          <input type="text" name="prefix" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" required/>
                      </div>
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 com-sm-12 mt-3">
                        <button class="btn btn-primary btn-block ">
                            {{__('Save Prefix')}}
                        </button>
                    </div>
                   
                </div>
            </div>
        </div> 
        
        
    </form>

    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 com-sm-12 mt-3">
                  <table id="prefixTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Prefi')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$prefixdata as $prefixdatadetail)
                            <tr>
                              <td>{{@$prefixdatadetail->code}}</td>
                              <td>{{@$prefixdatadetail->prefix}}</td>
                              
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$prefixdatadetail->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$prefixdatadetail->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                   {{-- @can('update-prefix', User::class) --}}
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updateprefix{{$prefixdatadetail->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- @endcan   --}}

                                    <div class="modal fade" id="updateprefix{{$prefixdatadetail->id}}" tabindex="-1" user="dialog" aria-labelledby="updateprefix{{$prefixdatadetail->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updateprefix{{$prefixdatadetail->id}}Label">{{__('Update number_prefixdata')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/prefix/update',$prefixdatadetail)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Code')}}</label>
                                                      <input type="text" name="code" class="form-control" value="{{$prefixdatadetail->code}}" required readonly/>
                                                    </div>
                                                  </div>
                                                </div>
                                               
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Accident')}}</label>
                                                      <input type="text" name="prefix" class="form-control" value="{{$prefixdatadetail->prefix}}" data-validation="length" data-validation-length="0-150" required/>
                                                    </div>
                                                  </div>

                                               
                                               
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                                <input type="submit" class="btn btn-info" value="Update">
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                </div>
                                {{-- Edit Modal Ends --}}

                                  {{-- @can('delete-prefix', User::class) --}}

                                    <span id="delbtn{{@$prefixdatadetail->id}}"></span>
                                  
                                      <form id="delete-prefix-{{$prefixdatadetail->id}}"
                                          action="{{ url('master-data/prefix/destroy', $prefixdatadetail->id) }}"
                                          method="POST">
                                          @method('DELETE')
                                          @csrf
                                      </form>

                                    {{-- @endcan   --}}
                                </span>
                              </td>

                            </tr>
                        @endforeach
                    </tbody>
                    
                  </table>
                </div>
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.master.masterprefix_js')
@endsection