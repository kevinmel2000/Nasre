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
                        @foreach (@$floodzone as $floodzonedata)
                            <tr>
                              <td>{{@$floodzonedata->id}}</td>
                              <td>{{@$floodzonedata->name}}</td>
                              <td>{{@$floodzonedata->flag_delete}}</td>
                             
                             
                              <td>
                               
                                <span>
                                   {{-- @can('update-floodzone', User::class) --}}
                                    <a class="text-primary mr-3" href="{{url('master-data/floodzone/edit',$floodzonedata->id)}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- @endcan   --}}

                                  {{-- @can('delete-floodzone', User::class) --}}

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