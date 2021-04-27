@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/interestinsured/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Interest Insured Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__(' Code')}} </label>
                          <input type="text" name="iicode" style="width: 25%" class="form-control form-control-sm" data-validation="length" data-validation-length="1-16" value="{{ $code_ii }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Description')}}</label>
                          <input type="text" name="iidescription" class="form-control form-control-sm " data-validation="length" data-validation-length="0-250"/>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('COB')}}</label>
                        <select name="iicob" class="e1 form-control form-control-sm ">
                            <option selected disabled>{{__('Select COB')}}</option>
                            @foreach($cob as $cob_data)
                            <option value="{{ $cob_data->id }}">{{ $cob_data->code }} - {{ $cob_data->description }}</option>
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
                            {{__('Save Interest Insured')}}
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
                    <table id="interestinsuredTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('COB')}}</th>
                        <th width="20%">{{__('Actions')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach (@$interestinsured as $ii)
                              <tr>
                                <td>{{@$ii->code}}</td>
                                <td>{{@$ii->description}}</td>
                                <td>{{@$ii->cob->code}} - {{@$ii->cob->description}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$ii->created_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$ii->updated_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    {{-- @can('update-construction', User::class) --}}
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updateinterestinsured{{$ii->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    {{-- @endcan --}}
  
                                    <div class="modal fade" id="updateinterestinsured{{$ii->id}}" tabindex="-1" user="dialog" aria-labelledby="updateinterestinsured{{$ii->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updateinterestinsured{{$ii->id}}Label">{{__('Update Interest Insured')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/interestinsured',$ii)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')
                                                  <div class="row">
                                                    <div class="col-md-4 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Code')}}</label>
                                                        <input type="text" name="codeii" class="form-control" value="{{$ii->code}}" data-validation="length" data-validation-length="1-16" readonly="readonly" required/>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Description')}}</label>
                                                        <input type="text" name="descriptionii" class="form-control" value="{{$ii->description}}" data-validation="length" data-validation-length="0-150" />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('COB')}}</label><br>
                                                            <select name="cobii" class="e1 form-control form-control-sm ">
                                                                <option selected disabled>{{__('Select COB')}}</option>
                                                                @foreach($cob as $cob_data)
                                                                  @if($ii->cob_id  == $cob_data->id)
                                                                    <option value="{{ $cob_data->id }}" selected>{{ $cob_data->code }} - {{ $cob_data->description }}</option>
                                                                  @else
                                                                    <option value="{{  $cob_data->id }}">{{  $cob_data->code  }} - {{ $cob_data->description }}</option>
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
                                      <span id="delbtn{{@$ii->id}}"></span>
                                        <form id="delete-interestinsured-{{$ii->id}}"
                                            action="{{ url('master-data/interestinsured/destroy', $ii->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                      </span>
                                  {{-- @endcan   --}}
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
@include('crm.master.interest_insured_js')
@endsection