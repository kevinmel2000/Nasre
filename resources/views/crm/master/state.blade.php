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
                          <label for="">{{__('Enter State Name')}} </label>
                          <input type="text" name="name" class="form-control form-control-sm" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Country')}}</label>
                          <select name="crccountry" id="e1" class="e1 form-control form-control-sm ">
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
                    {{-- <hr>
                    {!! Form::open(array('url'=>'master-data/state')) !!}
                    {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari Province/State, ketik lalu tekan enter']) !!}
                    {!! Form::close() !!}
                    <hr> --}}
                  <table id="stateTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Country')}}</th>
                      <th>{{__('State/Province Name')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$state as $statedata)
                            <tr>
                              <td>{{@$statedata->country->id}} - {{@$statedata->country->name}}</td>
                              <td>{{@$statedata->name}}</td>
                             
                              <td>
                               
                                <span>
                                    @can('update-state', User::class)
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updatestate{{$statedata->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan  

                                    


                                  @can('delete-state', User::class)

                                  <span id="delbtn{{@$statedata->id}}"></span>
                                
                                    <form id="delete-state-{{$statedata->id}}"
                                        action="{{ url('master-data/state/destroy', $statedata->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>

                                   @endcan  
                                </span>
                              </td>

                            </tr>

                            <div class="modal fade" id="updatestate{{$statedata->id}}" tabindex="-1" user="dialog" aria-labelledby="updatestate{{$statedata->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog" user="document">
                                          <div class="modal-content bg-light-gray">
                                            <div class="modal-header bg-gray">
                                              <h5 class="modal-title" id="updatestate{{$statedata->id}}Label">{{__('Update State')}}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <form action="{{url('master-data/state/update',$statedata)}}" method="POST">
                                                <div class="modal-body">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                      <div class="col-md-6 col-md-12">
                                                        <div class="form-group">
                                                          <label for="">{{__('name')}}</label>
                                                          <input type="text" name="namestate" class="form-control" value="{{$statedata->name}}" required/>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    
                                                    <div class="col-md-4 col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('State')}}</label><br>
                                                            <select name="crccountrystate" class="form-control form-control-sm e1">
                                                                <option selected disabled>{{__('Select State')}}</option>
                                                                @foreach($country as $cty)
                                                                @if($statedata->country_id  == $cty->id)
                                                                <option value="{{ $cty->id }}" selected>{{ $cty->id }} - {{ $cty->name }}</option>
                                                                @else
                                                                <option value="{{  $cty->id }}">{{  $cty->id  }} - {{ $cty->name }}</option>
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
                        @endforeach
                    </tbody>
                    
                  </table>

                  {{-- {!! $state->render() !!} --}}

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