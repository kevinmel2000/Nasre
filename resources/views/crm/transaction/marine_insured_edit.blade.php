@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form id="formmarineinsured">
          @csrf

            @foreach($insured as $isd)
                <div class="card">
                    <div class="card-header bg-gray">
                        {{__('Insured')}}
                    </div>
                    
                    <div class="card-body bg-light-gray ">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade show active" id="l" role="tabpanel" aria-labelledby="lead-details">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="idslip" id="idslip" value="{{ $isd->id }}">
                                            <label for="">{{__('Number')}} </label>
                                            <input type="text" name="msinumber" id="msinumber" class="form-control form-control-sm" data-validation="length" data-validation-length="1-25" value="{{ $isd->number }}" readonly="readonly" required/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">{{__('Insured')}}</label>
                                                    <select name="msiprefix" id="msiprefix" class="e1 form-control form-control-sm ">
                                                        @if($isd->insured_prefix == 'CV')
                                                        <option  selected>{{$isd->insured_prefix}}</option>
                                                        <option value="PT">PT</option>
                                                        @elseif($isd->insured_prefix == 'PT')
                                                        <option  selected>{{$isd->insured_prefix}}</option>
                                                        <option value="PT">CV</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 1')}}</label>
                                                    <input type="text" id="autocomplete" name="msisuggestinsured" value="{{ $isd->insured_name }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="search for insured suggestion" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 2')}}</label>
                                                    <input type="text" name="msisuffix" id="autocomplete2" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="suffix: QQ or TBk" value="{{ $isd->insured_suffix }}"  />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{__('Route')}}</label>
                                                    <select id="msiroute" name="msiroute" class="e1 form-control form-control-sm ">
                                                        {{-- <option selected disabled>{{__('Select Route')}}</option> --}}
                                                        @foreach($routeship as $rs)
                                                            @if($isd->routeship->id  == $rs->id)
                                                                <option value="{{ $rs->id }}" selected >{{ $rs->name }} - {{ $rs->description }}</option>
                                                            @else 
                                                                <option value="{{ $rs->id }}"  >{{ $rs->name }} - {{ $rs->description }}</option>
                                                            @endif
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" style="opacity: 0">{{__('b')}}</label>
                                                    <input type="text" id="msiroutefrom" name="msiroutefrom" value="{{ $isd->route_from }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="*from" readonly="readonly" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" style="opacity: 0">{{__('a')}}</label>
                                                    <input type="text" id="msirouteto" name="msirouteto" value="{{ $isd->route_to }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="*to" readonly="readonly" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="">{{__('Our Share')}}</label>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="input-group">
                                                                <input type="text" id="msishare" name="msishare" value="{{ $isd->share }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text"><span><i class="fa fa-percent" aria-hidden="true"></i></span></div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{__('From')}}</label>
                                                    <input type="text" id="msisharefrom" name="msisharefrom" class="form-control form-control-sm " value="{{ $isd->share_from }}" placeholder="total nasre share" data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{__('To')}}</label>
                                                    <input type="text" id="msishareto" name="msishareto" class="form-control form-control-sm " value="{{ $isd->share_to }}" placeholder="total sum insured" data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-header bg-gray">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {{__('Ship Detail')}}
                                                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#ModalAddShip">{{__('Add Ship')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12 com-sm-12 mt-3">
                                                    <table id="shipdetailTable" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>{{__('Ship Code')}}</th>
                                                                <th>{{__('Ship Name')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($shiplist as $slt)
                                                                <tr id="sid{{ $slt->id }}" data-name="shiplistvalue[]">
                                                                    <td data-name="{{ $slt->ship_code }}">{{ $slt->ship_code }}</td>
                                                                    <td data-name="{{ $slt->ship_name }}">{{ $slt->ship_name }}</td>
                                                                    <td>
                                                                        <a class="text-primary mr-3" data-toggle="modal" data-target="#updateshiplist{{$exc->id}}">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        

                                                                        <div class="modal fade" id="updateshiplist{{$slt->id}}" tabindex="-1" user="dialog" aria-labelledby="updateshiplist{{$slt->id}}Label" aria-hidden="true">
                                                                            <div class="modal-dialog" user="document">
                                                                              <div class="modal-content bg-light-gray">
                                                                                <div class="modal-header bg-gray">
                                                                                  <h5 class="modal-title" id="updateshiplist{{$slt->id}}Label">{{__('Update Marine Ship List')}}</h5>
                                                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                  </button>
                                                                                </div>
                                                                                <form id="form-updateship" action="{{url('ship-list/',$slt)}}" method="POST">
                                                                                    <div class="modal-body">
                                                                                        @csrf
                                                                                        @method('PUT')
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="">{{__('Ship Code')}}</label><br>
                                                                                                    <select name="shipcodems" id="shipcodems" class="e1 form-control form-control-sm ">
                                                                                                        <option selected disabled>{{__('Select Currency')}}</option>
                                                                                                        @foreach($mlu as $mrnlu)
                                                                                                          @if($slt->ship_code  == $mrnlu->code)
                                                                                                            <option value="{{ $mrnlu->code }}" selected>{{ $mrnlu->code }} - {{ $mrnlu->shipname }}</option>
                                                                                                          @else
                                                                                                            <option value="{{  $mrnlu->code }}">{{  $mrnlu->code  }} - {{ $mrnlu->shipname }}</option>
                                                                                                          @endif
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                              </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12 col-md-12">
                                                                                                <div class="form-group">
                                                                                                <label for="">{{__('Ship Name')}}</label>
                                                                                                <input type="text" name="shipnamems" id="shipnamems" value="{{ $slt->ship_name }}" class="form-control" value="" />
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

                                                                        
                                                                        <a href="javascript:void(0)" onclick="deleteshipdetail({{ $slt->id }})"><i class="fas fa-trash text-danger"></i></a>
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

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">{{__('Coinsurance')}}</label>
                                            <input type="text" id="msicoinsurance" name="msicoinsurance" class="form-control form-control-sm " value="{{ $isd->coincurance }}" data-validation="length" data-validation-length="0-50" />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="ModalAddShip" tabindex="-1" user="dialog" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                        <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                            <h5 class="modal-title">{{__('Ship Detail')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="form-addship" >
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Ship Code')}}</label><br>
                                                            <select name="insshipcode" id="shipcodetxt" class="form-control form-control-sm e1">
                                                                <option selected disabled>{{__('Select Ship Code')}}</option>
                                                                @foreach($mlu as $mrnlu)
                                                                    <option value="{{  $mrnlu->code }}">{{  $mrnlu->code  }} - {{ $mrnlu->shipname }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-md-12">
                                                        <div class="form-group">
                                                        <label for="">{{__('Ship Name')}}</label>
                                                        <input type="text" name="insshipname" id="shipnametxt" class="form-control" value="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                                <button type="submit" class="btn btn-info" id="addship-btn">Add Ship</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 com-sm-12 mt-3">
                                        <button type="submit" id="addinsuredsave-btn" class="btn btn-primary btn-block ">
                                            {{__('SAVE')}}
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </form>

            

    </div>
</div>


@endsection

@section('scripts')
@include('crm.transaction.marine_insured_edit_js')
@endsection