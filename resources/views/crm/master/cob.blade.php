@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/cob/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New COB Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" name="cobcode" class="form-control form-control-sm" data-validation="length" data-validation-length="1-12" value="{{ $code_cob }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Description')}}</label>
                          <input type="text" name="cobdescription" class="form-control form-control-sm " data-validation="length" data-validation-length="2-150" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Abbreviation')}}</label>
                          <input type="text" name="cobabbreviation" class="form-control form-control-sm " data-validation="length" data-validation-length="2-20" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Remarks')}}</label>
                          <textarea name="cobremarks" class="form-control form-control-sm " rows="3" data-validation="length" data-validation-length="2-350" required></textarea>
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
                            {{__('Save COB')}}
                        </button>
                    </div>
                   
                </div>
            </div>
        </div> 
        
        
    </form>

    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
              <div class="table-responsive">
                <table id="cobTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{__('Code')}}</th>
                    <th>{{__('Description')}}</th>
                    <th>{{__('Abbreviation')}}</th>
                    <th>{{__('Remarks')}}</th>
                    <th width="20%">{{__('Actions')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach (@$cob as $boc)
                          <tr>
                            <td>{{@$boc->code}}</td>
                            <td>{{@$boc->description}}</td>
                            <td>{{@$boc->abbreviation}}</td>
                            <td>{{@$boc->remarks}}</td>
                            <td>
                              <a href="#" data-toggle="tooltip" data-title="{{$boc->created_at->toDayDateTimeString()}}" class="mr-3">
                                <i class="fas fa-clock text-info"></i>
                              </a>
                              <a href="#" data-toggle="tooltip" data-title="{{$boc->updated_at->toDayDateTimeString()}}" class="mr-3">
                                <i class="fas fa-history text-primary"></i>
                              </a>
                              <span>
                                {{-- @can('update-country', User::class) --}}
                                  <a class="text-primary mr-3" data-toggle="modal" data-target="#updatecob{{$boc->id}}">
                                    <i class="fas fa-edit"></i>
                                  </a>
                                {{-- @endcan --}}

                                <div class="modal fade" id="updatecob{{$boc->id}}" tabindex="-1" user="dialog" aria-labelledby="updatecob{{$boc->id}}Label" aria-hidden="true">
                                  <div class="modal-dialog" user="document">
                                    <div class="modal-content bg-light-gray">
                                      <div class="modal-header bg-gray">
                                        <h5 class="modal-title" id="updatecob{{$boc->id}}Label">{{__('Update COB')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form action="{{url('master-data/cob',$boc)}}" method="POST">
                                          <div class="modal-body">
                                              @csrf
                                              @method('PUT')
                                              <div class="row">
                                                <div class="col-md-6 col-md-12">
                                                  <div class="form-group">
                                                    <label for="">{{__('Code')}}</label>
                                                    <input type="text" name="codecob" class="form-control" value="{{$boc->code}}" data-validation="length" data-validation-length="1-5" required disabled/>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-4 col-md-12">
                                                  <div class="form-group">
                                                    <label for="">{{__('Description')}}</label>
                                                    <input type="text" name="descriptioncob" class="form-control" value="{{$boc->description}}" data-validation="length" data-validation-length="2-150" required/>
                                                  </div>
                                                </div>
                                                <div class="col-md-4 col-md-12">
                                                  <div class="form-group">
                                                    <label for="">{{__('Abbreviation')}}</label>
                                                    <input type="text" name="abbreviationcob" class="form-control" value="{{$boc->abbreviation}}" data-validation="length" data-validation-length="2-150" required/>
                                                  </div>
                                                </div>
                                                <div class="col-md-4 col-md-12">
                                                  <div class="form-group">
                                                    <label for="">{{__('Remarks')}}</label>
                                                    <textarea name="remarkscob" class="form-control" value="{{$boc->remarks}}" data-validation="length" data-validation-length="2-350" required>{{$boc->remarks}}</textarea>
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

                                <span id="delbtn{{@$boc->id}}"></span>
                              
                                  <form id="delete-cob-{{$boc->id}}"
                                      action="{{ url('master-data/cob/destroy', $boc->id) }}"
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
@include('crm.master.cob_js')
@endsection