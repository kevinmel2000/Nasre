@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/golffieldhole/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Golf Field Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" name="code" style="width: 25%;" class="form-control form-control-sm" value="{{ $code_gfh }}" readonly required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Golf Field')}}</label>
                          <input type="text" name="golffield" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Hole Number')}}</label>
                          <input type="text" name="holenumber" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                            {{__('Save Golf Field')}}
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
                  <table id="golffieldholeTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Golf field')}}</th>
                      <th>{{__('Hole Number')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$golffieldhole as $golf)
                            <tr>
                              <td>{{@$golf->code}}</td>
                              <td>{{@$golf->golf_field}}</td>
                              <td>{{@$golf->hole_number}}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$golf->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$golf->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                   
                                   
                                    @can('update-gfh', User::class)
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updategolffieldhole{{$golf->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan  

                                    <div class="modal fade" id="updategolffieldhole{{$golf->id}}" tabindex="-1" user="dialog" aria-labelledby="updategolffieldhole{{$golf->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updategolffieldhole{{$golf->id}}Label">{{__('Update Golf Field Hole')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/golffieldhole/update',$golf)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Code')}}</label>
                                                      <input type="text" name="codegolf" class="form-control" value="{{$golf->code}}" required readonly/>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Golf Field')}}</label>
                                                      <input type="text" name="golffieldgolf" class="form-control" value="{{$golf->golf_field}}" data-validation="length" data-validation-length="2-150" required/>
                                                    </div>
                                                  </div>

                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Hole Number ')}}</label>
                                                      <input type="text" name="holenumbergolf" class="form-control" value="{{$golf->hole_number}}" data-validation="length" data-validation-length="2-150" required/>
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


                                  @can('delete-gfh', User::class)

                                  <span id="delbtn{{@$golf->id}}"></span>
                                
                                    <form id="delete-golf-{{$golf->id}}"
                                        action="{{ url('master-data/golffieldhole/destroy', $golf->id) }}"
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
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.master.golffieldhole_js')
@endsection