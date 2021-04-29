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
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <input type="text" id="msishare" name="msishare" value="{{ $isd->share }}" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><i class="fa fa-percent"></i></div> 
                                                                </div>
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
                                    <td><a class="text-primary mr-3 float-right " data-toggle="modal" data-target="#editmodaldata" href="javascript:void(0)" onclick="editslip({{  @$slipdatatadetail->id }})">Update </a><a data-toggle="modal" data-target="#endorsementmodaldata" href="javascript:void(0)" onclick="endorsementslip({{  @$slipdatatadetail->id }})"> Endorsement</a></td>
                             </tr>   
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        

    </div>
</div>
@include('crm.transaction.pa_slipmodaldetail')
@include('crm.transaction.pa_slipmodaledit')
@include('crm.transaction.pa_slipmodalendorsement')

@endsection

@section('scripts')
@include('crm.transaction.pa_slip_detail_js')
@endsection