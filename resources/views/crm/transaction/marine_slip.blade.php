@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('transaction-data/marine-slip/store')}}>
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
                                            <input type="text" name="msnumber" id="insuredID" class="form-control form-control-sm" data-validation="length" data-validation-length="1-7" value="{{ $code_ms }}" readonly="readonly" required/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">{{__('Insured')}}</label>
                                                    <select name="msprefix" class="e1 form-control form-control-sm ">
                                                        <option selected disabled>{{__('Select Prefix')}}</option>
                                                        <option value="PT">PT</option>
                                                        <option value="CV">CV</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 1')}}</label>
                                                    <input type="text" name="mssuggestinsured" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" placeholder="search for insured suggestion" required/>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" style="opacity: 0">{{__('insured 2')}}</label>
                                                    <input type="text" name="mssuffix" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" placeholder="suffix: QQ or TBk" required/>
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
                                                    <select name="msroute" class="e1 form-control form-control-sm ">
                                                        <option selected disabled>{{__('Select Route')}}</option>
                                                        <option value="route">Route</option>
                                                        <option value="shipping">Shipping</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" style="opacity: 0">{{__('b')}}</label>
                                                    <select name="msroutefrom" class="e1 form-control form-control-sm ">
                                                        <option selected disabled>{{__('*from')}}</option>
                                                        @foreach($felookup as $flu)
                                                            <option value="{{ $flu->id }}">{{ $flu->loc_code }} - {{ $flu->address }} - {{ $flu->City->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" style="opacity: 0">{{__('a')}}</label>
                                                    <select name="msrouteto" class="e1 form-control form-control-sm ">
                                                        <option selected disabled>{{__('*to')}}</option>
                                                        @foreach($felookup as $flu)
                                                            <option value="{{ $flu->id }}">{{ $flu->loc_code }} - {{ $flu->address }} - {{ $flu->City->name}}</option>
                                                        @endforeach
                                                    </select>
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
                                                                <input type="text" name="msshare" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" required/>
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
                                                    <input type="text" name="mssharefrom" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{__('To')}}</label>
                                                    <input type="text" name="msshareto" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" required/>
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
                                                                <th width="20%">{{__('Actions')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
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
                                            <input type="text" name="mscoinsurance" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" required/>
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

            <div class="modal fade" id="ModalAddShip" tabindex="-1" user="dialog" aria-hidden="true">
                <div class="modal-dialog" user="document">
                    <div class="modal-content bg-light-gray">
                    <div class="modal-header bg-gray">
                        <h5 class="modal-title">{{__('Ship Detail')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body">
                            @csrf
                            @method('POST')
            
                            <div class="row">
                                <div class="col-md-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">{{__('Ship Code')}}</label><br>
                                        <select name="insshipcode" id="shipcode" class="form-control form-control-sm e1">
                                            <option selected disabled>{{__('Select Ship Code')}}</option>
                                            @foreach($mlu as $mrnlu)
                                                <option value="{{  $mrnlu->code }}">{{  $mrnlu->code  }} - {{ $mrnlu->shipname }}</option>
                                                {{-- @if($location->country_id  == $cty->id)
                                                <option value="{{ $mrnlu->id }}" selected>{{ $mrnlu->code }} - {{ $mrnlu->shipname }}</option>
                                                @else
                                                <option value="{{  $mrnlu->id }}">{{  $mrnlu->code  }} - {{ $mrnlu->shipname }}</option>
                                                @endif --}}
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-md-12">
                                    <div class="form-group">
                                    <label for="">{{__('Ship Name')}}</label>
                                    <input type="text" name="insshipname" id="shipname" class="form-control" value="" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                            <input type="submit" class="btn btn-info" id="addship" value="Add Ship">
                        </div>
                    </form>
                    </div>
                </div>
            </div>

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
                                                        <input type="text" name="slipnumber" class="form-control form-control-sm" data-validation="length" data-validation-length="3" value="{{ $code_sl }}" readonly="readonly" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Username')}}</label>
                                                            <input type="text" name="slipusername" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" value="{{Auth::user()->name}}" readonly="readonly" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{__('Prod Year')}}:</label>
                                                                <div class="input-group date" id="date" data-target-input="nearest">
                                                                        <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" name="slipprodyear" value="{{ $currdate }}" readonly="readonly">
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
                                                            
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                    <label for="" class="d-flex justify-content-center">{{__('Endorsement / Selisih')}}</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                    <input type="text" name="sliped" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50"/>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                    <input type="text" name="slipsls" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50"/>
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
                                                            <tr>
                                                                <td>{{__('Offer')}}</td>
                                                                <td>{{__('01/10/2020 09:00:00')}}</td>
                                                                <td>{{__('User A')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('Binding')}}</td>
                                                                <td>{{__('01/10/2020 14:15:00')}}</td>
                                                                <td>{{__('User A')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('Slip')}}</td>
                                                                <td>{{__('01/10/2020 11:20:00')}}</td>
                                                                <td>{{__('User B')}}</td>
                                                            </tr>
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
                                                    <select name="slipcedingbroker" class="e1 form-control form-control-sm ">
                                                        <option value="" disabled selected>Ceding or Broker</option>
                                                        @foreach($cedingbroker as $cb)
                                                            <option value="{{ $cb->id }}">{{ $cb->type }} - {{ $cb->code }} - {{ $cb->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>    
                                                <div class="form-group">
                                                    <select name="slipceding" class="e1 form-control form-control-sm ">
                                                        <option value="" disabled selected>Ceding </option>
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
                                                        <select name="slipcurrency" class="e1 form-control form-control-sm ">
                                                            <option selected disabled>{{__('Select Currency')}}</option>
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
                                                        <select name="slipcob" class="e1 form-control form-control-sm ">
                                                            <option selected disabled>{{__('COB list')}}</option>
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
                                                        <select name="slipkoc" class="e1 form-control form-control-sm ">
                                                            <option selected disabled>{{__('KOC list')}}</option>
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
                                                        <select name="slipoccupacy" class="e1 form-control form-control-sm ">
                                                            <option selected disabled>{{__('Occupation list')}}</option>
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
                                                        <select name="slipbld_const" class="e1 form-control form-control-sm ">
                                                            <option selected disabled>{{__('Building Const list')}}</option>
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
                                                                                        <option value="036 - Heavy Equipment">036 - Heavy Equipment</option>
                                                                                        <option value="450 - Bensin">450 - Bensin</option>
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
                                                    <input type="text" name="sliptotalsum" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" placeholder="tsi(*total/sum from interest insured)" required/>
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
                                                                        <input type="text" name="slippct" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="pct" required/>
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
                                                            <input type="text" name="sliptotalsumpct" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="=pct*tsi" readonly="readonly" required/>
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
                                                                                        <option value="MD">MD</option>
                                                                                        <option value="TPL">TPL</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select name="slipdpcurrency" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Currency')}}</option>
                                                                                        @foreach($currency as $crc)
                                                                                            <option value="{{ $crc->id }}">{{ $crc->code }} - {{ $crc->symbol_name}}</option>
                                                                                        @endforeach
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
                                                                                       @foreach($cnd as $ncd)
                                                                                        <option value="{{ $ncd->id }}">{{ $ncd->code }} - {{ $ncd->name }} - {{ $ncd->information }}</option>
                                                                                        @endforeach
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
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>{{__('Insurance Periode')}}:</label>
                                                                <div class="input-group date" id="dateinfrom" data-target-input="nearest">
                                                                        <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" name="slipipfrom">
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
                                                                        <input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" name="slipipto">
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
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="sliprpfrom">
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
                                                                        
                                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="sliprpto">
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
                                                    <select name="sliplayerproportional" class="form-control form-control-sm ">
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
                                                        <input type="text" name="sliprate" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a" required/>
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
                                                                        <input type="text" name="slipshare" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="b" required/>
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
                                                            <input type="text" name="slipsumshare" placeholder="= b% * tsi" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" required/>
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
                                                        <input type="text" name="slipbasicpremium" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a% * tsi" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Gross Prm to NR')}}</label>
                                                        <input type="text" name="slipgrossprmtonr" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a% * b% * tsi" readonly="readonly" required/>
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
                                                                        <input type="text" name="slipcommission" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="d" required/>
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
                                                            <input type="text" name="slipsumcommission" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="= a% * b% * tsi * (100% - d%)" readonly="readonly" required/>
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
                                                                                        <div class="input-group date" id="dateinstallment" data-target-input="nearest">
                                                                                                <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="slipipdate">
                                                                                                <div class="input-group-append" data-target="#dateinstallment" data-toggle="datetimepicker">
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
                                                                    <input type="text" name="slipsumor" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" placeholder="= x% * b% * tsi" readonly="readonly" required/>
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
                                                                                        <option value="NM XOL">NM XOL</option>
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select name="sliprpcontract" class="form-control form-control-sm ">
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
                                                                                                <input type="text" name="sliprppercentage" class="form-control form-control-sm " data-validation="length" placeholder="z" data-validation-length="0-50" required/>
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
                                                                                    <input type="text" name="sliprpamount" placeholder="= w% * net premium to NR" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="=z * b% * tsi" readonly="readonly" required/>
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
@include('crm.transaction.marine_slip_js')
@endsection