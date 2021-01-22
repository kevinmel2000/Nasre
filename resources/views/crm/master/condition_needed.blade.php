@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/conditionneeded/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Condition Needed Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" name="cdncode" class="form-control form-control-sm" data-validation="length" data-validation-length="2-12" value="{{ $code_cdn }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Name')}}</label>
                          <input type="text" name="cdnname" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Information')}}</label>
                          <input type="text" name="cdninfo" class="form-control form-control-sm " data-validation="length" data-validation-length="2-100" required/>
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
                            {{__('Save Condition Needed')}}
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
                    <table id="cdnTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Information')}}</th>
                        <th width="20%">{{__('Actions')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach (@$cdn as $ndc)
                              <tr>
                                <td>{{@$ndc->id}}</td>
                                <td>{{@$ndc->code}}</td>
                                <td>{{@$ndc->name}}</td>
                                <td>{{@$ndc->information}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$ndc->created_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$ndc->updated_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    @can('update-condition_needed', User::class)
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updateconditionneeded{{$ndc->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    @endcan
  
                                    <div class="modal fade" id="updateconditionneeded{{$ndc->id}}" tabindex="-1" user="dialog" aria-labelledby="updateconditionneeded{{$ndc->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updateconditionneeded{{$ndc->id}}Label">{{__('Update Condition Needed')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/conditionneeded',$ndc)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')
                                                  <div class="row">
                                                    <div class="col-md-4 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Code')}}</label>
                                                        <input type="text" name="codecdn" class="form-control" value="{{$ndc->code}}" data-validation="length" data-validation-length="2-12" readonly="readonly" required/>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Name')}}</label>
                                                        <input type="text" name="namecdn" class="form-control" value="{{$ndc->name}}" data-validation="length" data-validation-length="2-50" required />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Information')}}</label>
                                                        <input type="text" name="infocdn" class="form-control" value="{{$ndc->information}}" data-validation="length" data-validation-length="2-100" required />
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
  
                                    @can('delete-condition_needed', User::class)
                                      <span id="delbtn{{@$ndc->id}}"></span>
                                        <form id="delete-conditionneeded-{{$ndc->id}}"
                                            action="{{ url('master-data/conditionneeded/destroy', $ndc->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                      </span>
                                  @endcan  
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
@include('crm.master.condition_needed_js')
@endsection