@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
         <form>
          @csrf
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
                                            <label for="">{{__('Number')}} </label>
                                            <input type="text" name="fesnumber"  id="insuredIDtxt"  value="{{$code_ms}}" class="form-control form-control-sm" readonly required/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">{{__('Insured')}}</label>
                                                    <select id="feinsured" name="feinsured" class="form-control form-control-sm ">
                                                        <option selected disabled>{{__('Select Prefix')}}</option>
                                                        <option value="PT">PT</option>
                                                        <option value="CV">CV</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 1')}}</label>
                                                    <input type="text"name="fesuggestinsured" id='autocomplete'  class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="search for insured suggestion" required/>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 2')}}</label>
                                                    <input type="text" name="fesuffix" id='autocomplete2' class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="suffix: QQ or TBk" />
                                               
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
                                                    <label for="">{{__('Our Share')}}</label>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="input-group">
                                                             <input type="number" id="feshare" min="0" value="0" step=".01" name="feshare" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{__('From')}}</label>
                                                    <input id="fesharefrom" type="number" min="0" value="0" step=".01"  name="fesharefrom" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{__('To')}}</label>
                                                    <input id="feshareto" type="number" min="0" value="0" step=".01"  name="feshareto" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
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
                                                        {{__('Location')}}
                                                   
                                                        <a class="text-primary mr-3 float-right " data-toggle="modal" data-target="#addlocation">
                                                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addrisklocr">{{__('Add Risk Location')}}</button>
                                                        </a>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12 com-sm-12 mt-3">
                                                    <table id="locRiskTable" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>{{__('Loc Code')}}</th>
                                                        <th>{{__('Address')}}</th>
                                                        <th>{{__('City')}}</th>
                                                        <th>{{__('Province')}}</th>
                                                        <th>{{__('LatLong')}}</th>
                                                        <th width="20%">{{__('Actions')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                            @foreach($locationlist as $slt)
                                                             <tr id="sid{{ $slt->id }}">
                                                                    <td>{{ $slt->felookuplocation->loc_code }}</td>
                                                                    <td>{{ $slt->felookuplocation->address }}</td>
                                                                    <td>{{@$slt->felookuplocation->state->id}} - {{@$slt->felookuplocation->state->name}}</td>
                                                                    <td>{{@$slt->felookuplocation->city->id}} - {{@$slt->felookuplocation->city->name}}</td>
                                                                    <td>{{ $slt->felookuplocation->latitude , $slt->felookuplocation->longtitude  }}</td>
                                                                    <td><a href="javascript:void(0)" onclick="deletelocationdetail({{ $slt->id }})"><i class="fas fa-trash text-danger"></i></a></td>
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
                                            <input type="text" id="fecoinsurance" name="fecoinsurance" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 com-sm-12 mt-3">
                                        <button type="button" id="addinsuredsave-btn" class="btn btn-primary btn-block ">
                                            {{__('Save')}}
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <div class="modal fade" id="addlocation" tabindex="-1" user="dialog" aria-labelledby="addlocationLabel" aria-hidden="true">
                <div class="modal-dialog" user="document">
                <div class="modal-content bg-light-gray">
                    <div class="modal-header bg-gray">
                    <h5 class="modal-title" id="addlocationLabel">{{__('Add Lookup Location')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    <form id="form-addlocation">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                            
                            <div class="col-md-6 col-md-12">
                                <div class="form-group">
                                <label for="">{{__('Lookup Location')}}</label>
                                    <select name="lookup_location_id" id="lookup_location" class="e1 form-control form-control-sm " >
                                    <option selected readonly>{{__('Select Lookup Location ')}}</option>
                                    @foreach($felookup as $felookuplocationdata)
                                    <option value="{{ $felookuplocationdata->id }}">{{ $felookuplocationdata->loc_code }} - {{ $felookuplocationdata->address }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                            <button type="submit" class="btn btn-info" id="addship-btn">Add Risk Location</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            {{-- Edit Modal Ends --}}

        <div class="card ">
            <div class="card-header bg-gray">
                {{__('Slip Detail')}}
            </div>
            <div class="card-body bg-light-gray">
                <div class="container-fluid p-3">
                <form id="multi-file-upload-ajax" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                        <div class="card card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    <li class="pt-1 px-3"><h3 class="card-title">{{__('Slip Form')}}</h3></li>
                                    <li class="nav-item">
                                    <a class="nav-link active" id="general-details" data-toggle="pill" href="#general-details-id" role="tab" aria-controls="general-details-id" aria-selected="true">{{__('General Data')}}</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="insured-details" data-toggle="pill" href="#insured-details-id" role="tab" aria-controls="address-details-id" aria-selected="false">{{__('Insured Data')}}</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="insurance-details" data-toggle="pill" href="#insurance-details-id" role="tab" aria-controls="social-media-details-id" aria-selected="false">{{__('Insurance Measurement')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="installment-details" data-toggle="pill" href="#installment-details-id" role="tab" aria-controls="installment-details-id" aria-selected="false">{{__('Installment & Retrocession')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body bg-light-gray">
                                <div class="tab-content p-0 pt-1" id="custom-tabs-three-tabContent">
                                    <div class="tab-pane fade show active" id="general-details-id" role="tabpanel" aria-labelledby="general-details">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsement">{{__('Endorsement')}}</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="_token2" id="token" value="{{ csrf_token() }}">
                                                        <label for="">{{__('Number')}} </label>
                                                        <input type="text" id="slipnumber" name="slipnumber" class="form-control form-control-sm" value="{{ $code_sl }}" readonly="readonly" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Username')}}</label>
                                                            <input type="text" id="slipusername" name="slipusername" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{Auth::user()->name}}" readonly="readonly" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{__('Prod Year')}}:</label>
                                                                <div class="input-group date" id="date" data-target-input="nearest">
                                                                        <input type="text" id="slipprodyear" class="form-control form-control-sm datepicker-input" data-target="#date" name="slipprodyear" value="{{ $currdate }}" readonly="readonly">
                                                                        <div class="input-group-append" >
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('UY')}}</label>
                                                            <input type="number" id="slipuy" name="slipuy" class="form-control form-control-sm " data-validation="length"  data-validation-length="0-12" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Status')}}</label>
                                                        <select name="slipstatus" id="slipstatus" class="form-control form-control-sm ">
                                                            {{-- <option selected readonly>{{__('Select Status')}}</option> --}}
                                                            <option value="offer" selected>Offer</option>
                                                            <option value="binding">Binding</option>
                                                            <option value="slip">Slip</option>
                                                            <option value="endorsement">Endorsement</option>
                                                            <option value="decline">Decline</option>
                                                            <option value="cancel">Cancel</option>
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                    <label for="" class="d-flex justify-content-center">{{__('Endorsement / Selisih')}}</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                    <input type="text" id="sliped"  name="sliped" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50"/>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                    <input type="text" id="slipsls" name="slipsls" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 com-sm-12 mt-3">
                                                        <table id="slipStatusTable" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>{{__('Status')}}</th>
                                                                <th>{{__('Datetime')}}</th>
                                                                <th>{{__('User')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                        
                                                        </table>
                                                        <i class="fa fa-info-circle" style="color: grey;" aria-hidden="true"> Data is Transferred!</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">{{__('Source')}}</label>
                                                    <select id="slipcedingbroker" name="slipcedingbroker" class="e1 form-control form-control-sm ">
                                                        <option value="" readonly selected>Ceding or Broker</option>
                                                        @foreach($cedingbroker as $cb)
                                                            <option value="{{ $cb->id }}">{{ $cb->type }} - {{ $cb->code }} - {{ $cb->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>    
                                                <div class="form-group">
                                                    <select id="slipceding" name="slipceding" class="e1 form-control form-control-sm ">
                                                        <option value="" readonly selected>Ceding </option>
                                                        @foreach($ceding as $cd)
                                                            <option value="{{ $cd->id }}">{{ $cd->code }} - {{ $cd->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Currency')}}</label>
                                                        <select id="slipcurrency" name="slipcurrency" class="e1 form-control form-control-sm ">
                                                            <option selected readonly>{{__('Select Currency')}}</option>
                                                            @foreach($currency as $crc)
                                                                <option value="{{ $crc->id }}">{{ $crc->code }} - {{ $crc->symbol_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('COB')}}</label>
                                                        <select id="slipcob" name="slipcob" class="e1 form-control form-control-sm ">
                                                            <option selected readonly>{{__('COB list')}}</option>
                                                            @foreach($cob as $boc)
                                                                <option value="{{ $boc->id }}">{{ $boc->code }} - {{ $boc->description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('KOC')}}</label>
                                                        <select id="slipkoc" name="slipkoc" class="e1 form-control form-control-sm ">
                                                            <option selected readonly>{{__('KOC list')}}</option>
                                                            @foreach($koc as $cok)
                                                                <option value="{{ $cok->id }}">{{ $cok->code }} - {{ $cok->description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Occupacy')}}</label>
                                                        <select id="slipoccupacy" name="slipoccupacy" class="e1 form-control form-control-sm ">
                                                            <option selected readonly>{{__('Occupation list')}}</option>
                                                            @foreach($ocp as $ocpy)
                                                                <option value="{{ $ocpy->id }}">{{ $ocpy->code }} - {{ $ocpy->description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Building Const')}}</label>
                                                        <select id="slipbld_const" name="slipbld_const" class="e1 form-control form-control-sm ">
                                                            <option selected readonly>{{__('Building Const list')}}</option>
                                                            <option value="Buliding 1">Buliding 1</option>
                                                            <option value="Buliding 2">Buliding 2</option>
                                                            <option value="Buliding 3">Buliding 3</option>
                                                            <option value="Buliding 4">Buliding 4</option>
                                                            <option value="Buliding 5">Buliding 5 </option>
                                                            <option value="Buliding 6">Buliding 6</option>
                                                            <option value="Buliding 7">Buliding 7</option>
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-header bg-gray">
                                                                {{__('Reference Number')}}
                                                            </div>
                                                            <div class="card-body bg-light-gray ">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('Slip No.')}}</label>
                                                                        <input type="text" id="slipno" name="slipno" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('CN/DN')}}</label>
                                                                        <input type="text" id="slipcndn" name="slipcndn" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('Policy No')}}</label>
                                                                        <input type="text" id="slippolicy_no"  name="slippolicy_no" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" required/>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{__('Attachment')}} </label>
                                                    <div class="input-group">
                                                    
                                                        <div class="input-group control-group increment2" >
                                                        <input type="file" name="files[]" id="attachment" class="form-control">
                                                        <div class="input-group-btn"> 
                                                            <button class="btn btn-success" id="btn-success2" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                                        </div>
                                                        </div>
                                                        <div class="clone2 hide">
                                                        <div class="control-group input-group" id="control-group2" style="margin-top:10px">
                                                            <input type="file" name="files[]" id="attachment" class="form-control">
                                                            <div class="input-group-btn"> 
                                                            <button class="btn btn-danger" id="btn-danger2" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                            </div>
                                                        </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="insured-details-id" role="tabpanel" aria-labelledby="insured-details">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header bg-gray">
                                                        {{__('Interest Insured')}}
                                                    </div>
                                                    <div class="card-body bg-light-gray ">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="col-md-12 com-sm-12 mt-3">
                                                                    <table id="interestInsuredTable" class="table table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                        <th>{{__('Interest ID - Name')}}</th>
                                                                        <th>{{__('Amount')}}</th>
                                                                        <th width="20%">{{__('Actions')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                @php 
                                                                                $totalamountdata=0;
                                                                                @endphp
                                                                                @foreach($interestlist as $isl)
                                                                                    <tr id="iid{{ $isl->id }}">
                                                                                            <td>{{ $isl->interestinsured->description }}</td>
                                                                                            <td>{{ $isl->amount }}</td>
                                                                                            @php 
                                                                                            $totalamountdata=$totalamountdata+$isl->amount;
                                                                                            @endphp
                                                                                            <td><a href="javascript:void(0)" onclick="deleteinterestdetail({{ $isl->id }})">delete</i></a></td>
                                                                                    </tr>   
                                                                                @endforeach
                                                                            </tr>
                                                                            <tr>
                                                                                <form id="addinterestinsured">
                                                                                    @csrf
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <select id="slipinterestlist" name="slipinterestlist" class="form-control form-control-sm ">
                                                                                                <option selected disabled>{{__('Interest list')}}</option>
                                                                                                @foreach($interestinsured as $ii)
                                                                                                    <option value="{{ $ii->id }}">{{ $ii->code }} - {{ $ii->description }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>  
                                                                                    </td>

                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <input type="number" min="0" max="999999999,9999" value="" step=".01" id="slipamount" name="slipamount" class="form-control form-control-sm " data-validation="length" data-validation-length="0-20"/>
                                                                                        </div>
                                                                                    </td>

                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <button type="button" id="addinterestinsured-btn" class="btn btn-md btn-primary ">{{__('Add')}}</button>
                                                                                        </div>
                                                                                    </td>
                                                                                </form>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-end">
                                                <div class="form-group">
                                                    <label for="">{{__('Total Sum Insured') }}</label>
                                                    <input type="number" min="0" value="{{$totalamountdata}}" step=".0001" id="sliptotalsum" name="sliptotalsum" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" placeholder="tsi(*total/sum from interest insured)" />
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-md-12 d-flex justify-content-end">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">{{__('Type')}}</label>
                                                            <select id="sliptype" name="sliptype" class="form-control form-control-sm ">
                                                                {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
                                                                <option value="PML" selected >PML</option>
                                                                <option value="LOL">LOL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" style="opacity: 0;">{{__('Type')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <div class="input-group">
                                                                        <input type="number" value="0" step=".0001" id="slippct" name="slippct" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="pct" />
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
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for=""style="opacity: 0;">{{__('Type')}}</label>
                                                            <input type="number" value="0" step=".0001" id="sliptotalsumpct" name="sliptotalsumpct" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="=pct*tsi" readonly="readonly" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header bg-gray">
                                                        {{__('Deductible Panel')}}
                                                    </div>
                                                    <div class="card-body bg-light-gray ">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="col-md-12 com-sm-12 mt-3">
                                                                    <table id="deductiblePanel" class="table table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>{{__('Type')}}</th>
                                                                        <th>{{__('Currency')}}</th>
                                                                        <th>{{__('Percentage')}}</th>
                                                                        <th>{{__('Amount')}}</th>
                                                                        <th>{{__('MIn Claim Amount')}}</th>
                                                                        <th width="20%">{{__('Actions')}}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($deductiblelist as $isl)
                                                                            <tr id="iiddeductible{{ $isl->id }}">
                                                                                    <td>{{ $isl->DeductibleType->description }}</td>
                                                                                    <td>{{ @$isl->currency->code}} - {{@$isl->currency->symbol_name }}</td>
                                                                                    <td>{{ $isl->percentage }}</td>
                                                                                    <td>{{ $isl->amount }}</td>
                                                                                    <td>{{ $isl->min_claimamount }}</td>
                                                                                    <td><a href="#" onclick="deletedeductibledetail({{ $isl->id }})">delete</i></a></td>
                                                                            </tr>   
                                                                        @endforeach
                                                                         <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select id="slipdptype" name="slipdptype" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Type')}}</option>
                                                                                        @foreach($deductibletype as $dt)
                                                                                            <option value="{{ $dt->id }}">{{ $dt->abbreviation }} - {{ $dt->description }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select  id="slipdpcurrency" name="slipdpcurrency" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Currency')}}</option>
                                                                                        @foreach($currency as $crc)
                                                                                            <option value="{{ $crc->id }}">{{ $crc->code }} - {{ $crc->symbol_name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipdppercentage" name="slipdppercentage" placeholder="x" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipdpamount" name="slipdpamount" placeholder="=x*tsi" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipdpminamount" name="slipdpminamount" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                </div>
                                                                            </td> 
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" id="adddeductibleinsured-btn" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header bg-gray">
                                                        {{__('Extend Coverage')}}
                                                    </div>
                                                    <div class="card-body bg-light-gray ">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12 com-sm-12 mt-3">
                                                                    <table id="ExtendCoveragePanel" class="table table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>{{__('Peril Code - Name')}}</th>
                                                                        <th>{{__('Nilai (permil %.)')}}</th>
                                                                        <th>{{__('Amount')}}</th>
                                                                        <th width="20%">{{__('Actions')}}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($extendcoveragelist as $isl)
                                                                            <tr id="iidextendcoverage{{ $isl->id }}">
                                                                                    <td>{{ @$isl->extendcoveragedata->code}} - {{ @$isl->extendcoveragedata->name}} - {{@$isl->extendcoveragedata->description }}</td>
                                                                                    <td>{{ $isl->percentage }}</td>
                                                                                    <td>{{ $isl->amount }}</td>
                                                                                    <td><a href="#" onclick="deleteextendcoveragedetail({{ $isl->id }})">delete</i></a></td>
                                                                            </tr>   
                                                                        @endforeach
                                                                        <tr>
                                                                            <td >
                                                                                <div class="form-group">
                                                                                    <select id="slipcncode" name="slipcncode" class="form-control form-control-sm ">
                                                                                        <option selected readonly>{{__('Peril List')}}</option>
                                                                                        @foreach($extendedcoverage as $ncd)
                                                                                        <option value="{{ $ncd->id }}">{{ $ncd->code }} - {{ $ncd->name }} - {{ $ncd->description }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipnilaiec" name="slipnilaiec" placeholder="y" class="form-control form-control-sm "/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipamountec" name="slipamountec" placeholder="=y*tsi" class="form-control form-control-sm " readonly="readonly"/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" id="addextendcoverageinsured-btn" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="insurance-details-id" role="tabpanel" aria-labelledby="insurance-details">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>{{__('Insurance Periode')}}:</label>
                                                                <div class="input-group date" id="dateinfrom" data-target-input="nearest">
                                                                        <input type="text" id="slipipfrom" class="form-control form-control-sm datepicker-input" data-target="#date" name="slipipfrom">
                                                                        <div class="input-group-append datepickerinfrom" data-target="#dateinfrom" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label style="opacity: 0;">{{__('p')}}:</label>
                                                        <p class="d-flex justify-content-center">to</p>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label style="opacity: 0;">{{__('p')}}:</label>
                                                                <div class="input-group date" id="dateinto" data-target-input="nearest">
                                                                        <input type="text" id="slipipto" class="form-control form-control-sm datepicker-input" data-target="#date" name="slipipto">
                                                                        <div class="input-group-append datepickerinto" data-target="#dateinto" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>{{__('Reinsurance Periode')}}:</label>
                                                                <div class="input-group date" id="daterefrom" data-target-input="nearest">
                                                                        <input type="text" id="sliprpfrom" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="sliprpfrom">
                                                                        <div class="input-group-append" data-target="#daterefrom" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label style="opacity: 0;">{{__('p')}}:</label>
                                                        <p class="d-flex justify-content-center">to</p>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label style="opacity: 0;">{{__('p')}}:</label>
                                                                <div class="input-group date" id="datereto" data-target-input="nearest">
                                                                        
                                                                        <input type="text" id="sliprpto" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="sliprpto">
                                                                        <div class="input-group-append" data-target="#datereto" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-start">
                                            <i class="fa fa-info-circle" style="color: grey;" aria-hidden="true"> non proportional panel</i>
                                        </div>
                                        <div class="row d-flex justify-content-end">
                                            <div class="col-md-4">
                                                <label class="cl-switch cl-switch-green">
                                                    <span for="switch-proportional" class="label"> {{__('Proportional')}} </span>
                                                    <input type="checkbox" name="slipproportional[]" id="switch-proportional"
                                                    class="submit" checked>
                                                    <span class="switcher"></span>
                                                    <span  class="label"> {{__('Non Proportional')}} </span>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group d-flex justify-content-end">
                                                    <label style="opacity: 0;">{{__('p')}}:</label>
                                                    <button type="button" class="btn plus-button" data-toggle="modal" data-target="#addLayerModal">
                                                        <span data-toggle="tooltip" data-placement="top" title="{{__('Add New layer')}}"> + add layer </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">{{__('Layer for non proportional')}}</label>
                                                    <select id="sliplayerproportional" name="sliplayerproportional" class="form-control form-control-sm ">
                                                        <option selected disabled>{{__('Choose layer')}}</option>
                                                        <option value="Layer 1">Layer 1</option>
                                                        <option value="Layer 2">Layer 2</option>
                                                        <option value="Layer 3">Layer 3</option>
                                                        <option value="Layer 4">Layer 4</option>
                                                        <option value="Layer 5">Layer 5</option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex justify-content-start">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Rate (permil.. %)')}}</label>
                                                        <input type="number" value="0" step=".0001" id="sliprate" name="sliprate" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('Share')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <div class="input-group">
                                                                        <input type="number" value="0" step=".0001" id="slipshare" name="slipshare" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="b" />
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
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" style="opacity: 0;">{{__('slip sum share')}}</label>
                                                            <input type="number" value="0" step=".0001" id="slipsumshare" name="slipsumshare" placeholder="= b% * tsi" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Basic Premium')}}</label>
                                                        <input type="number" value="0" step=".0001" id="slipbasicpremium" name="slipbasicpremium" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a% * tsi" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Gross Prm to NR')}}</label>
                                                        <input type="number" value="0" step=".0001" id="slipgrossprmtonr" name="slipgrossprmtonr" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a% * b% * tsi" readonly="readonly" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('Commission')}}</label>
                                                            <div class="row d-flex flex-wrap">
                                                                <div class="col-md-10">
                                                                    <div class="input-group">
                                                                        <input type="number" value="0" step=".0001" id="slipcommission" name="slipcommission" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="d" />
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
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" style="opacity: 0;">{{__('Gross Prm to NR')}}</label>
                                                            <input type="number" value="0" step=".0001" id="slipsumcommission" name="slipsumcommission" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="= a% * b% * tsi * (100% - d%)" readonly="readonly" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Net Prm to NR')}}</label>
                                                        <input type="number" value="0" step=".0001" id="slipnetprmtonr" name="slipnetprmtonr" class="form-control form-control-sm " data-validation="length" placeholder="=a%. * b% * tsi * (100% - d%)" data-validation-length="2-50" readonly="readonly"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="installment-details-id" role="tabpanel" aria-labelledby="installment-details">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header bg-gray">
                                                        {{__('Installment Panel')}}
                                                    </div>
                                                    <div class="card-body bg-light-gray ">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="col-md-12 com-sm-12 mt-3">
                                                                    <table id="installmentPanel" class="table table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>{{__('Installment Date')}}</th>
                                                                        <th>{{__('Percentage')}}</th>
                                                                        <th>{{__('Amount')}}</th>
                                                                        <th width="20%">{{__('Actions')}}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($installmentlist as $isl)
                                                                            <tr id="iidinstallment{{ $isl->id }}">
                                                                                    <td>{{ $isl->installment_date }}</td>
                                                                                    <td>{{ $isl->percentage }}</td>
                                                                                    <td>{{ $isl->amount }}</td>
                                                                                    <td><a href="#" onclick="deleteinstallmentdetail({{ $isl->id }})">delete</i></a></td>
                                                                            </tr>   
                                                                        @endforeach
                                                                        <tr>
                                                                            <form id="addinstallmentinsured">
                                                                            @csrf
                                                                            <td>
                                                                                <div class="form-group">
                                                                                        <div class="input-group date" id="dateinstallment" data-target-input="nearest">
                                                                                                <input type="text" id="dateinstallmentdata" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="slipipdate">
                                                                                                <div class="input-group-append" data-target="#dateinstallment" data-toggle="datetimepicker">
                                                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" min="0" max="100" value="" step=".01"  id="slipippercentage" name="slipippercentage" placeholder="w" class="form-control form-control-sm " />
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" min="0" max="999999999,9999" value="" step=".01" id="slipipamount" name="slipipamount" placeholder="= w% * net premium to NR" class="form-control form-control-sm" readonly/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" id="addinstallmentinsured-btn"  class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
                                                                                </div>
                                                                            </td>
                                                                            </form>
                                                                        </tr>
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex justify-content-start">
                                                <div class="form-group">
                                                    <label for="">{{__('Retro Backup?')}}</label>
                                                    <select id="sliprb" name="sliprb" class="form-control form-control-sm ">
                                                        {{-- <option selected readonly>{{__('Select Continent')}}</option> --}}
                                                        <option value="AF" selected>YES</option>
                                                        <option value="AN">NO</option>
                                                    </select>
                                                </div>   
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="">{{__('Own Retention')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <input type="text" id="slipor" name="slipor" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span><i class="fa fa-percent" aria-hidden="true"></i></span></div> 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" id="slipsumor"  name="slipsumor" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header bg-gray">
                                                        {{__('Retrocession Panel')}}
                                                    </div>
                                                    <div class="card-body bg-light-gray ">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12 com-sm-12 mt-3">
                                                                    <table id="retrocessionPanel" class="table table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>{{__('Type')}}</th>
                                                                        <th>{{__('Retrocession Contract')}}</th>
                                                                        <th>{{__('Percentage')}}</th>
                                                                        <th>{{__('Amount')}}</th>
                                                                        <th width="20%">{{__('Actions')}}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($retrocessionlist as $isl)
                                                                            <tr id="iidretrocession{{ $isl->id }}">
                                                                                    <td>{{ $isl->type }}</td>
                                                                                    <td>{{ $isl->contract }}</td>
                                                                                    <td>{{ $isl->percentage }}</td>
                                                                                    <td>{{ $isl->amount }}</td>
                                                                                    <td><a href="#" onclick="deleteretrocessiondetail({{ $isl->id }})">delete</i></a></td>
                                                                            </tr>   
                                                                        @endforeach
                                                                        <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select id="sliprptype" name="sliprptype" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Type list')}}</option>
                                                                                        <option value="NM XOL">NM XOL</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select id="sliprpcontract" name="sliprpcontract" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Contract list')}}</option>
                                                                                        <option value="20NM11110">20NM11110</option>
                                                                                        <option value="20ABC">20ABC</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col-md-8">
                                                                                            <div class="input-group">
                                                                                                <input type="number" min="0" max="100" value="" step=".01" id="sliprppercentage" name="sliprppercentage" class="form-control form-control-sm " />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <div class="input-group-append">
                                                                                                <div class="input-group-text"><span><i class="fa fa-percent" aria-hidden="true"></i></span></div> 
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" id="sliprpamount" name="sliprpamount" placeholder="= w% * net premium to NR" class="form-control form-control-sm " readonly/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" id="addretrocessioninsured-btn" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                        <button type="submit" id="addslipinsured-btn" class="btn btn-primary btn-block ">
                                            {{__('Save')}}
                                        </button>
                                    </div>
                                
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
                
            </div>
        </div> 

    </div>
</div>
@endsection


@section('scripts')
@include('crm.transaction.fe_slip_js')
@endsection