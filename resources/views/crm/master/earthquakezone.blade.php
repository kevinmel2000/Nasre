@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/earthquakezone/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Master Earthquake Zone Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
              
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('Enter Code')}} </label>
                        <input type="text" name="ezcode" style="width: 25%;" class="form-control form-control-sm" value="{{$code_eqz}}" readonly="readonly"  required/>
                    </div>
                  </div>
                </div>

              <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Earthquake Zone Name')}}</label>
                          <input type="text" name="ezname" class="form-control form-control-sm " data-validation="length" data-validation-length="0-150"/>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('Country')}}</label>
                        <select name="ezcountry" id="e1" class="e1 form-control form-control-sm ">
                            <option selected disabled>{{__('Select Country')}}</option>
                            @foreach($country as $cty)
                            <option value="{{ $cty->id }}">{{ $cty->id }} - {{ $cty->name }}</option>
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
                            {{__('Save EarthQuake Zone')}}
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
                    {!! Form::open(array('url'=>'master-data/earthquakezone')) !!}
                    {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari EearthQuake Zone, ketik lalu tekan enter']) !!}
                    {!! Form::close() !!}
                    <hr> --}}
                  <table id="eqzTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Code')}}</th>
                      <th>{{__('EarthQuake Zone ')}}</th>
                      <th>{{__('Country ')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$earthquakezone as $earthquakezonedata)
                            <tr>
                              <td>{{@$earthquakezonedata->code}}</td>
                              <td>{{@$earthquakezonedata->name}}</td>
                              <td>{{@$earthquakezonedata->country->name}}</td>
                             
                              <td>
                               
                                <span>
                                    

                                      {{-- @can('update-eqz', User::class) --}}
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updateearthquakezone{{$earthquakezonedata->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                      {{-- @endcan   --}}

                                      <div class="modal fade" id="updateearthquakezone{{$earthquakezonedata->id}}" tabindex="-1" user="dialog" aria-labelledby="updateearthquakezone{{$earthquakezonedata->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updateearthquakezone{{$earthquakezonedata->id}}Label">{{__('Update EarthQuake Zone')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/earthquakezone/update',$earthquakezonedata->id)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')

                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Code')}}</label>
                                                        <input type="text" name="codeez" class="form-control" value="{{$earthquakezonedata->code}}" required readonly/>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('name')}}</label>
                                                        <input type="text" name="nameez" class="form-control" value="{{$earthquakezonedata->name}}"/>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                          <label for="">{{__('State')}}</label><br>
                                                          <select name="countryez" class="form-control form-control-sm e1">
                                                              <option selected disabled>{{__('Select State')}}</option>
                                                              @foreach($country as $cty)
                                                              @if($earthquakezonedata->country_id  == $cty->id)
                                                              <option value="{{ $cty->id }}" selected>{{ $cty->id }} - {{ $cty->name }}</option>
                                                              @else
                                                              <option value="{{  $cty->id }}">{{  $cty->id  }} - {{ $cty->name }}</option>
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

                                  {{-- @can('delete-eqz', User::class) --}}

                                  <span id="delbtn{{@$earthquakezonedata->id}}"></span>
                                
                                    <form id="delete-earthquakezone-{{$earthquakezonedata->id}}"
                                        action="{{ url('master-data/earthquakezone/destroy', $earthquakezonedata->id) }}"
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

                  {!! $earthquakezone->render() !!}

                </div>
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.master.earthquakezone_js')
@endsection