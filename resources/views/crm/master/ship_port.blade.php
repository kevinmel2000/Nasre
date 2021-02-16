@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/shipport/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Ship Port Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Code')}} </label>
                          <input type="text" name="spcode" class="form-control form-control-sm" data-validation="length" data-validation-length="1-12" value="{{ $code_sp }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Name')}}</label>
                          <input type="text" name="spname" class="form-control form-control-sm " data-validation="length" data-validation-length="1-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('Description')}}</label>
                        <input type="text" name="spdescription" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('City')}} </label>
                        <select name="spcity" id="spcity" class="e1 form-control form-control-sm ">
                            <option selected disabled>{{__('Select City')}}</option>
                            @foreach($city as $citydata)
                              <option value="{{ $citydata->id }}">{{ $citydata->id }} - {{ $citydata->name }}</option>
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
                            {{__('Save Ship Port')}}
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
                    <table id="shipportTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('City')}}</th>
                        <th width="20%">{{__('Actions')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach (@$shipport as $sp)
                              <tr>
                                <td>{{@$sp->code}}</td>
                                <td>{{@$sp->name}}</td>
                                <td>{{@$sp->description}}</td>
                                <td>{{@$sp->city->name}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$sp->created_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$sp->updated_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    {{-- @can('update-construction', User::class) --}}
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updateshipport{{$sp->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    {{-- @endcan --}}
  
                                    <div class="modal fade" id="updateshipport{{$sp->id}}" tabindex="-1" user="dialog" aria-labelledby="updateshipport{{$sp->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updateshipport{{$sp->id}}Label">{{__('Update Ship Port')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/shipport',$sp)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')
                                                  <div class="row">
                                                    <div class="col-md-4 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Code')}}</label>
                                                        <input type="text" name="codesp" class="form-control" value="{{$sp->code}}" data-validation="length" data-validation-length="1-12" readonly="readonly" required/>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Name')}}</label>
                                                        <input type="text" name="namesp" class="form-control" value="{{$sp->name}}" data-validation="length" data-validation-length="1-50" required />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Description')}}</label>
                                                        <input type="text" name="descriptionsp" class="form-control" value="{{$sp->description}}" data-validation="length" data-validation-length="0-50"  />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-4 col-md-12">
                                                      <div class="form-group">
                                                          <label for="">{{__('City')}}</label><br>
                                                          <select name="citysp" class="form-control form-control-sm e1">
                                                              <option selected disabled>{{__('Select State')}}</option>
                                                              @foreach($city as $citydata)
                                                                @if($sp->city_id  == $citydata->id)
                                                                  <option value="{{ $citydata->id }}" selected>{{ $citydata->id }} - {{ $citydata->name }}</option>
                                                                @else
                                                                  <option value="{{  $citydata->id }}">{{  $citydata->id  }} - {{ $citydata->name }}</option>
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
                                      <span id="delbtn{{@$sp->id}}"></span>
                                        <form id="delete-shipport-{{$sp->id}}"
                                            action="{{ url('master-data/shipport/destroy', $sp->id) }}"
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
@include('crm.master.ship_port_js')
@endsection