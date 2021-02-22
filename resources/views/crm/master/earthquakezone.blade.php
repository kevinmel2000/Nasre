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
                          <label for="">{{__('Earthquake Zone Name')}}</label>
                          <input type="text" name="name" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Flag Delete')}}</label>
                          <input type="text" name="flagdelete" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div> --}}
                
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
                      <th>{{__('ID')}}</th>
                      <th>{{__('EarthQuake Zone ')}}</th>
                      {{-- <th>{{__('Flag Delete ')}}</th> --}}
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$earthquakezone as $earthquakezonedata)
                            <tr>
                              <td>{{@$earthquakezonedata->id}}</td>
                              <td>{{@$earthquakezonedata->name}}</td>
                              {{-- <td>{{@$earthquakezonedata->flag_delete}}</td> --}}
                             
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
                                                        <label for="">{{__('name')}}</label>
                                                        <input type="text" name="name" class="form-control" value="{{$earthquakezonedata->name}}" required/>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  
                                                  {{-- <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Flag Delete')}}</label>
                                                        <input type="text" name="flag_delete" class="form-control" value="{{$earthquakezonedata->flag_delete}}" required/>
                                                      </div>
                                                    </div>
                                                  </div> --}}

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
                                
                                    <form id="delete-state-{{$earthquakezonedata->id}}"
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