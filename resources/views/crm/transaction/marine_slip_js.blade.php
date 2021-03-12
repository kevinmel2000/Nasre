<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>


<script type="text/javascript">

    function treatAsUTC(date) {
        var result = new Date(date);
        result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
        return result;
    }

    function daysBetween(startDate, endDate) {
        var millisecondsPerDay = 24 * 60 * 60 * 1000;
        return (treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay;
    }

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

<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>

<style>
    .hide {
        display: none;
    }
</style>

<script type="text/javascript">
    // $('#slipamount').keyup(function(){
    //     var currenc = $(this).val();
    //     console.log(currenc)
    //     currenc.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // });

    $('input.amount').keyup(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;
                console.log(event.which)
                console.log($(this).val())
                // format number
                $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
    });
</script>

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
    $('#switch-proportionalupdate').change(function(){
        var attr = $("#btnaddlayerupdate").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#btnaddlayer").removeAttr('hidden');
            $("#sliplayerproportionalupdate").removeAttr('hidden');
            $("#labelnonpropupdate").removeAttr('hidden');
            $("#labelnpupdate").removeAttr('hidden');
            
        }
        else{
            $("#btnaddlayerupdate").attr('hidden','true');
            $("#sliplayerproportionalupdate").attr('hidden','true');
            $("#labelnonpropupdate").attr('hidden','true');
            $("#labelnpupdate").attr('hidden','true');

        }
        
    });

    $('#sliprbupdate').change(function(){
        var attr = $("#retrocessionPanelupdate").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#retrocessionPanelupdate").removeAttr('hidden');
            $("#tabretroupdate").removeAttr('hidden');
        }
        else{
            $("#retrocessionPanelupdate").attr('hidden','true');
            $("#tabretroupdate").attr('hidden','true');
        }
    });

    $('#slipipfromupdate').on('dp.change', function(e){ console.log(e.date); })
</script>

<script type="text/javascript">
    $('#switch-proportionalendorsement').change(function(){
        var attr = $("#btnaddlayerendorsement").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#btnaddlayerendorsement").removeAttr('hidden');
            $("#sliplayerproportionalendorsement").removeAttr('hidden');
            $("#labelnonpropendorsement").removeAttr('hidden');
            $("#labelnpendorsement").removeAttr('hidden');
            
        }
        else{
            $("#btnaddlayerendorsement").attr('hidden','true');
            $("#sliplayerproportionalendorsement").attr('hidden','true');
            $("#labelnonpropendorsement").attr('hidden','true');
            $("#labelnpendorsement").attr('hidden','true');

        }
        
    });

    $('#sliprbendorsement').change(function(){
        var attr = $("#retrocessionPanelendorsement").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#retrocessionPanelendorsement").removeAttr('hidden');
            $("#tabretroendorsement").removeAttr('hidden');
        }
        else{
            $("#retrocessionPanelendorsement").attr('hidden','true');
            $("#tabretroendorsement").attr('hidden','true');
        }
    });

    $('#slipipfromendorsement').on('dp.change', function(e){ console.log(e.date); })
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

    $('#slipipfromupdate').change(function(){
        $('#sliprpfromupdate').val($(this).val());
    });

    $('#slipiptoupdate').change(function(){
        $('#sliprptoupdate').val($(this).val());
    });

    $('#slipipfromendorsement').change(function(){
        $('#sliprpfromendorsement').val($(this).val());
    });

    $('#slipiptoendorsement').change(function(){
        $('#sliprptoendorsement').val($(this).val());
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
    $('#msiroute').change(function(){
       var routeship = $(this).val();

        console.log(routeship);
       if(routeship){
           $.ajax({
               type:"GET",
               dataType: 'json',
               url:"{{url('get-route-list')}}?route_code="+routeship,
               success:function(response){        
                   if(response){
                       $("#msiroutefrom").val(response.route_from);
                       $("#msirouteto").val(response.route_to);
                   }else{
                       $("#msiroutefrom").empty();
                       $("#msirouteto").empty();
                   }
               }
           });
       }else{
           $("#msiroutefrom").empty();
           $("#msirouteto").empty();
       }
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
        var pct =  parseFloat($(this).val())/100;
        
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));

        var sum = isNaN(pct * parseFloat(conv_tsi)) ? 0 :(pct * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
         $('#sliptotalsumpct').val(real_sum);
         
     });

     $('#slipdppercentage').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN(percent * parseFloat(conv_tsi)) ? 0 :(percent * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('#slipdpamount').val(real_sum);
     });

     $('#slipshare').keyup(function () {
        var shareslip =  parseFloat($(this).val())/100;
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN(shareslip * parseFloat(conv_tsi)) ? 0 :(shareslip * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('#slipsumshare').val(real_sum);
        // $('#msishare').val(shareslip);
        $('#msisharev').val(shareslip);
     });

     $('#sliprate').keyup(function () {
        var insurance_period_from = $('#slipipfrom').val().split('-');
        var insurance_period_to = $('#slipipto').val().split('-');
        var insurance_period_from2 = $('#slipipfrom').val();
        var insurance_period_to2 = $('#slipipto').val();
        var month_from = parseInt(insurance_period_from[1]);
        var month_to = parseInt(insurance_period_to[1]);
        var month = (month_to - month_from);
        var days=daysBetween(insurance_period_from2, insurance_period_to2);
        var insurance = (days/365);
       
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(days)
        console.log(month_from)
        console.log(month_to)
        console.log(month)
        console.log(insurance)
        
        var rateslip =  parseFloat($(this).val()) / 1000;
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN((rateslip * parseFloat(conv_tsi)) * insurance) ? 0 :((rateslip * parseFloat(conv_tsi)) * insurance) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        $('#slipbasicpremium').val(real_sum);
     });

     $('#slipshare').change(function () {
        var rateslip =  parseFloat($('#sliprate').val()) / 1000 ;
        var shareslip =  parseFloat($('#slipshare').val()) / 100 ;
        var ourshare =  parseFloat($('#msisharev').val()) / 100 ;
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var mtsi = $("#msitsi").val();
        var conv_mtsi = parseInt(mtsi.replace(/,/g, ""));
        var sumshare = $('#slipsumshare').val() ;
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));
        var orpercent = parseFloat($('#slipor').val()) / 100;
        var sumor = isNaN(orpercent * parseFloat(conv_sumshare)) ? 0 :(orpercent * parseFloat(conv_sumshare));
        var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var sum = isNaN(rateslip * shareslip * parseFloat(conv_tsi)) ? 0 :(rateslip * shareslip * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;
        var real_sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;

        $('#slipgrossprmtonr').val(real_sum);
        $('#msisharefrom').val(real_sumourshare);
        $('#msisumsharev').val(sumourshare);
        
        $('#slipsumor').val(real_sumor);
     });

     $('#slipcommission').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = $("#slipgrossprmtonr").val();
        var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));
        
        var sum = isNaN(commision * parseFloat(conv_sumgrossprmtonr)) ? 0 :(commision * parseFloat(conv_sumgrossprmtonr));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        var sumnetprmtonr = isNaN( parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)) ? 0 :(parseFloat(conv_sumgrossprmtonr) * (100/100 - commision));
        var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        $('#slipsumcommission').val(real_sum);
        $('#slipnetprmtonr').val(real_sumnetprmtonr);
    });

    $('#slipippercentage').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        
        var sumnetprtonr = $("#slipnetprmtonr").val();
        var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

        var sum = isNaN(percent *  parseFloat(conv_sumnetprtonr)) ? 0 :(percent *  parseFloat(conv_sumnetprtonr));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipipamount').val(real_sum);
    });

    $('#slipor').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = $("#slipsumshare").val();
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

        var sum = isNaN(percent * parseFloat(conv_sumshare)) ? 0 :(percent * parseFloat(conv_sumshare));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipsumor').val(real_sum);
    });

    $('#sliprppercentage').keyup(function () {
        var percentval =  parseFloat($(this).val()) / 100;
        var sumor = $('#slipsumor').val() ;
        var conv_sumor = parseInt(sumor.replace(/,/g, ""));
        var sumrpamount = isNaN(percentval * parseFloat(conv_sumor)) ? 0 :(percentval * parseFloat(conv_sumor));
        var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
        // $('#slipor').val(sumpercentor);
        $('#sliprpamount').val(real_sumrpamount);
    });

    $('#sliprppercentage').change(function () {
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#slipor').val());
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#slipor').val(sumpercentor);
    });
</script>

<script  type='text/javascript'>
    $('#slippctupdate').keyup(function () {
        var pct =  parseFloat($(this).val())/100;
        
        var tsi = $("#sliptotalsumupdate").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));

        var sum = isNaN(pct * parseFloat(conv_tsi)) ? 0 :(pct * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
         $('#sliptotalsumpctupdate').val(real_sum);
         
     });

     $('#slipdppercentageupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var tsi = $("#sliptotalsumupdate").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN(percent * parseFloat(conv_tsi)) ? 0 :(percent * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('#slipdpamountupdate').val(real_sum);
     });

     $('#slipshareupdate').keyup(function () {
        var shareslip =  parseFloat($(this).val())/100;
        var tsi = $("#sliptotalsumupdate").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN(shareslip * parseFloat(conv_tsi)) ? 0 :(shareslip * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('#slipsumshareupdate').val(real_sum);
        // $('#msishare').val(shareslip);
        $('#msisharevupdate').val(shareslip);
     });

     $('#sliprateupdate').keyup(function () {
        var insurance_period_from = $('#slipipfromupdate').val().split('-');
        var insurance_period_to = $('#slipiptoupdate').val().split('-');
        var insurance_period_from2 = $('#slipipfromupdate').val();
        var insurance_period_to2 = $('#slipiptoupdate').val();
        var month_from = parseInt(insurance_period_from[1]);
        var month_to = parseInt(insurance_period_to[1]);
        var month = (month_to - month_from);
        var days=daysBetween(insurance_period_from2, insurance_period_to2);
        var insurance = (days/365);
       
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(days)
        console.log(month_from)
        console.log(month_to)
        console.log(month)
        console.log(insurance)
        
        var rateslip =  parseFloat($(this).val()) / 1000;
        var tsi = $("#sliptotalsumupdate").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN((rateslip * parseFloat(conv_tsi)) * insurance) ? 0 :((rateslip * parseFloat(conv_tsi)) * insurance) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        $('#slipbasicpremiumupdate').val(real_sum);
     });

     $('#slipshareupdate').change(function () {
        var rateslip =  parseFloat($('#sliprateupdate').val()) / 1000 ;
        var shareslip =  parseFloat($('#slipshareupdate').val()) / 100 ;
        var ourshare =  parseFloat($('#msisharevupdate').val()) / 100 ;
        var tsi = $("#sliptotalsumupdate").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var mtsi = $("#msitsiupdate").val();
        var conv_mtsi = parseInt(mtsi.replace(/,/g, ""));
        var sumshare = $('#slipsumshareupdate').val() ;
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));
        var orpercent = parseFloat($('#sliporupdate').val()) / 100;
        var sumor = isNaN(orpercent * parseFloat(conv_sumshare)) ? 0 :(orpercent * parseFloat(conv_sumshare));
        var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var sum = isNaN(rateslip * shareslip * parseFloat(conv_tsi)) ? 0 :(rateslip * shareslip * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;
        var real_sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;

        $('#slipgrossprmtonrupdate').val(real_sum);
        $('#msisharefromupdate').val(real_sumourshare);
        $('#msisumsharevupdate').val(sumourshare);
        
        $('#slipsumorupdate').val(real_sumor);
     });

     $('#slipcommissionupdate').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = $("#slipgrossprmtonrupdate").val();
        var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));
        
        var sum = isNaN(commision * parseFloat(conv_sumgrossprmtonr)) ? 0 :(commision * parseFloat(conv_sumgrossprmtonr));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        var sumnetprmtonr = isNaN( parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)) ? 0 :(parseFloat(conv_sumgrossprmtonr) * (100/100 - commision));
        var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        $('#slipsumcommissionupdate').val(real_sum);
        $('#slipnetprmtonrupdate').val(real_sumnetprmtonr);
    });

    $('#slipippercentageupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        
        var sumnetprtonr = $("#slipnetprmtonrupdate").val();
        var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

        var sum = isNaN(percent *  parseFloat(conv_sumnetprtonr)) ? 0 :(percent *  parseFloat(conv_sumnetprtonr));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipipamountupdate').val(real_sum);
    });

    $('#sliporupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = $("#slipsumshareupdate").val();
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

        var sum = isNaN(percent * parseFloat(conv_sumshare)) ? 0 :(percent * parseFloat(conv_sumshare));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipsumorupdate').val(real_sum);
    });

    $('#sliprppercentageupdate').keyup(function () {
        var percentval =  parseFloat($(this).val()) / 100;
        var sumor = $('#slipsumorupdate').val() ;
        var conv_sumor = parseInt(sumor.replace(/,/g, ""));
        var sumrpamount = isNaN(percentval * parseFloat(conv_sumor)) ? 0 :(percentval * parseFloat(conv_sumor));
        var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
        // $('#slipor').val(sumpercentor);
        $('#sliprpamountupdate').val(real_sumrpamount);
    });

    $('#sliprppercentageupdate').change(function () {
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#sliporupdate').val());
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#sliporupdate').val(sumpercentor);
    });
</script>

<script  type='text/javascript'>
   $('#slippctendorsement').keyup(function () {
        var pct =  parseFloat($(this).val())/100;
        
        var tsi = $("#sliptotalsumendorsement").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));

        var sum = isNaN(pct * parseFloat(conv_tsi)) ? 0 :(pct * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
         $('#sliptotalsumpctendorsement').val(real_sum);
         
     });

     $('#slipdppercentageendorsement').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var tsi = $("#sliptotalsumendorsement").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN(percent * parseFloat(conv_tsi)) ? 0 :(percent * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('#slipdpamountendorsement').val(real_sum);
     });

     $('#slipshareendorsement').keyup(function () {
        var shareslip =  parseFloat($(this).val())/100;
        var tsi = $("#sliptotalsumendorsement").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN(shareslip * parseFloat(conv_tsi)) ? 0 :(shareslip * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('#slipsumshareendorsement').val(real_sum);
        // $('#msishare').val(shareslip);
        $('#msisharevendorsement').val(shareslip);
     });

     $('#sliprateendorsement').keyup(function () {
        var insurance_period_from = $('#slipipfromendorsement').val().split('-');
        var insurance_period_to = $('#slipiptoendorsement').val().split('-');
        var insurance_period_from2 = $('#slipipfromendorsement').val();
        var insurance_period_to2 = $('#slipiptoendorsement').val();
        var month_from = parseInt(insurance_period_from[1]);
        var month_to = parseInt(insurance_period_to[1]);
        var month = (month_to - month_from);
        var days=daysBetween(insurance_period_from2, insurance_period_to2);
        var insurance = (days/365);
       
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(days)
        console.log(month_from)
        console.log(month_to)
        console.log(month)
        console.log(insurance)
        
        var rateslip =  parseFloat($(this).val()) / 1000;
        var tsi = $("#sliptotalsumendorsement").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN((rateslip * parseFloat(conv_tsi)) * insurance) ? 0 :((rateslip * parseFloat(conv_tsi)) * insurance) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        $('#slipbasicpremiumendorsement').val(real_sum);
     });

     $('#slipshareendorsement').change(function () {
        var rateslip =  parseFloat($('#sliprateendorsement').val()) / 1000 ;
        var shareslip =  parseFloat($('#slipshareendorsement').val()) / 100 ;
        var ourshare =  parseFloat($('#msisharevendorsement').val()) / 100 ;
        var tsi = $("#sliptotalsumendorsement").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var mtsi = $("#msitsiendorsement").val();
        var conv_mtsi = parseInt(mtsi.replace(/,/g, ""));
        var sumshare = $('#slipsumshareendorsement').val() ;
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));
        var orpercent = parseFloat($('#sliporendorsement').val()) / 100;
        var sumor = isNaN(orpercent * parseFloat(conv_sumshare)) ? 0 :(orpercent * parseFloat(conv_sumshare));
        var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var sum = isNaN(rateslip * shareslip * parseFloat(conv_tsi)) ? 0 :(rateslip * shareslip * parseFloat(conv_tsi)) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;
        var real_sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;

        $('#slipgrossprmtonrendorsement').val(real_sum);
        $('#msisharefromendorsement').val(real_sumourshare);
        $('#msisumsharevendorsement').val(sumourshare);
        
        $('#slipsumorendorsement').val(real_sumor);
     });

     $('#slipcommissionendorsement').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = $("#slipgrossprmtonrendorsement").val();
        var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));
        
        var sum = isNaN(commision * parseFloat(conv_sumgrossprmtonr)) ? 0 :(commision * parseFloat(conv_sumgrossprmtonr));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        var sumnetprmtonr = isNaN( parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)) ? 0 :(parseFloat(conv_sumgrossprmtonr) * (100/100 - commision));
        var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        $('#slipsumcommissionendorsement').val(real_sum);
        $('#slipnetprmtonrendorsement').val(real_sumnetprmtonr);
    });

    $('#slipippercentageendorsement').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        
        var sumnetprtonr = $("#slipnetprmtonrendorsement").val();
        var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

        var sum = isNaN(percent *  parseFloat(conv_sumnetprtonr)) ? 0 :(percent *  parseFloat(conv_sumnetprtonr));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipipamountendorsement').val(real_sum);
    });

    $('#sliporendorsement').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = $("#slipsumshareendorsement").val();
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

        var sum = isNaN(percent * parseFloat(conv_sumshare)) ? 0 :(percent * parseFloat(conv_sumshare));
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipsumorendorsement').val(real_sum);
    });

    $('#sliprppercentageendorsement').keyup(function () {
        var percentval =  parseFloat($(this).val()) / 100;
        var sumor = $('#slipsumorendorsement').val() ;
        var conv_sumor = parseInt(sumor.replace(/,/g, ""));
        var sumrpamount = isNaN(percentval * parseFloat(conv_sumor)) ? 0 :(percentval * parseFloat(conv_sumor));
        var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
        // $('#slipor').val(sumpercentor);
        $('#sliprpamountendorsement').val(real_sumrpamount);
    });

    $('#sliprppercentageendorsement').change(function () {
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#sliporendorsement').val());
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#sliporendorsement').val(sumpercentor);
    });
</script>

<script type='text/javascript'>
    $('#addinterestinsured-btn').click(function(e){
       e.preventDefault();

       var interest = $('#slipinterestlist').val();
       var amount = $('#slipamount').val();
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();

       var conv_amount = amount.replace(/,/g, "");
       console.log(conv_amount)
       var real_amount = parseInt(conv_amount);
       console.log(real_amount)
       
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
               slipamount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.interest_id+'">'+response.description+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
               var totalsum = $("#sliptotalsum").val();
               if(totalsum == '')
               {
                    var total_num = 0;
                    var sum = isNaN(total_num + parseFloat(response.amount)) ? 0 :(total_num + parseFloat(response.amount)) ;
                    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    console.log(' sum : ' + sum)
                    console.log(' real sum : ' + real_sum)
                    
                    $("#sliptotalsum").val(real_sum);
                    //    $("#msishareto").val(sum);
                    $("#msitsi").val(real_sum);
                    $("#msishareto").val(real_sum);
               }
               else
               {
                    var conv_total = totalsum.replace(/,/g, "");
                    console.log('conv total : ' + conv_total)
                    var real_total = parseInt(conv_total);
                    console.log('real total : ' + real_total)
                    var total =  parseFloat(real_total);
                    console.log(' total : ' + total)
                    var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
                    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    console.log(' sum : ' + sum)
                    console.log(' real sum : ' + real_sum)
                    
                    $("#sliptotalsum").val(real_sum);
                    //    $("#msishareto").val(sum);
                    $("#msitsi").val(real_sum);
               }
               
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

       var conv_amount = dpamount.replace(/,/g, "");
       console.log(conv_amount)
       var real_amount = parseInt(conv_amount);
       console.log(real_amount)

       var conv_minamount = dpminamount.replace(/,/g, "");
       console.log(conv_minamount)
       var real_minamount = parseInt(conv_minamount);
       console.log(real_minamount)
       
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
                minamount:real_minamount,
                amount:real_amount,
                percentage:dppercentage,
                id_slip:dpslip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
            
                console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               var curr_minclaimamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.min_claimamount);
                $('#deductiblePanel tbody').prepend('<tr id="ddtid'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype_id+'">'+ response.dtabbrev +' - '+ response.dtdescript+'</td><td data-name="'+response.currency_id+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td data-name="'+response.min_claimamount+'">'+curr_minclaimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibletype('+response.id+')">delete</a></td></tr>')
                
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

       var conv_amount = ipamount.replace(/,/g, "");
       console.log(conv_amount)
       var real_amount = parseInt(conv_amount);
       console.log(real_amount)
       
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
                slipamount:real_amount,
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

       var conv_amount = rpamount.replace(/,/g, "");
       console.log(conv_amount)
       var real_amount = parseInt(conv_amount);
       console.log(real_amount)
       
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
                amount:real_amount,
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
                
                var total =  $("#sliptotalsum").val();
                console.log(total)
                var conv_total = total.replace(/,/g, "");
                console.log(conv_total)
                var real_total = parseInt(conv_total);
                console.log(real_total)
                var sum = isNaN(parseFloat(real_total) - parseFloat(response.amount)) ? 0 :(parseFloat(real_total) - parseFloat(response.amount)) ;
                console.log(sum)
                var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $("#sliptotalsum").val(real_sum);
                $("#msishareto").val(real_sum);
                $("#msitsi").val(real_sum);
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
       var slipcommission   =   $('#slipcommission').val();
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
       var slipvbroker = $('#slipvbroker').val();
       
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
               code_ms:code_ins,
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
               slipcommission:slipcommission,
               slipsumcommission:slipsumcommission,
               slipnetprmtonr:slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipsumor:slipsumor,
               tsims:msitsi,
               sharems:msisharev,
               sumsharems:msisumsharev,
               slipcoinsurance:slipcoinsurance,
               slipvbroker:slipvbroker,
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
                     //swal("Error!", data.responseJSON.errors.files[0], "Insert Error");
                     //console.log(data.responseJSON.errors);
                    }
        });

   });
</script>

<script type="text/javascript">

    function detailslip(id)
        {
            if(id){
                alert(id);
                swal("Please wait!", "Loading Data")
                    $.ajax({
                        type:"GET",
                        dataType: 'json',
                        url:'{{ url("/") }}/transaction-data/getmodal-marine-slip/'+id,
                        beforeSend: function() { $("body").addClass("loading");  },
                        complete: function() {  $("body").removeClass("loading"); },
                        success:function(response){  
                            console.log(response)      
                            if(response){
                                
                                var status_log = response.status_log;
                                for (var i = 0; i < status_log.length; i++){
                                    var status = status_log[i].status;
                                    var datetime = status_log[i].datetime;
                                    var user = status_log[i].user;
                                    $('#slipStatusTabledetail tbody').prepend('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                                };
                                var interest_insured = response.interestinsured;
                                for (var i = 0; i < interest_insured.length; i++){
                                    var interest = interest_insured[i].description;
                                    var code = interest_insured[i].code;
                                    var amount = interest_insured[i].amount;
                                    $('#interestInsuredTabledetail tbody').prepend('<tr id="itsid'+interest_insured[i].id+'"><td >'+code+' - '+interest+'</td><td >currency('+amount+')</td></tr>')
                                };
                                var attachment = response.attachment;
                                for (var i = 0; i < attachment.length; i++){
                                    var filename = attachment[i].filename;
                                    $('#aidlistdetail').append('<li><div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+filename+'">'+filename+'</a></div></li>')
                                };
                                var deductible = response.deductible;
                                for (var i = 0; i < deductible.length; i++){
                                    var currency_code = deductible[i].code;
                                    var currency = deductible[i].symbol_name;
                                    var abbreviation = deductible[i].abbreviation;
                                    var description = deductible[i].description;
                                    var percentage = deductible[i].percentage;
                                    var amount = deductible[i].amount;
                                    var min_claimamount = deductible[i].min_claimamount;
                                    $('#deductiblePaneldetail tbody').prepend('<tr id="dbtid'+deductible[i].id+'"><td >'+abbreviation+' - '+description+'</td><td >'+currency_code+'-'+currency+'</td><td>'+percentage+'</td><td>currency('+amount+')</td><td>currency('+min_claimamount+')</td></tr>')
                                };
                                var condition_needed = response.condition_needed;
                                for (var i = 0; i < condition_needed.length; i++){
                                    var description = condition_needed[i].description;
                                    var code = condition_needed[i].code;
                                    var name = condition_needed[i].name;
                                    var information = condition_needed[i].information;
                                    $('#conditionNeededdetail tbody').prepend('<tr id="cntid'+condition_needed[i].id+'" ><td >'+code+' - '+name+' - '+description+'</td><td >'+information+'</td></tr>')
                                };
                                var installment_panel = response.installment_panel;
                                for (var i = 0; i < installment_panel.length; i++){
                                    var date = installment_panel[i].installment_date;
                                    var percentage = installment_panel[i].percentage;
                                    var amount = installment_panel[i].amount;
                                    $('#installmentPaneldetail tbody').prepend('<tr id="isptid'+installment_panel[i].id+'" ><td >'+date+'</td><td >'+percentage+'</td><td >currency('+amount+')</td></tr>')
                                };
                                var retrocession = response.retrocession;
                                for (var i = 0; i < retrocession.length; i++){
                                    var type = retrocession[i].type;
                                    var contract = retrocession[i].contract;
                                    var percentage = retrocession[i].percentage;
                                    var amount = retrocession[i].amount;
                                    $('#retrocessionPaneldetail tbody').prepend('<tr id="rcstid'+retrocession[i].id+'" ><td >'+type+'</td><td >'+contract+'</td><td >'+percentage+'</td><td >currency('+amount+')</td></tr>')
                                };

                                $("#slipnumberdetail").val(response.slip_number);
                                $("#slipusernamedetail").val(response.username);
                                $("#slipprodyeardetail").val(response.prod_year);
                                $("#slipuydetail").val(response.uy);
                                $("#slipstatusdetail").append('<option value="'+response.status+'" selected>'+response.status+'</option>');
                                $('#slipcedingbrokerdetail').append(' <option value="'+response.cedbrok_id+'" selected>'+response.cedbrok_cn+' - '+response.cedbrok_code+' - '+response.cedbrok+'</option>');
                                $('#slipcedingdetail').append(' <option value="'+response.ceding_id+'" selected>'+response.ceding_cn+' - '+response.ceding_code+' - '+response.ceding+'</option>');
                                $('#slipcurrencydetail').append('<option value="'+response.currency_id+'"selected>'+response.currency_code+' - '+response.currency+'</option>');
                                $('#slipcobdetail').append('<option value="'+response.cob_id+'"selected>'+response.cob+'</option>');
                                $('#slipkocdetail').append('<option value="'+response.koc_id+'"selected>'+response.koc+'</option>');
                                $('#slipoccupacydetail').append('<option value="'+response.occupacy_id+'"selected>'+response.occupacy+'</option>');
                                $('#slipbld_constdetail').append('<option value="'+response.build_const+'"selected>'+response.build_const+'</option>');
                                $('#sliptypedetail').append('<option value="'+response.insured_type+'"selected>'+response.insured_type+'</option>');
                                $('#sliplayerproportionaldetail').append('<option value="'+response.layer_non_proportional+'"selected>'+response.layer_non_proportional+'</option>');
                                $('#sliprbdetail').append('<option value="'+response.retro_backup+'"selected>'+response.retro_backup+'</option>');
                                if(response.retro_backup == 'NO'){
                                    $("#tabretrodetail").attr('hidden','true');
                                }

                                $('#slipnodetail').val(response.slip_no);
                                $('#slipcndndetail').val(response.cn_dn);
                                $('#slippolicy_nodetail').val(response.policy_no);
                                $('#slipcoinsurancedetail').val(response.coinsurance_slip);
                                $('#sliptotalsumdetail').val(response.total_sum_insured);
                                $('#slippctdetail').val(response.insured_Pct);
                                $('#sliptotalsumpctdetail').val(response.total_sum_pct);
                                $('#slipipfromdetail').val(response.insurance_period_from);
                                $('#slipiptodetail').val(response.insurance_period_to);
                                $('#sliprpfromdetail').val(response.reinsurance_period_from);
                                $('#sliprptodetail').val(response.reinsurance_period_to);
                                $('#switch-proportionaldetail').val(response.proportional);
                                if(response.proportional == null){
                                    $("#btnaddlayerdetail").attr('hidden','true');
                                    $("#sliplayerproportionaldetail").attr('hidden','true');
                                    $("#labelnonpropdetail").attr('hidden','true');
                                    $("#labelnpdetail").attr('hidden','true');
                                }
                                $('#slipratedetail').val(response.rate);
                                $('#slipsharedetail').val(response.share);
                                $('#slipsumsharedetail').val(response.sum_share);
                                $('#slipbasicpremiumdetail').val(response.basic_premium);
                                $('#slipgrossprmtonrdetail').val(response.grossprm_to_nr);
                                $('#slipcommissiondetail').val(response.commission);
                                $('#slipsumcommissiondetail').val(response.sum_commission);
                                $('#slipnetprmtonrdetail').val(response.netprm_to_nr);
                                $('#slipordetail').val(response.own_retention);
                                $('#slipsumordetail').val(response.sum_own_retention);
                                swal("Good job!", "Data Show", "success")
                            }else{
                                swal("Ohh no!", "Data failed to get", "failed")
                            }
                        }
                    });
                }else{
                    swal("Ohh no!", "Current object failed to get", "failed")
                }
        }

        function editslip(id)
        {
            if(id){
                alert(id);
                swal("Please wait!", "Loading Data")
                    $.ajax({
                        type:"GET",
                        dataType: 'json',
                        url:'{{ url("/") }}/transaction-data/getmodal-marine-slip/'+id,
                        beforeSend: function() { $("body").addClass("loading");  },
                        complete: function() {  $("body").removeClass("loading"); },
                        success:function(response){  
                            console.log(response)      
                            if(response){
                                
                                var status_log = response.status_log;
                                for (var i = 0; i < status_log.length; i++){
                                    var status = status_log[i].status;
                                    var datetime = status_log[i].datetime;
                                    var user = status_log[i].user;
                                    $('#slipStatusTableupdate tbody').prepend('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                                };
                                var interest_insured = response.interestinsured;
                                for (var i = 0; i < interest_insured.length; i++){
                                    var interest = interest_insured[i].description;
                                    var code = interest_insured[i].code;
                                    var amount = interest_insured[i].amount;
                                    $('#interestInsuredTableupdate tbody').prepend('<tr id="itsid'+interest_insured[i].id+'"><td >'+code+' - '+interest+'</td><td >currency('+amount+')</td></tr>')
                                };
                                var attachment = response.attachment;
                                for (var i = 0; i < attachment.length; i++){
                                    var filename = attachment[i].filename;
                                    $('#aidlistupdate').append('<li><div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+filename+'">'+filename+'</a></div></li>')
                                };
                                var deductible = response.deductible;
                                for (var i = 0; i < deductible.length; i++){
                                    var currency_code = deductible[i].code;
                                    var currency = deductible[i].symbol_name;
                                    var abbreviation = deductible[i].abbreviation;
                                    var description = deductible[i].description;
                                    var percentage = deductible[i].percentage;
                                    var amount = deductible[i].amount;
                                    var min_claimamount = deductible[i].min_claimamount;
                                    $('#deductiblePanelupdate tbody').prepend('<tr id="dbtid'+deductible[i].id+'"><td >'+abbreviation+' - '+description+'</td><td >'+currency_code+'-'+currency+'</td><td>'+percentage+'</td><td>currency('+amount+')</td><td>currency('+min_claimamount+')</td></tr>')
                                };
                                var condition_needed = response.condition_needed;
                                for (var i = 0; i < condition_needed.length; i++){
                                    var description = condition_needed[i].description;
                                    var code = condition_needed[i].code;
                                    var name = condition_needed[i].name;
                                    var information = condition_needed[i].information;
                                    $('#conditionNeededupdate tbody').prepend('<tr id="cntid'+condition_needed[i].id+'" ><td >'+code+' - '+name+' - '+description+'</td><td >'+information+'</td></tr>')
                                };
                                var installment_panel = response.installment_panel;
                                for (var i = 0; i < installment_panel.length; i++){
                                    var date = installment_panel[i].installment_date;
                                    var percentage = installment_panel[i].percentage;
                                    var amount = installment_panel[i].amount;
                                    $('#installmentPanelupdate tbody').prepend('<tr id="isptid'+installment_panel[i].id+'" ><td >'+date+'</td><td >'+percentage+'</td><td >currency('+amount+')</td></tr>')
                                };
                                var retrocession = response.retrocession;
                                for (var i = 0; i < retrocession.length; i++){
                                    var type = retrocession[i].type;
                                    var contract = retrocession[i].contract;
                                    var percentage = retrocession[i].percentage;
                                    var amount = retrocession[i].amount;
                                    $('#retrocessionPanelupdate tbody').prepend('<tr id="rcstid'+retrocession[i].id+'" ><td >'+type+'</td><td >'+contract+'</td><td >'+percentage+'</td><td >currency('+amount+')</td></tr>')
                                };

                                $("#slipnumberupdate").val(response.slip_number);
                                $("#slipusernameupdate").val(response.username);
                                $("#slipprodyearupdate").val(response.prod_year);
                                $("#slipuyupdate").val(response.uy);
                                $("#slipstatusupdate").append('<option value="'+response.status+'" selected>'+response.status+' - current choice</option>');
                                $('#slipcedingbrokerupdate').append(' <option value="'+response.cedbrok_id+'" selected>'+response.cedbrok_cn+' - '+response.cedbrok_code+' - '+response.cedbrok+' - current choice</option>');
                                $('#slipcedingupdate').append(' <option value="'+response.ceding_id+'" selected>'+response.ceding_cn+' - '+response.ceding_code+' - '+response.ceding+' - current choice</option>');
                                $('#slipcurrencyupdate').append('<option value="'+response.currency_id+'"selected>'+response.currency_code+' - '+response.currency+' - current choice</option>');
                                $('#slipcobupdate').append('<option value="'+response.cob_id+'"selected>'+response.cob_code+' - '+response.cob+' - current choice</option>');
                                $('#slipkocupdate').append('<option value="'+response.koc_id+'"selected>'+response.koc_code+' - '+response.koc+' - current choice</option>');
                                $('#slipoccupacyupdate').append('<option value="'+response.occupacy_id+'"selected>'+response.occupacy_code+' - '+response.occupacy+' - current choice</option>');
                                $('#slipbld_constupdate').append('<option value="'+response.build_const+'"selected>'+response.build_const+' - current choice</option>');
                                $('#sliptypeupdate').append('<option value="'+response.insured_type+'"selected>'+response.insured_type+' - current choice</option>');
                                $('#sliplayerproportionalupdate').append('<option value="'+response.layer_non_proportional+'"selected>'+response.layer_non_proportional+' - current choice</option>');
                                $('#sliprbupdate').append('<option value="'+response.retro_backup+'"selected>'+response.retro_backup+' - current choice</option>');
                                if(response.retro_backup == 'NO'){
                                    $("#tabretroupdate").attr('hidden','true');
                                }

                                $('#slipnoupdate').val(response.slip_no);
                                $('#slipcndnupdate').val(response.cn_dn);
                                $('#slippolicy_noupdate').val(response.policy_no);
                                $('#slipcoinsuranceupdate').val(response.coinsurance_slip);
                                $('#sliptotalsumupdate').val(response.total_sum_insured);
                                $('#slippctupdate').val(response.insured_Pct);
                                $('#sliptotalsumpctupdate').val(response.total_sum_pct);
                                $('#slipipfromupdate').val(response.insurance_period_from);
                                $('#slipiptoupdate').val(response.insurance_period_to);
                                $('#sliprpfromupdate').val(response.reinsurance_period_from);
                                $('#sliprptoupdate').val(response.reinsurance_period_to);
                                $('#switch-proportionalupdate').val(response.proportional);
                                if(response.proportional == null){
                                    $("#btnaddlayerupdate").attr('hidden','true');
                                    $("#sliplayerproportionalupdate").attr('hidden','true');
                                    $("#labelnonpropupdate").attr('hidden','true');
                                    $("#labelnpupdate").attr('hidden','true');
                                }
                                $('#sliprateupdate').val(response.rate);
                                $('#slipshareupdate').val(response.share);
                                $('#slipsumshareupdate').val(response.sum_share);
                                $('#slipbasicpremiumupdate').val(response.basic_premium);
                                $('#slipgrossprmtonrupdate').val(response.grossprm_to_nr);
                                $('#slipcommissionupdate').val(response.commission);
                                $('#slipsumcommissionupdate').val(response.sum_commission);
                                $('#slipnetprmtonrupdate').val(response.netprm_to_nr);
                                $('#sliporupdate').val(response.own_retention);
                                $('#slipsumorupdate').val(response.sum_own_retention);
                                swal("Good job!", "Data Show", "success")
                            }else{
                                swal("Ohh no!", "Data failed to get", "failed")
                            }
                        }
                    });
                }else{
                    swal("Ohh no!", "Current object failed to get", "failed")
                }
        }

        function endorsementslip(id)
        {
            if(id){
                alert(id);
                swal("Please wait!", "Loading Data")
                    $.ajax({
                        type:"GET",
                        dataType: 'json',
                        url:'{{ url("/") }}/transaction-data/getmodal-marine-slip/'+id,
                        beforeSend: function() { $("body").addClass("loading");  },
                        complete: function() {  $("body").removeClass("loading"); },
                        success:function(response){  
                            console.log(response)      
                            if(response){
                                
                                var status_log = response.status_log;
                                for (var i = 0; i < status_log.length; i++){
                                    var status = status_log[i].status;
                                    var datetime = status_log[i].datetime;
                                    var user = status_log[i].user;
                                    $('#slipStatusTableendorsement tbody').prepend('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                                };
                                var interest_insured = response.interestinsured;
                                for (var i = 0; i < interest_insured.length; i++){
                                    var interest = interest_insured[i].description;
                                    var code = interest_insured[i].code;
                                    var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(interest_insured[i].amount);
                                    $('#interestInsuredTableendorsement tbody').prepend('<tr id="itsid'+interest_insured[i].id+'"><td >'+code+' - '+interest+'</td><td >'+amount+'</td></tr>')
                                };
                                var attachment = response.attachment;
                                for (var i = 0; i < attachment.length; i++){
                                    var filename = attachment[i].filename;
                                    $('#aidlistendorsement').append('<li><div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+filename+'">'+filename+'</a></div></li>')
                                };
                                var deductible = response.deductible;
                                for (var i = 0; i < deductible.length; i++){
                                    var currency_code = deductible[i].code;
                                    var currency = deductible[i].symbol_name;
                                    var abbreviation = deductible[i].abbreviation;
                                    var description = deductible[i].description;
                                    var percentage = deductible[i].percentage;
                                    var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(deductible[i].amount);
                                    var min_claimamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(deductible[i].min_claimamount);
                                    $('#deductiblePanelendorsement tbody').prepend('<tr id="dbtid'+deductible[i].id+'"><td >'+abbreviation+' - '+description+'</td><td >'+currency_code+'-'+currency+'</td><td>'+percentage+'</td><td>'+amount+'</td><td>'+min_claimamount+'</td></tr>')
                                };
                                var condition_needed = response.condition_needed;
                                for (var i = 0; i < condition_needed.length; i++){
                                    var description = condition_needed[i].description;
                                    var code = condition_needed[i].code;
                                    var name = condition_needed[i].name;
                                    var information = condition_needed[i].information;
                                    $('#conditionNeededendorsement tbody').prepend('<tr id="cntid'+condition_needed[i].id+'" ><td >'+code+' - '+name+' - '+description+'</td><td >'+information+'</td></tr>')
                                };
                                var installment_panel = response.installment_panel;
                                for (var i = 0; i < installment_panel.length; i++){
                                    var date = installment_panel[i].installment_date;
                                    var percentage = installment_panel[i].percentage;
                                    var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(installment_panel[i].amount);
                                    $('#installmentPanelendorsement tbody').prepend('<tr id="isptid'+installment_panel[i].id+'" ><td >'+date+'</td><td >'+percentage+'</td><td >'+amount+'</td></tr>')
                                };
                                var retrocession = response.retrocession;
                                for (var i = 0; i < retrocession.length; i++){
                                    var type = retrocession[i].type;
                                    var contract = retrocession[i].contract;
                                    var percentage = retrocession[i].percentage;
                                    var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(retrocession[i].amount);
                                    $('#retrocessionPanelendorsement tbody').prepend('<tr id="rcstid'+retrocession[i].id+'" ><td >'+type+'</td><td >'+contract+'</td><td >'+percentage+'</td><td >'+amount+'</td></tr>')
                                };

                                $("#slipnumberendorsement").val(response.slip_number);
                                $("#msinumberendorsement").val(response.insured_id);
                                $("#slipusernameendorsement").val(response.username);
                                $("#slipprodyearendorsement").val(response.prod_year);
                                $("#slipuyendorsement").val(response.uy);
                                $("#slipstatusendorsement").append('<option value="'+response.status+'" selected>'+response.status+'- current choice</option>');
                                $('#slipcedingbrokerendorsement').append(' <option value="'+response.cedbrok_id+'" selected>'+response.cedbrok_cn+' - '+response.cedbrok_code+' - '+response.cedbrok+'- current choice</option>');
                                $('#slipcedingendorsement').append(' <option value="'+response.ceding_id+'" selected>'+response.ceding_cn+' - '+response.ceding_code+' - '+response.ceding+'- current choice</option>');
                                $('#slipcurrencyendorsement').append('<option value="'+response.currency_id+'"selected>'+response.currency_code+' - '+response.currency+'- current choice</option>');
                                $('#slipcobendorsement').append('<option value="'+response.cob_id+'"selected>'+response.cob_code+' - '+response.cob+'- current choice</option>');
                                $('#slipkocendorsement').append('<option value="'+response.koc_id+'"selected>'+response.koc_code+' - '+response.koc+'- current choice</option>');
                                $('#slipoccupacyendorsement').append('<option value="'+response.occupacy_id+'"selected>'+response.occupacy_code+' - '+response.occupacy+'- current choice</option>');
                                $('#slipbld_constendorsement').append('<option value="'+response.build_const+'"selected>'+response.build_const+'- current choice</option>');
                                $('#sliptypeendorsement').append('<option value="'+response.insured_type+'"selected>'+response.insured_type+'- current choice</option>');
                                $('#sliplayerproportionalendorsement').append('<option value="'+response.layer_non_proportional+'"selected>'+response.layer_non_proportional+'- current choice</option>');
                                $('#sliprbendorsement').append('<option value="'+response.retro_backup+'"selected>'+response.retro_backup+'- current choice</option>');
                                if(response.retro_backup == 'NO'){
                                    $("#tabretroendorsement").attr('hidden','true');
                                }

                                $('#slipnoendorsement').val(response.slip_no);
                                $('#slipcndnendorsement').val(response.cn_dn);
                                $('#slippolicy_noendorsement').val(response.policy_no);
                                $('#slipcoinsuranceendorsement').val(response.coinsurance_slip);
                                $('#sliptotalsumendorsement').val(response.total_sum_insured);
                                $('#slippctendorsement').val(response.insured_pct);
                                $('#sliptotalsumpctendorsement').val(response.total_sum_pct);
                                $('#slipipfromendorsement').val(response.insurance_period_from);
                                $('#slipiptoendorsement').val(response.insurance_period_to);
                                $('#sliprpfromendorsement').val(response.reinsurance_period_from);
                                $('#sliprptoendorsement').val(response.reinsurance_period_to);
                                $('#switch-proportionalendorsement').val(response.proportional);
                                if(response.proportional == null){
                                    $("#btnaddlayerendorsement").attr('hidden','true');
                                    $("#sliplayerproportionalendorsement").attr('hidden','true');
                                    $("#labelnonpropendorsement").attr('hidden','true');
                                    $("#labelnpendorsement").attr('hidden','true');
                                }
                                $('#sliprateendorsement').val(response.rate);
                                $('#slipshareendorsement').val(response.share);
                                $('#slipsumshareendorsement').val(response.sum_share);
                                $('#slipbasicpremiumendorsement').val(response.basic_premium);
                                $('#slipgrossprmtonrendorsement').val(response.grossprm_to_nr);
                                $('#slipcommissionendorsement').val(response.commission);
                                $('#slipsumcommissionendorsement').val(response.sum_commission);
                                $('#slipnetprmtonrendorsement').val(response.netprm_to_nr);
                                $('#sliporendorsement').val(response.own_retention);
                                $('#slipsumorendorsement').val(response.sum_own_retention);
                                swal("Good job!", "Data Show", "success")
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

<script type='text/javascript'>
    $('#multi-file-upload-ajaxupdate').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ms = $('#insuredIDtxt').val();
       var slipnumber = $('#slipnumberupdate').val();
       var slipuy = $('#slipuyupdate').val();
       var slipstatus = $('#slipstatusupdate').val();
       var sliped = $('#slipedupdate').val();
       var slipsls = $('#slipslsupdate').val();
       var slipcedingbroker = $('#slipcedingbrokerupdate').val();
       var slipceding = $('#slipcedingupdate').val();
       var slipcurrency = $('#slipcurrencyupdate').val();
       var slipcob = $('#slipcobupdate').val();
       var slipkoc = $('#slipkocupdate').val();
       var slipoccupacy = $('#slipoccupacyupdate').val();
       var slipbld_const = $('#slipbld_constupdate').val();
       var slipno = $('#slipnoupdate').val();
       var slipcndn = $('#slipcndnupdate').val();
       var slippolicy_no = $('#slippolicy_noupdate').val();
       var sliptotalsum = $('#sliptotalsumupdate').val();
       var sliptype =  $('#sliptypeupdate').val();
       var slippct =  $('#slippctupdate').val();
       var sliptotalsumpct =  $('#sliptotalsumpctupdate').val();
       var slipipfrom =  $('#slipipfromupdate').val();
       var slipipto =  $('#slipiptoupdate').val();
       var sliprpfrom =  $('#sliprpfromupdate').val();
       var sliprpto =  $('#sliprptoupdate').val();
       var proportional =  $('#switch-proportionalupdate').val();
       var sliplayerproportional =  $('#sliplayerproportionalupdate').val();
       var sliprate =  $('#sliprateupdate').val();
       var slipshare =  $('#slipshareupdate').val();
       var slipsumshare =  $('#slipsumshareupdate').val();
       var slipbasicpremium =  $('#slipbasicpremiumupdate').val();
       var slipgrossprmtonr =  $('#slipgrossprmtonrupdate').val();
       var slipsumcommission =  $('#slipsumcommissionupdate').val();
       var slipcommission =  $('#slipcommissionupdate').val();
       var slipnetprmtonr =  $('#slipnetprmtonrupdate').val();
       var sliprb =  $('#sliprbupdate').val();
       var slipor =  $('#sliporupdate').val();
       var slipsumor =  $('#slipsumorupdate').val();
       var slipvbroker = $('#slipvbrokerupdate').val();
       var token2 = $('input[name=_token]').val();
       
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
               slipcommission:slipcommission,
               slipsumcommission:slipsumcommission,
               slipnetprmtonr:slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipvbroker:slipvbroker,
               slipsumor:slipsumor
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Marine Slip Insert Success", "success")
                console.log(response)

                /*
                $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.number+'">'+response.number+'</td><td data-name="'+response.slipuy+'">'+slipuy+'</td><td data-name="'+response.slipstatus+'">"'+slipstatus+'"</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+response.number+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#updatemodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#endorsementmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                    +'</a><td></td></tr>');
                    */
                    
                //$('#slipnumberupdate').val(response.code_sl);

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", " Marine Slip Insert Error", "Insert Error");
           }
       });


      
       var formData = new FormData(this);
       let TotalFiles = $('#attachmentupdate')[0].files.length; //Total files
       let files = $('#attachmentupdate')[0];
       var slip_id = $('#slipnumberupdate').val();

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
                     // swal("Error!", data.responseJSON.errors.files[0], "Insert Error");
                     //console.log(data.responseJSON.errors);
                    }
        });


      // insured save
    //    var fesnumber = $('#insuredIDtxt').val();
    //    var fesinsured = $('#msiinsured').val();
    //    var fessuggestinsured = $('#autocomplete').val();
    //    var fessuffix = $('#autocomplete2').val();
    //    var fesshare = $('#msishare').val();
    //    var fessharefrom  = $('#msisharefrom').val();
    //    var fesshareto = $('#msishareto').val();
    //    var fescoinsurance = $('#msicoinsurance').val();
       
       
    //    var token2 = $('input[name=_token]').val();

    //    console.log(fesinsured)
    //    console.log(fessuggestinsured)
    //    console.log(fesnumber)
    //    console.log(fessuffix)

       
    //    $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });

    //    $.ajax({
    //        url:"{{ url('transaction-data/marine-insured/store') }}",
    //        type:"POST",
    //        data:{
    //            fesnumber:fesnumber,
    //            fesinsured:fesinsured,
    //            fessuggestinsured:fessuggestinsured,
    //            fessuffix:fessuffix,
    //            fesshare:fesshare,
    //            fessharefrom:fessharefrom,
    //            fesshareto:fesshareto,
    //            fescoinsurance:fescoinsurance
    //        },
    //        beforeSend: function() { $("body").addClass("loading");  },
    //        complete: function() {  $("body").removeClass("loading"); },
    //        success:function(response)
    //        {
    //             swal("Good job!", "Insured Marine Insert Success", "success")
    //             console.log(response)

    //        },
    //        error: function (request, status, error) {
    //             //alert(request.responseText);
    //             swal("Error!", "Insured Marine Insured Insert Error", "Insert Error");
    //        }
    //    });




   });
</script>

<script type='text/javascript'>
    $('#multi-file-upload-ajaxendorsement').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ms = $('#insuredIDtxt').val();
       var slipnumber = $('#slipnumberendorsement').val();
       var prevslipnumber = $('#prevslipnumberendorsement').val();
       var slipuy = $('#slipuyendorsement').val();
       var slipstatus = $('#slipstatusendorsement').val();
       var sliped = $('#slipedendorsement').val();
       var slipsls = $('#slipslsendorsement').val();
       var slipcedingbroker = $('#slipcedingbrokerendorsement').val();
       var slipceding = $('#slipcedingendorsement').val();
       var slipcurrency = $('#slipcurrencyendorsement').val();
       var slipcob = $('#slipcobendorsement').val();
       var slipkoc = $('#slipkocendorsement').val();
       var slipoccupacy = $('#slipoccupacyendorsement').val();
       var slipbld_const = $('#slipbld_constendorsement').val();
       var slipno = $('#slipnoendorsement').val();
       var slipcndn = $('#slipcndnendorsement').val();
       var slippolicy_no = $('#slippolicy_noendorsement').val();
       var sliptotalsum = $('#sliptotalsumendorsement').val();
       var sliptype =  $('#sliptypeendorsement').val();
       var slippct =  $('#slippctendorsement').val();
       var sliptotalsumpct =  $('#sliptotalsumpctendorsement').val();
       var slipipfrom =  $('#slipipfromendorsement').val();
       var slipipto =  $('#slipiptoendorsement').val();
       var sliprpfrom =  $('#sliprpfromendorsement').val();
       var sliprpto =  $('#sliprptoendorsement').val();
       var proportional =  $('#switch-proportionalendorsement').val();
       var sliplayerproportional =  $('#sliplayerproportionalendorsement').val();
       var sliprate =  $('#sliprateendorsement').val();
       var slipshare =  $('#slipshareendorsement').val();
       var slipsumshare =  $('#slipsumshareendorsement').val();
       var slipbasicpremium =  $('#slipbasicpremiumendorsement').val();
       var slipgrossprmtonr =  $('#slipgrossprmtonrendorsement').val();
       var slipsumcommission =  $('#slipsumcommissionendorsement').val();
       var slipcommission =  $('#slipcommissionendorsement').val();
       var slipnetprmtonr =  $('#slipnetprmtonrendorsement').val();
       var sliprb =  $('#sliprbendorsement').val();
       var slipor =  $('#sliporendorsement').val();
       var slipsumor =  $('#slipsumorendorsement').val();
       var slipvbrokerendorsement = $('#slipvbrokerendorsement').val();
       var token2 = $('input[name=_token]').val();
       
       //ajaxfilefunction(e);

       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/marine-slip/endorsementstore')}}",
           type:"POST",
           data:{
               code_ms:code_ms,
               slipnumber:slipnumber,
               prevslipnumber:prevslipnumber,
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
               slipcommission:slipcommission,
               slipsumcommission:slipsumcommission,
               slipnetprmtonr:slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipvbroker:slipvbrokerendorsement,
               slipsumor:slipsumor
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Marine Slip Insert Success", "success")
                console.log(response)

                
                $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.number+'">'+response.number+'</td><td data-name="'+response.slipuy+'">'+slipuy+'</td><td data-name="'+response.slipstatus+'">"'+slipstatus+'"</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+response.number+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#updatemodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#endorsementmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                    +'</a><td></td></tr>');
                

                $('#slipnumberendorsement').val(response.code_sl);

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Marine Slip Insert Error", "Insert Error");
           }
       });


      
       var formData = new FormData(this);
       let TotalFiles = $('#attachmentendorsement')[0].files.length; //Total files
       let files = $('#attachmentendorsement')[0];
       var slip_id = $('#slipnumberendorsement').val();

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
                     //swal("Error!", data.responseJSON.errors.files[0], "Insert Error");
                     //console.log(data.responseJSON.errors);
                    }
        });


      // insured save
    //    var fesnumber = $('#insuredIDtxt').val();
    //    var fesinsured = $('#feinsured').val();
    //    var fessuggestinsured = $('#autocomplete').val();
    //    var fessuffix = $('#autocomplete2').val();
    //    var fesshare = $('#feshare').val();
    //    var fessharefrom  = $('#fesharefrom').val();
    //    var fesshareto = $('#feshareto').val();
    //    var fescoinsurance = $('#fecoinsurance').val();
       
       
    //    var token2 = $('input[name=_token]').val();

    //    console.log(fesinsured)
    //    console.log(fessuggestinsured)
    //    console.log(fesnumber)
    //    console.log(fessuffix)

       
    //    $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });

    //    $.ajax({
    //        url:"{{ url('transaction-data/fe-insured/store') }}",
    //        type:"POST",
    //        data:{
    //            fesnumber:fesnumber,
    //            fesinsured:fesinsured,
    //            fessuggestinsured:fessuggestinsured,
    //            fessuffix:fessuffix,
    //            fesshare:fesshare,
    //            fessharefrom:fessharefrom,
    //            fesshareto:fesshareto,
    //            fescoinsurance:fescoinsurance
    //        },
    //        beforeSend: function() { $("body").addClass("loading");  },
    //        complete: function() {  $("body").removeClass("loading"); },
    //        success:function(response)
    //        {
    //             swal("Good job!", "Insured Fire & Engineering Insert Success", "success")
    //             console.log(response)

    //        },
    //        error: function (request, status, error) {
    //             //alert(request.responseText);
    //             swal("Error!", "Insured Fire & Engineering Insured Insert Error", "Insert Error");
    //        }
    //    });




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
        background: rgba(255,255,255,0.8) url("{{asset('loader.gif')}}") center no-repeat;
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


