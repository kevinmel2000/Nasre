@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/construction/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Construction Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" name="crcode" class="form-control form-control-sm" data-validation="length" data-validation-length="2-12" value="{{ $code_cr }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Construction Name')}}</label>
                          <input type="text" name="crname" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                            {{__('Save Construction')}}
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
                  <div class="table-responsive">
                    <table id="constructionTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Name')}}</th>
                        <th width="20%">{{__('Actions')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach (@$construction as $cr)
                              <tr>
                                <td>{{@$cr->id}}</td>
                                <td>{{@$cr->code}}</td>
                                <td>{{@$cr->name}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$cr->created_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$cr->updated_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    @can('update-construction', User::class)
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updateconstruction{{$cr->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    @endcan
  
                                    <div class="modal fade" id="updateconstruction{{$cr->id}}" tabindex="-1" user="dialog" aria-labelledby="updateconstruction{{$cr->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updateconstruction{{$cr->id}}Label">{{__('Update Construction')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/construction',$cr)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')
                                                  <div class="row">
                                                    <div class="col-md-4 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Code')}}</label>
                                                        <input type="text" name="codecr" class="form-control" value="{{$cr->code}}" data-validation="length" data-validation-length="2-12" readonly="readonly" required/>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Name')}}</label>
                                                        <input type="text" name="namecr" class="form-control" value="{{$cr->name}}" data-validation="length" data-validation-length="2-50" required />
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
  
                                    @can('delete-country', User::class)
                                      <span id="delbtn{{@$cr->id}}"></span>
                                        <form id="delete-construction-{{$cr->id}}"
                                            action="{{ url('master-data/construction/destroy', $cr->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                      </span>
                                  @endcan  
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
  </div>
@endsection

@section('scripts')
@include('crm.master.construction_js')
@endsection