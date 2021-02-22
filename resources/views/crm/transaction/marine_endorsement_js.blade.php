<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>
<link rel="stylesheet" href="{{url('/')}}/css/sweetalert2.min.css">
<script src="{{url('/')}}/js/sweetalert2.all.min.js"></script>
<style>
    .hide {
        display: none;
    }
</style>


<script type="text/javascript">
    $(function() {              
       // Bootstrap DateTimePicker v4
       $('#dateinstallment').datetimepicker({
             format: 'YYYY-MM-DD'
       });

       $('#dateinfrom').datetimepicker({
             format: 'YYYY-MM-DD'
       });

       $('#dateinto').datetimepicker({
             format: 'YYYY-MM-DD'
       });

       $('#daterefrom').datetimepicker({
             format: 'YYYY-MM-DD'
       });

       $('#datereto').datetimepicker({
             format: 'YYYY-MM-DD'
       });
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
        $('#msishare').val(shareslip);
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
        var ourshare =  parseFloat($('#msishare').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * tsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonr').val(sum);
        $('#msisharefrom').val(sumourshare);
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
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.interest_id+'">'+response.description+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
               
               var total =  parseFloat($("#sliptotalsum").val());
               var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
               $("#sliptotalsum").val(sum);
               $("#msishareto").val(sum);
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
                $('#deductiblePanel tbody').prepend('<tr id="ddtid'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype_id+'">'+ response.dtabbrev +' - '+ response.dtdescript+'</td><td data-name="'+response.currency_id+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibletype('+response.id+')">delete</a></td></tr>')
                
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
               $('#installmentPanel tbody').prepend('<tr id="ispid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentpanel('+response.id+')">delete</a></td></tr>')
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
               $('#retrocessionPanel tbody').prepend('<tr id="rscid'+response.id+'" data-name="retrocessionvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteretrocessiontemp('+response.id+')">delete</a></td></tr>')
               $(':input','#addretrocessiontemp').not(':button, :submit, :reset, :hidden').val(' ').removeAttr('checked').removeAttr('selected');
               
               
               
            
           }
       });

    });
</script>

<script type="text/javascript">
    function geteditinterest(id){
        // var ins_code = $('#interestidupdate').val();

        if(id){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-interest-list')}}?ins_code="+id,
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(response){  
                    console.log(response)      
                    if(response){
                        $("#slipinterestlist").val(response.interest_id);
                        $("#slipamount").val(response.amount);
                        $("#idinterestinsured").val(response.id);
                        $(':input','#addinterestinsured')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#slipinterestlist").empty();
                        $("#slipamount").empty();
                        $("#idinterestinsured").empty();
                    }
                }
            });
        }else{
            swal("Ohh no!", "Current object failed to get", "failed")
        }
    }

    function geteditdeductible(id){
        // var deductible_code = $('#deductidupdate').val();

        if(id){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-deductible-list')}}?deductible_code="+id,
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(response){  
                    console.log(response)      
                    if(response){
                        $("#slipdptype").val(response.deductibletype_id);
                        $("#slipdpcurrency").val(response.currency_id);
                        $("#slipdppercentage").val(response.perceentage);
                        $("#slipdpamount").val(response.amount);
                        $("#slipdpminamount").val(response.min_claimamount);
                        $('#id_deduct').val(response.id);
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#slipdptype").empty();
                        $("#slipdpcurrency").empty();
                        $("#slipdppercentage").empty();
                        $("#slipdpamount").empty();
                        $("#slipdpminamount").empty();
                    }
                }
            });
        }else{
            swal("Ohh no!", "Current object failed to get", "failed")
        }
    }

    function geteditconditionneeded(id){
        // var cn_code = $('#cnidupdate').val();

        if(id){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-conditionneeded-list')}}?cn_code="+id,
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(response){  
                    console.log(response)      
                    if(response){
                        $("#slipcncode").val(response.condition_id);
                        $("#id_cnt").val(response.id);
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#slipcncode").empty();
                        $("#id_cnt").empty();
                    }
                }
            });
        }else{
            swal("Ohh no!", "Current object failed to get", "failed")
        }
    }

    function geteditinstallment(id){
        var intem_code = $('#impidupdate').val();

        if(intem_code){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-installment-list')}}?intem_code="+intem_code,
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(response){  
                    console.log(response)      
                    if(response){
                        $("#slipipdate").val(response.installment_date);
                        $("#slipippercentage").val(response.percentage);
                        $("#slipipamount").val(response.amount);
                        $("#id_inspan").val(response.id);
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#slipipdate").empty();
                        $("#slipippercentage").empty();
                        $("#slipipamount").empty();
                        $("#id_inspan").empty();
                    }
                }
            });
        }else{
            swal("Ohh no!", "Current object failed to get", "failed")
        }
    }

    function geteditretrocession(id){
        var rsc_code = $('#interestidupdate').val();

        if(rsc_code){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-retrocession-list')}}?rsc_code="+rsc_code,
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(response){  
                    console.log(response)      
                    if(response){
                        $("#sliprptype").val(response.type);
                        $("#sliprpcontract").val(response.contract);
                        $("#sliprppercentage").val(response.percentage);
                        $("#sliprpamount").val(response.amount);
                        $("#id_rsp").val(response.id);
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#sliprptype").empty();
                        $("#sliprpcontract").empty();
                        $("#sliprppercentage").empty();
                        $("#sliprpamount").empty();
                        $("#id_rsp").empty();
                    }
                }
            });
        }else{
            swal("Ohh no!", "Current object failed to get", "failed")
        }
    }
</script>


<script type='text/javascript'>
    function interestdetailupdate(){
        var token = $('input[name=_token]').val();
        var interestins = $('#slipinterestlist').val();
        var interestamount = $('#slipamount').val();
        var slipnumber = $('#slipnumber').val();
        var id = $('#idinterestinsured').val();

        console.log(token)
        console.log(interestins)
        console.log(interestamount)
        console.log(slipnumber)

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
        $.ajax({
            url:'{{ url("/") }}/update-interest-list/'+id,
            type:"POST",
            data:{
                interest_insured:interestins,
                interest_amount:interestamount,
                slip_number:slipnumber
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                // $('#updateshiplist'+id).modal('hide');
                $('#iid'+id).remove();
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'"  data-name="interestlistvalue[]"><td data-name="'+response.interest_id+'">'+response.description+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td> <input type="hidden" id="interestidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editinterestinsured" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
               console.log(response);
            }
        });
    }

    function deductibledetailupdate(){
        var token = $('input[name=_token]').val();
        var deduct_type = $('#slipdptype').val();
        var deduct_currency = $('#slipdpcurrency').val();
        var deduct_percent = $('#slipdppercentage').val();
        var deduct_amount = $('#slipdpamount').val();
        var deduct_minamount = $('#slipdpminamount').val();
        var slipnumber = $('#slipnumber').val();
        var id = $('#id_deduct').val();

        console.log(token)
        console.log(deduct_type)
        console.log(deduct_currency)
        console.log(deduct_percent)
        console.log(deduct_amount)
        console.log(deduct_minamount)
        console.log(slipnumber)

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
        $.ajax({
            url:'{{ url("/") }}/update-deductible-list/'+id,
            type:"POST",
            data:{
                type:deduct_type,
                currency:deduct_currency,
                percentage:deduct_percent,
                amount:deduct_amount,
                min_amount:deduct_minamount,
                slip_number:slipnumber
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                // $('#updateshiplist'+id).modal('hide');
                $('#ddtid'+id).remove();
                $('#deductiblePanel tbody').prepend('<tr id="ddtid'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype_id+'">'+ response.dtabbrev +' - '+ response.dtdescript+'</td><td data-name="'+response.currency_id+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><input type="hidden" id="deductidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editdeductibletype" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deletedeductibletype('+response.id+')">delete</a></td></tr>')
               console.log(response);
            }
        });
    }

    function conditionneededdetailupdate(){
        var token = $('input[name=_token]').val();
        var cncode = $('#slipcncode').val();
        var slipnumber = $('#slipnumber').val();
        var id = $('#id_cnt').val();

        console.log(token)
        console.log(cncode)
        console.log(slipnumber)

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
        $.ajax({
            url:'{{ url("/") }}/update-conditionneeded-list/'+id,
            type:"POST",
            data:{
                condition_needed:cncode,
                slip_number:slipnumber
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                // $('#updateshiplist'+id).modal('hide');
                $('#cnid'+id).remove();
                $('#conditionNeeded tbody').prepend('<tr id="cnid'+response.id+'" data-name="conditionneededvalue[]"><td data-name="'+response.conditionneeded_id+'">'+response.condition+'</td><td data-name="'+response.information+'">-</td><td><input type="hidden" id="cnidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editconditionneeded" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deleteconditionneeded('+response.id+')">delete</a></td></tr>')
               console.log(response);
            }
        });
    }

    function installmentdetailupdate(){
        var token = $('input[name=_token]').val();
        var ip_date = $('#slipipdate').val();
        var ip_percent = $('#slipippercentage').val();
        var ip_amount = $('#slipipamount').val();
        var slipnumber = $('#slipnumber').val();
        var id = $('#id_inspan').val();

        console.log(token)
        console.log(ip_date)
        console.log(ip_percent)
        console.log(ip_amount)
        console.log(slipnumber)

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
        $.ajax({
            url:'{{ url("/") }}/update-installment-list/'+id,
            type:"POST",
            data:{
                installment_date:ip_date,
                percentage:ip_percent,
                amount:ip_amount,
                slip_number:slipnumber
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                // $('#updateshiplist'+id).modal('hide');
                $('#ispid'+id).remove();
                $('#installmentPanel tbody').prepend('<tr id="ispid'+response.id+'" data-name="installmentvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><input type="hidden" id="impidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editinstallmentpanel" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deleteinstallmentpanel('+response.id+')">delete</a></td></tr>')
               console.log(response);
            }
        });
    }

    function retrocessiondetailupdate(){
        var token = $('input[name=_token]').val();
        var retro_type = $('#sliprptype').val();
        var retro_contract = $('#sliprpcontract').val();
        var retro_percent = $('#sliprppercentage').val();
        var retro_amount = $('#sliprpamount').val();
        var slipnumber = $('#slipnumber').val();
        var id = $('#id_rsp').val();

        console.log(token)
        console.log(retro_type)
        console.log(retro_contract)
        console.log(retro_percent)
        console.log(retro_amount)
        console.log(slipnumber)

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
        $.ajax({
            url:'{{ url("/") }}/update-retrocession-list/'+id,
            type:"POST",
            data:{
                type:retro_type,
                contract:retro_contract,
                percentage:retro_percent,
                amount:retro_amount,
                slip_number:slipnumber
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                // $('#updateshiplist'+id).modal('hide');
                $('#rscid'+id).remove();
                $('#retrocessionPanel tbody').prepend('<tr id="rscid'+response.id+'" data-name="retrocessionvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><input type="hidden" id="rscidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editretrocessionpanel" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deleteretrocessiontemp('+response.id+')">delete</a></td></tr>')
               console.log(response);
            }
        });
    }
</script>

<script type='text/javascript'>
    $('#updateslipmarine-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slip_id = $('#idslip').val();
       var code_ins = $('#msinumber').val();
       var slipnumber = $('#slipnumber').val();
       var slipusername = $('#slipusername').val();
       var slipprodyear = $('#slipprodyear').val();
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
       

       console.log(slip_id)
       console.log(slipstatus)
       console.log(slipnumber)
       console.log(slipcedingbroker)
       console.log(slippolicy_no)

       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:'{{ url("/") }}/transaction-data/marine-endorsement',
           type:"POST",
           data:{
               code_ins:code_ins,
               slipnumber:slipnumber,
               slipusername:slipusername,
               prod_year:slipprodyear,
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
               formData:formData
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Marine Slip Endorsement Success", "success")
                console.log(response)
                // $(':input','#formmarineinsured')
                //     .not(':button, :submit, :reset, :hidden')
                //     .val('')
                //     .removeAttr('checked')
                //     .removeAttr('selected');
           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Marine Slip Update Error", "Insert Error");
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