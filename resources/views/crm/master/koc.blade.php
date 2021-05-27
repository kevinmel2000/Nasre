@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/koc/store')}}>
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
                          <input type="text" id="koccode" style="width: 25%;" name="code" class="form-control form-control-sm" value="{{ $code_koc }}" placeholder="enter code manually if not have parent data" data-validation="length" readonly="readonly" data-validation-length="1-16" required/>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('Parent')}}</label>
                        <select name="parent_id" id="kocparentdd" class="form-control form-control-sm ">
                            <option selected disabled>{{__('Select Parent')}}</option>
                            @foreach (@$kocparent as $parentdata)
                            <option value="{{ $parentdata->id }}">{{ $parentdata->code }} - {{ $parentdata->description }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Description')}}</label>
                          <input type="text" name="description" class="form-control form-control-sm " data-validation="length" data-validation-length="0-250" required/>
                      </div>
                    </div>
                </div>

                

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Abbreviation')}}</label>
                          <input type="text" name="abbreviation" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" required/>
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
                  <table id="kocTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Description')}}</th>
                      <th>{{__('Abbreviation')}}</th>
                      <th>{{__('Parent')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$koc as $kocdata)
                            <tr>
                              <td>{{@$kocdata->code}}</td>
                              <td>{{@$kocdata->description}}</td>
                              <td>{{@$kocdata->abbreviation}}</td>
                              <td>{{@$kocdata->kocparent->code}} - {{@$kocdata->kocparent->description}}</td>
                          
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$kocdata->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$kocdata->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                   {{-- @can('update-koc', User::class) --}}
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updatekoc{{$kocdata->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- @endcan   --}}

                                    <div class="modal fade" id="updatekoc{{$kocdata->id}}" tabindex="-1" user="dialog" aria-labelledby="updatekoc{{$kocdata->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updatekoc{{$kocdata->id}}Label">{{__('Update Koc')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/koc/update',$kocdata)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Code')}}</label>
                                                      <input type="text" name="code" class="form-control" value="{{$kocdata->code}}" required readonly/>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="col-md-4 col-md-12">
                                                  <div class="form-group">
                                                      <label for="">{{__('Parent')}}</label><br>
                                                      <select name="parent_id" class="form-control form-control-sm e1">
                                                          <option selected disabled>{{__('Select Parent')}}</option>
                                                          @foreach (@$koc as $kocdata2)
                                                          @if($kocdata->parent_id  == $kocdata2->id)
                                                          <option value="{{ $kocdata2->id }}" selected>{{ $kocdata2->code }} - {{ $kocdata2->description }}</option>
                                                          @else
                                                          <option value="{{ $kocdata2->id }}">{{ $kocdata2->code }} - {{ $kocdata2->description }}</option>
                                                           @endif
                                                          @endforeach
                                                      </select>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Description')}}</label>
                                                      <input type="text" name="description" class="form-control" value="{{$kocdata->description}}" data-validation="length" data-validation-length="0-250" required/>
                                                    </div>
                                                  </div>

                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Abbreviation')}}</label>
                                                      <input type="text" name="abbreviation" class="form-control" value="{{$kocdata->abbreviation}}" data-validation="length" data-validation-length="0-150" required/>
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

                                  {{-- @can('delete-koc', User::class) --}}

                                  <span id="delbtn{{@$kocdata->id}}"></span>
                                
                                    <form id="delete-koc-{{$kocdata->id}}"
                                        action="{{ url('master-data/koc/destroy', $kocdata->id) }}"
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
@include('crm.master.koc_js')
@endsection