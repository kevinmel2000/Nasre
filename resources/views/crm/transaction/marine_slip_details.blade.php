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
                                                        <option  readonly="readonly" selected>{{$isd->insured_prefix}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 1')}}</label>
                                                    <input type="text" id="autocomplete" name="msisuggestinsured" value="{{ $isd->insured_name }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="search for insured suggestion" readonly="readonly"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 2')}}</label>
                                                    <input type="text" name="msisuffix" id="autocomplete2" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="suffix: QQ or TBk" value="{{ $isd->insured_suffix }}" readonly="readonly" />
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
                                                        {{-- @foreach($routeship as $rs) --}}
                                                            <option value="{{ $isd->routeship->id }}" selected aria-readonly="true">{{ $isd->routeship->name }} - {{ $isd->routeship->description }}</option>
                                                        {{-- @endforeach --}}
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
                                            <input type="text" id="msicoinsurance" name="msicoinsurance" class="form-control form-control-sm " value="{{ $isd->coincurance }}" data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </form>

        <div class="card card-primary" id="sliplistSection">
            <div class="card-header bg-gray">
                <div class="row">
                    <div class="col-md-12">
                        {{__('Slip List')}}
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12 com-sm-12 mt-3">
                    <table id="SlipInsuredTableData" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{__('Slip Number')}}</th>
                                <th>{{__('UY')}}</th>
                                <th>{{__('Status')}}</th>
                                <th width="20%">{{__('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(@$slipdata2 as $slipdatatadetail)
                             <tr>
                                    <td><a class="text-primary mr-3 " data-toggle="modal" data-target="#detailmodaldata" href="javascript:void(0)" onclick="detailslip({{ @$slipdatatadetail->id }})">{{ @$slipdatatadetail->number }}</a></td>
                                    <td>{{ @$slipdatatadetail->uy }}</td>
                                    <td >{{ @$slipdatatadetail->status }}</td>
                                    <td><a class="text-primary mr-3 float-right " data-toggle="modal" data-target="#editmodaldata" href="javascript:void(0)" onclick="editslip({{  @$slipdatatadetail->id }})">Update </a><a href="javascript:void(0)" onclick="endorsementmarine({{  @$slipdatatadetail->id }})"> Endorsement</a></td>
                             </tr>   
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card ">
            <div class="card-header bg-gray">
                {{__('Slip Details')}}
            </div>
            <div class="card-body bg-light-gray">
                
                <div class="container-fluid p-3">
                    <form id="marineslipform" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                        @foreach($slip as $slp)
                            <div class="card card-tabs">
                                
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                        <li class="pt-1 px-3"><h3 class="card-title">{{__('Slip Data')}}</h3></li>
                                        <li class="nav-item">
                                        <a class="nav-link active" id="general-details" data-toggle="pill" href="#general-details-id" role="tab" aria-controls="general-details-id" aria-selected="true">{{__('General Data')}}</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" id="insured-details" data-toggle="pill" href="#insured-details-id" role="tab" aria-controls="address-details-id" aria-selected="false">{{__('Insured Data')}}</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                        <a class="nav-link" id="insurance-details" data-toggle="pill" href="#insurance-details-id" role="tab" aria-controls="social-media-details-id" aria-selected="false">{{__('Insurance Measurement')}}</a>
                                        </li> --}}
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
                                                    <a href="{{url('/transaction-data/marine-endorsement', $slp->id )}}" class="btn btn-sm btn-primary float-right" >{{__('Endorsement')}}</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="hidden" name="_token2" id="token" value="{{ csrf_token() }}">
                                                            <label for="">{{__('Number')}} </label>
                                                            <input type="text" id="slipnumber" name="slipnumber" class="form-control form-control-sm" data-validation="length" data-validation-length="0-25" value="{{ $slp->number }}" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{__('Username')}}</label>
                                                                <input type="text" id="slipusername" name="slipusername" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{$slp->username}}" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{__('Prod Year')}}:</label>
                                                                    <div class="input-group date" id="date" data-target-input="nearest">
                                                                            <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" id="slipprodyear" name="slipprodyear" value="{{ $slp->prod_year }}" readonly="readonly">
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
                                                                <input type="number" id="slipuy" name="slipuy" class="form-control form-control-sm " data-validation="length"  data-validation-length="0-15" value="{{ $slp->uy }}" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Status')}}</label>
                                                            <select id="slipstatus" name="slipstatus" class="form-control form-control-sm ">
                                                                {{-- <option selected disabled>{{__('Select Status')}}</option> --}}
                                                                <option value="{{ $slp->status }}" aria-readonly="true" selected>{{ $slp->status }}</option>
                                                                
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
                                                                        <input type="text" id="sliped" name="sliped" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->endorsment }}" readonly="readonly" />
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                        <input type="text" id="slipsls" name="slipsls" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->selisih }}" readonly="readonly"/>
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
                                                                @foreach($statuslist as $stl)
                                                                    <tr id="sid{{ $stl->id }}" data-name="shiplistvalue[]">
                                                                            <td data-name="{{ $stl->id }}">{{ $stl->status }}</td>
                                                                            <td data-name="{{ $stl->datetime }}">{{ $stl->datetime }}</td>
                                                                            <td data-name="{{ $stl->user }}">{{ $stl->user }}</td>
                                                                    </tr>   
                                                                @endforeach  
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
                                                            {{-- <option value="" disabled selected>Ceding or Broker</option> --}}
                                                            
                                                                <option value="{{ $slp->cedingbroker->id }}" aria-readonly="true" selected>{{ $slp->cedingbroker->companytype->name }} - {{ $slp->cedingbroker->code }} - {{ $slp->cedingbroker->name }}</option>
                                                            
                                                        </select>
                                                    </div>    
                                                    <div class="form-group">
                                                        <select id="slipceding" name="slipceding" class="e1 form-control form-control-sm ">
                                                            {{-- <option value="" disabled selected>Ceding </option> --}}
                                                            
                                                                <option value="{{ $slp->ceding->id }}" aria-readonly="true">{{ $slp->ceding->code }} - {{ $slp->ceding->name }}</option>
                                                            
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
                                                                {{-- <option selected disabled>{{__('Select Currency')}}</option> --}}
                                                               
                                                                    <option value="{{ $slp->currencies->id }}" selected aria-readonly="true">{{ $slp->currencies->code }} - {{ $slp->currencies->symbol_name }}</option>
                                                                
                                                            </select>
                                                        </div>    
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('COB')}}</label>
                                                            <select id="slipcob" name="slipcob" class="e1 form-control form-control-sm ">
                                                                {{-- <option selected disabled>{{__('COB list')}}</option> --}}
                                                                
                                                                    <option value="{{ $slp->corebusiness->id }}">{{ $slp->corebusiness->code }} - {{ $slp->corebusiness->description }}</option>
                                                                
                                                            </select>
                                                        </div>    
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('KOC')}}</label>
                                                            <select id="slipkoc" name="slipkoc" class="e1 form-control form-control-sm ">
                                                                {{-- <option selected disabled>{{__('KOC list')}}</option> --}}
                                                                
                                                                    <option value="{{ $slp->kindcontract->id }}">{{ $slp->kindcontract->code }} - {{ $slp->kindcontract->description }}</option>
                                                                
                                                            </select>
                                                        </div>    
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Occupacy')}}</label>
                                                            <select id="slipoccupacy" name="slipoccupacy" class="e1 form-control form-control-sm ">
                                                                {{-- <option selected disabled>{{__('Occupation list')}}</option> --}}
                                                                
                                                                    <option value="{{ $slp->occupation->id }}">{{ $slp->occupation->code }} - {{ $slp->occupation->description }}</option>
                                                                
                                                            </select>
                                                        </div>    
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Building Const')}}</label>
                                                            <select id="slipbld_const" name="slipbld_const" class="e1 form-control form-control-sm ">
                                                                {{-- <option selected disabled>{{__('Building Const list')}}</option> --}}
                                                                <option value="{{ $slp->build_const }}">{{ $slp->build_const }}</option>
                                                                
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
                                                                            <input type="text" id="slipno" name="slipno" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->slip_no }} " readonly="readonly" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">{{__('CN/DN')}}</label>
                                                                            <input type="text" id="slipcndn" name="slipcndn" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->cn_dn }} " readonly="readonly" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">{{__('Policy No')}}</label>
                                                                            <input type="text" id="slippolicy_no" name="slippolicy_no" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->policy_no }} " readonly="readonly" />
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
                                                                <input type="file" name="files[]" id="attachment" class="form-control" multiple>
                                                            </div>
                                                            @foreach($filelist as $isl)
                                                                <div class="control-group input-group" id="control-group2" style="margin-top:10px">
                                                                    <a href="{{ asset('files')}}/{{$isl->filename}}">{{$isl->filename}}</a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Coinsurance')}}</label>
                                                        <input type="text" id="slipcoinsurance" name="slipcoinsurance" class="form-control form-control-sm " value="{{ $slp->coinsurance_slip }} " data-validation="length" data-validation-length="0-50" />
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
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($interestlist as $isl)
                                                                                    <tr id="iid{{ $isl->id }}" data-name="interestvalue[]">
                                                                                            <td data-name="{{ $isl->interest_id }}">{{ $isl->interestinsureddata->description }}</td>
                                                                                            <td data-name="{{ $isl->amount }}">{{ $isl->amount }}</td>
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
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <div class="form-group">
                                                        <label for="">{{__('Total Sum Insured')}}</label>
                                                        <input type="number" min="0" step=".0001" id="sliptotalsum" name="sliptotalsum" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->total_sum_insured }}" readonly="readonly" placeholder="tsi(*total/sum from interest insured)" />
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
                                                                    <option value="{{ $slp->insured_type }}" aria-readonly="true" selected >{{ $slp->insured_type }}</option>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" style="opacity: 0;">{{__('Type')}}</label>
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="input-group">
                                                                            <input type="number"  step=".0001" id="slippct" name="slippct" value="{{ $slp->insured_pct }}" readonly="readonly" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="pct" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text"><span><i class="fa fa-percent"  aria-hidden="true"></i></span></div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for=""style="opacity: 0;">{{__('Type')}}</label>
                                                                <input type="number" step=".0001" id="sliptotalsumpct" name="sliptotalsumpct" value="{{ $slp->total_sum_pct }}" readonly="readonly" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="=pct*tsi" readonly="readonly" />
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
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($deductibletemp as $dtt)
                                                                                <tr id="ddtid{{ $dtt->id }}">
                                                                                        <td data-name="{{ $dtt->deductible_id }}">{{ $dtt->DeductibleType->abbreviation }} - {{ $dtt->DeductibleType->description }}</td>
                                                                                        <td data-name="{{ $dtt->currency_id }}">{{ $dtt->currency->symbol_name }}</td>
                                                                                        <td data-name="{{ $dtt->percentage }}">{{ $dtt->percentage }}</td>
                                                                                        <td data-name="{{ $dtt->amount }}">{{ $dtt->amount }}</td>
                                                                                        <td data-name="{{ $dtt->min_claimamount }}">{{ $dtt->min_claimamount }}</td>
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header bg-gray">
                                                            {{__('Condition Needed')}}
                                                        </div>
                                                        <div class="card-body bg-light-gray ">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-12 com-sm-12 mt-3">
                                                                        <table id="conditionNeeded" class="table table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{__('Condition Needed Code - Name')}}</th>
                                                                            <th>{{__('Information')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($conditionneededtemp as $cnt)
                                                                                <tr id="cnid{{ $cnt->id }}">
                                                                                        <td data-name="{{ $cnt->condition_id }}">{{ $cnt->conditionneeded->name }} - {{ $cnt->conditionneeded->description }}</td>
                                                                                        <td data-name="{{ $cnt->information }}">@if($cnt->information == null)
                                                                                                - 
                                                                                            @else
                                                                                                {{ $cnt->information }}
                                                                                            @endif
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
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>{{__('Insurance Periode')}}:</label>
                                                                    <div class="input-group date" id="dateinfrom" data-target-input="nearest">
                                                                            <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" id="slipipfrom" value="{{ $slp->insurance_period_from }}" readonly="readonly" name="slipipfrom">
                                                                            <div class="input-group-append datepickerinfrom" data-target="#dateinfrom" data-toggle="">
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
                                                                            <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" value="{{ $slp->insurance_period_to }}" readonly="readonly" id="slipipto" name="slipipto">
                                                                            <div class="input-group-append datepickerinto" data-target="#dateinto" data-toggle="">
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
                                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" value="{{ $slp->reinsurance_period_from }}" readonly="readonly" id="sliprpfrom" name="sliprpfrom">
                                                                            <div class="input-group-append" data-target="#daterefrom" data-toggle="">
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
                                                                            
                                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" value="{{ $slp->reinsurance_period_to }}" readonly="readonly" data-target="#date" id="sliprpto" name="sliprpto">
                                                                            <div class="input-group-append" data-target="#datereto" data-toggle="">
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
                                                        <input type="checkbox" name="slipproportional[]" value="{{ $slp->proportional }}" id="switch-proportional"
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
                                                            {{-- <option selected disabled>{{__('Choose layer')}}</option> --}}
                                                            <option value="{{ $slp->layer_non_proportional }}">{{ $slp->layer_non_proportional }}</option>
                                                        </select>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 d-flex justify-content-start">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Rate (permil.. %)')}}</label>
                                                            <input type="number"  step=".0001" id="sliprate" name="sliprate" value="{{ $slp->rate }}" readonly="readonly" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a" />
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
                                                                            <input type="number" step=".0001" id="slipshare" name="slipshare" value="{{ $slp->share }}" readonly="readonly" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="b" />
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
                                                                <input type="number"  step=".0001" id="slipsumshare" name="slipsumshare" value="{{ $slp->sum_share }}" readonly="readonly" placeholder="= b% * tsi" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50"  />
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
                                                            <input type="number"  step=".0001" id="slipbasicpremium" name="slipbasicpremium" class="form-control form-control-sm " value="{{ $slp->basic_premium }}" readonly="readonly" data-validation="length" data-validation-length="0-50" placeholder="a% * tsi" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Gross Prm to NR')}}</label>
                                                            <input type="number"  step=".0001" id="slipgrossprmtonr" name="slipgrossprmtonr" class="form-control form-control-sm " value="{{ $slp->grossprm_to_nr }}" readonly="readonly" data-validation="length" data-validation-length="0-50" placeholder="a% * b% * tsi" />
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
                                                                            <input type="number"  step=".0001" id="slipcommission" name="slipcommission" class="form-control form-control-sm " data-validation="length" value="{{ $slp->commission }}" readonly="readonly" data-validation-length="0-50" placeholder="d" />
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
                                                                <input type="number" step=".0001" id="slipsumcommission" name="slipsumcommission" class="form-control form-control-sm " data-validation="length" value="{{ $slp->sum_commission }}" readonly="readonly" data-validation-length="0-50" placeholder="= a% * b% * tsi * (100% - d%)"  />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Net Prm to NR')}}</label>
                                                            <input type="number"  step=".0001" id="slipnetprmtonr" name="slipnetprmtonr" class="form-control form-control-sm " value="{{ $slp->netprm_to_nr }}" readonly="readonly" data-validation="length" placeholder="=a%. * b% * tsi * (100% - d%)" data-validation-length="0-50" />
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
                                                                            
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($installmentpanel as $isp)
                                                                                <tr id="ispid{{ $isp->id }}">
                                                                                        <td data-name="{{ $isp->installment_date }}">{{ $isp->installment_date }}</td>
                                                                                        <td data-name="{{ $isp->percentage }}">{{ $isp->percentage }}</td>
                                                                                        <td data-name="{{ $isp->amount }}">{{ $isp->amount }}</td>
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
                                            <div class="row">
                                                <div class="col-md-6 d-flex justify-content-start">
                                                    <div class="form-group">
                                                        <label for="">{{__('Retro Backup?')}}</label>
                                                        <select id="sliprb" name="sliprb" class="form-control form-control-sm ">
                                                            {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
                                                            <option value="{{ $slp->retro_backup }}" aria-readonly="true" selected>{{ $slp->retro_backup }}</option>
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
                                                                        <input type="number" value="{{ $slp->own_retention }}" readonly="readonly" step=".0001" id="slipor" name="slipor" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text"><span><i class="fa fa-percent" aria-hidden="true"></i></span></div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="number" value="{{ $slp->sum_own_retention }}" readonly="readonly" step=".0001" id="slipsumor" name="slipsumor" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="= x% * b% * tsi"  />
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
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($retrocessiontemp as $rsc)
                                                                                <tr id="rscid{{ $rsc->id }}">
                                                                                        <td data-name="{{ $rsc->type }}">{{ $rsc->type }}</td>
                                                                                        <td data-name="{{ $rsc->contract }}">{{ $rsc->contract }}</td>
                                                                                        <td data-name="{{ $rsc->percentage }}">{{ $rsc->percentage }}</td>
                                                                                        <td data-name="{{ $rsc->amount }}">{{ $rsc->amount }}</td>
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
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 com-sm-12 mt-3">
                                            <a type="button" href="{{ url('transaction-data/marine-slip/edit', $slp->id) }}" id="addslipsave-btn" class="btn btn-primary btn-block ">
                                                {{__('EDIT')}}
                                            </a>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div> 

                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 com-sm-12 mt-3">
                                            <a type="button" href="{{url('/transaction-data/marine-index')}}" id="addinsuredsave-btn" class="btn btn-primary btn-block ">
                                                {{__('BACK')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            
                        @endforeach
                    </form>
                </div>
                
            </div>
        </div> 

    </div>
</div>
@include('crm.transaction.marine_modal_slip')
@include('crm.transaction.marine_modal_edit')

@endsection

@section('scripts')
@include('crm.transaction.marine_slip_detail_js')
@endsection