            <div class="modal fade" id="endorsementmodaldata" tabindex="-1" user="dialog" aria-labelledby="addendorsementLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" user="document">
                <div class="modal-content bg-light-gray">
                    <div class="modal-header bg-gray">
                    <h5 class="modal-title" id="addendorsementLabel">{{__('Slip Endorsement')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    
                    <form id="multi-file-upload-ajaxendorsement" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                            <div class="card card-tabs">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                        <li class="pt-1 px-3"><h3 class="card-title">{{__('Slip Form')}}</h3></li>
                                        <li class="nav-item">
                                        <a class="nav-link active" id="general-details" data-toggle="pill" href="#general-details-id3" role="tab" aria-controls="general-details-id" aria-selected="true">{{__('General Data')}}</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" id="insured-details" data-toggle="pill" href="#insured-details-id3" role="tab" aria-controls="address-details-id" aria-selected="false">{{__('Insured Data & Insurance Measurement')}}</a>
                                        </li>
                                    
                                        <li class="nav-item">
                                            <a class="nav-link" id="installment-details" data-toggle="pill" href="#installment-details-id3" role="tab" aria-controls="installment-details-id" aria-selected="false">{{__('Installment & Retrocession')}}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body bg-light-gray">
                                    <div class="tab-content p-0 pt-1" id="custom-tabs-three-tabContent">
                                        <div class="tab-pane fade show active" id="general-details-id3" role="tabpanel" aria-labelledby="general-details">
                                            <div class="row">
                                                
                                               
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="hidden" name="_token2" id="token" value="{{ csrf_token() }}">
                                                            <label for="">{{__('Number')}} </label>
                                                            <input type="text" id="slipnumberendorsement" name="slipnumberendorsement" class="form-control form-control-sm" value="{{ $code_sl }}" readonly="readonly" required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{__('Username')}}</label>
                                                                <input type="text" id="slipusernameendorsement" name="slipusernameendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" value="" readonly="readonly" required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{__('Prod Year')}}:</label>
                                                                    <div class="input-group date" id="date" data-target-input="nearest">
                                                                            <input type="text" id="slipprodyearendorsement" class="form-control form-control-sm datepicker-input" data-target="#date" name="slipprodyearendorsement" value="" readonly="readonly">
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
                                                                <input type="number" id="slipuyendorsement" name="slipuyendorsement" value="" class="form-control form-control-sm " data-validation="length"  data-validation-length="0-4" required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Status')}}</label>
                                                            <select name="slipstatusendorsement" id="slipstatusendorsement" class="form-control form-control-sm ">
                                                                <option value="offer"    >Offer</option>
                                                                <option value="binding"  >Binding</option>
                                                                <option value="slip"  >Slip</option>
                                                                <option value="endorsement">Endorsement</option>
                                                                <option value="decline" > Decline</option>
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
                                                                        <input type="text" id="slipedendorsement"  name="slipedendorsement" value="" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50"/>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="" class="d-flex justify-content-center" style="opacity: 0;">{{__('Endorsement / Selisih')}}</label>
                                                                        <input type="text" id="slipslsendorsement" name="slipslsendorsement" value="" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 com-sm-12 mt-3">
                                                            <table id="slipStatusTableendorsement" class="table table-bordered table-striped">
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
                                                        <select id="slipcedingbrokerendorsement" name="slipcedingbrokerendorsement" class="e1 form-control form-control-sm ">
                                                            @foreach($cedingbroker as $cb)
                                                                <option value="{{ $cb->id }}" selected="selected">{{ $cb->type }} - {{ $cb->code }} - {{ $cb->name }}</option>
                                                                
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                    <div class="form-group">
                                                        <select id="slipcedingendorsement" name="slipcedingendorsement" class="e1 form-control form-control-sm ">
                                                            <option value="" readonly selected  value='0'>Ceding </option>
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
                                                            <select id="slipcurrencyendorsement" name="slipcurrencyendorsement" class="e1 form-control form-control-sm ">
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
                                                            <select id="slipcobendorsement" name="slipcobendorsement" class="e1 form-control form-control-sm ">
                                                                <option selected readonly  value='0'>{{__('COB list')}}</option>
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
                                                            <select id="slipkocendorsement" name="slipkocendorsement" class="e1 form-control form-control-sm ">
                                                                <option selected readonly  value='0'>{{__('KOC list')}}</option>
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
                                                            <select id="slipoccupacydetail" name="slipoccupacydetail" class="e1 form-control form-control-sm ">
                                                                <option selected readonly  value='0'>{{__('Occupation list')}}</option>
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
                                                            <select id="slipbld_constendorsement" name="slipbld_constendorsement" class="e1 form-control form-control-sm ">
                                                                <option selected readonly  value='0'>{{__('Building Const list')}}</option>
                                                                <option value="Buliding 1" >Buliding 1</option>
                                                                <option value="Buliding 2" >Buliding 2</option>
                                                                <option value="Buliding 3" >Buliding 3</option>
                                                                <option value="Buliding 4" >Buliding 4</option>
                                                                <option value="Buliding 5" >Buliding 5 </option>
                                                                <option value="Buliding 6" >Buliding 6</option>
                                                                <option value="Buliding 7" >Buliding 7</option>
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
                                                                            <input type="text" id="slipnoendorsement"  value=""  name="slipnoendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">{{__('CN/DN')}}</label>
                                                                            <input type="text" id="slipcndnendorsement" name="slipcndnendorsement" value=""  class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">{{__('Policy No')}}</label>
                                                                            <input type="text" id="slippolicy_noendorsement" value="" name="slippolicy_noendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
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
                                                            <input type="file" name="filesendorsement[]" id="attachmentendorsement" class="form-control" multiple>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="insured-details-id3" role="tabpanel" aria-labelledby="insured-details">
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
                                                                        <table id="interestInsuredTableendorsement" class="table table-bordered table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                            <th>{{__('Interest ID - Name')}}</th>
                                                                            <th>{{__('Amount')}}</th>
                                                                            <th width="20%">{{__('Actions')}}</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                
                                                                                
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                        <table class="table table-bordered table-striped">
                                                                            <tbody>
                                                                                    <tr>
                                                                                        
                                                                                            <td>
                                                                                                <div class="form-group">
                                                                                                    <select id="slipinterestlistendorsement" name="slipinterestlistendorsement" class="form-control form-control-sm ">
                                                                                                        <option selected disabled>{{__('Interest list')}}</option>
                                                                                                        @foreach($interestinsured as $ii)
                                                                                                            <option value="{{ $ii->id }}">{{ $ii->code }} - {{ $ii->description }}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>  
                                                                                            </td>

                                                                                            <td>
                                                                                                <div class="form-group">
                                                                                                    <input type="number" min="0" max="999999999,9999" value="" step=".01" id="slipamountendorsement" name="slipamountendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-20"/>
                                                                                                </div>
                                                                                            </td>

                                                                                            <td>
                                                                                                <div class="form-group">
                                                                                                    <button type="button" id="addinterestinsuredendorsement-btn" class="btn btn-md btn-primary ">{{__('Add')}}</button>
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
                                                        <label for="">{{__('Total Sum Insured') }}</label>
                                                        <input type="number" min="0" value="{{$totalamountdata}}" step=".0001" id="sliptotalsumendorsement" name="sliptotalsumendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" placeholder="tsi(*total/sum from interest insured)" />
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
                                                                <select id="sliptypeendorsement" name="sliptypeendorsement" class="form-control form-control-sm ">
                                                                    {{-- <option selected disabled>{{__('Select Continent')}}</option> --}}
                                                                    <option value="PML" >PML</option>
                                                                    <option value="LOL" >LOL</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" style="opacity: 0;">{{__('Type')}}</label>
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="input-group">
                                                                            <input type="number" value="" step=".0001" id="slippctendorsement" name="slippctendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="pct" />
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
                                                                <input type="number" value="" step=".0001" id="sliptotalsumpctendorsement" name="sliptotalsumpctendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="=pct*tsi" readonly="readonly" required/>
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
                                                                        <table id="deductiblePanelendorsement" class="table table-bordered table-striped">
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
                                                                           
                                                                        </tbody>
                                                                        </table>

                                                                        <table class="table table-bordered table-striped">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select id="slipdptypeendorsement" name="slipdptypeendorsement" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Type')}}</option>
                                                                                        @foreach($deductibletype as $dt)
                                                                                            <option value="{{ $dt->id }}">{{ $dt->abbreviation }} - {{ $dt->description }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select  id="slipdpcurrencyendorsement" name="slipdpcurrencyendorsement" class="form-control form-control-sm ">
                                                                                        <option selected disabled>{{__('Currency')}}</option>
                                                                                        @foreach($currency as $crc)
                                                                                            <option value="{{ $crc->id }}">{{ $crc->code }} - {{ $crc->symbol_name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipdppercentageendorsement" name="slipdppercentageendorsement" placeholder="x" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipdpamountendorsement" name="slipdpamountendorsement" placeholder="=x*tsi" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" />
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipdpminamountendorsement" name="slipdpminamountendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                </div>
                                                                            </td> 
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" id="adddeductibleinsuredendorsement-btn" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                                                        <table id="ExtendCoveragePanelendorsement" class="table table-bordered table-striped">
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

                                                                        <table class="table table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <td >
                                                                                <div class="form-group">
                                                                                    <select id="slipcncodeendorsement" name="slipcncodeendorsement" class="form-control form-control-sm ">
                                                                                        <option selected readonly>{{__('Peril List')}}</option>
                                                                                        @foreach($extendedcoverage as $ncd)
                                                                                        <option value="{{ $ncd->id }}">{{ $ncd->code }} - {{ $ncd->name }} - {{ $ncd->description }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>  
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipnilaiecendorsement" name="slipnilaiecendorsement" placeholder="y" class="form-control form-control-sm "/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipamountecendorsement" name="slipamountecendorsement" placeholder="=y*tsi" class="form-control form-control-sm " readonly="readonly"/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" id="addextendcoverageinsuredendorsement-btn" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>{{__('Insurance Periode')}}:</label>
                                                                    {{-- <div class="input-group date" id="dateinfrom" data-target-input="nearest"> --}}
                                                                            <input type="date" class="form-control form-control-sm datepicker-input" value="" data-target="#date" id="slipipfromendorsement" name="slipipfromendorsement">
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
                                                                            <input type="date" class="form-control form-control-sm datepicker-input"  value="" data-target="#date" id="slipiptoendorsement" name="slipiptoendorsement">
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
                                                                            <input type="date" class="form-control form-control-sm datetimepicker-input" value="" data-target="#date" id="sliprpfromendorsement" name="sliprpfromendorsement">
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
                                                                            <input type="date" class="form-control form-control-sm datetimepicker-input" value=""  data-target="#date" id="sliprptoendorsement" name="sliprptoendorsement">
                                                                            {{-- <div class="input-group-append" data-target="#datereto" data-toggle="datetimepicker">
                                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                    </div> --}}
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
                                                        <input type="checkbox" name="slipproportionalendorsement[]" id="switch-proportionalendorsement"
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
                                                        <select id="sliplayerproportionalendorsement" name="sliplayerproportionalendorsement" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('Choose layer')}}</option>
                                                            <option value="Layer 1"  >Layer 1</option>
                                                            <option value="Layer 2" >Layer 2</option>
                                                            <option value="Layer 3" >Layer 3</option>
                                                            <option value="Layer 4" >Layer 4</option>
                                                            <option value="Layer 5" >Layer 5</option>
                                                        </select>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 d-flex justify-content-start">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Rate (permil.. %)')}}</label>
                                                            <input type="number"  value="" step=".0001" id="sliprateendorsement" name="sliprateendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a" required/>
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
                                                                            <input type="number" value="" step=".0001" id="slipshareendorsement" name="slipshareendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="b" required/>
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
                                                                <input type="number" value="" step=".0001" id="slipsumshareendorsement" name="slipsumshareendorsement" placeholder="= b% * tsi" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" required/>
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
                                                            <input type="number" value="" step=".0001" id="slipbasicpremiumendorsement" name="slipbasicpremiumendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a% * tsi" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Gross Prm to NR')}}</label>
                                                            <input type="number" value="" step=".0001" id="slipgrossprmtonrendorsement" name="slipgrossprmtonrendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="a% * b% * tsi" readonly="readonly" required/>
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
                                                                            <input type="number" value="" step=".0001" id="slipcommissionendorsement" name="slipcommissionendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="d" required/>
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
                                                                <input type="number"  value="" step=".0001" id="slipsumcommissionendorsement" name="slipsumcommissionendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="= a% * b% * tsi * (100% - d%)" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Net Prm to NR')}}</label>
                                                            <input type="number"  value="" step=".0001" id="slipnetprmtonrendorsement" name="slipnetprmtonrendorsement" class="form-control form-control-sm " data-validation="length" placeholder="=a%. * b% * tsi * (100% - d%)" data-validation-length="2-50" readonly="readonly"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="tab-pane fade" id="installment-details-id3" role="tabpanel" aria-labelledby="installment-details">
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
                                                                        <table id="installmentPanelendorsement" class="table table-bordered table-striped">
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

                                                                        <table class="table table-bordered table-striped">
                                                                        <tbody>
                                                                        <tr>

                                                                           <td>
                                                                                <div class="form-group">
                                                                                        <div class="input-group date" id="dateinstallment" data-target-input="nearest">
                                                                                                <input type="date" id="dateinstallmentdataendorsement" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="slipipdateendorsement">
                                                                                                <div class="input-group-append" data-target="#dateinstallment" data-toggle="datetimepicker">
                                                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" min="0" max="100" value="" step=".01"  id="slipippercentageendorsement" name="slipippercentageendorsement" placeholder="w" class="form-control form-control-sm " />
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number" min="0" max="999999999,9999" value="" step=".01" id="slipipamountendorsement" name="slipipamountendorsement" placeholder="= w% * net premium to NR" class="form-control form-control-sm" readonly/>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <button type="button" id="addinstallmentinsuredendorsement-btn"  class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                                        <select id="sliprbendorsement" name="sliprbendorsement" class="form-control form-control-sm ">
                                                            <option value="AF" >YES</option>
                                                            <option value="AN" >NO</option>
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
                                                                        <input type="text" id="sliporendorsement" value="" name="sliporendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text"><span><i class="fa fa-percent" aria-hidden="true"></i></span></div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" id="slipsumorendorsement" value=""   name="slipsumorendorsement" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="tabretroendorsement">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header bg-gray">
                                                            {{__('Retrocession Panel')}}
                                                        </div>
                                                        
                                                        <div class="card-body bg-light-gray ">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-12 com-sm-12 mt-3">
                                                                        <table id="retrocessionPanelendorsement" class="table table-bordered table-striped">
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

                                                                        <table class="table table-bordered table-striped">
                                                                        <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <select id="sliprptypeendorsement" name="sliprptypeendorsement" class="form-control form-control-sm ">
                                                                                                <option selected disabled>{{__('Type list')}}</option>
                                                                                                <option value="NM XOL">NM XOL</option>
                                                                                            </select>
                                                                                        </div>  
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <select id="sliprpcontractendorsement" name="sliprpcontractendorsement" class="form-control form-control-sm ">
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
                                                                                                        <input type="number" min="0" max="100" value="" step=".01" id="sliprppercentageendorsement" name="sliprppercentageendorsement" class="form-control form-control-sm " />
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
                                                                                            <input type="text" id="sliprpamountendorsement" name="sliprpamountendorsement" placeholder="= w% * net premium to NR" class="form-control form-control-sm " readonly/>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <button type="button" id="addretrocessioninsuredendorsement-btn" class="btn btn-md btn-primary" data-toggle="modal" data-target="#adduser">{{__('Add')}}</button>
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
                                
                                
                                </div>
                            </div>
                        </div> 
                    

                        
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                            <input type="submit" class="btn btn-secondary"  value="Endorsement"/>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            {{-- Edit Modal Ends --}}