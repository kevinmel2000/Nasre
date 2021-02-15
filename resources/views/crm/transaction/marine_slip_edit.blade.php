@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        <div class="card ">
            <div class="card-header bg-gray">
                {{__('Slip Details')}}
            </div>
            <div class="card-body bg-light-gray">
                
                <div class="container-fluid p-3">
                    <form id="marineslipform" >
                        @csrf
                        {{ method_field('POST') }}      
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
                                                            <input type="hidden" name="_token2" id="token" value="{{ csrf_token() }}" />
                                                            <input type="hidden" name="idslip" id="idslip" value="{{$slp->id}}" />
                                                            <input type="hidden" name="msinumber" id="msinumber" value="{{$slp->insured_id}}" />
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
                                                                            <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" id="slipprodyear" name="slipprodyear" value="{{ $slp->prod_year }}" readonly="readonly" />
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
                                                                <input type="number" id="slipuy" name="slipuy" class="form-control form-control-sm " data-validation="length"  data-validation-length="0-15" value="{{ $slp->uy }}"  />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Status')}}</label>
                                                            <select id="slipstatus" name="slipstatus" class="form-control form-control-sm ">
                                                                {{-- <option selected disabled>{{__('Select Status')}}</option> --}}
                                                                @if( $slp->status == 'offer' )
                                                                    <option value="{{ $slp->status }}" selected>{{ $slp->status }}</option>
                                                                    <option value="binding">Binding</option>
                                                                    <option value="slip">Slip</option>
                                                                    <option value="endorsement">Endorsement</option>
                                                                    <option value="decline">Decline</option>
                                                                    <option value="cancel">Cancel</option>
                                                                @elseif($slp->status == 'binding')
                                                                    <option value="offer">Offer</option>
                                                                    <option value="{{ $slp->status }}" selected>{{ $slp->status }}</option>
                                                                    <option value="endorsement">Endorsement</option>
                                                                    <option value="decline">Decline</option>
                                                                    <option value="cancel">Cancel</option>
                                                                @elseif($slp->status == 'slip')
                                                                    <option value="offer">Offer</option>
                                                                    <option value="binding">Binding</option>
                                                                    <option value="{{ $slp->status }}" selected>{{ $slp->status }} </option>
                                                                    <option value="endorsement">Endorsement</option>
                                                                    <option value="decline">Decline</option>
                                                                    <option value="cancel">Cancel</option>
                                                                @elseif($slp->status == 'endorsment')
                                                                    <option value="offer">Offer</option>
                                                                    <option value="binding">Binding</option>
                                                                    <option value="slip">Slip</option>
                                                                    <option value="{{ $slp->status }}" selected>{{ $slp->status }}</option>
                                                                    <option value="decline">Decline</option>
                                                                    <option value="cancel">Cancel</option>
                                                                @elseif($slp->status == 'decline')
                                                                    <option value="offer">Offer</option>
                                                                    <option value="binding">Binding</option>
                                                                    <option value="slip">Slip</option>
                                                                    <option value="endorsement">Endorsement</option>
                                                                    <option value="{{ $slp->status }}"  selected>{{ $slp->status }}</option>
                                                                    <option value="cancel">Cancel</option>
                                                                @elseif($slp->status == 'cancel')
                                                                    <option value="offer">Offer</option>
                                                                    <option value="binding">Binding</option>
                                                                    <option value="slip">Slip</option>
                                                                    <option value="endorsement">Endorsement</option>
                                                                    <option value="decline">Decline</option>
                                                                    <option value="{{ $slp->status }}"  selected>{{ $slp->status }}</option>
                                                                @endif
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
                                                                        <input type="text" id="sliped" name="sliped" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->endorsment }}"  />
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                        <input type="text" id="slipsls" name="slipsls" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->selisih }}" />
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
                                                            @foreach($cedingbroker as $cedbrok)
                                                                @if($slp->source  == $cedbrok->id)
                                                                    <option value="{{ $cedbrok->id }}" selected>{{ $cedbrok->companytype->name }} - {{ $cedbrok->code }} - {{ $cedbrok->name }}</option>
                                                                    
                                                                @else 
                                                                    <option value="{{ $cedbrok->id }}">{{ $cedbrok->companytype->name }} - {{ $cedbrok->code }} - {{ $cedbrok->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                    <div class="form-group">
                                                        <select id="slipceding" name="slipceding" class="e1 form-control form-control-sm ">
                                                            {{-- <option value="" disabled selected>Ceding </option> --}}
                                                            @foreach($ceding as $cd)
                                                                @if($slp->source_2  == $cd->id)
                                                                    <option value="{{ $cd->id }}" selected>{{ $cd->code }} - {{ $cd->name }}</option>
                                                                @else 
                                                                    <option value="{{ $cd->id }}" >{{ $cd->code }} - {{ $cd->name }}</option>
                                                                @endif
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
                                                                {{-- <option selected disabled>{{__('Select Currency')}}</option> --}}
                                                                @foreach($currency as $crc)
                                                                    @if($slp->currency  == $crc->id)
                                                                        <option value="{{ $crc->id }}" selected >{{ $crc->code }} - {{ $crc->symbol_name }}</option>
                                                                    @else
                                                                        <option value="{{ $crc->id }}" >{{ $crc->code }} - {{ $crc->symbol_name }}</option>
                                                                    @endif
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
                                                                {{-- <option selected disabled>{{__('COB list')}}</option> --}}
                                                                @foreach($cob as $cobdata)
                                                                    @if($slp->cob  == $cobdata->id)
                                                                        <option value="{{ $cobdata->id }}" selected>{{ $cobdata->code }} - {{ $cobdata->description }}</option>
                                                                    @else 
                                                                        <option value="{{ $cobdata->id }}" >{{ $cobdata->code }} - {{ $cobdata->description }}</option>
                                                                    @endif
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
                                                                {{-- <option selected disabled>{{__('KOC list')}}</option> --}}
                                                                @foreach($koc as $kocdata)
                                                                    @if($slp->koc  == $kocdata->id)
                                                                        <option value="{{ $kocdata->id }}" selected>{{ $kocdata->code }} - {{ $kocdata->description }}</option>
                                                                    @else 
                                                                        <option value="{{ $kocdata->id }}">{{ $kocdata->code }} - {{ $kocdata->description }}</option>
                                                                    @endif
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
                                                                {{-- <option selected disabled>{{__('Occupation list')}}</option> --}}
                                                                @foreach($ocp as $ocpdata)
                                                                    @if($slp->occupacy  == $ocpdata->id)
                                                                        <option value="{{ $ocpdata->id }}" selected> {{ $ocpdata->code }} - {{ $ocpdata->description }}</option>
                                                                    @else
                                                                    <option value="{{ $ocpdata->id }}">{{ $ocpdata->code }} - {{ $ocpdata->description }}</option>
                                                                    @endif
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
                                                                {{-- <option selected disabled>{{__('Building Const list')}}</option> --}}
                                                                @if($slp->build_const = "Buliding 1")
                                                                    <option value="{{ $slp->build_const }}">{{ $slp->build_const }}</option>
                                                                    <option value="Buliding 2">Buliding 2</option>
                                                                    <option value="Buliding 3">Buliding 3</option>
                                                                    <option value="Buliding 4">Buliding 4</option>
                                                                    <option value="Buliding 5">Buliding 5 </option>
                                                                    <option value="Buliding 6">Buliding 6</option>
                                                                    <option value="Buliding 7">Buliding 7</option>
                                                                @elseif($slp->build_const = "Buliding 2")
                                                                    <option value="Buliding 1">Buliding 1</option>
                                                                    <option value="{{ $slp->build_const }}">{{ $slp->build_const }}</option>
                                                                    <option value="Buliding 3">Buliding 3</option>
                                                                    <option value="Buliding 4">Buliding 4</option>
                                                                    <option value="Buliding 5">Buliding 5 </option>
                                                                    <option value="Buliding 6">Buliding 6</option>
                                                                    <option value="Buliding 7">Buliding 7</option>
                                                                @elseif($slp->build_const = "Buliding 3")
                                                                    <option value="Buliding 1">Buliding 1</option>
                                                                    <option value="Buliding 2">Buliding 2</option>
                                                                    <option value="{{ $slp->build_const }}">{{ $slp->build_const }}</option>
                                                                    <option value="Buliding 4">Buliding 4</option>
                                                                    <option value="Buliding 5">Buliding 5 </option>
                                                                    <option value="Buliding 6">Buliding 6</option>
                                                                    <option value="Buliding 7">Buliding 7</option>
                                                                @elseif($slp->build_const = "Buliding 4")
                                                                    <option value="Buliding 1">Buliding 1</option>
                                                                    <option value="Buliding 2">Buliding 2</option>
                                                                    <option value="Buliding 3">Buliding 3</option>
                                                                    <option value="{{ $slp->build_const }}">{{ $slp->build_const }}</option>
                                                                    <option value="Buliding 5">Buliding 5 </option>
                                                                    <option value="Buliding 6">Buliding 6</option>
                                                                    <option value="Buliding 7">Buliding 7</option>
                                                                @elseif($slp->build_const = "Buliding 5")
                                                                    <option value="Buliding 1">Buliding 1</option>
                                                                    <option value="Buliding 2">Buliding 2</option>
                                                                    <option value="Buliding 3">Buliding 3</option>
                                                                    <option value="Buliding 4">Buliding 4 </option>
                                                                    <option value="{{ $slp->build_const }}">{{ $slp->build_const }}</option>
                                                                    <option value="Buliding 6">Buliding 6</option>
                                                                    <option value="Buliding 7">Buliding 7</option>
                                                                @elseif($slp->build_const = "Buliding 6")
                                                                    <option value="Buliding 1">Buliding 1</option>
                                                                    <option value="Buliding 2">Buliding 2</option>
                                                                    <option value="Buliding 3">Buliding 3</option>
                                                                    <option value="Buliding 4">Buliding 4 </option>
                                                                    <option value="Buliding 5">Buliding 5</option>
                                                                    <option value="{{ $slp->build_const }}">{{ $slp->build_const }}</option>
                                                                    <option value="Buliding 7">Buliding 7</option>
                                                                @elseif($slp->build_const = "Buliding 7")
                                                                    <option value="Buliding 1">Buliding 1</option>
                                                                    <option value="Buliding 2">Buliding 2</option>
                                                                    <option value="Buliding 3">Buliding 3</option>
                                                                    <option value="Buliding 4">Buliding 4 </option>
                                                                    <option value="Buliding 5">Buliding 5</option>
                                                                    <option value="Buliding 6">Buliding 6</option>
                                                                    <option value="{{ $slp->build_const }}">{{ $slp->build_const }}</option>
                                                                @endif
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
                                                                            <input type="text" id="slipno" name="slipno" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->slip_no }}"  />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">{{__('CN/DN')}}</label>
                                                                            <input type="text" id="slipcndn" name="slipcndn" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->cn_dn }}" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">{{__('Policy No')}}</label>
                                                                            <input type="text" id="slippolicy_no" name="slippolicy_no" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{ $slp->policy_no }}" />
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
                                                                <input type="file" name="files[]" id="attachment" class="form-control" />
                                                                <div class="input-group-btn"> 
                                                                    <button class="btn btn-success" id="btn-success2" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                                                </div>
                                                            </div>
                                                            <div class="clone2 hide">
                                                                <div class="control-group input-group" id="control-group2" style="margin-top:10px">
                                                                    <input type="file" name="files[]" id="attachment" class="form-control" />
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
                                                                                @foreach($interestlist as $isl)
                                                                                        <tr id="iid{{ $isl->id }}" data-name="interestvalue[]">
                                                                                                <td id="interestdescription" data-name="{{ $isl->interest_id }}">{{ $isl->interestinsureddata->description }}</td>
                                                                                                <td id="interestamount" data-name="{{ $isl->amount }}">{{ $isl->amount }}</td>
                                                                                                <td>
                                                                                                    <input type="hidden" id="interestidupdate" value="{{ $isl->id }}"/>
                                                                                                    <a class="text-primary mr-3" id="editinterestinsured" type="button" onClick="geteditinterest({{ $isl->id }})" href="javascript:void(0)">
                                                                                                        <i class="fas fa-edit"></i>
                                                                                                    </a>
                                                                                                    <a type="button" href="javascript:void(0)" onClick="deleteshipdetail({{ $isl->id }})"><i class="fas fa-trash text-danger"></i></a>
                                                                                                </td>
                                                                                        </tr>   
                                                                                @endforeach 
                                                                            
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
                                                                                                    <input type="number" min="0" max="999999999,9999" value="" step=".01" id="slipamount" name="slipamount" class="form-control form-control-sm " data-validation="length" data-validation-length="0-15" />
                                                                                                </div>
                                                                                            </td>
                    
                                                                                            <td>
                                                                                                <div class="form-group">
                                                                                                    <button type="button" onClick="interestdetailupdate({{$isl->id}})" id="updateinterestinsured-btn" class="btn btn-md btn-primary ">{{__('Update')}}</button>
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
                                                                    @if($slp->insured_type == "PML")
                                                                        <option value="{{ $slp->insured_type }}" selected >{{ $slp->insured_type }}</option>
                                                                        <option value="LOL">LOL</option>
                                                                    @else 
                                                                        <option value="PML" >PML</option>
                                                                        <option value="{{ $slp->insured_type }}" selected >{{ $slp->insured_type }}</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" style="opacity: 0;">{{__('Type')}}</label>
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="input-group">
                                                                            <input type="number"  step=".0001" id="slippct" name="slippct" value="{{ $slp->insured_pct }}"  class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="pct" />
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
                                                                            <th>{{__('Min Claim Amount')}}</th>
                                                                            <th width="20%">{{__('Actions')}}</th>
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
                                                                                            <td>
                                                                                                <input type="hidden" id="deductidupdate" value="{{ $dtt->id }}"/>
                                                                                                <a class="text-primary mr-3" id="editdeductibletype" type="button" href="javascript:void(0)"  onClick="geteditdeductible({{ $dtt->id }})">
                                                                                                    <i class="fas fa-edit"></i>
                                                                                                </a>
                                                                                                <a type="button" href="javascript:void(0)" onClick="deletedeductibletype({{ $dtt->id }})"><i class="fas fa-trash text-danger"></i></a>
                                                                                            </td>
                                                                                    </tr>  
                                                                            @endforeach 
                                                                                <tr>
                                                                                    <form id="adddeductibletype">
                                                                                        @csrf
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
                                                                                                <select id="slipdpcurrency" name="slipdpcurrency" class="form-control form-control-sm ">
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
                                                                                                <input type="number" value="0" step=".0001" id="slipdpminamount" name="slipdpminamount" placeholder="min amount" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                            </div>
                                                                                        </td> 
                                                                                        <td>
                                                                                            <div class="form-group">
                                                                                                <button type="button" id="updatedeductibletype-btn" onClick="deductibledetailupdate({{$dtt->id}})" class="btn btn-md btn-primary" >{{__('Update')}}</button>
                                                                                                <button type="button" id="adddeductibletype-btn" class="btn btn-md btn-primary ">{{__('Add')}}</button>
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
                                                                            <th width="20%">{{__('Actions')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($conditionneededtemp as $cnt)
                                                                                <tr id="cnid{{ $cnt->id }}">
                                                                                        <td data-name="{{ $cnt->condition_id }}">{{ $cnt->conditionneeded->name }} - {{ $cnt->conditionneeded->description }}</td>
                                                                                        <td data-name="{{ $cnt->information }}">
                                                                                            @if($cnt->information == null)
                                                                                                - 
                                                                                            @else
                                                                                                {{ $cnt->information }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="hidden" id="cnidupdate" value="{{ $cnt->id }}"/>
                                                                                            <a class="text-primary mr-3" id="editconditionneeded" type="button" onClick="geteditconditionneeded({{ $cnt->id }})" href="javascript:void(0)">
                                                                                                <i class="fas fa-edit"></i>
                                                                                            </a>
                                                                                            <a type="button" href="javascript:void(0)" onClick="deleteconditionneeded({{ $cnt->id }})"><i class="fas fa-trash text-danger"></i></a>
                                                                                        </td>
                                                                                </tr>   
                                                                            @endforeach
                                                                                <tr>
                                                                                    <form id="addconditionneeded">
                                                                                        @csrf
                                                                                        <td colspan="2">
                                                                                            <div class="form-group">
                                                                                                <select id="slipcncode" name="slipcncode" class="form-control form-control-sm ">
                                                                                                    <option selected disabled>{{__('Condition Needed Code - Name - Information List')}}</option>
                                                                                                    @foreach($cnd as $ncd)
                                                                                                    <option value="{{ $ncd->id }}">{{ $ncd->code }} - {{ $ncd->name }} - {{ $ncd->description }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>  
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="form-group">
                                                                                                <button type="button" class="btn btn-md btn-primary" onClick="conditionneededdetailupdate({{ $cnt->id }})" id="updateconditionneeded-btn">{{__('Update')}}</button>
                                                                                                <button type="button" id="addconditionneeded-btn" class="btn btn-md btn-primary ">{{__('Add')}}</button>
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
                                        </div>
                                        <div class="tab-pane fade" id="insurance-details-id" role="tabpanel" aria-labelledby="insurance-details">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>{{__('Insurance Periode')}}:</label>
                                                                    <div class="input-group date" id="dateinfrom" data-target-input="nearest">
                                                                            <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" id="slipipfrom" value="{{ $slp->insurance_period_from }}"  name="slipipfrom"/>
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
                                                                            <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" value="{{ $slp->insurance_period_to }}"  id="slipipto" name="slipipto" />
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
                                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" value="{{ $slp->reinsurance_period_from }}"  id="sliprpfrom" name="sliprpfrom" />
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
                                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" value="{{ $slp->reinsurance_period_to }}" data-target="#date" id="sliprpto" name="sliprpto" />
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
                                                        <input type="checkbox" name="slipproportional[]" value="{{ $slp->proportional }}" id="switch-proportional" class="submit" checked />
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
                                                            @if( $slp->layer_non_proportional == "Layer 1")
                                                                <option value="{{ $slp->layer_non_proportional }}" selected>{{ $slp->layer_non_proportional }}</option>
                                                                <option value="Layer 2">Layer 2</option>
                                                                <option value="Layer 3">Layer 3</option>
                                                                <option value="Layer 4">Layer 4</option>
                                                                <option value="Layer 5">Layer 5</option>
                                                            @elseif($slp->layer_non_proportional == "Layer 2")
                                                                <option value="Layer 1">Layer 1</option>
                                                                <option value="{{ $slp->layer_non_proportional }}" selected>{{ $slp->layer_non_proportional }}</option>
                                                                <option value="Layer 3">Layer 3</option>
                                                                <option value="Layer 4">Layer 4</option>
                                                                <option value="Layer 5">Layer 5</option>
                                                            @elseif($slp->layer_non_proportional == "Layer 3")
                                                                <option value="Layer 1">Layer 1</option>
                                                                <option value="Layer 2">Layer 2</option>
                                                                <option value="{{ $slp->layer_non_proportional }}" selected>{{ $slp->layer_non_proportional }}</option>
                                                                <option value="Layer 4">Layer 4</option>
                                                                <option value="Layer 5">Layer 5</option>
                                                            @elseif($slp->layer_non_proportional == "Layer 4")
                                                                <option value="Layer 1">Layer 1</option>
                                                                <option value="Layer 2">Layer 2</option>
                                                                <option value="Layer 3">Layer 3</option>
                                                                <option value="{{ $slp->layer_non_proportional }}" selected>{{ $slp->layer_non_proportional }}</option>
                                                                <option value="Layer 5">Layer 5</option>
                                                            @elseif($slp->layer_non_proportional == "Layer 5")
                                                                <option value="Layer 1">Layer 1</option>
                                                                <option value="Layer 2">Layer 2</option>
                                                                <option value="Layer 3">Layer 3</option>
                                                                <option value="Layer 4">Layer 4</option>
                                                                <option value="{{ $slp->layer_non_proportional }}" selected>{{ $slp->layer_non_proportional }}</option>
                                                            @endif
                                                        </select>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 d-flex justify-content-start">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Rate (permil.. %)')}}</label>
                                                            <input type="number"  step=".0001" id="sliprate" name="sliprate" value="{{ $slp->rate }}"  class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a" />
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
                                                                            <input type="number" step=".0001" id="slipshare" name="slipshare" value="{{ $slp->share }}"  class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="b" />
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
                                                                            <input type="number"  step=".0001" id="slipcommission" name="slipcommission" class="form-control form-control-sm " data-validation="length" value="{{ $slp->commission }}" data-validation-length="0-50" placeholder="d" />
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
                                                                            <th width="20%">{{__('Actions')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($installmentpanel as $isp)
                                                                                <tr id="ispid{{ $isp->id }}">
                                                                                        <td data-name="{{ $isp->installment_date }}">{{ $isp->installment_date }}</td>
                                                                                        <td data-name="{{ $isp->percentage }}">{{ $isp->percentage }}</td>
                                                                                        <td data-name="{{ $isp->amount }}">{{ $isp->amount }}</td>
                                                                                        <td>
                                                                                            <input type="hidden" id="impidupdate" value="{{ $isp->id }}"/>
                                                                                            <a class="text-primary mr-3" id="editinstallmentpanel" type="button" href="javascript:void(0)" onClick="geteditinstallment({{ $isp->id }})">
                                                                                                <i class="fas fa-edit"></i>
                                                                                            </a>
                                                                                            <a type="button" href="javascript:void(0)" onClick="deleteinstallmentpanel({{ $isp->id }})"><i class="fas fa-trash text-danger"></i></a>
                                                                                        </td>
                                                                                </tr>   
                                                                            @endforeach
                                                                                <tr>
                                                                                    <form id="addinstallmentpanel">
                                                                                        @csrf
                                                                                        <td>
                                                                                            <div class="form-group">
                                                                                                    <div class="input-group date" id="dateinstallment" data-target-input="nearest">
                                                                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#dateinstallment" id="slipipdate" name="slipipdate" />
                                                                                                            <div class="input-group-append" data-target="#dateinstallment" data-toggle="datetimepicker">
                                                                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="form-group">
                                                                                                <input type="number" value="0" step=".0001" id="slipippercentage" name="slipippercentage" placeholder="w" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="form-group">
                                                                                                <input type="number" value="0" step=".0001" id="slipipamount" name="slipipamount" placeholder="= w% * net premium to NR" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="form-group">
                                                                                                <button type="button" class="btn btn-md btn-primary" id="updateinstallmentpanel-btn" onClick="installmentdetailupdate({{ $isp->id }})" >{{__('Update')}}</button>
                                                                                                <button type="button" id="addinstallmentpanel-btn" class="btn btn-md btn-primary ">{{__('Add')}}</button>
                                                                                                
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
                                                            {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
                                                            @if($slp->retro_backup == "YES")
                                                                <option value="{{ $slp->retro_backup }}"  selected>{{ $slp->retro_backup }}</option>
                                                                <option value="NO">NO</option>
                                                            @else
                                                                <option value="YES" >YES</option>
                                                                <option value="{{ $slp->retro_backup }}"  selected>{{ $slp->retro_backup }}</option>    
                                                            @endif
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
                                                                        <input type="number" value="{{ $slp->own_retention }}"  step=".0001" id="slipor" name="slipor" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
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
                                                                            <th width="20%">{{__('Actions')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($retrocessiontemp as $rsc)
                                                                                <tr id="rscid{{ $rsc->id }}">
                                                                                        <td data-name="{{ $rsc->type }}">{{ $rsc->type }}</td>
                                                                                        <td data-name="{{ $rsc->contract }}">{{ $rsc->contract }}</td>
                                                                                        <td data-name="{{ $rsc->percentage }}">{{ $rsc->percentage }}</td>
                                                                                        <td data-name="{{ $rsc->amount }}">{{ $rsc->amount }}</td>
                                                                                        <td>
                                                                                            <input type="hidden" id="rscidupdate" value="{{ $rsc->id }}"/>
                                                                                            <a class="text-primary mr-3" id="editretrocessionpanel" type="button" onClick="geteditretrocession({{ $rsc->id }})" href="javascript:void(0)">
                                                                                                <i class="fas fa-edit"></i>
                                                                                            </a>
                                                                                            <a type="button" href="javascript:void(0)" onClick="deleteretrocessionpanel({{ $rsc->id }})"><i class="fas fa-trash text-danger"></i></a>
                                                                                            
                                                                                        </td>
                                                                                </tr>   
                                                                            @endforeach
                                                                                <tr>
                                                                                    <form id="addretrocessiontemp">
                                                                                        @csrf
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
                                                                                                            <input type="number" value="0" step=".0001" id="sliprppercentage" name="sliprppercentage" class="form-control form-control-sm " data-validation="length" placeholder="z" data-validation-length="0-50" />
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
                                                                                                <input type="number" value="0" step=".0001" id="sliprpamount" name="sliprpamount" placeholder="= z% * b% * tsi" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="=z * b% * tsi" readonly="readonly" />
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="form-group">
                                                                                                <button type="button" class="btn btn-md btn-primary" id="updateretrocessiontemp-btn" onClick="retrocessiondetailupdate({{ $rsc->id }})" >{{__('Update')}}</button>
                                                                                                
                                                                                                <button type="button" id="addretrocessiontemp-btn" class="btn btn-md btn-primary ">{{__('Add')}}</button>
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
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 com-sm-12 mt-3">
                                            <a type="button" href="javascript:void(0)" id="updateslipmarine-btn" class="btn btn-primary btn-block ">
                                                {{__('UPDATE')}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 com-sm-12 mt-3">
                                            <a type="button" href="{{url('/transaction-data/marine-index')}}" id="back-btn" class="btn btn-primary btn-block ">
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


@endsection

@section('scripts')
@include('crm.transaction.marine_slip_edit_js')
@endsection