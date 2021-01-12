@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/felookuplocation/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New FIRE & ENGINEERING LOOKUP - LOCATION Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Loc Code')}} </label>
                          <input type="text" name="code" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Address')}}</label>
                          <input type="text" name="Address" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="">{{__('Longitude')}}</label>
                          <input type="text" name="longitude" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                  
                      </div>    
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="">{{__('Latitude')}}</label>
                          <input type="text" name="latitude" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="">{{__('Country')}}</label>
                            <select name="crccountry" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Country')}}</option>
                              @foreach($country as $cty)
                              <option value="{{ $cty->id }}">{{ $cty->id }} - {{ $cty->name }}</option>
                              @endforeach
                          </select>
                      </div>    
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="">{{__('Postal Code')}}</label>
                          <input type="text" name="postal_code" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="">{{__('Province')}}</label>
                            <select name="province" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Province')}}</option>
                              @foreach($country as $statedata)
                              <option value="{{ $statedata->id }}">{{ $statedata->id }} - {{ $statedata->name }}</option>
                              @endforeach
                          </select>
                      </div>    
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="">{{__('Cities')}}</label>
                            <select name="city" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Cities')}}</option>
                              @foreach($country as $citydata)
                              <option value="{{ $citydata->id }}">{{ $citydata->id }} - {{ $citydata->name }}</option>
                              @endforeach
                          </select>
                      </div>     
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="">{{__('EQ Zone')}}</label>
                            <select name="eqzone" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select EQ Zone')}}</option>
                              @foreach($earthquakezone as $earthquakezonedata)
                              <option value="{{ $earthquakezonedata->id }}">{{ $earthquakezonedata->id }} - {{ $earthquakezonedata->name }}</option>
                              @endforeach
                          </select>
                      </div>    
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="">{{__('Flood Zone')}}</label>
                            <select name="floodzone" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Flood Zone')}}</option>
                              @foreach($floodzone as $floodzonedata)
                              <option value="{{ $floodzonedata->id }}">{{ $floodzonedata->id }} - {{ $floodzonedata->name }}</option>
                              @endforeach
                          </select>
                      </div>     
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Insured')}}</label>
                          <input type="text" name="insured" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                            {{__('SAVE FIRE & ENGINEERING LOOKUP LOCATION')}}
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
                      <th>{{__('Location Code')}}</th>
                      <th>{{__('Address')}}</th>
                      <th>{{__('City')}}</th>
                      <th>{{__('Province')}}</th>
                      <th>{{__('Postal Code')}}</th>
                      <th>{{__('Insured')}}</th>
                      <th>{{__('EQ Zone')}}</th>
                      <th>{{__('Flood Zone')}}</th>
                      <th>{{__('Latitude')}}</th>
                      <th>{{__('Longitude')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$felookuplocation as $location)
                            <tr>
                              <td>{{@$location->loc_code}}</td>
                              <td>{{@$location->address}}</td>
                              <td>{{@$location->city_id}}</td>
                              <td>{{@$location->province_id}}</td>
                              <td>{{@$location->postal_code }}</td>
                              <td>{{@$location->insured}}</td>
                              <td>{{@$location->eq_zone}}</td>
                              <td>{{@$location->flood_zone}}</td>
                              <td>{{@$location->latitude}}</td>
                              <td>{{@$location->longtitude}}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$location->created_at}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$location->updated_at}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>

                                  @can('update-country', User::class)
                                    <a class="text-primary mr-3" href="{{url('master-data/felookuplocation/edit',$location->id)}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                  @endcan

                                  @can('delete-country', User::class)

                                  <span id="delbtn{{@$location->id}}"></span>
                                
                                    <form id="delete-felookuplocation-{{$location->id}}"
                                        action="{{ url('master-data/felookuplocation/destroy', $location->id) }}"
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
@include('crm.master.felookuplocation_js')
@endsection