<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script type="text/javascript">
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); 
        
        $("#btnaddlayer").attr('hidden','true');
        $("#sliplayerproportional").attr('hidden','true');
        $("#labelnonprop").attr('hidden','true');
        $("#retrocessionPanel").attr('hidden','true');
        $("#tabretro").attr('hidden','true');
        $("#labelnp").attr('hidden','true');


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
            $("#labelnp").removeAttr('hidden');
            
        }
        else{
            $("#btnaddlayer").attr('hidden','true');
            $("#sliplayerproportional").attr('hidden','true');
            $("#labelnonprop").attr('hidden','true');
            $("#labelnp").attr('hidden','true');

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
        var sumshare = parseFloat($('#slipsumshare').val()) ;
        var orpercent = parseFloat($('#slipor').val()) / 100;
        var sumor = isNaN(orpercent * sumshare) ? 0 :(orpercent * sumshare);
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * mtsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonr').val(sum);
        // $('#msisharefrom').val(sumourshare);
        $('#msisumsharev').val(sumourshare);
        
        $('#slipsumor').val(sumor);
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
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#slipor').val());
        var sumshare = parseFloat($('#slipsumshare').val()) ;
        var orpercentage = parseFloat($('#slipor').val()) / 100;
        var sumor = isNaN(orpercentage * sumshare) ? 0 :(orpercentage * sumshare);
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#slipor').val(sumpercentor);
        $('#slipsumor').val(sumor);
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
    //    var msicoinsurance = $('#msicoinsurance').val();
       
       
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
            //    msicoinsurance:msicoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Marine Insert Success", "success")
                console.log(response)
                // $(':input','#formmarineinsured')
                //     .not(':button, :submit, :reset, :hidden')
                //     .val('')
                //     .removeAttr('checked')
                //     .removeAttr('selected');

                // $("#marineslipform").attr("hidden", false);
                // $("#marineslipform :input").prop("disabled", false);
                $('#slipmsinumber').val(msinumber);
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
    //    var sliped = $('#sliped').val();
    //    var slipsls = $('#slipsls').val();
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
       var slipcoinsurance = $('#slipcoinsurance').val();
       
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
            //    sliped:sliped,
            //    slipsls:slipsls,
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
               slipcoinsurance:slipcoinsurance,
               formData:formData
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Marine Slip Insert Success", "success")
                console.log(response)
               $('#SlipInsuredTableData tbody').prepend('<tr id="sliid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.slip_number+'"><a class="text-primary mr-3 float-right " data-toggle="modal" data-target="#detailmodaldata" onclick="detailslip('+response.id+')">'+response.slip_number+'</a></td><td data-name="'+response.uy+'">'+response.uy+'</td><td data-name="'+response.status+'">'+response.status+'</td><td><a class="text-primary mr-3 float-right " data-toggle="modal" data-target="#detailmodaldata" href="javascript:void(0)" onclick="edit('+response.id+')">Update </a><a href="javascript:void(0)" onclick="endorsementmarine('+response.id+')"> Endorsement</a></td></tr>')

               $('#slipnumber').val(response.new_slip_number);
                
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

<script type="text/javascript">

function detailslip(id){
    if(id){
        alert(id);
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('transaction-data/getmodal-marine-slip')}}?slipid="+id,
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(response){  
                    console.log(response)      
                    if(response){
                        $("#slipnumberdetail").val(response.slip_number);
                        $("#slipusernamedetail").val(response.username);
                        $("#slipprodyeardetail").val(response.prod_year);
                        $("#slipuydetail").val(response.uy);
                        $("#slipstatusdetail").val(response.status);
                        $('#slipcedingbrokerdetail').append(' <option value="'+response.cedbrok_id+'" selected>'+response.cedbrok_cn+' - '+response.cedbrok_code+' - '+response.cedbrok+'</option>');
                        // $('#slipcedingdetail').val(response.id);
                        // $('#slipcurrencydetail').val(response.id);
                        // $('#slipcobdetail').val(response.id);
                        // $('#slipkocdetail').val(response.id);
                        // $('#slipoccupacydetail').val(response.id);
                        // $('#slipbld_constdetail').val(response.id);
                        // $('#slipnodetail').val(response.slip_no);
                        // $('#slipcndndetail').val(response.cn_dn);
                        // $('#slippolicy_nodetail').val(response.policy_no);
                        $('#aid').append('<div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+response.attachment_filename+'">'+response.attachment_filename+'</a></div>');
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                    }
                }
            });
        }else{
            swal("Ohh no!", "Current object failed to get", "failed")
        }
}

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


