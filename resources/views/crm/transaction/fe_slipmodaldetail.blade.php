<div class="modal fade" id="detailmodaldata" tabindex="-1" user="dialog" aria-labelledby="addDetailLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" user="document">
                <div class="modal-content bg-light-gray">
                    <div class="modal-header bg-gray">
                    <h5 class="modal-title" id="addDetailLabel">{{__('Slip Detail')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    
                    <form id="multi-file-upload-ajaxdetail" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                            <div class="card card-tabs">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                        <li class="pt-1 px-3"><h3 class="card-title">{{__('Slip Form')}}</h3></li>
                                        <li class="nav-item">
                                        <a class="nav-link active" id="general-details2" data-toggle="pill" href="#general-details-id2" role="tab" aria-controls="general-details-id" aria-selected="true">{{__('General Data')}}</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" id="insured-details2" data-toggle="pill" href="#insured-details-id2" role="tab" aria-controls="address-details-id" aria-selected="false">{{__('Insured Data & Insurance Measurement')}}</a>
                                        </li>
                                    
                                        <li class="nav-item">
                                            <a class="nav-link" id="installment-details2" data-toggle="pill" href="#installment-details-id2" role="tab" aria-controls="installment-details-id" aria-selected="false">{{__('Installment & Retrocession')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body bg-light-gray">
                                    <div class="tab-content p-0 pt-1" id="custom-tabs-three-tabContent">
                                        <div class="tab-pane fade show active" id="general-details-id2" role="tabpanel" aria-labelledby="general-details">
                                            <div class="row">
                                                
                                             
                                            
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="hidden" name="_token2" id="token" value="{{ csrf_token() }}">
                                                            <label for="">{{__('Number')}} </label>
                                                            <input type="text" id="slipnumberdetail" name="slipnumberdetail" class="form-control form-control-sm" value="{{ $code_sl }}" readonly="readonly" required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{__('Username')}}</label>
                                                                <input type="text" id="slipusernamedetail" name="slipusernamedetail" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" value="" readonly="readonly" required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{__('Prod Year')}}:</label>
                                                                    <div class="input-group " >
                                                                            <input type="text" id="slipprodyeardetail" class="form-control form-control-sm "  name="slipprodyeardetail" value="" disabled>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            {{-- <div class="form-group">
                                                                <label for="">{{__('UY')}}</label>
                                                                <input type="number" id="slipuydetail" name="slipuydetail" value="" class="form-control form-control-sm " data-validation="length"  data-validation-length="0-4" required/>
                                                            </div> --}}
                                                            <div class="form-group">
                                                                <label for="">{{__('Transfer Date')}}</label>
                                                                 <input type="text" id="sliptddetail" name="sliptddetail" class="form-control form-control-sm datetimepicker-input" data-validation="length" value="" data-validation-length="0-50" disabled />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Status')}}</label>
                                                            <input type="text" id="slipstatusdetail" name="slipstatusdetail" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="slip" readonly="readonly"/>
                                                         
                                                        </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 com-sm-12 mt-3">
                                                            <table id="slipStatusTabledetail" class="table table-bordered table-striped">
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
                                                        <select id="slipcedingbrokerdetail" disabled="true" name="slipcedingbrokerdetail" class=" form-control form-control-sm ">
                                                            @foreach($cedingbroker as $cb)
                                                                <option value="{{ $cb->id }}" >{{ $cb->type }} - {{ $cb->code }} - {{ $cb->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                    <div class="form-group">
                                                        <select id="slipcedingdetail" disabled="true" name="slipcedingdetail" class=" form-control form-control-sm ">
                                                            {{-- <option value="" readonly selected  value='0'>Ceding </option> --}}
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
                                                            <select id="slipcurrencydetail" disabled="true" name="slipcurrencydetail" class=" form-control form-control-sm ">
                                                                @foreach($currency as $crc)
                                                                    <option value="{{ $crc->id }}" hidden="true">{{ $crc->code }} - {{ $crc->symbol_name }}</option>
                                                                    
                                                                @endforeach
                                                            </select>
                                                        </div>    
                                                        </div>
                                                    </div>
                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('COB')}}</label>
                                                            <select id="slipcobdetail" name="slipcobdetail" disabled="true" class=" form-control form-control-sm ">
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
                                                            <select id="slipkocdetail" name="slipkocdetail" disabled="true" class=" form-control form-control-sm ">
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
                                                            <select id="slipoccupacydetail" disabled="true" name="slipoccupacydetail"  class=" form-control form-control-sm ">
                                                                @foreach($ocp as $ocpy)
                                                                    <option value="{{ $ocpy->id }}">{{ $ocpy->code }} - {{ $ocpy->description }}</option>
                                                                  
                                                                @endforeach
                                                            </select>
                                                        </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('Building Const')}}</label>
                                                        <select id="slipbld_constdetail" name="slipbld_constdetail" disabled="true" class=" form-control form-control-sm ">
                                                            <option  disabled>{{__('Building Const list')}}</option>
                                                            <option value="Building 1">Building 1</option>
                                                            <option value="Building 2">Building 2</option>
                                                            <option value="Building 3">Building 3</option>
                                                        
                                                        </select>
                                                    </div>    
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">{{__('Rate Upper Area')}}</label>
                                                                <input type="text" id="slipbcuadetail" name="slipbcuadetail" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">{{__('Rate Lower Area')}}</label>
                                                                <input type="text" id="slipbcladetail" name="slipbcladetail" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('WPC')}}</label>
                                                        <input type="number" min="0" value="" readonly="readonly" step=".0001" id="wpcdetail" name="wpcdetail" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>{{__('Attachment')}} </label>
                                                        <div class="input-group">
                                                            <ul id="aidlistdetail">


                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Count Endorsement')}}</label>
                                                        <input type="text" min="0" value="" readonly="readonly" step=".0001" id="countendorsmentdetail" name="countendorsmentdetail" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Remarks')}}</label>
                                                        <textarea type="text"  id="remarksdetail" name="remarksdetail" class="form-control form-control-sm" data-validation="length" data-validation-length="0-50" placeholder="" readonly></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="insured-details-id2" role="tabpanel" aria-labelledby="insured-details">
                                           
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">{{__('TSI/Ceding Share') }}</label>
                                                                <select id="sliptypetsidetail" disabled="true" name="sliptypetsiupdate" class="form-control form-control-sm ">
                                                                    <option selected disabled>{{__('Select Share')}}</option>
                                                                    <option value="1">Total Sum Insured</option>
                                                                    <option value="2">Ceding Share</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <div class="form-group">
                                                                <label for="">{{__('Total Sum Insured') }}</label>
                                                                <input type="text" value="" id="sliptotalsumdetail"  name="sliptotalsumdetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" readonly="readonly" placeholder="tsi(*total/sum from interest insured)" />
                                                            </div>
                                                        </div>
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
                                                                <select id="sliptypedetail" disabled="true" name="sliptypedetail" class="form-control form-control-sm ">
                                                                    {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
                                                                    <option value="PML" >PML</option>
                                                                    <option value="LOL" >LOL</option>
                                                                    <option value="TSI" >TSI</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" style="opacity: 0;">{{__('Type')}}</label>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="input-group">
                                                                            <input type="number" value="" step=".0001" readonly="readonly" id="slippctdetail" name="slippctdetail" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="pct" />
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text"><span><i class="fa fa-percent" aria-hidden="true"></i></span></div> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for=""style="opacity: 0;">{{__('Type')}}</label>
                                                                <input type="text" value="" id="sliptotalsumpctdetail" name="sliptotalsumpctdetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" placeholder="=pct*tsi" readonly="readonly" />
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
                                                                        <table id="deductiblePaneldetail" class="table table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{__('Type')}}</th>
                                                                            <th>{{__('Percentage')}}</th>
                                                                            <th>{{__('Amount')}}</th>
                                                                            <th>{{__('Min Claim Amount')}}</th>
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
                                                                        <table id="ExtendCoveragePaneldetail" class="table table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{__('Peril Code - Name')}}</th>
                                                                            <th>{{__('Nilai (permil %.)')}}</th>
                                                                            <th>{{__('Amount')}}</th>
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
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>{{__('Insurance Periode')}}:</label>
                                                                    {{-- <div class="input-group date" id="dateinfrom" data-target-input="nearest"> --}}
                                                                            <input type="text" class="form-control form-control-sm datepicker-input" value="" readonly="readonly" data-target="#date" id="slipipfromdetail" name="slipipfromdetail">
                                                                            {{-- <div class="input-group-append datepickerinfrom" data-target="#dateinfrom" data-toggle="datetimepicker">
                                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                    </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label style="opacity: 0;">{{__('p')}}:</label>
                                                            <p class="d-flex justify-content-center">to</p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label style="opacity: 0;">{{__('p')}}:</label>
                                                                    {{-- <div class="input-group date" id="dateinto" data-target-input="nearest"> --}}
                                                                            <input type="text" class="form-control form-control-sm datepicker-input"  readonly="readonly" value="" data-target="#date" id="slipiptodetail" name="slipiptodetail">
                                                                            {{-- <div class="input-group-append datepickerinto" data-target="#dateinto" data-toggle="datetimepicker">
                                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                    </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>{{__('Reinsurance Periode')}}:</label>
                                                                    {{-- <div class="input-group date" id="daterefrom" data-target-input="nearest"> --}}
                                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" readonly="readonly" value="" data-target="#date" id="sliprpfromdetail" name="sliprpfromdetail">
                                                                            {{-- <div class="input-group-append" data-target="#daterefrom" data-toggle="datetimepicker">
                                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                    </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label style="opacity: 0;">{{__('p')}}:</label>
                                                            <p class="d-flex justify-content-center">to</p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label style="opacity: 0;">{{__('p')}}:</label>
                                                                    {{-- <div class="input-group date" id="datereto" data-target-input="nearest"> --}}
                                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" value="" readonly="readonly"  data-target="#date" id="sliprptodetail" name="sliprptodetail">
                                                                            {{-- <div class="input-group-append" data-target="#datereto" data-toggle="datetimepicker">
                                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                    </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            {{-- <div class="form-group" id="daytotal">                         
                                                            Total Days :0
                                                            
                                                            </div> --}}
                                                            <div class="form-group">
                                                                <label for="">{{__('Total Days')}}</label>
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <input type="hidden"  id="slipdaytotaldetail" name="slipdaytotal" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a"  />
                                                                        <input type="text" disabled="true"  id="slipdaytotaldetail2" name="slipdaytotal2" class="form-control form-control-sm intTextBox" data-validation="length" data-validation-length="0-50" placeholder="a"  />
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <h2>/</h2>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input type="hidden"  id="slipdaytotaldetail3" name="slipdaytotal" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a"  />
                                                                        <input type="text" disabled="true"  id="slipdaytotaldetail4" name="slipdaytotal2" class="form-control form-control-sm intTextBox" data-validation="length" data-validation-length="0-50" placeholder="a"  />
                                                                    </div>
                                                                </div>                                                                       
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">{{__('Total Summary Insurance Periode')}}</label>
                                                                <input type="text"  id="sliptotalsumdatedetail" name="sliptotalsumdatedetail" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            

                                            
                                            <div class="row d-flex justify-content-start">
                                                <i class="fa fa-info-circle" id="labelnpdetail" style="color: grey;" aria-hidden="true"> non proportional panel</i>
                                            </div>
                                            <div class="row d-flex justify-content-end">
                                                <div class="col-md-4">
                                                    <label class="cl-switch cl-switch-green">
                                                        <span for="switch-proportionaldetail" class="label"> {{__('Proportional')}} </span>
                                                        <input type="checkbox" name="slipproportionaldetail[]" id="switch-proportional"
                                                        class="submit" checked>
                                                        <span class="switcher"></span>
                                                        <span  class="label"> {{__('Non Proportional')}} </span>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group d-flex justify-content-end">
                                                        <label style="opacity: 0;">{{__('p')}}:</label>
                                                        <button type="button" id="btnaddlayerdetail" class="btn plus-button" data-toggle="modal" data-target="#addLayerModal">
                                                            <span data-toggle="tooltip" data-placement="top" title="{{__('Add New layer')}}"> + add layer </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="" id="labelnonpropdetail">{{__('Layer for non proportional')}}</label>
                                                        <select id="sliplayerproportionaldetail" disabled="true" name="sliplayerproportionaldetail" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('Choose layer')}}</option>
                                                            <option value="Layer 1" >Layer 1</option>
                                                            <option value="Layer 2" >Layer 2</option>
                                                            <option value="Layer 3">Layer 3</option>
                                                            <option value="Layer 4" >Layer 4</option>
                                                            <option value="Layer 5" >Layer 5</option>
                                                        </select>
                                                    </div>  
                                                </div>
                                            </div>

                                            
                                            <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('TSI/Ceding Share') }}</label>
                                                            <select id="sharetypetsidetail" disabled="true" name="sharetypetsidetail" class="form-control form-control-sm ">
                                                                <option selected disabled>{{__('Select Share')}}</option>
                                                                <option value="1">Total Sum Insured</option>
                                                                <option value="2">Ceding Share</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""  style="opacity: 0;" >{{__('Total Sum Insured') }}</label>
                                                            <!-- /<input type="hidden" id="sharetotalsumdetail" value="" name="sharetotalsumdetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50"  placeholder="tsi(*total/sum from interest insured)" /> -->
                                                            <input type="text" id="sharetotalsumdetail" value="" name="sharetotalsumdetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" disabled placeholder="tsi(*total/sum from interest insured)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('Rate (permil.. ')}} &permil;)</label>
                                                            <input type="text" disabled="true" id="slipratedetail" name="slipratedetail" class="form-control form-control-sm floatTextBox2" data-validation="length" data-validation-length="0-50" placeholder="a &permil;" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""  style="opacity: 0;" >{{__('Total Rate') }}</label>
                                                            <!-- <input type="hidden" id="sliptotalratedetail" value="" name="sliptotalratedetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50"  placeholder="= a &permil; * sum y &permil; " /> -->
                                                            <input type="text" id="sliptotalratedetail" value="" name="sliptotalratedetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" disabled placeholder="= a &permil; * sum y &permil; " />
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
                                                        <input type="text" disabled="true"  id="slipbasicpremiumdetail" name="slipbasicpremiumdetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" placeholder="a &permil; * tsi" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('Share')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="input-group">
                                                                        <input type="text"  id="slipsharedetail" disabled="true" name="slipsharedetail" class="form-control form-control-sm floatTextBox" data-validation="length" data-validation-length="0-50" placeholder="b%" />
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text"><i class="fa fa-percent" aria-hidden="true"></i></div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" style="opacity: 0;">{{__('slip sum share')}}</label>
                                                            <input type="hidden" id="slipsumsharedetail" name="slipsumsharedetail" placeholder="= b% * tsi" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50"  />
                                                            <input type="text" id="slipsumsharedetail2" name="slipsumsharedetail2" placeholder="= b% * tsi" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('RI Com')}}</label>
                                                            <div class="row d-flex flex-wrap">
                                                                <div class="col-md-12">
                                                                    <div class="input-group">
                                                                        <input type="text" disabled="true" id="slipcommissiondetail" name="slipcommissiondetail" class="form-control form-control-sm floatTextBox" data-validation="length" data-validation-length="0-50" placeholder="d" />
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text"><i class="fa fa-percent" aria-hidden="true"></i></div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('RI Com Amount')}}</label>
                                                            <input type="hidden" id="slipsumcommissiondetail" name="slipsumcommissiondetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" placeholder="= a &permil; * b% * tsi * (100% - d%)"  />
                                                            <input type="text" id="slipsumcommissiondetail2" name="slipsumcommissiondetail2" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" placeholder="= a &permil; * b% * tsi * (100% - d%)" disabled />
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('Fee Broker')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="input-group">
                                                                        <input type="text" disabled="true" id="slipvbrokerdetail" name="slipvbrokerdetail" value="0" class="form-control form-control-sm floatTextBox" data-validation="length" data-validation-length="0-50" placeholder="a" />
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text"><i class="fa fa-percent" aria-hidden="true"></i></div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">{{__('Fee Broker Amount')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="input-group">
                                                                        <input type="hidden"  id="slipsumfeedetail" name="slipsumfeedetail"  class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="= a &permil; * b% * tsi * (100% - e%)" />
                                                                        <input type="text"  id="slipsumfeedetail2" name="slipsumfeedetail"  class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" disabled placeholder="= a &permil; * b% * tsi * (100% - e%)" />
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="row"> 
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Gross Prm to NR')}}</label>
                                                            <input type="hidden" id="slipgrossprmtonrdetail" name="slipgrossprmtonrdetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" placeholder="a &permil;  * tsi * b%"  />
                                                            <input type="text" id="slipgrossprmtonrdetail2" name="slipgrossprmtonrdetail2" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" placeholder="a &permil; * tsi * b% " disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Net Prm to NR')}}</label>
                                                            <input type="hidden" id="slipnetprmtonrdetail" name="slipnetprmtonrdetail" class="form-control form-control-sm amount" data-validation="length" placeholder="=a &permil;. * b% * tsi * (100% - d%)" data-validation-length="0-50" />
                                                            <input type="text" id="slipnetprmtonrdetail2" name="slipnetprmtonrdetail2" class="form-control form-control-sm amount" data-validation="length" placeholder="= a &permil; * b% * tsi * (100% - d% - e%)" data-validation-length="0-50" disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            

                                        </div>
                                        
                                        <div class="tab-pane fade" id="installment-details-id2" role="tabpanel" aria-labelledby="installment-details">
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
                                                                        <table id="installmentPaneldetail" class="table table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{__('Installment Date')}}</th>
                                                                            <th>{{__('Percentage')}}</th>
                                                                            <th>{{__('Amount')}}</th>
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
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 d-flex justify-content-start">
                                                    <div class="form-group">
                                                        <label for="">{{__('Retro Backup?')}}</label>
                                                        <select id="sliprbdetail" name="sliprbdetail" disabled="true" class="form-control form-control-sm ">
                                                            <option value="NO" >NO</option>
                                                            <option value="YES" >YES</option>
                                                            
                                                        </select>
                                                    </div>   
                                                </div>
                                                <div class="col-md-6 d-flex justify-content-end">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="">{{__('Own Retention')}}</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <input type="text" id="slipordetail" readonly="readonly" value="" name="slipordetail" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text"><i class="fa fa-percent" aria-hidden="true"></i></div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" id="slipsumordetail" value=""   name="slipsumordetail" class="form-control form-control-sm amount" data-validation="length" data-validation-length="0-50" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="tabretrodetail">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header bg-gray">
                                                            {{__('Retrocession Panel')}}
                                                        </div>
                                                        <div class="card-body bg-light-gray ">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-12 com-sm-12 mt-3">
                                                                        <table id="retrocessionPaneldetail" class="table table-bordered table-striped">
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
                            
                            
                            </div>
                        </div>
                    </div> 
            

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            {{-- Edit Modal Ends --}}