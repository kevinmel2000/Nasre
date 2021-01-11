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
                          <input type="text" name="code" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
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
                  <table id="countryTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Golf field')}}</th>
                      <th>{{__('Hole Number')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$golffieldhole as $golf)
                            <tr>
                              <td>{{@$golf->id}}</td>
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
                                {{-- @can('update-golffieldhole', User::class) --}}

                                    <a class="text-primary mr-3" href="{{url('master-data/golffieldhole/edit',$golf->id)}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- @endcan   --}}

                                  {{-- @can('delete-golffieldhole', User::class) --}}

                                  <span id="delbtn{{@$golf->id}}"></span>
                                
                                    <form id="delete-golf-{{$golf->id}}"
                                        action="{{ url('master-data/golffieldhole/destroy', $golf->id) }}"
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
@include('crm.master.golffieldhole_js')
@endsection