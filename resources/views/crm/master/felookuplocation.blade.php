@extends('crm.layouts.app')

<style type="text/css">    
      #map {
        margin: 10px;
        width: 600px;
        height: 300px;  
        padding: 10px;
      }
</style>

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
               <div class="col-md-6">
                      <div class="form-group">

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Loc Code')}} </label>
                                  <input type="text" name="code" class="form-control form-control-sm" value="{{ $code_felookuplocation }}" readonly required/>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Address')}}</label>
                                  <input type="text" name="address" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                              </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                              <label for="">{{__('Longitude')}}</label>
                                  <input type="text" name="longtitude" id='longitude' class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                          
                              </div>    
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                              <label for="">{{__('Latitude')}}</label>
                                  <input type="text" name="latitude" id="latitude" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                              </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                              <label for="">{{__('Country')}}</label>
                                    <select name="crccountry" id="country" class="e1 form-control form-control-sm ">
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
                                    <select name="province" id="state"  class="e1 form-control form-control-sm ">
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
                                    <select name="cityinsert" id="city" class="e1 form-control form-control-sm ">
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
                                    <select name="eqzone"  class="e1 form-control form-control-sm ">
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
                                    <select name="floodzone"  class="e1 form-control form-control-sm ">
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
                                  <select name="insured" class="e1 form-control form-control-sm ">
                                      <option selected disabled>{{__('Select  Insure Costumer')}}</option>
                                      @foreach($costumer as $costumerdata)
                                      <option value="{{ $costumerdata->id }}">{{ $costumerdata->id }} - {{ $costumerdata->username }} - {{ $costumerdata->company_name }}</option>
                                      @endforeach
                                  </select></div>
                            </div>
                        </div>
                 
                 </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                     
                    <div class="col-md-12">
                       <div id="map"></div>
                    </div>

                  

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
                    {{-- <hr>
                    {!! Form::open(array('url'=>'master-data/felookuplocation')) !!}
                    {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari Fire & Engineering Lookup Location, ketik lalu tekan enter']) !!}
                    {!! Form::close() !!}
                    <hr> --}}
                  <table id="felookupTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Location Code')}}</th>
                      <th>{{__('Address')}}</th>
                      <th>{{__('Country')}}</th>
                      <th>{{__('Province')}}</th>
                      <th>{{__('City')}}</th>
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
                              <td>{{@$location->countryside->id}} - {{@$location->countryside->name}}</td>
                              <td>{{@$location->state->id}} - {{@$location->state->name}}</td>
                              <td>{{@$location->city->id}} - {{@$location->city->name}}</td>
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

                                
                                  @can('update-felookup', User::class)
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updatefelookuplocation{{$location->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan  

                                    <div class="modal fade" id="updatefelookuplocation{{$location->id}}" tabindex="-1" user="dialog" aria-labelledby="updatefelookuplocation{{$location->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updatefelookuplocation{{$location->id}}Label">{{__('Update Fe Lookup Location')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/felookuplocation/update',$location)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Loc Code')}}</label>
                                                      <input type="text" name="loc_code" class="form-control" value="{{$location->loc_code}}" readonly required/>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Address')}}</label>
                                                      <input type="text" name="address" class="form-control" value="{{$location->address}}" required/>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  
                                                  <div class="col-md-6 col-md-6">
                                                    <div class="form-group">
                                                      <label for="">{{__('Longtitude')}}</label>
                                                      <input type="text" name="longtitude" class="form-control" value="{{$location->longtitude}}" required/>
                                                    </div>
                                                  </div>
                                                  
                                                  <div class="col-md-6 col-md-6">
                                                    <div class="form-group">
                                                      <label for="">{{__('Latitude')}}</label>
                                                      <input type="text" name="latitude" class="form-control" value="{{$location->latitude}}" required/>
                                                    </div>
                                                  </div>

                                                </div>

                                                

                                                <div class="row">
                                                  <div class="col-md-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('Country')}}</label><br>
                                                        <select name="country_id" id="country2" class="form-control form-control-sm e1">
                                                            <option selected disabled>{{__('Select State')}}</option>
                                                            @foreach($country as $cty)
                                                            @if($location->country_id  == $cty->id)
                                                            <option value="{{ $cty->id }}" selected>{{ $cty->id }} - {{ $cty->name }}</option>
                                                            @else
                                                            <option value="{{  $cty->id }}">{{  $cty->id  }} - {{ $cty->name }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                  </div>
                                                  
                                                  <div class="col-md-6 col-md-6">
                                                    <div class="form-group">
                                                      <label for="">{{__('Postal Code')}}</label>
                                                      <input type="text" name="postal_code" class="form-control" value="{{$location->postal_code}}" required/>
                                                    </div>
                                                  </div>
                                                </div>

                                                
                                                <div class="row">
                                                  <div class="col-md-6 col-md-6">
                                                      <div class="form-group">
                                                          <label for="">{{__('State/Province')}}</label><br>
                                                          <select name="province_id" id="state2" class="form-control form-control-sm e1">
                                                              <option selected disabled>{{__('Select State')}}</option>
                                                              @foreach($state as $statedata)
                                                              @if($location->province_id  == $statedata->id)
                                                              <option value="{{ $statedata->id }}" selected>{{ $statedata->id }} - {{ $statedata->name }}</option>
                                                              @else
                                                              <option value="{{  $statedata->id }}">{{  $statedata->id  }} - {{ $statedata->name }}</option>
                                                              @endif
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>

                                                  <div class="col-md-6 col-md-6">
                                                      <div class="form-group">
                                                          <label for="">{{__('City ')}}</label><br>
                                                          <select name="city_id" id="city2" class="form-control form-control-sm e1">
                                                              <option selected disabled>{{__('Select City')}}</option>
                                                              @foreach($country as $citydata)
                                                              @if($location->city_id  == $citydata->id)
                                                              <option value="{{ $citydata->id }}" selected>{{ $citydata->id }} - {{ $citydata->name }}</option>
                                                              @else
                                                              <option value="{{  $citydata->id }}">{{  $citydata->id  }} - {{ $citydata->name }}</option>
                                                              @endif
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-6 col-md-6">
                                                      <div class="form-group">
                                                          <label for="">{{__('EQ ZONE')}}</label><br>
                                                          <select name="eq_zone" class="form-control form-control-sm e1">
                                                              <option selected disabled>{{__('Select EarthQuake Zone')}}</option>
                                                              @foreach($earthquakezone as $zone)
                                                              @if($location->eq_zone  == $zone->id)
                                                              <option value="{{ $zone->id }}" selected>{{ $zone->id }} - {{ $zone->name }}</option>
                                                              @else
                                                              <option value="{{  $zone->id }}">{{  $zone->id  }} - {{ $zone->name }}</option>
                                                              @endif
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>

                                                  <div class="col-md-6 col-md-6">
                                                      <div class="form-group">
                                                          <label for="">{{__('FLOOD ZONE ')}}</label><br>
                                                          <select name="flood_zone" class="form-control form-control-sm e1">
                                                              <option selected disabled>{{__('Select Flood Zone')}}</option>
                                                              @foreach($floodzone as $zone)
                                                              @if($location->flood_zone  == $zone->id)
                                                              <option value="{{ $zone->id }}" selected>{{ $zone->id }} - {{ $zone->name }}</option>
                                                              @else
                                                              <option value="{{  $zone->id }}">{{  $zone->id  }} - {{ $zone->name }}</option>
                                                              @endif
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Insured')}}</label><br>
                                                      <select name="insured" class="form-control form-control-sm e1">
                                                              <option selected disabled>{{__('Select Insured')}}</option>
                                                              @foreach($costumer as $zone)
                                                              @if($location->insured  == $zone->id)
                                                              <option value="{{ $zone->id }}" selected>{{ $zone->id }} - {{ $zone->username }}  - {{ $zone->company_name }}</option>
                                                              @else
                                                              <option value="{{  $zone->id }}">{{  $zone->id  }}  - {{ $zone->username }}  - {{ $zone->company_name }}</option>
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

                                @can('delete-felookup', User::class)

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

                  {!! $felookuplocation->render() !!}

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