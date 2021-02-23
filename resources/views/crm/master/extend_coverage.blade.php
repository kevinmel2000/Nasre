@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/extendedcoverage/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Extend Coverage Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Code')}} </label>
                          <input type="text" name="eccode" style="width: 25%;" class="form-control form-control-sm" data-validation="length" data-validation-length="1-12" value="{{ $code_ec }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Name')}}</label>
                          <input type="text" name="ecname" class="form-control form-control-sm " data-validation="length" data-validation-length="1-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('Description')}}</label>
                        <input type="text" name="ecdescription" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('COB')}}</label>
                        <select name="eccob" class="e1 form-control form-control-sm ">
                            <option selected disabled>{{__('Select COB')}}</option>
                            @foreach($cob as $cob_data)
                            <option value="{{ $cob_data->id }}">{{ $cob_data->code }} - {{ $cob_data->description }}</option>
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
                            {{__('Save Extend Coverage')}}
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
                    <table id="exendedcoverageTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('COB')}}</th>
                        <th width="20%">{{__('Actions')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach (@$extendcoverage as $ec)
                              <tr>
                                <td>{{@$ec->code}}</td>
                                <td>{{@$ec->name}}</td>
                                <td>{{@$ec->description}}</td>
                                <td>{{@$ec->cob->code}} - {{@$ec->cob->description}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$ec->created_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$ec->updated_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    {{-- @can('update-construction', User::class) --}}
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updateextendedcoverage{{$ec->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    {{-- @endcan --}}
  
                                    <div class="modal fade" id="updatecextendedcoverage{{$ec->id}}" tabindex="-1" user="dialog" aria-labelledby="updateextendedcoverage{{$ec->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updateextendedcoverage{{$ec->id}}Label">{{__('Update Extend Coverage')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/extendedcoverage',$ec)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')
                                                  <div class="row">
                                                    <div class="col-md-4 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Code')}}</label>
                                                        <input type="text" name="codeec" class="form-control" value="{{$ec->code}}" data-validation="length" data-validation-length="1-12" readonly="readonly" required/>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Name')}}</label>
                                                        <input type="text" name="nameec" class="form-control" value="{{$ec->name}}" data-validation="length" data-validation-length="1-50" required />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Description')}}</label>
                                                        <input type="text" name="descriptionec" class="form-control" value="{{$ec->description}}" data-validation="length" data-validation-length="0-50"  />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('COB')}}</label><br>
                                                            <select name="cobec" class="e1 form-control form-control-sm ">
                                                                <option selected disabled>{{__('Select COB')}}</option>
                                                                @foreach($cob as $cob_data)
                                                                  @if($ec->cob_id  == $cob_data->id)
                                                                    <option value="{{ $cob_data->id }}" selected>{{ $cob_data->code }} - {{ $cob_data->description }}</option>
                                                                  @else
                                                                    <option value="{{  $cob_data->id }}">{{  $cob_data->code  }} - {{ $cob_data->description }}</option>
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
                                      <span id="delbtn{{@$ec->id}}"></span>
                                        <form id="delete-extendedcoverage-{{$ec->id}}"
                                            action="{{ url('master-data/extendedcoverage/destroy', $ec->id) }}"
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
@include('crm.master.extend_coverage_js')
@endsection