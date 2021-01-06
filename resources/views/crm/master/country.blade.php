@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/country/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Country Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" name="countrycode" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Country Name')}}</label>
                          <input type="text" name="countryname" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Continent')}}</label>
                          <select name="continent" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Continent')}}</option>
                              <option value="AF">Africa</option>
                              <option value="AN">Antartica</option>
                              <option value="AS">Asia</option>
                              <option value="EU">Europa</option>
                              <option value="NA">North America </option>
                              <option value="OC">Oceania</option>
                              <option value="SA">South America</option>
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
                            {{__('Save Country')}}
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
                      <th>{{__('Name')}}</th>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Continent')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$country as $cty)
                            <tr>
                              <td>{{@$cty->id}}</td>
                              <td>{{@$cty->name}}</td>
                              <td>{{@$cty->code}}</td>
                              <td>@if(@$cty->continent == "AF")Africa 
                                  @elseif(@$cty->continent == "AN")Antartica
                                  @elseif(@$cty->continent == "AS")Asia
                                  @elseif(@$cty->continent == "EU")Europa
                                  @elseif(@$cty->continent == "NA")North America
                                  @elseif(@$cty->continent == "OC")Oceania
                                  @elseif(@$cty->continent == "SA")South America
                                  @endif
                              </td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$cty->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$cty->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                  {{-- @can('update-country', User::class) --}}
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updateuser{{$cty->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                  {{-- @endcan --}}

                                  <div class="modal fade" id="updatecountry{{$cty->id}}" tabindex="-1" user="dialog" aria-labelledby="updatecountry{{$cty->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updateuser{{$cty->id}}Label">{{__('Update Country')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('user',$cty)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Name')}}</label>
                                                      <input type="text" name="namecountry" class="form-control" value="{{$cty->name}}" data-validation="length" data-validation-length="2-20" required />
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Code')}}</label>
                                                      <input type="text" name="codecountry" class="form-control" value="{{$cty->code}}"/>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Continent')}}</label>
                                                      <select name="continentcountry" class="form-control">
                                                        {{-- @foreach ($roles as $role)
                                                            @if ($role->id == $user->role_id)
                                                              <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                                            @else 
                                                              <option value="{{$role->id}}">{{$role->name}}</option>  
                                                            @endif
                                                              
                                                        @endforeach --}}
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

                                  <span id="delbtn{{@$cty->id}}"></span>
                                
                                    <form id="delete-country-{{$cty->id}}"
                                        action="{{ url('master-data/country/destroy', $cty->id) }}"
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
@include('crm.master.country_js')
@endsection