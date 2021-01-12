@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/city/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Master City Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Name')}} </label>
                          <input type="text" name="name" class="form-control form-control-sm" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('State')}} </label>
                          <select name="state" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select State')}}</option>
                              @foreach($state as $statedata)
                              <option value="{{ $statedata->id }}">{{ $statedata->id }} - {{ $statedata->name }}</option>
                              @endforeach
                          </select> </div>
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
                            {{__('Save City')}}
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
                      <th>{{__('State')}}</th>
                      <th>{{__('City Name')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$city as $citydata)
                            <tr>
                              <td>{{@$citydata->id}}</td>
                              <td>{{@$citydata->state->id}} - {{@$citydata->state->name}}</td>
                              <td>{{@$citydata->name}}</td>
                             
                              <td>
                               
                                <span>
                                   {{-- @can('update-city', User::class) --}}
                                    <a class="text-primary mr-3" href="{{url('master-data/city/edit',$citydata->id)}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- @endcan   --}}

                                  {{-- @can('delete-city', User::class) --}}

                                  <span id="delbtn{{@$citydata->id}}"></span>
                                
                                    <form id="delete-city-{{$citydata->id}}"
                                        action="{{ url('master-data/city/destroy', $citydata->id) }}"
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

                  {!! $city->render() !!}

                </div>
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.master.city_js')
@endsection