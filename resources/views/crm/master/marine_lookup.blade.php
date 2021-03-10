@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/marine-lookup/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Marine Lookup Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{__('Code')}} </label>
                                    <input type="text" name="mlucode" style="width: 25%;" class="form-control form-control-sm" data-validation="length" data-validation-length="1-16" value="{{ $code_mlu }}" readonly="readonly" required/>
                                </div>
                            </div>
                            <div class="col-md-8">
                            <div class="form-group">
                                <label for="">{{__('Ship Name')}} </label>
                                <input type="text" name="mlushipname" placeholder="enter ship name" class="form-control form-control-sm" data-validation="length" data-validation-length="0-150" required/>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="">{{__('Owner')}}</label>
                                <input type="text" name="mluowner" class="form-control form-control-sm " data-validation="length" data-validation-length="0-250" required/>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-gray">
                                        {{__('The Tornanger of the ship')}}
                                    </div>
                                    <div class="card-body bg-light-gray ">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('GRT')}}</label>
                                                    <input type="text" name="mlugrt" class="form-control form-control-sm " data-validation="length" data-validation-length="0-20" value="0" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('NRT')}}</label>
                                                    <input type="text" name="mlunrt" class="form-control form-control-sm " data-validation="length" data-validation-length="0-30" value="0" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('DWT')}}</label>
                                                    <input type="text" name="mludwt" class="form-control form-control-sm " data-validation="length" data-validation-length="0-30" value="0" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('Power')}}</label>
                                                    <input type="text" name="mlupower" class="form-control form-control-sm " data-validation="length" data-validation-length="0-30" value="0"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">{{__('Ship Year')}}</label>
                                            <input type="text" name="mlushipyear" class="form-control form-control-sm " data-validation="length" data-validation-length="0-70"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">{{__('Repair Year')}}</label>
                                            <input type="text" name="mlurepairyear" class="form-control form-control-sm " data-validation="length" data-validation-length="0-150" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">{{__('Galangan')}}</label>
                                            <input type="text" name="mlugalangan" class="form-control form-control-sm " data-validation="length" data-validation-length="0-150" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Country')}}</label>
                                  <select name="mlucountry" class="form-control form-control-sm ">
                                      <option selected disabled>{{__('Select Country')}}</option>
                                      @foreach($country as $cty)
                                        <option value="{{ $cty->id }}">{{ $cty->code }} - {{ $cty->name }}</option>
                                      @endforeach
                                  </select>
                              </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Ship Type')}}</label>
                                  <select name="mlushiptype" class="form-control form-control-sm ">
                                      <option selected disabled>{{__('Select Ship Type')}}</option>
                                      @foreach($shiptype as $stp)
                                        <option value="{{ $stp->id }}">{{ $stp->code }} - {{ $stp->name }}</option>
                                      @endforeach
                                  </select>
                              </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Classification')}}</label>
                                  <select name="mluclassification" class="form-control form-control-sm ">
                                      <option selected disabled>{{__('Select Classification')}}</option>
                                      @foreach($classification as $cs)
                                        <option value="{{ $cs->id }}">{{ $cs->code }} - {{ $cs->name }}</option>
                                      @endforeach
                                  </select>
                              </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Construction')}}</label>
                                  <select name="mluconstruction" class="form-control form-control-sm ">
                                      <option selected disabled>{{__('Select Construction')}}</option>
                                      @foreach($construction as $cr)
                                        <option value="{{ $cr->id }}">{{ $cr->code }} - {{ $cr->name }}</option>
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
                {{-- @can('create-marinelookup', User::class) --}}
                    <div class="row">
                        <div class="col-md-12 com-sm-12 mt-3">
                            <button class="btn btn-primary btn-block ">
                                {{__('Create New')}}
                            </button>
                        </div>
                    </div>
                {{-- @endcan --}}
            </div>
        </div> 
        
        
    </form>

    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 com-sm-12 mt-3">
                  <table id="mluTable" class="table table-bordered display nowrap" style="width:100%;white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>{{__('Code')}}</th>
                            <th>{{__('Ship Name')}}</th>
                            <th>{{__('Owner')}}</th>
                            <th>{{__('GRT')}}</th>
                            <th>{{__('DWT')}}</th>
                            <th>{{__('NRT')}}</th>
                            <th>{{__('Power')}}</th>
                            <th>{{__('Country')}}</th>
                            <th>{{__('Type')}}</th>
                            <th>{{__('Classification')}}</th>
                            <th>{{__('Construction')}}</th>
                            <th>{{__('Ship Year')}}</th>
                            <th>{{__('Repair Year')}}</th>
                            <th>{{__('Galangan')}}</th>
                            <th >{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (@$mlu as $mlp)
                            <tr>
                                <td>{{@$mlp->code}}</td>
                                <td>{{@$mlp->shipname}}</td>
                                <td>{{@$mlp->owner}}</td>
                                <td>{{@$mlp->grt}}</td>
                                <td>{{@$mlp->dwt}}</td>
                                <td>{{@$mlp->nrt}}</td>
                                <td>{{@$mlp->power}}</td>
                                <td>{{@$mlp->countryside->code}} - {{@$mlp->countryside->name}}</td>
                                <td>{{@$mlp->shiptype->code}} - {{@$mlp->shiptype->name}}</td>
                                <td>{{@$mlp->classify->code}} - {{@$mlp->classify->name}}</td>
                                <td>{{@$mlp->construct->code}} - {{@$mlp->construct->name}}</td>
                                <td>{{@$mlp->ship_year}}</td>
                                <td>{{@$mlp->repair_year}}</td>
                                <td>{{@$mlp->galangan}}</td>
                                <td >
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updateshipport{{$mlp->id}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="modal fade" id="updateshipport{{$mlp->id}}" tabindex="-1" user="dialog" aria-labelledby="updateshipport{{$mlp->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog" user="document">
                                          <div class="modal-content bg-light-gray">
                                            <div class="modal-header bg-gray">
                                              <h5 class="modal-title" id="updateshipport{{$mlp->id}}Label">{{__('Update Ship Port')}}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <form action="{{url('master-data/marine-lookup',$mlp)}}">
                                                <div class="modal-body">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="">{{__('Code')}} </label>
                                                                <input type="text" name="codemlu" style="width: 75%;" class="form-control form-control-sm" data-validation="length" data-validation-length="1-16" value="{{ $mlp->code }}" readonly="readonly" required/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="">{{__('Ship Name')}} </label>
                                                            <input type="text" name="shipnamemlu" value="{{ $mlp->shipname }}" placeholder="enter ship name" class="form-control form-control-sm" data-validation="length" data-validation-length="0-150" required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Owner')}}</label>
                                                            <input type="text" name="ownermlu" value="{{ $mlp->owner }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-250" required/>
                                                        </div>
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="card">
                                                                <div class="card-header bg-gray">
                                                                    {{__('The Tornanger of the ship')}}
                                                                </div>
                                                                <div class="card-body bg-light-gray ">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">{{__('GRT')}}</label>
                                                                                <input type="text" name="grtmlu" value="{{ $mlp->grt }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-20" value="0" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">{{__('NRT')}}</label>
                                                                                <input type="text" name="nrtmlu" value="{{ $mlp->nrt }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-30" value="0" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">{{__('DWT')}}</label>
                                                                                <input type="text" name="dwtmlu" value="{{ $mlp->dwt }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-30" value="0" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">{{__('Power')}}</label>
                                                                                <input type="text" name="powermlu" value="{{ $mlp->power }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-30" value="0"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('Ship Year')}}</label>
                                                                        <input type="text" name="shipyearmlu" value="{{ $mlp->ship_year }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-70"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('Repair Year')}}</label>
                                                                        <input type="text" name="repairyearmlu" value="{{ $mlp->repair_year }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-150" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('Galangan')}}</label>
                                                                        <input type="text" name="galanganmlu" value="{{ $mlp->galangan }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-150" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                          <div class="form-group">
                                                              <label for="">{{__('Country')}}</label>
                                                              <select name="countrymlu" class="form-control form-control-sm ">
                                                                  <option selected disabled>{{__('Select Country')}}</option>
                                                                  @foreach($country as $cty)
                                                                    @if($mlp->country == $cty->id)
                                                                    <option value="{{ $cty->id }}" selected>{{ $cty->code }} - {{ $cty->name }}</option>
                                                                    @else 
                                                                    <option value="{{ $cty->id }}">{{ $cty->code }} - {{ $cty->name }}</option>
                                                                    @endif
                                                                  @endforeach
                                                              </select>
                                                          </div>    
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                          <div class="form-group">
                                                              <label for="">{{__('Ship Type')}}</label>
                                                              <select name="shiptypemlu" class="form-control form-control-sm ">
                                                                  <option selected disabled>{{__('Select Ship Type')}}</option>
                                                                    @foreach($shiptype as $stp)
                                                                        @if($mlp->ship_type == $stp->id )
                                                                            <option value="{{ $stp->id }}" selected>{{ $stp->code }} - {{ $stp->name }}</option>
                                                                        @else
                                                                            <option value="{{ $stp->id }}">{{ $stp->code }} - {{ $stp->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                              </select>
                                                          </div>    
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                          <div class="form-group">
                                                              <label for="">{{__('Classification')}}</label>
                                                              <select name="classificationmlu" class="form-control form-control-sm ">
                                                                  <option selected disabled>{{__('Select Classification')}}</option>
                                                                    @foreach($classification as $cs)
                                                                        @if($mlp->classification == $cs->id )
                                                                        <option value="{{ $cs->id }}" selected>{{ $cs->code }} - {{ $cs->name }}</option>
                                                                        @else 
                                                                            <option value="{{ $cs->id }}">{{ $cs->code }} - {{ $cs->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                              </select>
                                                          </div>    
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                          <div class="form-group">
                                                              <label for="">{{__('Construction')}}</label>
                                                              <select name="constructionmlu" class="form-control form-control-sm ">
                                                                  <option selected disabled>{{__('Select Construction')}}</option>
                                                                  @foreach($construction as $cr)
                                                                        @if($mlp->construction == $cr->id)
                                                                            <option value="{{ $cr->id }}" selected>{{ $cr->code }} - {{ $cr->name }}</option>
                                                                        @else 
                                                                        <option value="{{ $cr->id }}">{{ $cr->code }} - {{ $cr->name }}</option>
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
                                    <span id="delbtn{{@$mlp->id}}"></span>
                                        <form id="delete-mlu-{{$mlp->id}}"
                                            action="{{ url('master-data/marinelookup/destroy', $mlp->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                        </form>
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
@include('crm.master.marine_lookup_js')
@endsection