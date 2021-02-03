@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/deductibletype/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Deductible Type Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__(' Code')}} </label>
                          <input type="text" name="dtcode" class="form-control form-control-sm" data-validation="length" data-validation-length="1-12" value="{{ $code_dt }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Abbreviation')}}</label>
                          <input type="text" name="dtabbreviation" class="form-control form-control-sm " data-validation="length" data-validation-length="1-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('Description')}}</label>
                        <input type="text" name="dtdescription" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" required/>
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
                            {{__('Save Deductible Type')}}
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
                    <table id="deductibletypeTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Abbreviation')}}</th>
                        <th>{{__('Description')}}</th>
                        <th width="20%">{{__('Actions')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach (@$deductibletype as $dt)
                              <tr>
                                <td>{{@$dt->code}}</td>
                                <td>{{@$dt->abbreviation}}</td>
                                <td>{{@$dt->description}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$dt->created_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$dt->updated_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    {{-- @can('update-construction', User::class) --}}
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updatedeductibletype{{$dt->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    {{-- @endcan --}}
  
                                    <div class="modal fade" id="updatedeductibletype{{$dt->id}}" tabindex="-1" user="dialog" aria-labelledby="updatedeductibletype{{$dt->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updatedeductibletype{{$dt->id}}Label">{{__('Update Deductible Type')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/deductibletype',$dt)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')
                                                  <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Code')}}</label>
                                                        <input type="text" name="codedt" class="form-control" value="{{$dt->code}}" data-validation="length" data-validation-length="1-12" readonly="readonly" required/>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Abbreviation')}}</label>
                                                        <input type="text" name="abbreviationdt" class="form-control" value="{{$dt->abbreviation}}" data-validation="length" data-validation-length="1-50" required />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Description')}}</label>
                                                        <input type="text" name="descriptiondt" class="form-control" value="{{$dt->description}}" data-validation="length" data-validation-length="0-50" required />
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
                                      <span id="delbtn{{@$dt->id}}"></span>
                                        <form id="delete-deductibletype-{{$dt->id}}"
                                            action="{{ url('master-data/deductibletype/destroy', $dt->id) }}"
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
@include('crm.master.deductible_type_js')
@endsection