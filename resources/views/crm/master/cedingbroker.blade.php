@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/cedingbroker/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Ceding Broker Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" name="codebroker" class="form-control form-control-sm" data-validation="length" data-validation-length="1-12" value="{{ $code_ceding }}" readonly="readonly" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Name')}}</label>
                          <input type="text" name="name" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Company Name')}}</label>
                          <input type="text" name="companyname" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Address')}}</label>
                          <textarea name="address" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/></textarea>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Country')}}</label>
                          <select name="crccountry" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Country')}}</option>
                              @foreach($country as $cty)
                              <option value="{{ $cty->id }}">{{ $cty->id }} - {{ $cty->name }}</option>
                              @endforeach
                          </select>
                      </div>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Type')}}</label>
                          <select name="type" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Type')}}</option>
                              <option value="Ceding">Ceding</option>
                              <option value="Broker">Broker</option>
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
                            {{__('Save Ceding Broker')}}
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
                      <th>{{__('Code')}}</th>
                      <th>{{__('Name')}}</th>
                      <th>{{__('Company')}}</th>
                      <th>{{__('Address')}}</th>
                      <th>{{__('Country')}}</th>
                      <th>{{__('Type')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$cedingbroker as $ceding)
                            <tr>
                              <td>{{@$ceding->id}}</td>
                              <td>{{@$ceding->code}}</td>
                              <td>{{@$ceding->name}}</td>
                              <td>{{@$ceding->company_name}}</td>
                              <td>{{@$ceding->address}}</td>
                              <td>{{@$ceding->countryside->id}} - {{@$ceding->countryside->name}}</td>
                              <td>{{@$ceding->type}}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$ceding->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$ceding->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                 
                                    {{-- @can('update-cedingbroker', User::class) --}}
                                      <a class="text-primary mr-3" data-toggle="modal" data-target="#updatecedingbroker{{$ceding->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                      {{-- @endcan   --}}

                                      <div class="modal fade" id="updatecedingbroker{{$ceding->id}}" tabindex="-1" user="dialog" aria-labelledby="updatecedingbroker{{$ceding->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                            <h5 class="modal-title" id="updatecedingbroker{{$ceding->id}}Label">{{__('Update Ceding Broker')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <form action="{{url('master-data/cedingbroker/update',$ceding->id)}}" method="POST">
                                              <div class="modal-body">
                                                  @csrf
                                                  @method('PUT')

                                                  <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Code')}}</label>
                                                      <input type="text" name="codebroker" class="form-control" value="{{$ceding->code}}" required readonly/>
                                                    </div>
                                                  </div>
                                                </div>

                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('name')}}</label>
                                                        <input type="text" name="namebroker" class="form-control" value="{{$ceding->name}}" required/>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  
                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Company Name')}}</label>
                                                        <input type="text" name="companynamebroker" class="form-control" value="{{$ceding->company_name}}" required/>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Address')}}</label>
                                                        <textarea name="addressbroker" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>{{$ceding->address}}</textarea>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                         <label for="">{{__('Country')}}</label>
                                                          <select name="crccountrybroker" class="form-control form-control-sm ">
                                                              <option selected disabled>{{__('Select Country')}}</option>
                                                              @foreach($country as $cty)
                                                              @if($ceding->country  == $cty->id)
                                                              <option value="{{ $cty->id }}" selected>{{ $cty->id }} - {{ $cty->name }}</option>
                                                              @else
                                                              <option value="{{  $cty->id }}">{{  $cty->id  }} - {{ $cty->name }}</option>
                                                              @endif
                                                              @endforeach
                                                          </select>
                                                        </div>
                                                    </div>
                                                  </div>

                                                  <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                         <label for="">{{__('Type')}}</label>
                                                          <select name="typebroker" class="form-control form-control-sm ">
                                                              @if($ceding->type  == 'Ceding')
                                                              <option value="Ceding" selected>Ceding</option>
                                                              @else
                                                              <option value="Broker" >Broker</option>
                                                              @endif

                                                              @if($ceding->type  == 'Broker')
                                                              <option value="Broker" selected>Broker</option>
                                                              @else
                                                              <option value="Ceding" >Ceding</option>
                                                              @endif
                                                              
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



                                {{-- @can('delete-cedingbroker', User::class) --}}

                                  <span id="delbtn{{@$ceding->id}}"></span>
                                
                                    <form id="delete-ceding-{{$ceding->id}}"
                                        action="{{ url('master-data/cedingbroker/destroy', $ceding->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    {{-- @endcan --}}

                                </span>
                              </td>

                            </tr>
                        @endforeach
                    </tbody>
                    
                  </table>
                   {!! $cedingbroker->render() !!}

                </div>
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.master.cedingbroker_js')
@endsection