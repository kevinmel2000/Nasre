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
                          <select name="state" class="e1 form-control form-control-sm ">
                              <option selected disabled>{{__('Select State')}}</option>
                              @foreach($state as $statedata)
                                <option value="{{ $statedata->id }}">{{ $statedata->id }} - {{ $statedata->name }}</option>
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
                    {{-- <hr>
                    {!! Form::open(array('url'=>'master-data/city')) !!}
                    {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari City, ketik lalu tekan enter']) !!}
                    {!! Form::close() !!}
                    <hr> --}}
                  <table id="cityTable" class="table table-bordered table-striped">
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

                                    @can('update-city', User::class)
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updatecity{{$citydata->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan  

                                    <div class="modal fade" id="updatecity{{$citydata->id}}" tabindex="-1" user="dialog" aria-labelledby="updatekoc{{$citydata->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updatecity{{$citydata->id}}Label">{{__('Update City')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/city/update',$citydata)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('name')}}</label>
                                                      <input type="text" name="namecity" class="form-control" value="{{$citydata->name}}" required/>
                                                    </div>
                                                  </div>
                                                </div>

                                                
                                                <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('State')}}</label><br>
                                                        <select name="statecity" class="form-control form-control-sm e1">
                                                            <option selected disabled>{{__('Select State')}}</option>
                                                            @foreach($state as $statedata)
                                                              @if($citydata->state_id  == $statedata->id)
                                                                <option value="{{ $statedata->id }}" selected>{{ $statedata->id }} - {{ $statedata->name }}</option>
                                                              @else
                                                                <option value="{{  $statedata->id }}">{{  $statedata->id  }} - {{ $statedata->name }}</option>
                                                              @endif
                                                            @endforeach
                                                        </select>
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

                                  @can('delete-city', User::class)

                                  <span id="delbtn{{@$citydata->id}}"></span>
                                
                                    <form id="delete-city-{{$citydata->id}}"
                                        action="{{ url('master-data/city/destroy', $citydata->id) }}"
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