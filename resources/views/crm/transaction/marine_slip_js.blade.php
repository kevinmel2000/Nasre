<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script type="text/javascript">
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); 
        
        $("#btnaddlayer").attr('hidden','true');
        $("#sliplayerproportional").attr('hidden','true');
        $("#labelnonprop").attr('hidden','true');
        $("#retrocessionPanel").attr('hidden','true');
        $("#tabretro").attr('hidden','true');

        // $("#marineslipform").attr("hidden", true);
        // $("#marineslipform :input").prop("disabled", true);
        
        });
</script>
<link rel="stylesheet" href="{{url('/')}}/css/sweetalert2.min.css">
<script src="{{url('/')}}/js/sweetalert2.all.min.js"></script>

<style>
    .hide {
        display: none;
    }
</style>

<script type="text/javascript">
    $('#switch-proportional').change(function(){
        var attr = $("#btnaddlayer").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#btnaddlayer").removeAttr('hidden');
            $("#sliplayerproportional").removeAttr('hidden');
            $("#labelnonprop").removeAttr('hidden');
        }
        else{
            $("#btnaddlayer").attr('hidden','true');
            $("#sliplayerproportional").attr('hidden','true');
            $("#labelnonprop").attr('hidden','true');
        }
        
    });

    $('#sliprb').change(function(){
        var attr = $("#retrocessionPanel").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#retrocessionPanel").removeAttr('hidden');
            $("#tabretro").removeAttr('hidden');
        }
        else{
            $("#retrocessionPanel").attr('hidden','true');
            $("#tabretro").attr('hidden','true');
        }
    });

    $('#slipipfrom').on('dp.change', function(e){ console.log(e.date); })
</script>

<script type="text/javascript">
    $(function() {              
       // Bootstrap DateTimePicker v4
       $('#dateinstallment').datetimepicker({
             format: 'DD/MM/YYYY'
       });

       $('#dateinfrom').datetimepicker({
             format: 'DD/MM/YYYY'
       });

       $('#dateinto').datetimepicker({
             format: 'DD/MM/YYYY'
       });

       $('#daterefrom').datetimepicker({
             format: 'DD/MM/YYYY'
       });

       $('#datereto').datetimepicker({
             format: 'DD/MM/YYYY'
       });
    });      

    $('#slipipfrom').change(function(){
        $('#sliprpfrom').val($(this).val());
    });

    $('#slipipto').change(function(){
        $('#sliprpto').val($(this).val());
    });

</script>


<script>
    $( "#autocomplete" ).autocomplete({
      source: [
      @foreach (@$customer as $costumerdata)
       "{{@$costumerdata->company_name }}",
      @endforeach
      ]
    });
    </script>
    
    <script>
        $( "#autocomplete2" ).autocomplete({
          source: [
          @foreach (@$customer as $costumerdata)
           "{{@$costumerdata->company_name }}",
          @endforeach
          ]
        });
    </script>

<script>
    var CSRF_TOKEN = $('meta[name="_token2"]').attr('content');
    
   $(document).ready(function() { 
           
           $(".e1").select2({ width: '100%' }); 
           
           $("#btn-success2").click(function(){ 
           var html = $(".clone2").html();
           $(".increment2").after(html);
           });
   
           $("body").on("click","#btn-danger2",function(){ 
           $(this).parents("#control-group2").remove();
           });
   
           
   });
</script>



<script type="text/javascript">
     $('#shipcodetxt').change(function(){
        var shipcode = $(this).val();

        if(shipcode){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-ship-list')}}?ship_code="+shipcode,
                success:function(response){        
                    if(response){
                        $("#shipnametxt").val(response.shipname);
                    }else{
                        $("#shipnametxt").empty();
                    }
                }
            });
        }else{
            $("#shipnametxt").empty();
        }
    });
</script>

<script type='text/javascript'>
     $('#form-addship').submit(function(e){
        e.preventDefault();

        var shipcode = $('#shipcodetxt').val();
        var shipname = $('#shipnametxt').val();
        var insured_id = $('#msinumber').val();
        var token = $('input[name=_token]').val();
        
        $.ajax({
            url:"{{ route('shiplist.store') }}",
            type:"POST",
            data:{
                ship_code:shipcode,
                ship_name:shipname,
                insuredID:insured_id,
                _token:token
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                console.log(response)
                $('#shipdetailTable tbody').prepend('<tr id="sid'+response.id+'"  data-name="shiplistvalue[]"><td data-name="'+shipcode+'">'+shipcode+'</td><td data-name="'+shipname+'">'+shipname+'</td><td><a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
                $('#ModalAddShip').modal('toggle');
                $('#form-addship')[0].reset();
            }
        });

    });
</script>



<script type='text/javascript'>
    function deleteshipdetail(id){
        var token = $('input[name=_token]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-ship-list/'+id,
            type:"DELETE",
            data:{
                _token:token
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                
                $('#sid'+id).remove();
                console.log(response);
            }
        });
    }
</script>

<script type="text/javascript">
    $('#addslipform').click(function () {
        var count = 1;
        count = count + 1;
        output = '<tr id="row_'+count+'">';
        
        output =    '<div class="tab-pane fade show active" id="slip-details-id" role="tabpanel" aria-labelledby="slip-details">';
        output +=   '<div class="container-fluid p-3">';                         
        output +=   '<form id="marineslipform" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">';
        output +=   '<div class="card card-tabs">';
        output +=   '<div class="card-header p-0 pt-1 border-bottom-0">';
        output +=   '<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">';
        output +=   '<li class="pt-1 px-3"><h3 class="card-title">Slip Form</h3></li>';
        output +=   '<li class="nav-item">';
        output +=   '<a class="nav-link active" id="general-details" data-toggle="pill" href="#general-details-id" role="tab" aria-controls="general-details-id" aria-selected="true">General Data</a></li>';
        output +=   '<li class="nav-item"><a class="nav-link" id="insured-details" data-toggle="pill" href="#insured-details-id" role="tab" aria-controls="address-details-id" aria-selected="false">Insured Data</a></li>';
        output +=   '<li class="nav-item"><a class="nav-link" id="installment-details" data-toggle="pill" href="#installment-details-id" role="tab" aria-controls="installment-details-id" aria-selected="false">Installment & Retrocession</a></li></ul></div>';
        output +=   '<div class="card-body bg-light-gray"><div class="tab-content p-0 pt-1" id="custom-tabs-three-tabContent">';
        output +=   '<div class="tab-pane fade show active" id="general-details-id" role="tabpanel" aria-labelledby="general-details">';
        output +=   '<div class="row"><div class="col-md-6"><div class="row"><div class="col-md-12"><div class="form-group">';
        output +=   '<input type="hidden" name="_token2" id="token" value="{{ csrf_token() }}"><input type="hidden" name="slipmsinumber" id="slipmsinumber" value="{{ $code_ms }}"><label for="">Number</label>';
        output +=   '<input type="text" id="slipnumber" name="slipnumber" class="form-control form-control-sm" data-validation="length" data-validation-length="0-25" value="{{ $code_sl }}" readonly="readonly" /></div></div></div>';
        output +=   '<div class="row"><div class="col-md-12"><div class="form-group"><label for="">Username</label><input type="text" id="slipusername" name="slipusername" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" value="{{Auth::user()->name}}" readonly="readonly" /></div> </div></div>';
        output +=   '<div class="row"><div class="col-md-12"><div class="form-group"> <label>Prod Year:</label><div class="input-group date" id="date" data-target-input="nearest">';
        output +=   '<input type="text" class="form-control form-control-sm datepicker-input" data-target="#date" id="slipprodyear" name="slipprodyear" value="{{ $currdate }}" readonly="readonly"><div class="input-group-append" ><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div></div></div></div>';
        output +=   '<div class="row"><div class="col-md-12"><div class="form-group"><label for="">{{__('UY')}}</label><input type="number" id="slipuy" name="slipuy" class="form-control form-control-sm " data-validation="length"  data-validation-length="0-15" /></div></div></div>';
        output <div class="row">
                                                                    <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('Status')}}</label>
                                                                        <select id="slipstatus" name="slipstatus" class="form-control form-control-sm ">
                                                                            {{-- <option selected disabled>{{__('Select Status')}}</option> --}}
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
                                                                        <i class="fa fa-info-circle" style="color: grey;" hidden="true"> Data is Transferred!</i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Source')}}</label>
                                                                    <select id="slipcedingbroker" name="slipcedingbroker" class="e1 form-control form-control-sm ">
                                                                        <option value="" disabled selected>Ceding or Broker</option>
                                                                        @foreach($cedingbroker as $cb)
                                                                            <option value="{{ $cb->id }}">{{ $cb->companytype->name }} - {{ $cb->code }} - {{ $cb->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>    
                                                                <div class="form-group">
                                                                    <select id="slipceding" name="slipceding" class="e1 form-control form-control-sm ">
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
                                                                        <select id="slipcurrency" name="slipcurrency" class="e1 form-control form-control-sm ">
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
                                                                        <select id="slipcob" name="slipcob" class="e1 form-control form-control-sm ">
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
                                                                        <select id="slipkoc" name="slipkoc" class="e1 form-control form-control-sm ">
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
                                                                        <select id="slipoccupacy" name="slipoccupacy" class="e1 form-control form-control-sm ">
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
                                                                        <select id="slipbld_const" name="slipbld_const" class="e1 form-control form-control-sm ">
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
                                                                                        <input type="text" id="slipno" name="slipno" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="">{{__('CN/DN')}}</label>
                                                                                        <input type="text" id="slipcndn" name="slipcndn" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="">{{__('Policy No')}}</label>
                                                                                        <input type="text" id="slippolicy_no" name="slippolicy_no" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
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
                                                                                    <input type="hidden" name="msitsi" id="msitsi" value="">
                                                                                    <input type="hidden" name="msisharev" id="msisharev" value="">
                                                                                    <input type="hidden" name="msisumsharev" id="msisumsharev" value="">
                
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
                                                                                                        <td data-name="{{ $isl->interest_id }}">{{ $isl->interestinsureddata->description }}</td>
                                                                                                        <td data-name="{{ $isl->amount }}">@currency($isl->amount)</td>
                                                                                                        <td><a href="javascript:void(0)" onclick="deleteinterestdetail({{ $isl->id }})">delete</i></a></td>
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
                                                                    <input type="number" min="0" value="0" step=".0001" id="sliptotalsum" name="sliptotalsum" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" readonly="readonly" placeholder="tsi(*total/sum from interest insured)" />
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
                                                                                        <tr>
                                                                                            @foreach($deductibletemp as $dtt)
                                                                                                <tr id="ddtid{{ $dtt->id }}">
                                                                                                        <td data-name="{{ $dtt->deductible_id }}">{{ $dtt->DeductibleType->abbreviation }} - {{ $dtt->DeductibleType->description }}</td>
                                                                                                        <td data-name="{{ $dtt->currency_id }}">{{ $dtt->currency->symbol_name }}</td>
                                                                                                        <td data-name="{{ $dtt->percentage }}">{{ $dtt->percentage }}</td>
                                                                                                        <td data-name="{{ $dtt->amount }}">@currency($dtt->amount)</td>
                                                                                                        <td data-name="{{ $dtt->min_claimamount }}">@currency($dtt->min_claimamount)</td>
                                                                                                        <td><a href="javascript:void(0)" onclick="deletedeductibletype({{ $dtt->id }})">delete</i></a></td>
                                                                                                </tr>   
                                                                                            @endforeach
                                                                                        </tr>
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
                                                                                                        <button type="button" id="adddeductibletype-btn" class="btn btn-md btn-primary" >{{__('Add')}}</button>
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
                                                                                                    <td data-name="{{ $cnt->information }}">@if($cnt->information == null)
                                                                                                            - 
                                                                                                        @else
                                                                                                            {{ $cnt->information }}
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td><a href="javascript:void(0)" onclick="deleteconditionneeded({{ $cnt->id }})">delete</i></a></td>
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
                                                                                                        <button type="button" class="btn btn-md btn-primary" id="addconditionneeded-btn">{{__('Add')}}</button>
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
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label>{{__('Insurance Periode')}}:</label>
                                                                                {{-- <div class="input-group date" id="dateinfrom" data-target-input="nearest"> --}}
                                                                                        <input type="date" class="form-control form-control-sm datepicker-input" data-target="#date" id="slipipfrom" name="slipipfrom">
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
                                                                                        <input type="date" class="form-control form-control-sm datepicker-input" data-target="#date" id="slipipto" name="slipipto">
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
                                                                                        <input type="date" class="form-control form-control-sm datetimepicker-input" data-target="#date" id="sliprpfrom" name="sliprpfrom">
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
                                                                                        <input type="date" class="form-control form-control-sm datetimepicker-input" data-target="#date" id="sliprpto" name="sliprpto">
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
                                                                    <input type="checkbox" name="slipproportional[]" value="1" id="switch-proportional"
                                                                    class="submit" checked>
                                                                    <span class="switcher"></span>
                                                                    <span  class="label"> {{__('Non Proportional')}} </span>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group d-flex justify-content-end">
                                                                    <label style="opacity: 0;">{{__('p')}}:</label>
                                                                    <button type="button" class="btn plus-button" id="btnaddlayer" data-toggle="modal" data-target="#addLayerModal">
                                                                        <span data-toggle="tooltip" data-placement="top" title="{{__('Add New layer')}}"> + add layer </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="" id="labelnonprop">{{__('Layer for non proportional')}}</label>
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
                                                                        <input type="number" value="0" step=".0001" id="slipnetprmtonr" name="slipnetprmtonr" class="form-control form-control-sm " data-validation="length" placeholder="=a%. * b% * tsi * (100% - d%)" data-validation-length="0-50" readonly="readonly"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="tab-pane fade" id="insurance-details-id" role="tabpanel" aria-labelledby="insurance-details">
                                                    </div> --}}
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
                                                                                                    <td data-name="{{ $isp->amount }}">@currency( $isp->amount)</td>
                                                                                                    <td><a href="javascript:void(0)" onclick="deleteinstallmentpanel({{ $isp->id }})">delete</i></a></td>
                                                                                            </tr>   
                                                                                        @endforeach
                                                                                        <tr>
                                                                                            <form id="addinstallmentpanel">
                                                                                                @csrf
                                                                                                <td>
                                                                                                    <div class="form-group">
                                                                                                            {{-- <div class="input-group date" id="dateinstallment" data-target-input="nearest"> --}}
                                                                                                                    <input type="date" class="form-control form-control-sm datetimepicker-input" data-target="#dateinstallment" id="slipipdate" name="slipipdate">
                                                                                                                    {{-- <div class="input-group-append" data-target="#dateinstallment" data-toggle="datetimepicker">
                                                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                                                    </div> --}}
                                                                                                            {{-- </div> --}}
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
                                                                                                        <button type="button" class="btn btn-md btn-primary" id="addinstallmentpanel-btn">{{__('Add')}}</button>
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
                                                                        <option value="YES" >YES</option>
                                                                        <option value="NO" selected>NO</option>
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
                                                                                    <input type="number" value="100" step=".0001" id="slipor" name="slipor" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text"><span><i class="fa fa-percent" aria-hidden="true"></i></span></div> 
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input type="number" value="0" step=".0001" id="slipsumor" name="slipsumor" class="form-control form-control-sm " data-validation="length" data-validation-length="0-50" placeholder="= x% * b% * tsi" readonly="readonly" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="tabretro">
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
                                                                                                        <td data-name="{{ $rsc->amount }}">@currency( $rsc->amount)</td>
                                                                                                        <td><a href="javascript:void(0)" onclick="deleteretrocessiontemp({{ $rsc->id }})">delete</i></a></td>
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
                                                                                                            <button type="button" class="btn btn-md btn-primary" id="addretrocessiontemp-btn">{{__('Add')}}</button>
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
                                                        <button type="submit" id="addslipsave-btn" class="btn btn-primary btn-block ">
                                                            {{__('Save')}}
                                                        </button>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                        </div> 
                                    </form>
                                </div>
                            </div>
        $('#custom-tabs-three-tabContent').append(output);
    });


</script>

<script  type='text/javascript'>
    $('#slippct').keyup(function () {
        var pct =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(pct * tsi/100) ? 0 :(pct * tsi/100) ;
         $('#sliptotalsumpct').val(sum);
         
     });

     $('#slipdppercentage').keyup(function () {
        var percent =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(percent * tsi/100) ? 0 :(percent * tsi/100) ;
        $('#slipdpamount').val(sum);
     });

     $('#slipshare').keyup(function () {
        var shareslip =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(shareslip * tsi/100) ? 0 :(shareslip * tsi/100) ;
        $('#slipsumshare').val(sum);
        // $('#msishare').val(shareslip);
        $('#msisharev').val(shareslip);
     });

     $('#sliprate').keyup(function () {
        var rateslip =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(rateslip * tsi/100) ? 0 :(rateslip * tsi/100) ;
        $('#slipbasicpremium').val(sum);
     });

     $('#slipshare').change(function () {
        var rateslip =  parseFloat($('#sliprate').val()) / 100 ;
        var shareslip =  parseFloat($('#slipshare').val()) / 100 ;
        var ourshare =  parseFloat($('#msisharev').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsum").val());
        var mtsi = parseFloat($("#msitsi").val());
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * mtsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonr').val(sum);
        // $('#msisharefrom').val(sumourshare);
        $('#msisumsharev').val(sumourshare);
     });

     $('#slipcommission').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = parseFloat($("#slipgrossprmtonr").val());
        var sum = isNaN(commision * sumgrossprmtonr/100) ? 0 :(commision * sumgrossprmtonr/100);
        var sumnetprmtonr = isNaN( sumgrossprmtonr * (100/100 - commision)) ? 0 :(sumgrossprmtonr * (100/100 - commision));
        $('#slipsumcommission').val(sum);
        $('#slipnetprmtonr').val(sumnetprmtonr);
    });

    $('#slipippercentage').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumnetprtonr = parseFloat($("#slipnetprmtonr").val());
        var sum = isNaN(percent * sumnetprtonr) ? 0 :(percent * sumnetprtonr);
        $('#slipipamount').val(sum);
    });

    $('#slipor').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = parseFloat($("#slipsumshare").val());
        var sum = isNaN(percent * sumshare) ? 0 :(percent * sumshare);
        $('#slipsumor').val(sum);
    });

    $('#sliprppercentage').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = parseFloat($("#slipsumshare").val());
        var sum = isNaN(percent * sumshare) ? 0 :(percent * sumshare);
        $('#sliprpamount').val(sum);
    });

    $('#sliprppercentage').change(function () {
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#slipor').val());
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#slipor').val(sumpercentor);
    });
</script>

<script type='text/javascript'>
    $('#addinterestinsured-btn').click(function(e){
       e.preventDefault();

       var interest = $('#slipinterestlist').val();
       var amount = $('#slipamount').val();
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('interestlist.store') }}",
           type:"POST",
           data:{
               interest_insured:interest,
               slipamount:amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.interest_id+'">'+response.description+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
               
               var total =  parseFloat($("#sliptotalsum").val());
               var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
               $("#sliptotalsum").val(sum);
            //    $("#msishareto").val(sum);
               $("#msitsi").val(sum);
               $(':input','#addinterestinsured').not(':button, :submit, :reset, :hidden').val(' ').removeAttr('checked').removeAttr('selected');
            
           }
       });

    });

    $('#adddeductibletype-btn').click(function(e){
       e.preventDefault();

       var dptype = $('#slipdptype').val();
       var dpcurrency = $('#slipdpcurrency').val();
       var dpminamount = $('#slipdpminamount').val();
       var dpamount = $('#slipdpamount').val();
       var dppercentage = $('#slipdppercentage').val();
       var dpslip_id = $('#slipnumber').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(dptype)
            console.log(dpcurrency)
            console.log(dpminamount)
            console.log(dpamount)
            console.log(dppercentage)
            console.log(dpslip_id)
       $.ajax({
           url:"{{ route('deductible.store') }}",
           type:"POST",
           data:{
                slipdptype:dptype,
                slipdpcurrency:dpcurrency,
                minamount:dpminamount,
                amount:dpamount,
                percentage:dppercentage,
                id_slip:dpslip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
            
                console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
                $('#deductiblePanel tbody').prepend('<tr id="ddtid'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype_id+'">'+ response.dtabbrev +' - '+ response.dtdescript+'</td><td data-name="'+response.currency_id+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibletype('+response.id+')">delete</a></td></tr>')
                
                $(':input','#adddeductibletype').not(':button, :submit, :reset, :hidden').val(' ').removeAttr('checked').removeAttr('selected');
               
           }
       });

    });

    $('#addconditionneeded-btn').click(function(e){
       e.preventDefault();

       var cncode = $('#slipcncode').val();
       var slip_id = $('#slipnumber').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('conditionneeded.store') }}",
           type:"POST",
           data:{
                slipcncode:cncode,
                id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){

               console.log(response)
               
               if(response.information == null){
                $('#conditionNeeded tbody').prepend('<tr id="cnid'+response.id+'" data-name="conditionneededvalue[]"><td data-name="'+response.conditionneeded_id+'">'+response.condition+'</td><td data-name="'+response.information+'">-</td><td><a href="javascript:void(0)" onclick="deleteconditionneeded('+response.id+')">delete</a></td></tr>')
               
               }else{
                $('#conditionNeeded tbody').prepend('<tr id="cnid'+response.id+'" data-name="conditionneededvalue[]"><td data-name="'+response.conditionneeded_id+'">'+response.condition+'</td><td data-name="'+response.information+'">'+response.information+'</td><td><a href="javascript:void(0)" onclick="deleteconditionneeded('+response.id+')">delete</a></td></tr>')
               
               }
               $(':input','#addconditionneeded').not(':button, :submit, :reset, :hidden').val(' ').removeAttr('checked').removeAttr('selected');
               
               
               
            
           }
       });

    });

    $('#addinstallmentpanel-btn').click(function(e){
       e.preventDefault();

       var ipdate = $('#slipipdate').val();
       var ippercentage = $('#slipippercentage').val();
       var ipamount = $('#slipipamount').val();
       var slip_id = $('#slipnumber').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('installment.store') }}",
           type:"POST",
           data:{
                installmentdate:ipdate,
                percentage:ippercentage,
                slipamount:ipamount,
                id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#installmentPanel tbody').prepend('<tr id="ispid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentpanel('+response.id+')">delete</a></td></tr>')
               $(':input','#addinstallmentpanel').not(':button, :submit, :reset, :hidden').val(' ').removeAttr('checked').removeAttr('selected');
               

               
               
            
           }
       });

    });

    $('#addretrocessiontemp-btn').click(function(e){
       e.preventDefault();

       var rptype = $('#sliprptype').val();
       var rpcontract = $('#sliprpcontract').val();
       var rppercentage = $('#sliprppercentage').val();
       var rpamount = $('#sliprpamount').val();
       var slip_id = $('#slipnumber').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('retrocession.store') }}",
           type:"POST",
           data:{
                type:rptype,
                contract:rpcontract,
                percentage:rppercentage,
                amount:rpamount,
                id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#retrocessionPanel tbody').prepend('<tr id="rscid'+response.id+'" data-name="retrocessionvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteretrocessiontemp('+response.id+')">delete</a></td></tr>')
               $(':input','#addretrocessiontemp').not(':button, :submit, :reset, :hidden').val(' ').removeAttr('checked').removeAttr('selected');
               $('#sliprppercentage').val(' ');
               $('#sliprpamount').val(' ');
               
               
            
           }
       });

    });
</script>

<script type='text/javascript'>
    function deleteinterestdetail(id){
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-interest-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                
                $('#iid'+id).remove();
                console.log(response);
                
                var total =  parseFloat($("#sliptotalsum").val());
                var sum = isNaN(total - parseFloat(response.amount)) ? 0 :(total - parseFloat(response.amount)) ;
                $("#sliptotalsum").val(sum);
                $("#msishareto").val(sum);
            }
        });
    }

    function deletedeductibletype(id){
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-deductible-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                
                $('#ddtid'+id).remove();
                console.log(response);
                
            }
        });
    }

    function deleteconditionneeded(id){
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-conditionneeded-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                
                $('#cnid'+id).remove();
                console.log(response);
                
            }
        });
    }

    function deleteinstallmentpanel(id){
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-installment-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                
                $('#ispid'+id).remove();
                console.log(response);
                
            }
        });
    }

    function deleteretrocessiontemp(id){
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-retrocession-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                
                $('#rscid'+id).remove();
                console.log(response);
                
            }
        });
    }
</script>

<script type="text/javascript">
    $('#addinsuredsave-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var msinumber = $('#msinumber').val();
       var msiprefix = $('#msiprefix').val();
       var msisuggestinsured = $('#autocomplete').val();
       var msisuffix = $('#autocomplete2').val();
       var msishare = $('#msishare').val();
       var msisharefrom  = $('#msisharefrom').val();
       var msishareto = $('#msishareto').val();
       var msiroute = $('#msiroute').val();
       var msiroutefrom  = $('#msiroutefrom').val();
       var msirouteto = $('#msirouteto').val();
       var msicoinsurance = $('#msicoinsurance').val();
       
       
       var token2 = $('input[name=_token]').val();

       console.log(msiprefix)
       console.log(msisuggestinsured)
       console.log(msinumber)
       console.log(msisuffix)

       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/marine-insured/store') }}",
           type:"POST",
           data:{
               msinumber:msinumber,
               msiprefix:msiprefix,
               msisuggestinsured:msisuggestinsured,
               msisuffix:msisuffix,
               msishare:msishare,
               msisharefrom:msisharefrom,
               msishareto:msishareto,
               msiroute:msiroute,
               msiroutefrom:msiroutefrom,
               msirouteto:msirouteto,
               msicoinsurance:msicoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Marine Insert Success", "success")
                console.log(response)
                $(':input','#formmarineinsured')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');

                // $("#marineslipform").attr("hidden", false);
                $("#marineslipform :input").prop("disabled", false);
                $('#slipmsinumber').val();
           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Marine Insured Insert Error", "Insert Error");
           }
       });

   });
</script>

<script type='text/javascript'>
    $('#marineslipform').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ins = $('#slipmsinumber').val();
       var slipnumber = $('#slipnumber').val();
       var slipuy = $('#slipuy').val();
       var slipstatus = $('#slipstatus').val();
       var sliped = $('#sliped').val();
       var slipsls = $('#slipsls').val();
       var slipcedingbroker = $('#slipcedingbroker').val();
       var slipceding = $('#slipceding').val();
       var slipcurrency = $('#slipcurrency').val();
       var slipcob = $('#slipcob').val();
       var slipkoc = $('#slipkoc').val();
       var slipoccupacy = $('#slipoccupacy').val();
       var slipbld_const = $('#slipbld_const').val();
       var slipno = $('#slipno').val();
       var slipcndn = $('#slipcndn').val();
       var slippolicy_no = $('#slippolicy_no').val();
       var sliptotalsum = $('#sliptotalsum').val();
       var sliptype =  $('#sliptype').val();
       var slippct =  $('#slippct').val();
       var sliptotalsumpct =  $('#sliptotalsumpct').val();
       var slipipfrom =  $('#slipipfrom').val();
       var slipipto =  $('#slipipto').val();
       var sliprpfrom =  $('#sliprpfrom').val();
       var sliprpto =  $('#sliprpto').val();
       var proportional =  $('#switch-proportional').val();
       var sliplayerproportional =  $('#sliplayerproportional').val();
       var sliprate =  $('#sliprate').val();
       var slipshare =  $('#slipshare').val();
       var slipsumshare =  $('#slipsumshare').val();
       var slipbasicpremium =  $('#slipbasicpremium').val();
       var slipgrossprmtonr =  $('#slipgrossprmtonr').val();
       var slipsumcommission =  $('#slipsumcommission').val();
       var slipnetprmtonr =  $('#slipnetprmtonr').val();
       var sliprb =  $('#sliprb').val();
       var slipor =  $('#slipor').val();
       var slipsumor =  $('#slipsumor').val();
       var token2 = $('input[name=_token]').val();
       var msitsi = $('#msitsi').val();
       var msisumsharev = $('#msisumsharev').val();
       var msisharev = $('#msisharev').val();
       
       //ajaxfilefunction(e);

       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/marine-slip/store')}}",
           type:"POST",
           data:{
               code_ins:code_ins,
               slipnumber:slipnumber,
               slipuy:slipuy,
               slipstatus:slipstatus,
               sliped:sliped,
               slipsls:slipsls,
               slipcedingbroker:slipcedingbroker,
               slipceding:slipceding,
               slipcurrency:slipcurrency,
               slipcob:slipcob,
               slipkoc:slipkoc,
               slipoccupacy:slipoccupacy,
               slipbld_const:slipbld_const,
               slipno:slipno,
               slipcndn:slipcndn,
               slippolicy_no:slippolicy_no,
               sliptotalsum:sliptotalsum,
               sliptype:sliptype,
               slippct:slippct,
               sliptotalsumpct:sliptotalsumpct,
               slipipfrom:slipipfrom,
               slipipto:slipipto,
               sliprpfrom:sliprpfrom,
               sliprpto:sliprpto,
               proportional:proportional,
               sliplayerproportional:sliplayerproportional,
               sliprate:sliprate,
               slipshare:slipshare,
               slipsumshare:slipsumshare,
               slipbasicpremium:slipbasicpremium,
               slipgrossprmtonr:slipgrossprmtonr,
               slipsumcommission:slipsumcommission,
               slipnetprmtonr:slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipsumor:slipsumor,
               tsims:msitsi,
               sharems:msisharev,
               sumsharems:msisumsharev,
               formData:formData
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Marine Slip Insert Success", "success")
                console.log(response)
                
           },
           error: function (request, status, error) {
                console.log(request.responseText);
                swal("Error!", "Marine Slip Insert Error", "Insert Error");
           }
       });

       


        var formData = new FormData(this);
       let TotalFiles = $('#attachment')[0].files.length; //Total files
       let files = $('#attachment')[0];
       var slip_id = $('#slipnumber').val();

       for (let i = 0; i < TotalFiles; i++) 
       {
        formData.append('files' + i, files.files[i]);
       }
       
       formData.append('TotalFiles', TotalFiles);
       formData.append('slip_id', slip_id);
     
       $.ajax({
                    type:'POST',
                    url: "{{ url('store-multi-file-ajax')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: (data) => {
                    //this.reset();
                    //alert('Files has been uploaded using jQuery ajax');
                      swal("Good job!", "Files has been uploaded", "success")
                    },
                    error: function(data){
                     //alert(data.responseJSON.errors.files[0]);
                     swal("Error!", data.responseJSON.errors.files[0], "Insert Error");
                     console.log(data.responseJSON.errors);
                    }
        });

   });
</script>


<style>
    .overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("{{url('/')}}/loader.gif") center no-repeat;
    }
    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;   
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }
</style>

<script>
    // $(function () {
    //   "use strict";
  
    //   var marineslip = <?php echo(($ms_ids->content())) ?>;
    //   for(const id of marineslip) {
    //       var btn = `
    //           <a href="#" onclick="confirmDelete('${id}')">
    //               <i class="fas fa-trash text-danger"></i>
    //           </a>
    //       `;
    //       $(`#delbtn${id}`).append(btn);
    //   }
  
  
    //   $("#marineSlip").DataTable({
    //     "order": [[ 0, "desc" ]],
    //     dom: '<"top"Bf>rt<"bottom"lip><"clear">',
    //     lengthMenu: [
    //         [ 10, 25, 50,100, -1 ],
    //         [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
    //     ]
    //   });
  
    // });
  
    // function confirmDelete(id){
    //     let choice = confirm("{{__('Are you sure, you want to delete this product and related data?')}}")
    //     if(choice){
    //         document.getElementById('delete-country-'+id).submit();
    //     }
    // }
  
</script>


