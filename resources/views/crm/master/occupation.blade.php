@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/occupation/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Occupation Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Code')}} </label>
                          <input type="text" name="ocpcode" class="form-control form-control-sm" data-validation="length" data-validation-length="1-5" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Description')}}</label>
                          <input type="text" name="ocpdescription" class="form-control form-control-sm " data-validation="length" data-validation-length="2-150" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Abbreviation')}}</label>
                          <input type="text" name="ocpabbreviation" class="form-control form-control-sm " data-validation="length" data-validation-length="2-20" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Group Type')}}</label>
                          <input type="text" name="ocpgrouptype" class="form-control form-control-sm " rows="3" data-validation="length" data-validation-length="2-350" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('COB')}}</label>
                          <select name="ocpcob" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select COB')}}</option>
                              @foreach($cob as $cco)
                              <option value="{{ $cco->id }}">{{ $cco->code }} - {{ $cco->description }}</option>
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
                            {{__('Save Occupation')}}
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
                  <table id="ocpTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Description')}}</th>
                      <th>{{__('Abbreviation')}}</th>
                      <th>{{__('Group Type')}}</th>
                      <th>{{__('COB')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$occupation as $ocp)
                            <tr>
                              <td>{{@$ocp->code}}</td>
                              <td>{{@$ocp->description}}</td>
                              <td>{{@$ocp->abbreviation}}</td>
                              <td>{{@$ocp->group_type}}</td>
                              <td>{{@$ocp->cobs->code}} - {{@$ocp->cobs->description}}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$ocp->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$ocp->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                  {{-- @can('update-country', User::class) --}}
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updateocp{{$ocp->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                  {{-- @endcan --}}

                                  <div class="modal fade" id="updateocp{{$ocp->id}}" tabindex="-1" user="dialog" aria-labelledby="updateocp{{$ocp->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updateocp{{$ocp->id}}Label">{{__('Update Occupation')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/occupation',$ocp)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Code')}}</label>
                                                      <input type="text" name="codeocp" class="form-control" value="{{$ocp->code}}" data-validation="length" data-validation-length="1-5" required disabled/>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Description')}}</label>
                                                      <input type="text" name="descriptionocp" class="form-control" value="{{$ocp->description}}" data-validation="length" data-validation-length="2-150" required/>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Abbreviation')}}</label>
                                                      <input type="text" name="abbreviationocp" class="form-control" value="{{$ocp->abbreviation}}" data-validation="length" data-validation-length="2-150" required/>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Group Type')}}</label>
                                                      <input type="text" name="grouptypeocp" class="form-control" value="{{$ocp->group_type}}" data-validation="length" data-validation-length="2-350" required/>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('COB')}}</label>
                                                        <select name="cobocp" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('Select COB')}}</option>
                                                            @foreach($cob as $cco)
                                                            @if($ocp->cob  == $cco->id)
                                                            <option value="{{ $cco->id }}" selected>{{ $cco->code }} - {{ $cco->description }}</option>
                                                            @else
                                                            <option value="{{ $cco->id }}">{{ $cco->code }} - {{ $cco->description }}</option>
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

                                  {{-- @can('delete-country', User::class) --}}

                                  <span id="delbtn{{@$ocp->id}}"></span>
                                
                                    <form id="delete-ocp-{{$ocp->id}}"
                                        action="{{ url('master-data/occupation/destroy', $ocp->id) }}"
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
@include('crm.master.occupation_js')
@endsection