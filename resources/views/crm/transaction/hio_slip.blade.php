@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('transaction-data/hio-slip/store')}}>
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
                                            <label for="">{{__('Number')}} </label>
                                            <input type="text" name="hionumber" class="form-control form-control-sm" data-validation="length" data-validation-length="1-7" disabled required/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">{{__('Insured')}}</label>
                                                    <select name="hioinsured" class="form-control form-control-sm ">
                                                        <option selected disabled>{{__('Select Continent')}}</option>
                                                        <option value="AF">Africa</option>
                                                        <option value="AN">Antartica</option>
                                                        <option value="AS">Asia</option>
                                                        <option value="EU">Europa</option>
                                                        <option value="NA">North America </option>
                                                        <option value="OC">Oceania</option>
                                                        <option value="SA">South America</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 1')}}</label>
                                                    <input type="text" name="hiosuggestinsured" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" placeholder="search for insured suggestion" required/>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 2')}}</label>
                                                    <input type="text" name="hiosuffix" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" placeholder="suffix: QQ or TBk" required/>
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
                                                                <input type="text" name="hioshare" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                    <input type="text" name="hiosharefrom" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{__('To')}}</label>
                                                    <input type="text" name="hioshareto" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addrisklocr">{{__('Add Risk Location')}}</button>
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
                                                        <th>{{__('Loc Code')}}</th>
                                                        <th>{{__('Address')}}</th>
                                                        <th>{{__('City')}}</th>
                                                        <th>{{__('Province')}}</th>
                                                        <th>{{__('LatLong')}}</th>
                                                        <th width="20%">{{__('Actions')}}</th>
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
                                            <input type="text" name="hiocoinsurance" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                        </div>
                                    </div>
                                </div>


                                
                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-start">
                                        <div class="col-md-12 com-sm-12 mt-3">
                                            <label for="">{{__('Hole Detail')}}</label>
                                            <table id="hiogolf" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>{{__('Code')}}</th>
                                                <th>{{__('Golf FIeld - Hole Number')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{__('CODE001')}}</td>
                                                    <td>{{__('Emeralda - hole 10A')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('CODE002')}}</td>
                                                    <td>{{__('Emeralda - hole 8')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            {{-- <label for="">{{__('Layer for non proportional')}}</label> --}}
                                                            <select name="hiogolfholenum" class="form-control form-control-sm ">
                                                                <option selected disabled>{{__('Golf Field - Hole Number List')}}</option>
                                                                <option value="AF">Africa</option>
                                                                <option value="AN">Antartica</option>
                                                                <option value="AS">Asia</option>
                                                                <option value="EU">Europa</option>
                                                                <option value="NA">North America </option>
                                                                <option value="OC">Oceania</option>
                                                                <option value="SA">South America</option>
                                                            </select>
                                                        </div>  
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-start">
                                        <div class="col-md-12 com-sm-12 mt-3">
                                            <label for="" style="opacity: 0;">{{__('Property Type')}}</label>
                                            <table id="hioevent" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>{{__('Event')}}</th>
                                                <th width="20%">{{__('Actions')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{__('Event Golf x 2020')}}</td>
                                                    <td width="20%">{{__('delete')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Event Golf x 2021')}}</td>
                                                    <td width="20%">{{__('delete')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            {{-- <label for="">{{__('Layer for non proportional')}}</label> --}}
                                                            <select name="propertytypelist" class="form-control form-control-sm ">
                                                                <option selected disabled>{{__('PropertyType List')}}</option>
                                                                <option value="AF">Africa</option>
                                                                <option value="AN">Antartica</option>
                                                                <option value="AS">Asia</option>
                                                                <option value="EU">Europa</option>
                                                                <option value="NA">North America </option>
                                                                <option value="OC">Oceania</option>
                                                                <option value="SA">South America</option>
                                                            </select>
                                                        </div>  
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 com-sm-12 mt-3">
                                        <button class="btn btn-primary btn-block ">
                                            {{__('Save')}}
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        <div class="card ">
            <div class="card-header bg-gray">
                {{__('Slip Detail')}}
            </div>
            <div class="card-body bg-light-gray">
                
                <div class="container-fluid p-3">
                    <form>
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
                                                        <label for="">{{__('Number')}} </label>
                                                        <input type="text" name="slipnumber" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Username')}}</label>
                                                            <input type="text" name="slipusername" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{__('Prod Year')}}:</label>
                                                                <div class="input-group date" id="date" data-target-input="nearest">
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="slipprodyear">
                                                                        <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
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
                                                            <input type="text" name="slipuy" class="form-control form-control-sm " data-validation="length" data-validation-length="1-50" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Status')}}</label>
                                                        <select name="slipstatus" class="form-control form-control-sm ">
                                                            {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
                                                            <option value="AF" selected>Offer</option>
                                                            <option value="AN">Binding</option>
                                                            <option value="AS">Slip</option>
                                                            <option value="EU">Endorsement</option>
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="" class="d-flex justify-content-center">{{__('Endorsement / Selisih')}}</label>
                                                        <br>
                                                        <div class="form-check form-check-inline d-flex justify-content-around">
                                                                <input class="form-check-input" type="checkbox" id="slipedselisih" name="slipedselisih" value="Endorsement">
                                                                <input class="form-check-input" type="checkbox" id="slipedselisih" name="slipedselisih" value="Selisih">
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 com-sm-12 mt-3">
                                                        <table id="slipStatusTable" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>{{__('ID')}}</th>
                                                            <th>{{__('Name')}}</th>
                                                            <th>{{__('Code')}}</th>
                                                            <th>{{__('Continent')}}</th>
                                                            <th width="20%">{{__('Actions')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <td>{{__('Code')}}</td>
                                                            <td>{{__('Ship Name')}}</td>
                                                            <td>{{__('Owner')}}</td>
                                                            <td>{{__('Continent')}}</td>
                                                            <td width="20%">{{__('Actions')}}</td>
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
                                                    <select name="slipcedingbroker" class="form-control form-control-sm ">
                                                        {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
                                                        <option value="AF" selected>Ceding or Broker</option>
                                                        <option value="AN">Binding</option>
                                                        <option value="AS">Slip</option>
                                                        <option value="EU">Endorsement</option>
                                                    </select>
                                                </div>    
                                                <div class="form-group">
                                                    <select name="slipceding" class="form-control form-control-sm ">
                                                        {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
                                                        <option value="AF" selected>Ceding </option>
                                                        <option value="AN">Binding</option>
                                                        <option value="AS">Slip</option>
                                                        <option value="EU">Endorsement</option>
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
                                                        <select name="slipcurrency" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('Select Currency')}}</option>
                                                            <option value="AF">Africa</option>
                                                            <option value="AN">Antartica</option>
                                                            <option value="AS">Asia</option>
                                                            <option value="EU">Europa</option>
                                                            <option value="NA">North America </option>
                                                            <option value="OC">Oceania</option>
                                                            <option value="SA">South America</option>
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('COB')}}</label>
                                                        <select name="slipcob" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('COB list')}}</option>
                                                            <option value="AF">Africa</option>
                                                            <option value="AN">Antartica</option>
                                                            <option value="AS">Asia</option>
                                                            <option value="EU">Europa</option>
                                                            <option value="NA">North America </option>
                                                            <option value="OC">Oceania</option>
                                                            <option value="SA">South America</option>
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('KOC')}}</label>
                                                        <select name="slipkoc" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('KOC list')}}</option>
                                                            <option value="AF">Africa</option>
                                                            <option value="AN">Antartica</option>
                                                            <option value="AS">Asia</option>
                                                            <option value="EU">Europa</option>
                                                            <option value="NA">North America </option>
                                                            <option value="OC">Oceania</option>
                                                            <option value="SA">South America</option>
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Occupacy')}}</label>
                                                        <select name="slipoccupacy" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('Occupation list')}}</option>
                                                            <option value="AF">Africa</option>
                                                            <option value="AN">Antartica</option>
                                                            <option value="AS">Asia</option>
                                                            <option value="EU">Europa</option>
                                                            <option value="NA">North America </option>
                                                            <option value="OC">Oceania</option>
                                                            <option value="SA">South America</option>
                                                        </select>
                                                    </div>    
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Building Const')}}</label>
                                                        <select name="slipbld_const" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('Building Const list')}}</option>
                                                            <option value="AF">Africa</option>
                                                            <option value="AN">Antartica</option>
                                                            <option value="AS">Asia</option>
                                                            <option value="EU">Europa</option>
                                                            <option value="NA">North America </option>
                                                            <option value="OC">Oceania</option>
                                                            <option value="SA">South America</option>
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
                                                                        <input type="text" name="slipno" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('CN/DN')}}</label>
                                                                        <input type="text" name="slipcndn" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('Policy No')}}</label>
                                                                        <input type="text" name="slippolicy_no" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                        <input type="file" name="slipfile_att" id="attachment" required>
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
                                                                    <table id="interestInsured" class="table table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                        <th>{{__('Interest ID - Name')}}</th>
                                                                        <th>{{__('Amount')}}</th>
                                                                        <th width="20%">{{__('Actions')}}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                            <td>{{__('036 - Heavy Equipment')}}</td>
                                                                            <td>{{__('100.000.000')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>{{__('450 - Bensin')}}</td>
                                                                            <td>{{__('100.000.000')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                <div class="form-group">
                                                                                    <select name="slipinterestlist" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Interest list')}}</option>
                                                                                        <option value="AF">Africa</option>
                                                                                        <option value="AN">Antartica</option>
                                                                                        <option value="AS">Asia</option>
                                                                                        <option value="EU">Europa</option>
                                                                                        <option value="NA">North America </option>
                                                                                        <option value="OC">Oceania</option>
                                                                                        <option value="SA">South America</option>
                                                                                    </select>
                                                                                </div>  
                                                                                </td>
                                                                                <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="slipamount" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                                </div>
                                                                                </td>
                                                                                <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-md btn-primary " data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                            <div class="col-md-12 d-flex justify-content-end">
                                                <div class="form-group">
                                                    <label for="">{{__('Total Sum Insured')}}</label>
                                                    <input type="text" name="sliptotalsum" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                            <select name="sliptype" class="form-control form-control-sm ">
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
                                                                        <input type="text" name="slippct" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                            <input type="text" name="sliptotalsumpct" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                                        <tr>
                                                                            <td>{{__('MD')}}</td>
                                                                            <td>{{__('IDR')}}</td>
                                                                            <td>{{__('x %')}}</td>
                                                                            <td>{{__('= x * tsi')}}</td>
                                                                            <td>{{__('10.000.000')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('TPL')}}</td>
                                                                            <td>{{__('USD')}}</td>
                                                                            <td>{{__('0,001 %')}}</td>
                                                                            <td>{{__('= x * tsi')}}</td>
                                                                            <td>{{__('100.000')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select name="slipdptype" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Type')}}</option>
                                                                                        <option value="AF">Africa</option>
                                                                                        <option value="AN">Antartica</option>
                                                                                        <option value="AS">Asia</option>
                                                                                        <option value="EU">Europa</option>
                                                                                        <option value="NA">North America </option>
                                                                                        <option value="OC">Oceania</option>
                                                                                        <option value="SA">South America</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select name="slipdpcurrency" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Currency')}}</option>
                                                                                        <option value="AF">Africa</option>
                                                                                        <option value="AN">Antartica</option>
                                                                                        <option value="AS">Asia</option>
                                                                                        <option value="EU">Europa</option>
                                                                                        <option value="NA">North America </option>
                                                                                        <option value="OC">Oceania</option>
                                                                                        <option value="SA">South America</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="slipdppercentage" placeholder="x" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="slipdpamount" placeholder="=x*tsi" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" disabled required/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="slipdpminamount" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                                </div>
                                                                            </td> 
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                                                        <tr>
                                                                            <td>{{__('028 - RSMD 4.1A + TERRORISM')}}</td>
                                                                            <td>{{__('RSMD 4.1A + TERRORISM')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('028 - RSMD 4.1 AAA')}}</td>
                                                                            <td>{{__('TERRORISM, SABOTAGE AND CIVIL COMMOTION')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <div class="form-group">
                                                                                    <select name="slipcncode" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Condition Needed Code - Name - Information List')}}</option>
                                                                                        <option value="AF">Africa</option>
                                                                                        <option value="AN">Antartica</option>
                                                                                        <option value="AS">Asia</option>
                                                                                        <option value="EU">Europa</option>
                                                                                        <option value="NA">North America </option>
                                                                                        <option value="OC">Oceania</option>
                                                                                        <option value="SA">South America</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>{{__('Insurance Periode')}}:</label>
                                                                <div class="input-group date" id="date" data-target-input="nearest">
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="slipipfrom">
                                                                        <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
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
                                                                <div class="input-group date" id="date" data-target-input="nearest">
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="slipipto">
                                                                        <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
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
                                                                <div class="input-group date" id="date" data-target-input="nearest">
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="sliprpfrom">
                                                                        <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
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
                                                                <div class="input-group date" id="date" data-target-input="nearest">
                                                                        
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="sliprpto">
                                                                        <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
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
                                                    <select name="sliplayerproportional" class="form-control form-control-sm ">
                                                        <option selected disabled>{{__('Choose layer')}}</option>
                                                        <option value="AF">Africa</option>
                                                        <option value="AN">Antartica</option>
                                                        <option value="AS">Asia</option>
                                                        <option value="EU">Europa</option>
                                                        <option value="NA">North America </option>
                                                        <option value="OC">Oceania</option>
                                                        <option value="SA">South America</option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex justify-content-start">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Rate (permil.. %)')}}</label>
                                                        <input type="text" name="sliprate" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                                        <input type="text" name="slipshare" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                            <input type="text" name="slipsumshare" placeholder="= w% * net premium to NR" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" disabled required/>
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
                                                        <input type="text" name="slipbasicpremium" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Gross Prm to NR')}}</label>
                                                        <input type="text" name="slipgrossprmtonr" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" disabled required/>
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
                                                                        <input type="text" name="slipcommission" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                            <input type="text" name="slipsumcommission" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" disabled required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Net Prm to NR')}}</label>
                                                        <input type="text" name="slipnetprmtonr" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                                        <tr>
                                                                            <td>{{__('20/09/2020')}}</td>
                                                                            <td>{{__('50%')}}</td>
                                                                            <td>{{__('100.000.000')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('20/10/2020')}}</td>
                                                                            <td>{{__('50%')}}</td>
                                                                            <td>{{__('100.000.000')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                        <div class="input-group date" id="date" data-target-input="nearest">
                                                                                                <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="slipipdate">
                                                                                                <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="slipippercentage" placeholder="w" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="slipipamount" placeholder="= w% * net premium to NR" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" disabled required/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                            <div class="col-md-6 d-flex justify-content-start">
                                                <div class="form-group">
                                                    <label for="">{{__('Retro Backup?')}}</label>
                                                    <select name="sliprb" class="form-control form-control-sm ">
                                                        {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
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
                                                                    <input type="text" name="slipor" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text"><span><i class="fa fa-percent" aria-hidden="true"></i></span></div> 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="slipsumor" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" disabled required/>
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
                                                                        <tr>
                                                                            <td>{{__('NM XOL')}}</td>
                                                                            <td>{{__('20NM11110')}}</td>
                                                                            <td>{{__('80%')}}</td>
                                                                            <td>{{__('160.000.000')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('NM XOL')}}</td>
                                                                            <td>{{__('20ABC')}}</td>
                                                                            <td>{{__('80%')}}</td>
                                                                            <td>{{__('40.000.000')}}</td>
                                                                            <td width="20%">{{__('delete')}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select name="sliprptype" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Type list')}}</option>
                                                                                        <option value="AF">Africa</option>
                                                                                        <option value="AN">Antartica</option>
                                                                                        <option value="AS">Asia</option>
                                                                                        <option value="EU">Europa</option>
                                                                                        <option value="NA">North America </option>
                                                                                        <option value="OC">Oceania</option>
                                                                                        <option value="SA">South America</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select name="sliprpcontract" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Contract list')}}</option>
                                                                                        <option value="AF">Africa</option>
                                                                                        <option value="AN">Antartica</option>
                                                                                        <option value="AS">Asia</option>
                                                                                        <option value="EU">Europa</option>
                                                                                        <option value="NA">North America </option>
                                                                                        <option value="OC">Oceania</option>
                                                                                        <option value="SA">South America</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col-md-8">
                                                                                            <div class="input-group">
                                                                                                <input type="text" name="sliprppercentage" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                                                    <input type="text" name="sliprpamount" placeholder="= w% * net premium to NR" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" disabled required/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                        <button class="btn btn-primary btn-block ">
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
@include('crm.transaction.hio_slip_js')
@endsection