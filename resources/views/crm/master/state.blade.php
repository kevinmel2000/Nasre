@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/state/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Master State/Province Data')}}
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
                          <label for="">{{__('Description')}}</label>
                          <input type="text" name="description" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Abbreviation')}}</label>
                          <input type="text" name="abbreviation" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                            {{__('Save State/Province')}}
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
                      <th>{{__('Country')}}</th>
                      <th>{{__('State/Province Name')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$state as $statedata)
                            <tr>
                              <td>{{@$statedata->id}}</td>
                              <td>{{@$statedata->country_id}}</td>
                              <td>{{@$statedata->name}}</td>
                             
                              <td>
                               
                                <span>
                                   {{-- @can('update-city', User::class) --}}
                                    <a class="text-primary mr-3" href="{{url('master-data/state/edit',$statedata->id)}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- @endcan   --}}

                                  {{-- @can('delete-city', User::class) --}}

                                  <span id="delbtn{{@$statedata->id}}"></span>
                                
                                    <form id="delete-city-{{$statedata->id}}"
                                        action="{{ url('master-data/state/destroy', $statedata->id) }}"
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
@include('crm.master.state_js')
@endsection