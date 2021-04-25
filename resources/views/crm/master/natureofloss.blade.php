@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/natureofloss/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Master Koc Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" id="number" style="width: 25%;" name="number" class="form-control form-control-sm" value="{{ $number_natureofloss }}" placeholder="enter code manually if not have parent data" data-validation="length" readonly="readonly" data-validation-length="1-16" required/>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Accident')}}</label>
                          <input type="text" name="accident" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Description')}}</label>
                          <input type="text" name="keterangan" class="form-control form-control-sm " data-validation="length" data-validation-length="0-250" required/>
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
                            {{__('Save Koc')}}
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
                  <table id="natureoflossTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Number')}}</th>
                      <th>{{__('Accident')}}</th>
                      <th>{{__('Description')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$natureofloss as $natureoflossdata)
                            <tr>
                              <td>{{@$natureoflossdata->number}}</td>
                              <td>{{@$natureoflossdata->accident}}</td>
                              <td>{{@$natureoflossdata->keterangan}}</td>
                              
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$natureoflossdata->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$natureoflossdata->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                   {{-- @can('update-natureofloss', User::class) --}}
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updatenatureofloss{{$natureoflossdata->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- @endcan   --}}

                                    <div class="modal fade" id="updatenatureofloss{{$natureoflossdata->id}}" tabindex="-1" user="dialog" aria-labelledby="updatenatureofloss{{$natureoflossdata->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updatenatureofloss{{$natureoflossdata->id}}Label">{{__('Update Nature Of Loss')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/natureofloss/update',$natureoflossdata)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Number')}}</label>
                                                      <input type="text" name="number" class="form-control" value="{{$natureoflossdata->number}}" required readonly/>
                                                    </div>
                                                  </div>
                                                </div>
                                               
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Accident')}}</label>
                                                      <input type="text" name="accident" class="form-control" value="{{$natureoflossdata->accident}}" data-validation="length" data-validation-length="0-150" required/>
                                                    </div>
                                                  </div>

                                               
                                                <div class="row">
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Description')}}</label>
                                                      <input type="text" name="keterangan" class="form-control" value="{{$natureoflossdata->keterangan}}" data-validation="length" data-validation-length="0-250" required/>
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

                                  {{-- @can('delete-natureofloss', User::class) --}}

                                    <span id="delbtn{{@$natureoflossdata->id}}"></span>
                                  
                                      <form id="delete-natureofloss-{{$natureoflossdata->id}}"
                                          action="{{ url('master-data/natureofloss/destroy', $natureoflossdata->id) }}"
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
@include('crm.master.natureofloss_js')
@endsection