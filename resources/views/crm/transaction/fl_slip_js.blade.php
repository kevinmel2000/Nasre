<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>

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
    });      
</script>

<script type="text/javascript">
    $(function() {              
       // Bootstrap DateTimePicker v4
       $('#dateinstallment').datetimepicker({
             format: 'YYYY-MM-DD'
       });
    });      
</script>

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


<script>
$( "#autocomplete" ).autocomplete({
  source: [
  @foreach (@$costumer as $costumerdata)
   "{{@$costumerdata->company_name }}",
  @endforeach
  ]
});
</script>

<script>
    $( "#autocomplete2" ).autocomplete({
      source: [
      @foreach (@$costumer as $costumerdata)
       "{{@$costumerdata->company_name }}",
      @endforeach
      ]
    });
</script>

<script>
$(document).ready(function() { 
        
        $(".e1").select2({ width: '100%' }); 

        $("#btnaddlayer").attr('hidden','true');
        $("#sliplayerproportional").attr('hidden','true');
        $("#labelnonprop").attr('hidden','true');
        
        $("#btn-success2").click(function(){ 
        var html = $(".clone2").html();
        $(".increment2").after(html);
        });

        $("body").on("click","#btn-danger2",function(){ 
        $(this).parents("#control-group2").remove();
        });
        
});
</script>

<script type='text/javascript'>
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
</script>

<script type='text/javascript'>
     $('#form-addlocation').submit(function(e){
        e.preventDefault();

        var lookupcode = $('#lookup_location').val();
        var insured_id = $('#insuredIDtxt').val();
        var token = $('input[name=_token]').val();
        
        $.ajax({
            url:"{{ route('locationlist.store') }}",
            type:"POST",
            data:{
                lookupcode:lookupcode,
                insuredID:insured_id,
                _token:token
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                console.log(response)
                //alert(response);
                
                $('#locRiskTable tbody').prepend('<tr id="sid'+response.id+'"><td>'+response.loc_code+'</td><td>'+response.address+'</td><td>'+response.city_id+'</td><td>'+response.province_id+'</td><td>'+response.latitude+' , '+response.longtitude+'</td><td><a href="javascript:void(0)" onclick="deletelocationdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
                $('#addlocation').modal('toggle');
                $('#form-addlocation')[0].reset();
            }
        });

    });


    
    function deletelocationdetail(id){
        var token = $('input[name=_token]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-sliplocation-list/'+id,
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



<script type='text/javascript'>
    $('#addinterestinsured-btn').click(function(e){
       e.preventDefault();

       var interest = $('#slipinterestlist').val();
       var amount = $('#slipamount').val();
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajax({
           url:"{{ route('interestlist.store') }}",
           type:"POST",
           data:{
               interest_insured:interest,
               slipamount:amount,
               id_slip:slip_id,
               _token:token2
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
            
               console.log(response)
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.description+'">'+response.description+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
               $('#slipamount').val('');
               $('#slipinterestlist').val('');
               var total =  parseFloat($("#sliptotalsum").val());
               var sum = isNaN(total + parseFloat(response.amount)) ? (0 + parseFloat(response.amount)) : (total + parseFloat(response.amount)) ;
               $("#sliptotalsum").val(sum);

               

            //    if($('#sliptotalsum').val(''))
            //         $("#sliptotalsum").val(parseFloat(response.amount));
            //    else
            //    {
            //     var total=isNaN(parseInt($("#sliptotalsum").val() + $("#slipamount").val())) ? 0 :($("#sliptotalsum").val() + $("#slipamount").val());
            //      $("#sliptotalsum").val(total);
                
            //    }
           }
       });

   });
</script>
    
<script  type='text/javascript'>
    
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
        $('#flshare').val(shareslip);
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
        var ourshare =  parseFloat($('#flshare').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * tsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonr').val(sum);
        $('#flsharefrom').val(sumourshare);
     });

     $('#slipcommission').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = parseFloat($("#slipgrossprmtonr").val());
        var sum = isNaN(commision * sumgrossprmtonr/100) ? 0 :(commision * sumgrossprmtonr/100);
        var sumnetprmtonr = isNaN( sumgrossprmtonr * (100/100 - commision)) ? 0 :(sumgrossprmtonr * (100/100 - commision));
        $('#slipsumcommission').val(sum);
        $('#slipnetprmtonr').val(sumnetprmtonr);
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

    $('#slipippercentage').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumnetprtonr = parseFloat($("#slipnetprmtonr").val());
        var sum = isNaN(percent * sumnetprtonr) ? 0 :(percent * sumnetprtonr);
        $('#slipipamount').val(sum);
    });
</script>

<script type="text/javascript">
    $(document).ready(function() { 
        
        if(($('#sliprate').val() != 0) && ($('#slipshare').val() != 0) )
        {
            
        }
        

     });
   
    
</script>

<script type='text/javascript'>
    
     $('#slipippercentage').keyup(function () {
        var persentage =  parseFloat($('#slipippercentage').val());
        var premiumnr =  parseFloat($('#slipnetprmtonr').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(premiumnr * persentage/100) ? 0 :(premiumnr * persentage/100) ;
        //alert(sum);
        $('#slipipamount').val(sum);
     });

     $('#slipippercentage').change(function () {
        var persentage =  parseFloat($('#slipippercentage').val());
        var premiumnr =  parseFloat($('#slipnetprmtonr').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(premiumnr * persentage/100) ? 0 :(premiumnr * persentage/100) ;
        //alert(sum);
        $('#slipipamount').val(sum);
     });

</script>

<script type='text/javascript'>
    
     $('#slipdppercentage').keyup(function () {
        var persentage =  parseFloat($('#slipdppercentage').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipdpamount').val(sum);
     });

     $('#slipdppercentage').change(function () {
        var persentage =  parseFloat($('#slipdppercentage').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipdpamount').val(sum);
     });

</script>


<script type='text/javascript'>
    
     $('#slipnilaiec').keyup(function () {
        var persentage =  parseFloat($('#slipnilaiec').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipamountec').val(sum);
     });

     $('#slipnilaiec').change(function () {
        var persentage =  parseFloat($('#slipnilaiec').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipamountec').val(sum);
     });

</script>


<script type='text/javascript'>
    $('#addinstallmentinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var installmentdate = $('#dateinstallmentdata').val();
       
       var percentage = $('#slipippercentage').val();
       var amount = $('#slipipamount').val();
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('installment.store') }}",
           type:"POST",
           data:{
               installmentdate:installmentdate,
               percentage:percentage,
               slipamount:amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               $('#installmentPanel tbody').prepend('<tr id="iidinstallment'+response.id+'" data-name="installmentvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentdetail('+response.id+')">delete</a></td></tr>')
               $('#dateinstallment').val('');
               $('#slipippercentage').val('');
               $('#slipipamount').val('');
               
               //var total =  parseFloat($("#sliptotalsum").val());
               //var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
               //$("#sliptotalsum").val(sum);

           }
       });

   });
</script>

<script type='text/javascript'>
    function deleteinstallmentdetail(id)
    {
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
                
                $('#iidinstallment'+id).remove();
                console.log(response);
            }
        });
    }
</script>



<script type='text/javascript'>
    $('#adddeductibleinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slipdptype = $('#slipdptype').val();
       var slipdpcurrency = $('#slipdpcurrency').val();
       
       var percentage = $('#slipdppercentage').val();
       var amount = $('#slipdpamount').val();
       var minamount = $('#slipdpminamount').val();
       
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('deductible.store') }}",
           type:"POST",
           data:{
               slipdptype:slipdptype,
               slipdpcurrency:slipdpcurrency,
               percentage:percentage,
               amount:amount,
               minamount:minamount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               $('#deductiblePanel tbody').prepend('<tr id="iiddeductible'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype+'">'+response.deductibletype+'</td><td data-name="'+response.currencydata+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibledetail('+response.id+')">delete</a></td></tr>');
               $('#slipdppercentage').val('');
               $('#slipdpamount').val('');
               $('#slipdpminamount').val('');
               
           }
       });

   });
</script>

<script type='text/javascript'>
    function deletedeductibledetail(id)
    {
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
                
                $('#iiddeductible'+id).remove();
                console.log(response);
            }
        });
    }
</script>



<script type='text/javascript'>
    $('#addextendcoverageinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slipcncode = $('#slipcncode').val();
       var percentage = $('#slipnilaiec').val();
       var amount = $('#slipamountec').val();
       
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('extendcoverage.store') }}",
           type:"POST",
           data:{
               slipcncode:slipcncode,
               percentage:percentage,
               amount:amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               $('#ExtendCoveragePanel tbody').prepend('<tr id="iidextendcoverage'+response.id+'" data-name="extendcoveragevalue[]"><td data-name="'+response.coveragetype+'">'+response.coveragetype+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteextendcoveragedetail('+response.id+')">delete</a></td></tr>');
               $('#slipnilaiec').val('');
               $('#slipamountec').val('');
               
           }
       });

   });
</script>

<script type='text/javascript'>
    function deleteextendcoveragedetail(id)
    {
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-extendcoverage-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                
                $('#iidextendcoverage'+id).remove();
                console.log(response);
            }
        });
    }
</script>



<script type='text/javascript'>
    $('#addretrocessioninsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var type = $('#sliprptype').val();
       var contract = $('#sliprpcontract').val();
       var percentage = $('#sliprppercentage').val();
       var amount = $('#sliprpamount').val();
       
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('retrocession.store') }}",
           type:"POST",
           data:{
               type:type,
               contract:contract,
               percentage:percentage,
               amount:amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               $('#retrocessionPanel tbody').prepend('<tr id="iidretrocession'+response.id+'" data-name="retrocessionvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteretrocessiondetail('+response.id+')">delete</a></td></tr>');
               $('#sliprppercentage').val('');
               $('#sliprpamount').val('');
               
           }
       });

   });
</script>

<script type='text/javascript'>
    function deleteretrocessiondetail(id)
    {
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
                
                $('#iidretrocession'+id).remove();
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


<script type='text/javascript'>
    $('#addinsuredsave-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var flnumber = $('#insuredIDtxt').val();
       var flinsured = $('#flinsured').val();
       var flsuggestinsured = $('#autocomplete').val();
       var flsuffix = $('#autocomplete2').val();
       var flshare = $('#flshare').val();
       var flsharefrom  = $('#flsharefrom').val();
       var flshareto = $('#flshareto').val();
       var flcoinsurance = $('#flcoinsurance').val();
       var flobligee = $('#flobligee').val();
       var flprincipal = $('#flprincipal').val();
       
       
       var token2 = $('input[name=_token]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/fl-insured/store') }}",
           type:"POST",
           data:{
               flnumber:flnumber,
               flinsured:flinsured,
               flsuggestinsured:flsuggestinsured,
               flsuffix:flsuffix,
               flshare:flshare,
               flsharefrom:flsharefrom,
               flshareto:flshareto,
               flcoinsurance:flcoinsurance,
               flobligee:flobligee,
               flprincipal:flprincipal
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Financial Line Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", request.responseText, "Insert Error");
           }
       });

   });
</script>


<script type='text/javascript'>
    $('#multi-file-upload-ajax').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ms = $('#insuredIDtxt').val();
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
       var slipcommission =  $('#slipcommission').val();
       var slipsumcommission =  $('#slipsumcommission').val();
       var slipnetprmtonr =  $('#slipnetprmtonr').val();
       var sliprb =  $('#sliprb').val();
       var slipor =  $('#slipor').val();
       var slipsumor =  $('#slipsumor').val();

       var token2 = $('input[name=_token]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/fl-slip/store')}}",
           type:"POST",
           data:{
               code_ms:code_ms,
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
               slipcommission:slipcommission,
               slipnetprmtonr:slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipsumor:slipsumor
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Financial Line Slip Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Financial Line Slip Insert Error", "Insert Error");
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


       //insured SAVE
       var flnumber = $('#insuredIDtxt').val();
       var flinsured = $('#flinsured').val();
       var flsuggestinsured = $('#autocomplete').val();
       var flsuffix = $('#autocomplete2').val();
       var flshare = $('#flshare').val();
       var flsharefrom  = $('#flsharefrom').val();
       var flshareto = $('#flshareto').val();
       var flcoinsurance = $('#flcoinsurance').val();
       var flobligee = $('#flobligee').val();
       var flprincipal = $('#flprincipal').val();
       
       
       var token2 = $('input[name=_token]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/fl-insured/store') }}",
           type:"POST",
           data:{
               flnumber:flnumber,
               flinsured:flinsured,
               flsuggestinsured:flsuggestinsured,
               flsuffix:flsuffix,
               flshare:flshare,
               flsharefrom:flsharefrom,
               flshareto:flshareto,
               flcoinsurance:flcoinsurance,
               flobligee:flobligee,
               flprincipal:flprincipal
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Financial Line Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", request.responseText, "Insert Error");
           }
       });

   });
</script>