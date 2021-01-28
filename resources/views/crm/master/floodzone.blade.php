@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/floodzone/store')}}>
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
                          <label for="">{{__('Flood Zone Name')}}</label>
                          <input type="text" name="name" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Flag Delete')}}</label>
                          <input type="text" name="flagdelete" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                            {{__('Save Flood Zone')}}
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
                    {!! Form::open(array('url'=>'master-data/floodzone')) !!}
                    {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari Flood Zone, ketik lalu tekan enter']) !!}
                    {!! Form::close() !!}
                    <hr> --}}
                  <table id="fzTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Country')}}</th>
                      <th>{{__('State/Province Name')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$floodzone as $floodzonedata)
                            <tr>
                              <td>{{@$floodzonedata->id}}</td>
                              <td>{{@$floodzonedata->name}}</td>
                              <td>{{@$floodzonedata->flag_delete}}</td>
                             
                             
                              <td>
                               
  
                                  
                                <span>
                                 
                                     {{-- @can('update-fz', User::class) --}}
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updatefloodzone{{$floodzonedata->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                      {{-- @endcan   --}}

                                      <div class="modal fade" id="updatefloodzone{{$floodzonedata->id}}" tabindex="-1" user="dialog" aria-labelledby="updatefloodzone{{$floodzonedata->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updatefloodzone{{$floodzonedata->id}}Label">{{__('Update Flood Zone')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/floodzone/update',$floodzonedata->id)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')

                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('name')}}</label>
                                                        <input type="text" name="name" class="form-control" value="{{$floodzonedata->name}}" required/>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Flag Delete')}}</label>
                                                        <input type="text" name="flag_delete" class="form-control" value="{{$floodzonedata->flag_delete}}" required/>
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


                                  {{-- @can('delete-fz', User::class) --}}
                                  

                                  <span id="delbtn{{@$floodzonedata->id}}"></span>
                                
                                    <form id="delete-floodzone-{{$floodzonedata->id}}"
                                        action="{{ url('master-data/floodzone/destroy', $floodzonedata->id) }}"
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

                  {!! $floodzone->render() !!}

                </div>
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.master.floodzone_js')
@endsection