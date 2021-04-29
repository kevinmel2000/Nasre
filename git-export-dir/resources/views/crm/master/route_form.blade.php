@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/routeform/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Route Form Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__(' Code')}} </label>
                          <input type="text" name="rfcode" style="width: 25%;" class="form-control form-control-sm" data-validation="length" data-validation-length="1-16" value="{{ $code_rf }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Name')}}</label>
                          <input type="text" name="rfname" class="form-control form-control-sm " data-validation="length" data-validation-length="0-150" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('Description')}}</label>
                        <input type="text" name="rfdescription" class="form-control form-control-sm " data-validation="length" data-validation-length="0-150" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('From')}} </label>
                        <select name="rffrom" class="e1 form-control form-control-sm ">
                            <option selected disabled>{{__('Select Port location')}}</option>
                            @foreach($shipport as $sp)
                              <option value="{{ $sp->id }}">{{ $sp->code }} - {{ $sp->name }}</option>
                            @endforeach
                        </select> 
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('To')}} </label>
                        <select name="rfto" class="e1 form-control form-control-sm ">
                            <option selected disabled>{{__('Select Port location')}}</option>
                            @foreach($shipport as $sp)
                              <option value="{{ $sp->id }}">{{ $sp->code }} - {{ $sp->name }}</option>
                            @endforeach
                        </select> 
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('transit 1')}} </label>
                        <select name="rftransit" class="e1 form-control form-control-sm ">
                            <option selected disabled>{{__('Select Port location')}}</option>
                            @foreach($shipport as $sp)
                              <option value="{{ $sp->id }}">{{ $sp->code }} - {{ $sp->name }}</option>
                            @endforeach
                        </select> 
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('Transit 2')}} </label>
                        <select name="rftransit2" class="e1 form-control form-control-sm ">
                            <option selected disabled>{{__('Select Port location')}}</option>
                            @foreach($shipport as $sp)
                              <option value="{{ $sp->id }}">{{ $sp->code }} - {{ $sp->name }}</option>
                            @endforeach
                        </select> 
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
                            {{__('Save Route')}}
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
                  <div class="table-responsive">
                    <table id="routeformTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('From')}}</th>
                        <th>{{__('To')}}</th>
                        <th>{{__('Transit 1')}}</th>
                        <th>{{__('Transit 2')}}</th>
                        <th width="20%">{{__('Actions')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach (@$routeform as $rf)
                              <tr>
                                <td>{{@$rf->code}}</td>
                                <td>{{@$rf->name}}</td>
                                <td>{{@$rf->description}}</td>
                                <td>{{@$rf->route_from->name}}</td>
                                <td>{{@$rf->route_to->name}}</td>
                                <td>{{@$rf->route_transit->name}}</td>
                                <td>{{@$rf->route_transit_2->name}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$rf->created_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$rf->updated_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    {{-- @can('update-construction', User::class) --}}
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updaterouteform{{$rf->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    {{-- @endcan --}}
  
                                    <div class="modal fade" id="updaterouteform{{$rf->id}}" tabindex="-1" user="dialog" aria-labelledby="updaterouteform{{$rf->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updaterouteform{{$rf->id}}Label">{{__('Update Route')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/routeform',$rf)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')
                                                  <div class="row">
                                                    <div class="col-md-4 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Code')}}</label>
                                                        <input type="text" name="coderf" class="form-control" value="{{$rf->code}}" data-validation="length" data-validation-length="1-16" readonly="readonly" required/>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Name')}}</label>
                                                        <input type="text" name="namerf" class="form-control" value="{{$rf->name}}" data-validation="length" data-validation-length="0-150" required />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Description')}}</label>
                                                        <input type="text" name="descriptionrf" class="form-control" value="{{$rf->description}}" data-validation="length" data-validation-length="0-250"  />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-12">
                                                      <div class="form-group">
                                                          <label for="">{{__('From')}} </label>
                                                          <select name="fromrf" class="e1 form-control form-control-sm ">
                                                              <option selected disabled>{{__('Select City')}}</option>
                                                              @foreach($shipport as $sp)
                                                                @if($rf->from  == $sp->id)
                                                                  <option value="{{ $sp->id }}" selected>{{ $sp->code }} - {{ $sp->name }}</option>
                                                                @else
                                                                  <option value="{{  $sp->id }}">{{  $sp->code  }} - {{ $sp->name }}</option>
                                                                @endif
                                                              @endforeach
                                                          </select> 
                                                      </div>
                                                    </div>
                                                  </div>\<div class="row">
                                                    <div class="col-md-12">
                                                      <div class="form-group">
                                                          <label for="">{{__('To')}} </label>
                                                          <select name="torf" class="e1 form-control form-control-sm ">
                                                              <option selected disabled>{{__('Select City')}}</option>
                                                              @foreach($shipport as $sp)
                                                                @if($rf->to  == $sp->id)
                                                                  <option value="{{ $sp->id }}" selected>{{ $sp->code }} - {{ $sp->name }}</option>
                                                                @else
                                                                  <option value="{{  $sp->id }}">{{  $sp->code  }} - {{ $sp->name }}</option>
                                                                @endif
                                                              @endforeach
                                                          </select> 
                                                      </div>
                                                    </div>
                                                  </div>\<div class="row">
                                                    <div class="col-md-12">
                                                      <div class="form-group">
                                                          <label for="">{{__('Transit 1')}} </label>
                                                          <select name="transitrf" class="e1 form-control form-control-sm ">
                                                              <option selected disabled>{{__('Select City')}}</option>
                                                              @foreach($shipport as $sp)
                                                                @if($rf->transit_1  == $sp->id)
                                                                  <option value="{{ $sp->id }}" selected>{{ $sp->code }} - {{ $sp->name }}</option>
                                                                @else
                                                                  <option value="{{  $sp->id }}">{{  $sp->code  }} - {{ $sp->name }}</option>
                                                                @endif
                                                              @endforeach
                                                          </select> 
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-12">
                                                      <div class="form-group">
                                                          <label for="">{{__('Transit 2')}} </label>
                                                          <select name="transit2rf" class="e1 form-control form-control-sm ">
                                                              <option selected disabled>{{__('Select City')}}</option>
                                                              @foreach($shipport as $sp)
                                                                @if($rf->transit_2  == $sp->id)
                                                                  <option value="{{ $sp->id }}" selected>{{ $sp->code }} - {{ $sp->name }}</option>
                                                                @else
                                                                  <option value="{{  $sp->id }}">{{  $sp->code  }} - {{ $sp->name }}</option>
                                                                @endif
                                                              @endforeach
                                                          </select> 
                                                      </div>
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
  
                                    {{-- @can('delete-country', User::class) --}}
                                      <span id="delbtn{{@$rf->id}}"></span>
                                        <form id="delete-routeform-{{$rf->id}}"
                                            action="{{ url('master-data/routeform/destroy', $rf->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                      </span>
                                  {{-- @endcan   --}}
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
  </div>
@endsection

@section('scripts')
@include('crm.master.route_form_js')
@endsection