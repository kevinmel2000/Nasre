<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('/js/select2.js')}}"></script>
<script>
    $(document).ready(function() { 
        
        $(".e1").select2({ width: '100%' }); 
    
        $("#tabretro").attr('hidden','true');
        // $("#tabretrodetail").attr('hidden','true');
        // $("#tabretroupdate").attr('hidden','true');
        // $("#tabretroendorsement").attr('hidden','true');
        $("#sliptotalsum").val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $("#fesharefrom").val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $("#feshareto").val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        var countryID = 102; 
        //alert(countryID);
        if(countryID){
        $.ajax({
            type:"GET",
            url:"{{url('get-state-lookup')}}?country_id="+countryID,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res){
                    $("#state_location").empty();
                    $("#state_location").append('<option selected disabled>Select States/Province</option>');
                    $.each(res,function(key,value){
                    $("#state_location").append('<option value="'+key+'">'+value+'</option>');
                    });
                
                }else{
                    $("#state_location").append('<option value="" selected disabled>get value error</option>');
                }
            }
        });
        }else{
          $("#state_location").append('<option value="" selected disabled>countryID null</option>');
          $("#city_location").empty();
        }  
        
    });

    function treatAsUTC(date) {
        var result = new Date(date);
        result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
        return result;
    }

    function daysBetween(startDate, endDate) {
        var millisecondsPerDay = 24 * 60 * 60 * 1000;
        return (treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay;
    }
</script>



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



    $(".money").click(function() {
    var inputLength = $(".money").val().length;
    setCaretToPos($(".money")[0], inputLength)
    });

    // $(".uang").keyup(function() {
    // var inputLength = $(".uang").val().length;
    // setCaretToPos($(".uang")[0], inputLength)
    
    // });

    $(".uang").keyup(function() {
        $('.uang').mask("#,##0.00", {reverse: true});
        console.log($('#slipvbroker').val())

    });

   

    // $('#slipvbroker').change(function(){
    //     var amount = $('#slipvbroker').val();
    //     var conv_amount = amount.replace(/,/g, "");
    //    console.log(conv_amount)
    //     console.log($('#slipvbroker').val())
    // });

    // var options = {
    // onKeyPress: function(cep, e, field, options){
    //     if (cep.length<=6)
    //     {
        
    //         var inputVal = parseFloat(cep);
    //         jQuery('.uang').val(inputVal.toFixed(2));
    //     }
        
    //     // setCaretToPos(jQuery('#money')[0], 4);
                    
    //     var masks = ['#,##0.00', '0.00'];
    //     mask = (cep == 0) ? masks[1] : masks[0];
    //     $('.uang').mask(mask, options);
    // },
    // reverse: true
    // };

    // $('.money').mask('#,##0.00', options);
</script>


<script type="text/javascript">

    //triggered when modal is about to be shown
    $('#detailmodaldata').on('show.bs.modal', function(e) {

         //get data-id attribute of the clicked element
        var codesl = $(e.relatedTarget).data('book-id');
        
        //alert(codesl);
        
        $.ajax({
            url:'{{ url("/") }}/transaction-data/detailslip/'+codesl,
            type:"GET",
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response)
            {
                    $('#slipnumberdetail').val(response.number);
                    $('#slipusernamedetail').val(response.username);
                    $('#slipprodyeardetail').val(response.prod_year);
                    $('#slipuydetail').val(response.uy);
                    $('#slipeddetail').val(response.endorsment);
                    $('#slipslsdetail').val(response.selisih);
                    $('#wpcdetail').val(response.wpc);
                    $('#slipvbrokerdetail').val(response.v_broker);

                    // if(response.interest_insured)
                    // {
                    //     var interestdata = JSON.parse(response.interest_insured); 

                    //     for(var i = 0; i < interestdata.length; i++) 
                    //     {
                    //         var obj = interestdata[i];

                    //         //console.log(obj.id);
                    //         //$('#interestInsuredTabledetail tbody').prepend('');
                            
                    //         $('#interestInsuredTabledetail tbody').empty();
                    //         $('#interestInsuredTabledetail tbody').prepend('<tr id="iiddetail'+obj.id+'" data-name="interestdetailvalue[]"><td data-name="'+obj.description+'">'+obj.description+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>')
                
                    //     }
                    // }


                    if(response.deductible_panel)
                    {

                        var deductibledata = JSON.parse(response.deductible_panel); 

                        for(var i = 0; i < deductibledata.length; i++) 
                        {
                            var obj = deductibledata[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                            var curr_minamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.min_claimamount);
                            $('#deductiblePaneldetail tbody').empty();
                            $('#deductiblePaneldetail tbody').prepend('<tr id="iiddeductible'+obj.id+'" data-name="deductibledetailvalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.currencydata+'">'+obj.currencydata+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td data-name="'+curr_minamount+'">'+curr_minamount+'</td><td></td></tr>');
              
                        }
                    }


                    if(response.extend_coverage)
                    {

                        var extend_coverage = JSON.parse(response.extend_coverage); 

                        for(var i = 0; i < extend_coverage.length; i++) 
                        {
                            var obj = extend_coverage[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                            $('#ExtendCoveragePaneldetail tbody').empty();
                            $('#ExtendCoveragePaneldetail tbody').prepend('<tr id="iidextendcoveragedetail'+obj.id+'" data-name="extendcoveragedetailvalue[]"><td data-name="'+obj.coveragetype+'">'+obj.coveragetype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td></td></tr>');
                            
                        }
                    }


                    if(response.installment_panel)
                    {

                        var installment_panel = JSON.parse(response.installment_panel); 

                        for(var i = 0; i < installment_panel.length; i++) 
                        {
                            var obj = installment_panel[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                           $('#installmentPaneldetail tbody').empty();
                           $('#installmentPaneldetail tbody').prepend('<tr id="iidinstallmentdetail'+obj.id+'" data-name="installmentdetailvalue[]"><td data-name="'+obj.installment_date+'">'+obj.installment_date+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td></td></tr>')
               
                        }
                    }



                    if(response.retrocession_panel)
                    {

                        var retrocession_panel = JSON.parse(response.retrocession_panel); 

                        for(var i = 0; i < retrocession_panel.length; i++) 
                        {
                            var obj = retrocession_panel[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#retrocessionPaneldetail tbody').empty();
                            
                            $('#retrocessionPaneldetail tbody').prepend('<tr id="iidretrocessiondetail'+obj.id+'" data-name="retrocessiondetailvalue[]"><td data-name="'+obj.type+'">'+obj.type+'</td><td data-name="'+obj.contract+'">'+obj.contract+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td></td></tr>');
              
                        }
                    }
                    
                    
                    if(response.status)
                    {
                     $("#slipstatusdetail option[value=" + response.status + "]:first")[0].selected = true;
                    }

                    if(response.source)
                    {
                        $("#slipcedingbrokerdetail option[value=" + response.source + "]:first")[0].selected = true;
                    }

                    if(response.source2)
                    {
                        $("#slipcedingdetail option[value=" + response.source2 + "]:first")[0].selected = true;
                    }

                    if(response.currency)
                    {
                        $("#slipcurrencydetail option[value=" + response.currency + "]:first")[0].selected = true;
                    }
                    
                    if(response.cob)
                    {
                        $("#slipcobdetail option[value=" + response.cob + "]:first")[0].selected = true;
                    }

                    if(response.koc)
                    {
                        $("#slipkocdetail option[value=" + response.koc + "]:first")[0].selected = true;
                    }

                    if(response.occupacy)
                    {
                        $("#slipoccupacydetail option[value=" + response.occupacy + "]:first")[0].selected = true;
                    }

                    if(response.build_const)
                    {
                       $("#slipbld_constdetail option[value='" + response.build_const + "']:first")[0].selected = true;
                    }

                    $("#slipbcuadetail").val(response.build_rate_up);
                    $("#slipbcladetail").val(response.build_rate_down);

                    if(response.insured_type)
                    {
                        $("#sliptypedetail option[value=" + response.insured_type + "]:first")[0].selected = true;
                    }

                    if(response.layer_non_proportional)
                    {
                        $("#sliplayerproportionaldetail option[value=" + response.layer_non_proportional + "]:first")[0].selected = true;
                    }

                    if(response.retro_backup)
                    {
                        $("#sliprbdetail option[value=" + response.retro_backup + "]:first")[0].selected = true;
                        if(response.retro_backup == "NO")
                        {
                            $("#tabretrodetail").attr('hidden');
                        }
                        else if(response.retro_backup == "YES"){
                            $("#tabretrodetail").removeAttr('hidden');
                        }
                    }

                    if(response.status_log){
                        var status_log = response.status_log;
                                for (var i = 0; i < status_log.length; i++){
                                    var status = status_log[i].status;
                                    var datetime = status_log[i].datetime;
                                    var user = status_log[i].user;
                                    $('#slipStatusTabledetail tbody').append('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                                };
                    }


                    $('#slipnodetail').val(response.slip_no);
                    $('#slipcndndetail').val(response.cn_dn);
                    $('#slippolicy_nodetail').val(response.policy_no);
                    if(response.total_sum_insured){
                        $('#sliptotalsumdetail').val(response.total_sum_insured.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    else
                    {
                        $('#sliptotalsumdetail').val("0");
                    }
                   
                
                    $('#slippctdetail').val(response.insured_pct);
                    if(response.total_sum_pct){
                        $('#sliptotalsumpctdetail').val(response.total_sum_pct.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    else{
                        $('#sliptotalsumpctdetail').val("0");
                    }
                    

                    $('#sliptddetail').val(response.date_transfer);
                    $('#slipipfromdetail').val(response.insurance_period_from);
                    $('#slipiptodetail').val(response.insurance_period_to);

                    var insurance_period_from2 = response.insurance_period_from;
                    var insurance_period_to2 = response.insurance_period_to;
                    var days=daysBetween(insurance_period_from2, insurance_period_to2);
                    var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
                    var constday = days.toString() + "/365";
                    console.log(insurance_period_from2)
                    console.log(insurance_period_to2)
                    console.log(days)
                    console.log(constday)
                    console.log(parseFloat(sum))
                    
                    $('#slipdaytotaldetail').val(constday);
                    $('#sliptotalsumdatedetail').val(parseFloat(sum));

                    $('#sliprpfromdetail').val(response.reinsurance_period_from);
                    $('#sliprptodetail').val(response.reinsurance_period_to);
                    
                    $('#switch-proportionaldetail').val(response.proportional);
                    // if(response.proportional == ''){
                        $("#btnaddlayerdetail").attr('hidden','true');
                        $("#sliplayerproportionaldetail").attr('hidden','true');
                        $("#labelnonpropdetail").attr('hidden','true');
                        $("#labelnpdetail").attr('hidden','true');
                    // }

                    $('#slipratedetail').val(response.rate);
                    $('#slipsharedetail').val(response.share);
                    if(response.sum_share){
                        $('#slipsumsharedetail').val(response.sum_share.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    else{
                        $('#slipsumsharedetail').val("0");
                    }
                    if(response.basic_premium){
                        $('#slipbasicpremiumdetail').val(response.basic_premium.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }else
                    {
                        $('#slipbasicpremiumdetail').val("0");
                    }
                    
                    if(response.grossprm_to_nr){
                        $('#slipgrossprmtonrdetail').val(response.grossprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    else{
                        $('#slipgrossprmtonrdetail').val("0");
                    }
                    if(response.commission){
                        $('#slipcommissiondetail').val(response.commission);
                    }
                    else{
                        $('#slipcommissiondetail').val(0);
                    }
                    

                    if(response.sum_commission){
                        $('#slipsumcommissiondetail').val(response.sum_commission.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    else{
                        $('#slipsumcommissiondetail').val("0");

                    }

                    if(response.netprm_to_nr){
                        $('#slipnetprmtonrdetail').val(response.netprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ",")); 
                    }
                    else{
                        $('#slipnetprmtonrdetail').val("0"); 
                    }

                    if(response.own_retention){
                        $('#slipordetail').val(response.own_retention);
                    }
                    else{
                        $('#slipordetail').val(0);
                    }

                    if(response.sum_own_retention){
                        $('#slipsumordetail').val(response.sum_own_retention.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    else{
                        $('#slipsumordetail').val("0");
                    }
                    
                    
                    swal("Good job!", "Data Show")
                    console.log(response)

            },
            error: function (request, status, error) {
                    //alert(request.responseText);
                    swal("Error!", "Get Slip Data Error", "Get Data Error");
            }
        });

        $('input .amount').val(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;
                console.log(event.which)
                console.log($(this).val())
                // format number
                $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        // var bld = $('#slipbld_constdetail').val();
        // var ocp_id = $('#slipoccupacydetail').val();
        // console.log(bld)
        // console.log(ocp_id)
        // $.ajax({
        //     type:"GET",
        //     url:"{{url('get-building-rate')}}",
        //     data: {
        //     building: bld,
        //     occupacy_id:ocp_id
        //     },
        //     beforeSend: function() { $("body").addClass("loading");  },
        //     complete: function() {  $("body").removeClass("loading"); },
        //     success:function(res){  
        //         console.log(res)      
        //         console.log(bld)      
        //         if(res.rate_batas_atas_building_class_1){
        //             $("#slipbcuadetail").val(res.rate_batas_atas_building_class_1);
        //             $("#slipbcladetail").val(res.rate_batas_bawah_building_class_1);
        //         }
        //         else if(res.rate_batas_atas_building_class_2){
        //             $("#slipbcuadetail").val(res.rate_batas_atas_building_class_2);
        //             $("#slipbcladetail").val(res.rate_batas_bawah_building_class_2);
        //         }
        //         else if(res.rate_batas_atas_building_class_3){
        //             $("#slipbcuadetail").val(res.rate_batas_atas_building_class_3);
        //             $("#slipbcladetail").val(res.rate_batas_bawah_building_class_3);
        //         }
        //     }
        // });
        

    });
</script>


<script type="text/javascript">

    //triggered when modal is about to be shown
    $('#updatemodaldata').on('show.bs.modal', function(e) {
        
         //get data-id attribute of the clicked element
        var codesl = $(e.relatedTarget).data('book-id');
        //alert(codesl);
        $('input .amount').val(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;
                console.log(event.which)
                console.log($(this).val())
                // format number
                $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
        
        $.ajax({
            url:'{{ url("/") }}/transaction-data/detailslip/'+codesl,
            type:"GET",
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response)
            {
                    
                    $('#slipnumberupdate').val(response.number);
                    $('#slipusernameupdate').val(response.username);
                    $('#slipprodyearupdate').val(response.prod_year);
                    $('#slipuyupdate').val(response.uy);
                    $('#slipedupdate').val(response.endorsment);
                    $('#slipslsupdate').val(response.selisih);
                    $('#wpcupdate').val(response.wpc);
                    $('#slipvbrokerupdate').val(response.v_broker);

                    // if(response.interest_insured)
                    // {
                    //     var interestdata = JSON.parse(response.interest_insured); 

                    //     for(var i = 0; i < interestdata.length; i++) 
                    //     {
                    //         var obj = interestdata[i];

                    //         //console.log(obj.id);
                    //         //$('#interestInsuredTabledetail tbody').prepend('');
                    //         $('#interestInsuredTableupdate tbody').empty();
                    //         $('#interestInsuredTableupdate tbody').prepend('<tr id="iidupdate'+obj.id+'" data-name="interestupdatevalue[]"><td data-name="'+obj.description+'">'+obj.description+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestupdate('+obj.id+')">delete</a></td></tr>')
                
                    //     }
                    // }


                    if(response.deductible_panel)
                    {

                        var deductibledata = JSON.parse(response.deductible_panel); 

                        for(var i = 0; i < deductibledata.length; i++) 
                        {
                            var obj = deductibledata[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                            var curr_minamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.min_claimamount);

                            $('#deductiblePanelupdate tbody').empty();
                            $('#deductiblePanelupdate tbody').prepend('<tr id="iiddeductibleupdate'+obj.id+'" data-name="deductibleupdatevalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.currencydata+'">'+obj.currencydata+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td data-name="'+curr_minamount+'">'+curr_minamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibleupdate('+obj.id+')">delete</a></td></tr>');
              
                        }
                    }


                    if(response.extend_coverage)
                    {

                        var extend_coverage = JSON.parse(response.extend_coverage); 

                        for(var i = 0; i < extend_coverage.length; i++) 
                        {
                            var obj = extend_coverage[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#ExtendCoveragePanelupdate tbody').empty();
                            $('#ExtendCoveragePanelupdate tbody').prepend('<tr id="iidextendcoverageupdate'+obj.id+'" data-name="extendcoverageupdatevalue[]"><td data-name="'+obj.coveragetype+'">'+obj.coveragetype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteextendcoverageupdate('+obj.id+')">delete</a></td></tr>');
                            
                        }
                    }


                    if(response.installment_panel)
                    {

                        var installment_panel = JSON.parse(response.installment_panel); 

                        for(var i = 0; i < installment_panel.length; i++) 
                        {
                            var obj = installment_panel[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#installmentPanelupdate tbody').empty();
                           $('#installmentPanelupdate tbody').prepend('<tr id="iidinstallmentupdate'+obj.id+'" data-name="installmentupdatevalue[]"><td data-name="'+obj.installment_date+'">'+obj.installment_date+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentupdate('+obj.id+')">delete</a></td></tr>')
               
                        }
                    }



                    if(response.retrocession_panel)
                    {

                        var retrocession_panel = JSON.parse(response.retrocession_panel); 

                        for(var i = 0; i < retrocession_panel.length; i++) 
                        {
                            var obj = retrocession_panel[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#retrocessionPanelupdate tbody').empty();
                            
                            $('#retrocessionPanelupdate tbody').prepend('<tr id="iidretrocessionupdate'+obj.id+'" data-name="retrocessionupdatevalue[]"><td data-name="'+obj.type+'">'+obj.type+'</td><td data-name="'+obj.contract+'">'+obj.contract+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteretrocessionupdate('+obj.id+')">delete</a></td></tr>');
              
                        }
                    }
                    


                    if(response.status)
                    {
                     $("#slipstatusupdate option[value=" + response.status + "]:first")[0].selected = true;
                    }

                    if(response.source)
                    {
                        $("#slipcedingbrokerupdate option[value=" + response.source + "]:first")[0].selected = true;
                    }

                    if(response.source2)
                    {
                        $("#slipcedingupdate option[value=" + response.source2 + "]:first")[0].selected = true;
                    }

                    if(response.currency)
                    {
                        $("#slipcurrencyupdate option[value=" + response.currency + "]:first")[0].selected = true;
                    }
                    
                    if(response.cob)
                    {
                        $("#slipcobupdate option[value=" + response.cob + "]:first")[0].selected = true;
                    }

                    if(response.koc)
                    {
                        $("#slipkocupdate option[value=" + response.koc + "]:first")[0].selected = true;
                    }

                    if(response.occupacy)
                    {
                        $("#slipoccupacyupdate option[value=" + response.occupacy + "]:first")[0].selected = true;
                    }

                    if(response.build_const)
                    {
                        $("#slipbld_constupdate option[value='" + response.build_const + "']:first")[0].selected = true;
                        $("#slipbcuaupdate").val(response.build_rate_up);
                        $("#slipbclaupdate").val(response.build_rate_down);
                    }



                    if(response.insured_type)
                    {
                        $("#sliptypeupdate option[value=" + response.insured_type + "]:first")[0].selected = true;
                    }

                    if(response.layer_non_proportional)
                    {
                        $("#sliplayerproportionalupdate option[value=" + response.layer_non_proportional + "]:first")[0].selected = true;
                    }

                    if(response.retro_backup)
                    {
                        $("#sliprbupdate option[value=" + response.retro_backup + "]:first")[0].selected = true;
                        if(response.retro_backup == "NO")
                        {
                            $("#tabretroupdate").attr('hidden');
                        }
                        else if(response.retro_backup == "YES"){
                            $("#tabretroupdate").removeAttr('hidden');
                        }
                    }

                    if(response.status_log){
                        var status_log = response.status_log;
                                for (var i = 0; i < status_log.length; i++){
                                    var status = status_log[i].status;
                                    var datetime = status_log[i].datetime;
                                    var user = status_log[i].user;
                                    $('#slipStatusTableupdate tbody').append('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                                };
                    }
                   

                    $('#slipnoupdate').val(response.slip_no);
                    $('#slipcndnupdate').val(response.cn_dn);
                    $('#slippolicy_noupdate').val(response.policy_no);
                    $('#sliptotalsumupdate').val(response.total_sum_insured.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#sliptdupdate').val(response.date_transfer);
                    $('#slippctupdate').val(response.insured_pct);
                    $('#sliptotalsumpctupdate').val(response.total_sum_pct.replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                    $('#slipipfromupdate').val(response.insurance_period_from);
                    $('#slipiptoupdate').val(response.insurance_period_to);

                    var insurance_period_from2 = response.insurance_period_from;
                    var insurance_period_to2 = response.insurance_period_to;
                    var days=daysBetween(insurance_period_from2, insurance_period_to2);
                    var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
                    var constday = days.toString() + "/365";
                    console.log(insurance_period_from2)
                    console.log(insurance_period_to2)
                    console.log(days)
                    console.log(constday)
                    console.log(parseFloat(sum))
                    
                    $('#slipdaytotalupdate').val(constday);
                    $('#sliptotalsumdateupdate').val(parseFloat(sum));

                    $('#sliprpfromupdate').val(response.reinsurance_period_from);
                    $('#sliprptoupdate').val(response.reinsurance_period_to);

                    $('#switch-proportionalupdate').val(response.proportional);
                    // if(response.proportional == ''){
                        $("#btnaddlayerupdate").attr('hidden','true');
                        $("#sliplayerproportionalupdate").attr('hidden','true');
                        $("#labelnonpropupdate").attr('hidden','true');
                        $("#labelnpupdate").attr('hidden','true');
                    // }

                   $('#sliprateupdate').val(response.rate);
                    $('#slipshareupdate').val(response.share);
                    $('#slipsumshareupdate').val(response.sum_share.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipbasicpremiumupdate').val(response.basic_premium.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipgrossprmtonrupdate').val(response.grossprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipcommissionupdate').val(response.commission);
                    $('#slipsumcommissionupdate').val(response.sum_commission.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipnetprmtonrupdate').val(response.netprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                   
                    $('#sliporupdate').val(response.own_retention);
                    $('#slipsumorupdate').val(response.sum_own_retention.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    
                    
                    swal("Good job!", "Data Show")
                    console.log(response)

            },
            error: function (request, status, error) {
                    //alert(request.responseText);
                    swal("Error!", "Get Slip Data Error", "Get Data Error");
            }
        });

        $('input.amount').val(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;
                console.log(event.which)
                console.log($(this).val())
                // format number
                $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        // var bld = $('#slipbld_constupdate').val();
        // var ocp_id = $('#slipoccupacyupdate').val();

        // $.ajax({
        //     type:"GET",
        //     url:"{{url('get-building-rate')}}",
        //     data: {
        //     building: bld,
        //     occupacy_id:ocp_id
        //     },
        //     beforeSend: function() { $("body").addClass("loading");  },
        //     complete: function() {  $("body").removeClass("loading"); },
        //     success:function(res){  
        //         console.log(res)      
        //         console.log(bld)      
        //         if(res.rate_batas_atas_building_class_1){
        //             $("#slipbcuaupdate").val(res.rate_batas_atas_building_class_1);
        //             $("#slipbclaupdate").val(res.rate_batas_bawah_building_class_1);
        //         }
        //         else if(res.rate_batas_atas_building_class_2){
        //             $("#slipbcuaupdate").val(res.rate_batas_atas_building_class_2);
        //             $("#slipbclaupdate").val(res.rate_batas_bawah_building_class_2);
        //         }
        //         else if(res.rate_batas_atas_building_class_3){
        //             $("#slipbcuaupdate").val(res.rate_batas_atas_building_class_3);
        //             $("#slipbclaupdate").val(res.rate_batas_bawah_building_class_3);
        //         }
        //     }
        // });
        

    });
</script>



<script type="text/javascript">

    //triggered when modal is about to be shown
    $('#endorsementmodaldata').on('show.bs.modal', function(e) {
        
         //get data-id attribute of the clicked element
        var codesl = $(e.relatedTarget).data('book-id');
        //alert(codesl);
        $('input .amount').val(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;
                console.log(event.which)
                console.log($(this).val())
                // format number
                $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
        
        $.ajax({
            url:'{{ url("/") }}/transaction-data/detailendorsementslip/'+codesl,
            type:"GET",
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response)
            {
                    //$('#slipnumberendorsement').val(response.number);
                    $('#slipidendorsement').val(response.id);
                    $('#slipnumberendorsement').val(response.code_sl);
                    $('#slipusernameendorsement').val(response.username);
                    $('#slipprodyearendorsement').val(response.prod_year);
                    // $('#slipuyendorsement').val(response.uy);
                    $('#slipedendorsement').val(response.endorsment);
                    $('#slipslsendorsement').val(response.selisih);
                    $('#wpcendorsement').val(response.wpc);
                    $('#slipvbrokerendorsement').val(response.v_broker);

                    // if(response.interest_insured)
                    // {
                    //     var interestdata = JSON.parse(response.interest_insured); 

                    //     for(var i = 0; i < interestdata.length; i++) 
                    //     {
                    //         var obj = interestdata[i];

                    //         //console.log(obj.id);
                    //         //$('#interestInsuredTabledetail tbody').prepend('');
                    //         $('#interestInsuredTableendorsement tbody').empty();
                    //         $('#interestInsuredTableendorsement tbody').prepend('<tr id="iidendorsement'+obj.id+'" data-name="interestendorsementvalue[]"><td data-name="'+obj.description+'">'+obj.description+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestendorsement('+obj.id+')">delete</a></td></tr>')
                
                    //     }
                    // }


                    if(response.deductible_panel)
                    {

                        var deductibledata = JSON.parse(response.deductible_panel); 

                        for(var i = 0; i < deductibledata.length; i++) 
                        {
                            var obj = deductibledata[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                            var curr_minamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.min_claimamount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#deductiblePanelendorsement tbody').empty();
                            $('#deductiblePanelendorsement tbody').prepend('<tr id="iiddeductibleendorsement'+obj.id+'" data-name="deductibleendorsementvalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.currencydata+'">'+obj.currencydata+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td data-name="'+curr_minamount+'">'+curr_minamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibleendorsement('+obj.id+')">delete</a></td></tr>');
              
                        }
                    }


                    if(response.extend_coverage)
                    {

                        var extend_coverage = JSON.parse(response.extend_coverage); 

                        for(var i = 0; i < extend_coverage.length; i++) 
                        {
                            var obj = extend_coverage[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#ExtendCoveragePanelendorsement tbody').empty();
                            $('#ExtendCoveragePanelendorsement tbody').prepend('<tr id="iidextendcoverageendorsement'+obj.id+'" data-name="extendcoverageendorsementvalue[]"><td data-name="'+obj.coveragetype+'">'+obj.coveragetype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteextendcoverageendorsement('+obj.id+')">delete</a></td></tr>');
                            
                        }
                    }


                    if(response.installment_panel)
                    {

                        var installment_panel = JSON.parse(response.installment_panel); 

                        for(var i = 0; i < installment_panel.length; i++) 
                        {
                            var obj = installment_panel[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#installmentPanelendorsement tbody').empty();
                            $('#installmentPanelendorsement tbody').prepend('<tr id="iidinstallmentendorsement'+obj.id+'" data-name="installmentendorsementvalue[]"><td data-name="'+obj.installment_date+'">'+obj.installment_date+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentendorsement('+obj.id+')">delete</a></td></tr>')
               
                        }
                    }



                    if(response.retrocession_panel)
                    {

                        var retrocession_panel = JSON.parse(response.retrocession_panel); 

                        for(var i = 0; i < retrocession_panel.length; i++) 
                        {
                            var obj = retrocession_panel[i];
                            var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#retrocessionPanelendorsement tbody').empty();
                            
                            $('#retrocessionPanelendorsement tbody').prepend('<tr id="iidretrocessionendorsement'+obj.id+'" data-name="retrocessionendorsementvalue[]"><td data-name="'+obj.type+'">'+obj.type+'</td><td data-name="'+obj.contract+'">'+obj.contract+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteretrocessionendorsement('+obj.id+')">delete</a></td></tr>');
              
                        }
                    }
                    
                    
                    if(response.status)
                    {
                     $("#slipstatusendorsement option[value=" + response.status + "]:first")[0].selected = true;
                    }

                    if(response.source)
                    {
                        $("#slipcedingbrokerendorsement option[value=" + response.source + "]:first")[0].selected = true;
                    }

                    if(response.source2)
                    {
                        $("#slipcedingendorsement option[value=" + response.source2 + "]:first")[0].selected = true;
                    }

                    if(response.currency)
                    {
                        $("#slipcurrencyendorsement option[value=" + response.currency + "]:first")[0].selected = true;
                    }
                    
                    if(response.cob)
                    {
                        $("#slipcobendorsement option[value=" + response.cob + "]:first")[0].selected = true;
                    }

                    if(response.koc)
                    {
                        $("#slipkocendorsement option[value=" + response.koc + "]:first")[0].selected = true;
                    }

                    if(response.occupacy)
                    {
                        $("#slipoccupacyendorsement option[value=" + response.occupacy + "]:first")[0].selected = true;
                    }

                    if(response.build_const)
                    {
                       $("#slipbld_constendorsement option[value='" + response.build_const + "']:first")[0].selected = true;
                       $("#slipbcuaendorsement").val(response.build_rate_up);
                        $("#slipbclaendorsement").val(response.build_rate_down);
                    }

                    if(response.insured_type)
                    {
                        $("#sliptypeendorsement option[value=" + response.insured_type + "]:first")[0].selected = true;
                    }

                    if(response.layer_non_proportional)
                    {
                        $("#sliplayerproportionalendorsement option[value=" + response.layer_non_proportional + "]:first")[0].selected = true;
                    }

                    if(response.retro_backup)
                    {
                        $("#sliprbendorsement option[value=" + response.retro_backup + "]:first")[0].selected = true;
                        if(response.retro_backup == "NO")
                        {
                            $("#tabretroendorsement").attr('hidden');
                        }
                        else if(response.retro_backup == "YES"){
                            $("#tabretroendorsement").removeAttr('hidden');
                        }
                    }

                    if(response.status_log){
                        var status_log = response.status_log;
                                for (var i = 0; i < status_log.length; i++){
                                    var status = status_log[i].status;
                                    var datetime = status_log[i].datetime;
                                    var user = status_log[i].user;
                                    $('#slipStatusTableendorsement tbody').append('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                                };
                    }

                    $('#slipnoendorsement').val(response.slip_no);
                    $('#slipcndnendorsement').val(response.cn_dn);
                    $('#slippolicy_noendorsement').val(response.policy_no);
                    $('#sliptotalsumendorsement').val(response.total_sum_insured.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#sliptdendorsement').val(response.date_transfer);
                    $('#slippctendorsement').val(response.insured_pct);
                    $('#sliptotalsumpctendorsement').val(response.total_sum_pct.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipipfromendorsement').val(response.insurance_period_from);
                    $('#slipiptoendorsement').val(response.insurance_period_to);

                    var insurance_period_from2 = response.insurance_period_from;
                    var insurance_period_to2 = response.insurance_period_to;
                    var days=daysBetween(insurance_period_from2, insurance_period_to2);
                    var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
                    var constday = days.toString() + "/365";
                    console.log(insurance_period_from2)
                    console.log(insurance_period_to2)
                    console.log(days)
                    console.log(constday)
                    console.log(parseFloat(sum))
                    
                    $('#slipdaytotalendorsement').val(constday);
                    $('#sliptotalsumdateendorsement').val(parseFloat(sum));

                    $('#sliprpfromendorsement').val(response.reinsurance_period_from);
                    $('#sliprptoendorsement').val(response.reinsurance_period_to);
                    $('#switch-proportionalendorsement').val(response.proportional);
                    // if(response.proportional == ''){
                        $("#btnaddlayerendorsement").attr('hidden','true');
                        $("#sliplayerproportionalendorsement").attr('hidden','true');
                        $("#labelnonpropendorsement").attr('hidden','true');
                        $("#labelnpendorsement").attr('hidden','true');
                    // }

                    $('#sliprateendorsement').val(response.rate);
                    $('#slipshareendorsement').val(response.share);
                    $('#slipsumshareendorsement').val(response.sum_share.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipbasicpremiumendorsement').val(response.basic_premium.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipgrossprmtonrendorsement').val(response.grossprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipcommissionendorsement').val(response.commission);
                    $('#slipsumcommissionendorsement').val(response.sum_commission.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#slipnetprmtonrendorsement').val(response.netprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#sliporendorsement').val(response.own_retention);
                    $('#slipsumorendorsement').val(response.sum_own_retention.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    
                    
                    swal("Good job!", "Data Show")
                    console.log(response)

            },
            error: function (request, status, error) {
                    //alert(request.responseText);
                    swal("Error!", "Get Slip Data Error", "Get Data Error");
            }
        });

        $('input.amount').val(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;
                console.log(event.which)
                console.log($(this).val())
                // format number
                $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        // var bld = $('#slipbld_constendorsement').val();
        // var ocp_id = $('#slipoccupacyendorsement').val();

        // $.ajax({
        //     type:"GET",
        //     url:"{{url('get-building-rate')}}",
        //     data: {
        //     building: bld,
        //     occupacy_id:ocp_id
        //     },
        //     beforeSend: function() { $("body").addClass("loading");  },
        //     complete: function() {  $("body").removeClass("loading"); },
        //     success:function(res){  
        //         console.log(res)      
        //         console.log(bld)      
        //         if(res.rate_batas_atas_building_class_1){
        //             $("#slipbcuaendorsement").val(res.rate_batas_atas_building_class_1);
        //             $("#slipbclaendorsement").val(res.rate_batas_bawah_building_class_1);
        //         }
        //         else if(res.rate_batas_atas_building_class_2){
        //             $("#slipbcuaendorsement").val(res.rate_batas_atas_building_class_2);
        //             $("#slipbclaendorsement").val(res.rate_batas_bawah_building_class_2);
        //         }
        //         else if(res.rate_batas_atas_building_class_3){
        //             $("#slipbcuaendorsement").val(res.rate_batas_atas_building_class_3);
        //             $("#slipbclaendorsement").val(res.rate_batas_bawah_building_class_3);
        //         }
        //     }
        // });

        console.log($('#slipnumberendorsement').val())


       var code_ms = $('#insuredIDtxt').val();
       var slipid = $('#slipidendorsement').val();
       var slipnumber = $('#slipnumberendorsement').val();
       var prevslipnumber = $('#prevslipnumberendorsement').val();
       var slipdatetransfer = $('#sliptdendorsement').val();
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
       var slipvbroker =  $('#v_brokerendorsement').val();
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
       var wpc =  $('#wpcendorsement').val();

       var token2 = $('input[name=_token]').val();
       

       var conv_sliptotalsum = sliptotalsum.replace(/,/g, "");
       console.log(conv_sliptotalsum)
       var real_sliptotalsum = parseInt(conv_sliptotalsum);
       console.log(real_sliptotalsum)
       
       var conv_sliptotalsumpct = sliptotalsumpct.replace(/,/g, "");
       console.log(conv_sliptotalsumpct)
       var real_sliptotalsumpct = parseInt(conv_sliptotalsumpct);
       console.log(real_sliptotalsumpct)

       var conv_slipsumshare = slipsumshare.replace(/,/g, "");
       console.log(conv_slipsumshare)
       var real_slipsumshare = parseInt(conv_slipsumshare);
       console.log(real_slipsumshare)

       var conv_slipbasicpremium = slipbasicpremium.replace(/,/g, "");
       console.log(conv_slipbasicpremium)
       var real_slipbasicpremium = parseInt(conv_slipbasicpremium);
       console.log(real_slipbasicpremium)

       var conv_slipgrossprmtonr = slipgrossprmtonr.replace(/,/g, "");
       console.log(conv_slipgrossprmtonr)
       var real_slipgrossprmtonr = parseInt(conv_slipgrossprmtonr);
       console.log(real_slipgrossprmtonr)

       var conv_slipsumcommission = slipsumcommission.replace(/,/g, "");
       console.log(conv_slipsumcommission)
       var real_slipsumcommission = parseInt(conv_slipsumcommission);
       console.log(real_slipsumcommission)

       var conv_slipnetprmtonr = slipnetprmtonr.replace(/,/g, "");
       console.log(conv_slipnetprmtonr)
       var real_slipnetprmtonr = parseInt(conv_slipnetprmtonr);
       console.log(real_slipnetprmtonr)

       var conv_slipsumor = slipsumor.replace(/,/g, "");
       console.log(conv_slipsumor)
       var real_slipsumor = parseInt(conv_slipsumor);
       console.log(real_slipsumor)
       
       //ajaxfilefunction(e);

       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/fe-slip/endorsementstore')}}",
           type:"POST",
           data:{
               code_ms:code_ms,
               slipnumber:slipnumber,
               slipdatetransfer:slipdatetransfer,
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
               sliptotalsum:real_sliptotalsum,
               sliptype:sliptype,
               slippct:slippct,
               sliptotalsumpct:real_sliptotalsumpct,
               slipipfrom:slipipfrom,
               slipipto:slipipto,
               sliprpfrom:sliprpfrom,
               sliprpto:sliprpto,
               proportional:proportional,
               sliplayerproportional:sliplayerproportional,
               sliprate:sliprate,
               slipvbroker:slipvbroker,
               slipshare:slipshare,
               slipsumshare:real_slipsumshare,
               slipbasicpremium:real_slipbasicpremium,
               slipgrossprmtonr:real_slipgrossprmtonr,
               slipcommission:slipcommission,
               slipsumcommission:real_slipsumcommission,
               slipnetprmtonr:real_slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipsumor:real_slipsumor,
               wpc:wpc
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Slip Insert Success", "success")
                console.log(response)

                
                $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.number+'">'+response.number+'</td><td data-name="'+response.cedingbroker+'">"'+response.cedingbroker+'"</td><td data-name="'+response.ceding+'">'+response.ceding+'</td><td data-name="'+response.slipstatus+'">"'+slipstatus+'"</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+response.id+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#updatemodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#endorsementmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                    +'</a><td></td></tr>');


                $('#slipnumberendorsement').val(response.number);

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Slip Insert Error", "Insert Error");
           }
       });
        


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
        
        var insurance_period_from2 = $('#slipipfrom').val();
        var insurance_period_to2 = $('#slipipto').val();
        var days=daysBetween(insurance_period_from2, insurance_period_to2);
        var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
        var constday = days.toString() + "/365";
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(days)
        console.log(constday)
        console.log(parseFloat(sum))
        
        $('#slipdaytotal').val(constday);
        $('#sliptotalsumdate').val(parseFloat(sum));
        // document.getElementById("daytotal").innerHTML = "Total Days :"+days;
    });

    $('#slipipfromupdate').change(function(){
        $('#sliprpfromupdate').val($(this).val());
    });

    $('#slipiptoupdate').change(function(){
        $('#sliprptoupdate').val($(this).val());

        var insurance_period_from2 = $('#slipipfrom').val();
        var insurance_period_to2 = $('#slipipto').val();
        var days=daysBetween(insurance_period_from2, insurance_period_to2);
        var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
        var constday = days.toString() + "/365";
        $('sliptotalsumdateupdate').val(sum);

        $('slipdaytotalupdate').val(constday);
        // document.getElementById("daytotalupdate").innerHTML = "Total Days :"+days;
    });

    $('#slipipfromendorsement').change(function(){
        $('#sliprpfromendorsement').val($(this).val());
    });

    $('#slipiptoendorsement').change(function(){
        $('#sliprptoendorsement').val($(this).val());

        var insurance_period_from2 = $('#slipipfrom').val();
        var insurance_period_to2 = $('#slipipto').val();
        var days=daysBetween(insurance_period_from2, insurance_period_to2);
        var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
        var constday = days.toString() + "/365";

        $('sliptotalsumdateendorsement').val(sum);

        $('slipdaytotalendorsement').val(constday);
        // document.getElementById("daytotalendorsement").innerHTML = "Total Days :"+days;
    });


</script>

<script type="text/javascript">
    $('#slipbld_const').change(function(){
        var bld = $(this).val();
        var ocp_id = $('#slipoccupacy').val();
        // alert(bld);
        console.log(bld)
        console.log(ocp_id)

        if(ocp_id){
            $.ajax({
                type:"GET",
                url:"{{url('get-building-rate')}}",
                data: {
                building: bld,
                occupacy_id:ocp_id
                },
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(res){  
                    console.log(res)      
                    console.log(bld)      
                    if(res.rate_batas_atas_building_class_1 && res.rate_batas_bawah_building_class_1){
                        if(res.rate_batas_atas_building_class_1 != null){
                            $("#slipbcua").val(res.rate_batas_atas_building_class_1);
                        }else{
                            $("#slipbcua").val(parseInt('0'));
                        }
                        
                        if(res.rate_batas_bawah_building_class_1 != null){
                            $("#slipbcla").val(res.rate_batas_bawah_building_class_1);
                        }else{
                            $("#slipbcla").val(parseInt('0'));
                        }
                        

                    }
                    else if(res.rate_batas_atas_building_class_2 && res.rate_batas_bawah_building_class_2){
                        if(res.rate_batas_atas_building_class_2 != null){
                            $("#slipbcua").val(res.rate_batas_atas_building_class_2);
                        }else{
                            $("#slipbcua").val(parseInt('0'));
                        }
                        
                        if(res.rate_batas_bawah_building_class_2 != null){
                            $("#slipbcla").val(res.rate_batas_bawah_building_class_2);
                        }else{
                            $("#slipbcla").val(parseInt('0'));
                        }
                        
                    }
                    else if(res.rate_batas_atas_building_class_3 && res.rate_batas_bawah_building_class_3){
                        if(res.rate_batas_atas_building_class_3 != null){
                            $("#slipbcua").val(res.rate_batas_atas_building_class_3); 
                        }else{
                            $("#slipbcua").val( parseInt('0'));
                        }
                        
                        if(res.rate_batas_bawah_building_class_3 != null){
                            $("#slipbcla").val(res.rate_batas_bawah_building_class_3);
                        }else{
                            $("#slipbcla").val( parseInt('0'));
                        }
                        
                        
                    }else{
                        if(res.rate_batas_atas_building_class_1){
                            $("#slipbcua").val(res.rate_batas_atas_building_class_1); 
                            $("#slipbcla").val( parseInt('0'));
                        }else if(res.rate_batas_bawah_building_class_1){
                            $("#slipbcla").val(res.rate_batas_bawah_building_class_1); 
                            $("#slipbcua").val( parseInt('0'));
                        }else if(res.rate_batas_atas_building_class_2){
                            $("#slipbcua").val(res.rate_batas_atas_building_class_2); 
                            $("#slipbcla").val( parseInt('0'));
                        }else if(res.rate_batas_bawah_building_class_2){
                            $("#slipbcla").val(res.rate_batas_bawah_building_class_2); 
                            $("#slipbcua").val( parseInt('0'));
                        }else if(res.rate_batas_atas_building_class_3){
                            $("#slipbcua").val(res.rate_batas_atas_building_class_3); 
                            $("#slipbcla").val( parseInt('0'));
                        }else if(res.rate_batas_bawah_building_class_3){
                            $("#slipbcla").val(res.rate_batas_bawah_building_class_3); 
                            $("#slipbcua").val( parseInt('0'));
                        }
                    }
                }
            });
        }else{
            swal("Error!", "Please choose occupacy first", "Get Building Rate Error");
        }   
    });

    $('#slipbld_constupdate').change(function(){
        var bld = $(this).val();
        var ocp_id = $('#slipoccupacyupdate').val();
        // alert(bld);
        console.log(bld)
        console.log(ocp_id)

        if(ocp_id){
            $.ajax({
                type:"GET",
                url:"{{url('get-building-rate')}}",
                data: {
                building: bld,
                occupacy_id:ocp_id
                },
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(res){  
                    console.log(res)      
                    console.log(bld)      
                    if(res.rate_batas_atas_building_class_1){
                        if(res.rate_batas_atas_building_class_1 == ' ' || res.rate_batas_atas_building_class_1 == 0.000){
                            $("#slipbcuaupdate").val( parseInt('0'));
                        }else{
                            $("#slipbcuaupdate").val(res.rate_batas_atas_building_class_1);
                        }
                        
                        if(res.rate_batas_bawah_building_class_1 == ' ' || res.rate_batas_bawah_building_class_1 == 0.000){
                            $("#slipbclaupdate").val( parseInt('0'));
                        }else{
                            $("#slipbclaupdate").val(res.rate_batas_bawah_building_class_1);
                        }
                        

                    }
                    else if(res.rate_batas_atas_building_class_2){
                        if(res.rate_batas_atas_building_class_2 == ' ' || res.rate_batas_atas_building_class_2 == 0.000){
                            $("#slipbcuaupdate").val( parseInt('0'));
                        }else{
                            $("#slipbcuaupdate").val(res.rate_batas_atas_building_class_2);
                        }
                        
                        if(res.rate_batas_bawah_building_class_2 == ' ' || res.rate_batas_bawah_building_class_2 == 0.000){
                            $("#slipbclaupdate").val( parseInt('0'));
                        }else{
                            $("#slipbclaupdate").val(res.rate_batas_bawah_building_class_2);
                        }
                        
                    }
                    else if(res.rate_batas_atas_building_class_3){
                        if(res.rate_batas_atas_building_class_3 == ' ' || res.rate_batas_atas_building_class_3 == 0.000){
                            $("#slipbcuaupdate").val( parseInt('0'));
                        }else{
                            $("#slipbcuaupdate").val(res.rate_batas_atas_building_class_3);
                        }
                        
                        if(res.rate_batas_bawah_building_class_3 == ' ' || res.rate_batas_bawah_building_class_3 == 0.000){
                            $("#slipbclaupdate").val( parseInt('0'));
                        }else{
                            $("#slipbclaupdate").val(res.rate_batas_bawah_building_class_3);
                        }
                        
                        
                    }
                }
            });
        }else{
            swal("Error!", "Please choose occupacy first", "Get Building Rate Error");
        }   
    });

    $('#slipbld_constendorsement').change(function(){
        var bld = $(this).val();
        var ocp_id = $('#slipoccupacyendorsement').val();
        // alert(bld);
        console.log(bld)
        console.log(ocp_id)

        if(ocp_id){
            $.ajax({
                type:"GET",
                url:"{{url('get-building-rate')}}",
                data: {
                building: bld,
                occupacy_id:ocp_id
                },
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(res){  
                    console.log(res)      
                    console.log(bld)      
                    if(res.rate_batas_atas_building_class_1){
                        if(res.rate_batas_atas_building_class_1 == ' ' || res.rate_batas_atas_building_class_1 == 0.000){
                            $("#slipbcuaendorsement").val( parseInt('0'));
                        }else{
                            $("#slipbcuaendorsement").val(res.rate_batas_atas_building_class_1);
                        }
                        
                        if(res.rate_batas_bawah_building_class_1 == ' ' || res.rate_batas_bawah_building_class_1 == 0.000){
                            $("#slipbclaendorsement").val( parseInt('0'));
                        }else{
                            $("#slipbclaendorsement").val(res.rate_batas_bawah_building_class_1);
                        }
                        

                    }
                    else if(res.rate_batas_atas_building_class_2){
                        if(res.rate_batas_atas_building_class_2 == ' ' || res.rate_batas_atas_building_class_2 == 0.000){
                            $("#slipbcuaendorsement").val( parseInt('0'));
                        }else{
                            $("#slipbcuaendorsement").val(res.rate_batas_atas_building_class_2);
                        }
                        
                        if(res.rate_batas_bawah_building_class_2 == ' ' || res.rate_batas_bawah_building_class_2 == 0.000){
                            $("#slipbclaendorsement").val( parseInt('0'));
                        }else{
                            $("#slipbclaendorsement").val(res.rate_batas_bawah_building_class_2);
                        }
                        
                    }
                    else if(res.rate_batas_atas_building_class_3){
                        if(res.rate_batas_atas_building_class_3 == ' ' || res.rate_batas_atas_building_class_3 == 0.000){
                            $("#slipbcuaendorsement").val( parseInt('0'));
                        }else{
                            $("#slipbcuaendorsement").val(res.rate_batas_atas_building_class_3);
                        }
                        
                        if(res.rate_batas_bawah_building_class_3 == ' ' || res.rate_batas_bawah_building_class_3 == 0.000){
                            $("#slipbclaendorsement").val( parseInt('0'));
                        }else{
                            $("#slipbclaendorsement").val(res.rate_batas_bawah_building_class_3);
                        }
                        
                        
                    }
                }
            });
        }else{
            swal("Error!", "Please choose occupacy first", "Get Building Rate Error");
        }   
    });

</script>

<script type="text/javascript">
    $('#slipcedingbroker').change(function(){
        var cedbrok = $(this).val();
        var insuredid = $('#insuredIDtxt').val();  
        //alert(countryID);
        if(cedbrok){
        $.ajax({
            type:"GET",
            url:"{{url('get-ceding-detail')}}?ceding_id="+cedbrok+"&insured_id="+insuredid,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res.type == 4){
                    // alert(res.name);
                    // $("#slipceding option[value='placeholder']").removeAttr("selected");
                    // $("#slipceding option[value='placeholder']").prop("selected", false);
                    $("#slipceding option").remove();


                    $("#slipceding").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');
                    // $("#slipceding").append('<option value="'value.id'" selected>' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    // $.each(res,function(key,value){
                    //     alert(value.name);
                        
                    // });

                    var ceding_curr = $('#slipceding').val();
                    var totalsum = $("#sliptotalsum").val();
                        if(res.amountlist > 0)
                        {
                            console.log('sum amount ' + res.sumamount)
                            var sum = res.sumamount;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log('convert sum ' + real_sum)
                            // var total_num = 0;
                            // var sum = isNaN(total_num + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total_num + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            $("#sliptotalsum").val(real_sum);
                            // // $("#msishareto").val(real_sum);
                            // $("#fesharefrom").val(real_sum);
                            // // $("#feshareto").val(real_sum);
                        }
                        else
                        {
                            console.log('hasilnya ' + res)
                            // var conv_total = totalsum.replace(/,/g, "");
                            // console.log('conv total : ' + conv_total)
                            // var real_total = parseInt(conv_total);
                            // console.log('real total : ' + real_total)
                            // var total =  parseFloat(real_total);
                            // console.log(' total : ' + total)
                            // var sum = isNaN(total + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            // $("#sliptotalsum").val(real_sum);
                            // // $("#fesharefrom").val(real_sum);
                            // $("#feshareto").val(real_sum);
                        }
                    
                
                }else{
                    $("#slipceding option").remove();

                    $.each(res,function(key,value){
                        // alert(value.name);
                    

                    $("#slipceding").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');
                        // $("#slipceding").append('<option value="'value.id'">' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    });
                }
            }
        });
        }else{
            swal("Error!", "Please choose Ceding/Broker first", "Get Ceding Error");
        }   
    });

    $('#slipceding').change(function(){
        var ceding = $(this).val();
        var insuredid = $('#insuredIDtxt').val();  
        //alert(countryID);
        if(ceding){
        $.ajax({
            type:"GET",
            url:"{{url('get-ceding-detail')}}?ceding_id="+ceding+"&insured_id="+insuredid,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res.type == 4){
                    // alert(res.name);
                    // $("#slipceding option[value='placeholder']").removeAttr("selected");
                    // $("#slipceding option[value='placeholder']").prop("selected", false);
                    $("#slipceding option").remove();


                    $("#slipceding").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');
                    // $("#slipceding").append('<option value="'value.id'" selected>' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    // $.each(res,function(key,value){
                    //     alert(value.name);
                        
                    // });

                    var ceding_curr = $('#slipceding').val();
                    var totalsum = $("#sliptotalsum").val();
                        if(res.amountlist > 0)
                        {
                            console.log('sum amount ' + res.sumamount)
                            var sum = res.sumamount;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log('convert sum ' + real_sum)
                            // var total_num = 0;
                            // var sum = isNaN(total_num + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total_num + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            $("#sliptotalsum").val(real_sum);
                            // // $("#msishareto").val(real_sum);
                            // $("#fesharefrom").val(real_sum);
                            // // $("#feshareto").val(real_sum);
                        }
                        else
                        {
                            console.log('hasilnya ' + res)
                            // var conv_total = totalsum.replace(/,/g, "");
                            // console.log('conv total : ' + conv_total)
                            // var real_total = parseInt(conv_total);
                            // console.log('real total : ' + real_total)
                            // var total =  parseFloat(real_total);
                            // console.log(' total : ' + total)
                            // var sum = isNaN(total + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            // $("#sliptotalsum").val(real_sum);
                            // // $("#fesharefrom").val(real_sum);
                            // $("#feshareto").val(real_sum);
                        }
                    
                
                }else{
                    $("#slipceding option").remove();

                    $.each(res,function(key,value){
                        // alert(value.name);
                    

                    $("#slipceding").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');
                        // $("#slipceding").append('<option value="'value.id'">' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    });
                }
            }
        });
        }else{
            swal("Error!", "Please choose Ceding/Broker first", "Get Ceding Error");
        }   
    });
</script>

<script type="text/javascript">
    $('#slipcedingbrokerupdate').change(function(){
        var cedbrok = $(this).val();
        var insuredid = $('#insuredIDtxtupdate').val();  
        //alert(countryID);
        if(cedbrok){
        $.ajax({
            type:"GET",
            url:"{{url('get-ceding-detail')}}?ceding_id="+cedbrok+"&insured_id="+insuredid,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res.type == 4){
                    // alert(res.name);
                    // $("#slipceding option[value='placeholder']").removeAttr("selected");
                    // $("#slipceding option[value='placeholder']").prop("selected", false);
                    $("#slipcedingupdate option").remove();


                    $("#slipcedingupdate").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');
                    // $("#slipceding").append('<option value="'value.id'" selected>' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    // $.each(res,function(key,value){
                    //     alert(value.name);
                        
                    // });

                    var ceding_curr = $('#slipcedingupdate').val();
                    var totalsum = $("#sliptotalsumupdate").val();
                        if(res.amountlist > 0)
                        {
                            console.log('sum amount ' + res.sumamount)
                            var sum = res.sumamount;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log('convert sum ' + real_sum)
                            // var total_num = 0;
                            // var sum = isNaN(total_num + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total_num + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            $("#sliptotalsumupdate").val(real_sum);
                            // // $("#msishareto").val(real_sum);
                            // $("#fesharefrom").val(real_sum);
                            // // $("#feshareto").val(real_sum);
                        }
                        else
                        {
                            console.log('hasilnya ' + res)
                            // var conv_total = totalsum.replace(/,/g, "");
                            // console.log('conv total : ' + conv_total)
                            // var real_total = parseInt(conv_total);
                            // console.log('real total : ' + real_total)
                            // var total =  parseFloat(real_total);
                            // console.log(' total : ' + total)
                            // var sum = isNaN(total + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            // $("#sliptotalsum").val(real_sum);
                            // // $("#fesharefrom").val(real_sum);
                            // $("#feshareto").val(real_sum);
                        }
                    
                
                }else{
                    $("#slipcedingupdate option").remove();

                    $.each(res,function(key,value){
                        // alert(value.name);
                    

                    $("#slipcedingupdate").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');
                        // $("#slipceding").append('<option value="'value.id'">' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    });
                }
            }
        });
        }else{
            swal("Error!", "Please choose Ceding/Broker first", "Get Ceding Error");
        }   
    });

    $('#slipcedingupdate').change(function(){
        var ceding = $(this).val();
        var insuredid = $('#insuredIDtxtupdate').val();  
        //alert(countryID);
        if(ceding){
        $.ajax({
            type:"GET",
            url:"{{url('get-ceding-detail')}}?ceding_id="+ceding+"&insured_id="+insuredid,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res.type == 4){
                    // alert(res.name);
                    // $("#slipceding option[value='placeholder']").removeAttr("selected");
                    // $("#slipceding option[value='placeholder']").prop("selected", false);
                    $("#slipcedingupdate option").remove();


                    $("#slipcedingupdate").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');
                    // $("#slipceding").append('<option value="'value.id'" selected>' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    // $.each(res,function(key,value){
                    //     alert(value.name);
                        
                    // });

                    var ceding_curr = $('#slipcedingupdate').val();
                    var totalsum = $("#sliptotalsumupdate").val();
                        if(res.amountlist > 0)
                        {
                            console.log('sum amount ' + res.sumamount)
                            var sum = res.sumamount;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log('convert sum ' + real_sum)
                            // var total_num = 0;
                            // var sum = isNaN(total_num + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total_num + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            $("#sliptotalsumupdate").val(real_sum);
                            // // $("#msishareto").val(real_sum);
                            // $("#fesharefrom").val(real_sum);
                            // // $("#feshareto").val(real_sum);
                        }
                        else
                        {
                            console.log('hasilnya ' + res)
                            // var conv_total = totalsum.replace(/,/g, "");
                            // console.log('conv total : ' + conv_total)
                            // var real_total = parseInt(conv_total);
                            // console.log('real total : ' + real_total)
                            // var total =  parseFloat(real_total);
                            // console.log(' total : ' + total)
                            // var sum = isNaN(total + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            // $("#sliptotalsum").val(real_sum);
                            // // $("#fesharefrom").val(real_sum);
                            // $("#feshareto").val(real_sum);
                        }
                    
                
                }else{
                    $("#slipcedingupdate option").remove();

                    $.each(res,function(key,value){
                        // alert(value.name);
                    

                    $("#slipcedingupdate").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');
                        // $("#slipceding").append('<option value="'value.id'">' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    });
                }
            }
        });
        }else{
            swal("Error!", "Please choose Ceding/Broker first", "Get Ceding Error");
        }   
    });
</script>

<script type="text/javascript">
    $('#slipcedingbrokerendorsement').change(function(){
        var cedbrok = $(this).val();
        var insuredid = $('#insuredIDtxtendorsement').val();  
        //alert(countryID);
        if(cedbrok){
        $.ajax({
            type:"GET",
            url:"{{url('get-ceding-detail')}}?ceding_id="+cedbrok+"&insured_id="+insuredid,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res.type == 4){
                    // alert(res.name);
                    // $("#slipceding option[value='placeholder']").removeAttr("selected");
                    // $("#slipceding option[value='placeholder']").prop("selected", false);
                    $("#slipcedingendorsement option").remove();


                    $("#slipcedingendorsement").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');
                    // $("#slipceding").append('<option value="'value.id'" selected>' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    // $.each(res,function(key,value){
                    //     alert(value.name);
                        
                    // });

                    var ceding_curr = $('#slipcedingendorsement').val();
                    var totalsum = $("#sliptotalsumendorsement").val();
                        if(res.amountlist > 0)
                        {
                            console.log('sum amount ' + res.sumamount)
                            var sum = res.sumamount;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log('convert sum ' + real_sum)
                            // var total_num = 0;
                            // var sum = isNaN(total_num + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total_num + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            $("#sliptotalsumendorsement").val(real_sum);
                            // // $("#msishareto").val(real_sum);
                            // $("#fesharefrom").val(real_sum);
                            // // $("#feshareto").val(real_sum);
                        }
                        else
                        {
                            console.log('hasilnya ' + res)
                            // var conv_total = totalsum.replace(/,/g, "");
                            // console.log('conv total : ' + conv_total)
                            // var real_total = parseInt(conv_total);
                            // console.log('real total : ' + real_total)
                            // var total =  parseFloat(real_total);
                            // console.log(' total : ' + total)
                            // var sum = isNaN(total + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            // $("#sliptotalsum").val(real_sum);
                            // // $("#fesharefrom").val(real_sum);
                            // $("#feshareto").val(real_sum);
                        }
                    
                
                }else{
                    $("#slipcedingendorsement option").remove();

                    $.each(res,function(key,value){
                        // alert(value.name);
                    

                    $("#slipcedingendorsement").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');
                        // $("#slipceding").append('<option value="'value.id'">' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    });
                }
            }
        });
        }else{
            swal("Error!", "Please choose Ceding/Broker first", "Get Ceding Error");
        }   
    });

    $('#slipcedingendorsement').change(function(){
        var ceding = $(this).val();
        var insuredid = $('#insuredIDtxtendorsement').val();  
        //alert(countryID);
        if(ceding){
        $.ajax({
            type:"GET",
            url:"{{url('get-ceding-detail')}}?ceding_id="+ceding+"&insured_id="+insuredid,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res.type == 4){
                    // alert(res.name);
                    // $("#slipceding option[value='placeholder']").removeAttr("selected");
                    // $("#slipceding option[value='placeholder']").prop("selected", false);
                    $("#slipcedingendorsement option").remove();


                    $("#slipcedingendorsement").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');
                    // $("#slipceding").append('<option value="'value.id'" selected>' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    // $.each(res,function(key,value){
                    //     alert(value.name);
                        
                    // });

                    var ceding_curr = $('#slipcedingendorsement').val();
                    var totalsum = $("#sliptotalsumendorsement").val();
                        if(res.amountlist > 0)
                        {
                            console.log('sum amount ' + res.sumamount)
                            var sum = res.sumamount;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log('convert sum ' + real_sum)
                            // var total_num = 0;
                            // var sum = isNaN(total_num + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total_num + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            $("#sliptotalsumendorsement").val(real_sum);
                            // // $("#msishareto").val(real_sum);
                            // $("#fesharefrom").val(real_sum);
                            // // $("#feshareto").val(real_sum);
                        }
                        else
                        {
                            console.log('hasilnya ' + res)
                            // var conv_total = totalsum.replace(/,/g, "");
                            // console.log('conv total : ' + conv_total)
                            // var real_total = parseInt(conv_total);
                            // console.log('real total : ' + real_total)
                            // var total =  parseFloat(real_total);
                            // console.log(' total : ' + total)
                            // var sum = isNaN(total + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total + parseFloat(response.amountlocation)) ;
                            // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // console.log(' sum : ' + sum)
                            // console.log(' real sum : ' + real_sum)
                            // $("#sliptotalsum").val(real_sum);
                            // // $("#fesharefrom").val(real_sum);
                            // $("#feshareto").val(real_sum);
                        }
                    
                
                }else{
                    $("#slipcedingendorsement option").remove();

                    $.each(res,function(key,value){
                        // alert(value.name);
                    

                    $("#slipcedingendorsement").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');
                        // $("#slipceding").append('<option value="'value.id'">' + value.type + ' - ' + value.code + ' - ' + value.name + '</option>');
                    });
                }
            }
        });
        }else{
            swal("Error!", "Please choose Ceding/Broker first", "Get Ceding Error");
        }   
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
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function() { 
        
        
        
        $('.uang').mask("#,##0.00", {reverse: true});
        console.log($('#feshareto').val())

        $('input.amount').val(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;
                console.log(event.which)
                console.log($(this).val())
                // format number
                $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        $("#btnaddlayer").attr('hidden','true');
        $("#sliplayerproportional").attr('hidden','true');
        $("#labelnonprop").attr('hidden','true');
        $("#labelnp").attr('hidden','true');
        
        
        $("#btn-success2").click(function(){ 
        var html = $(".clone2").html();
        $(".increment2").after(html);
        });

        $("body").on("click","#btn-danger2",function(){ 
        $(this).parents("#control-group2").remove();
        });


        $( "#employee_search" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{route('customer.getCostumers')}}",
            type: 'post',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               search: request.term
            },
            success: function( data ) {
               response( data );
              // alert(data[0].label);
            },
            fail : function ( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
          });
        },
        select: function (event, ui) {
           // Set selection
           //alert(ui.item.label);

           $('#employee_search').val(ui.item.label); // display the selected text
           //$('#employeeid').val(ui.item.value); // save selected id to input
           return false;
        }
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

    $('#switch-proportionaldetail').change(function(){
        var attr = $("#btnaddlayerdetail").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#btnaddlayerdetail").removeAttr('hidden');
            $("#sliplayerproportionaldetail").removeAttr('hidden');
            $("#labelnonpropdetail").removeAttr('hidden');
        }
        else{
            $("#btnaddlayerdetail").attr('hidden','true');
            $("#sliplayerproportionaldetail").attr('hidden','true');
            $("#labelnonpropdetail").attr('hidden','true');
        }
        
    });

    $('#switch-proportionalupdate').change(function(){
        var attr = $("#btnaddlayerupdate").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#btnaddlayerupdate").removeAttr('hidden');
            $("#sliplayerproportionalupdate").removeAttr('hidden');
            $("#labelnonpropupdate").removeAttr('hidden');
        }
        else{
            $("#btnaddlayerupdate").attr('hidden','true');
            $("#sliplayerproportionalupdate").attr('hidden','true');
            $("#labelnonpropupdate").attr('hidden','true');
        }
        
    });

    $('#switch-proportionalendorsement').change(function(){
        var attr = $("#btnaddlayerendorsement").attr('hidden');
        if(typeof attr !== typeof undefined && attr !== false){
            $("#btnaddlayerendorsement").removeAttr('hidden');
            $("#sliplayerproportionalendorsement").removeAttr('hidden');
            $("#labelnonpropendorsement").removeAttr('hidden');
        }
        else{
            $("#btnaddlayerendorsement").attr('hidden','true');
            $("#sliplayerproportionalendorsement").attr('hidden','true');
            $("#labelnonpropendorsement").attr('hidden','true');
        }
        
    });

    $('#sliprb').change(function(){
        var attr = $("#tabretro").attr('hidden');
        var valdata =  $('#sliprb').val();
        //alert(valdata);
        if((typeof attr !== typeof undefined && attr !== false) || valdata=="AF"){
            // $("#retrocessionPanel").removeAttr('hidden');
            $("#tabretro").removeAttr('hidden');
        }
        else{
            // $("#retrocessionPanel").attr('hidden','true');
            $("#tabretro").attr('hidden','true');
        }
    });

    $('#sliprbdetail').change(function(){
        var attr = $("#tabretrodetail").attr('hidden');
        var valdata =  $('#sliprbdetail').val();

        if((typeof attr !== typeof undefined && attr !== false ) || valdata=="AF"){
            // $("#retrocessionPanel").removeAttr('hidden');
            $("#tabretrodetail").removeAttr('hidden');
        }
        else{
            // $("#retrocessionPanel").attr('hidden','true');
            $("#tabretrodetail").attr('hidden','true');
        }
    });

    $('#sliprbupdate').change(function(){
        var attr = $("#tabretroupdate").attr('hidden');
        var valdata =  $('#sliprbupdate').val();

        if((typeof attr !== typeof undefined && attr !== false ) || valdata=="AF"){
            // $("#retrocessionPanel").removeAttr('hidden');
            $("#tabretroupdate").removeAttr('hidden');
        }
        else{
            // $("#retrocessionPanel").attr('hidden','true');
            $("#tabretroupdate").attr('hidden','true');
        }
    });

    $('#sliprbendorsement').change(function(){
        var attr = $("#tabretroendorsement").attr('hidden');
        var valdata =  $('#sliprbendorsement').val();

        if((typeof attr !== typeof undefined && attr !== false) || valdata=="AF"){
            // $("#retrocessionPanel").removeAttr('hidden');
            $("#tabretroendorsement").removeAttr('hidden');
        }
        else{
            // $("#retrocessionPanel").attr('hidden','true');
            $("#tabretroendorsement").attr('hidden','true');
        }
    });
</script>

<script type='text/javascript'>
    $('#country_location').change(function(){
        var countryID = $(this).val();  
        //alert(countryID);
        if(countryID){
        $.ajax({
            type:"GET",
            url:"{{url('get-state-lookup')}}?country_id="+countryID,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res){
                    $("#state_location").empty();
                    $("#state_location").append('<option selected disabled>Select States/Province</option>');
                    $.each(res,function(key,value){
                    $("#state_location").append('<option value="'+key+'">'+value+'</option>');
                    });
                
                }else{
                    $("#state_location").append('<option value="" selected disabled>get value error</option>');
                }
            }
        });
        }else{
        $("#state_location").append('<option value="" selected disabled>countryID null</option>');
        $("#city_location").empty();
        }   
    });

    $('#state_location').on('change',function(){
        var stateID = $(this).val();  
        //alert(stateID);
            if(stateID){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-city-lookup')}}?state_id="+stateID,
                    beforeSend: function() { $("body").addClass("loading");  },
                    complete: function() {  $("body").removeClass("loading"); },
                    success:function(res){        
                        if(res){
                            $("#city_location").empty();
                            $("#city_location").append('<option selected disabled>Select City</option>');
                            $.each(res,function(key,value){
                                $("#city_location").append('<option value="'+key+'">'+value+'</option>');
                            });
                        
                        }else{
                            $("#city_location").append('<option value="" selected disabled>get value error</option>');
                        }
                    }
                });
            }else{
                $("#city_location").append('<option value="" selected disabled>countryID null</option>');
                $("#address_location").empty();
            }
            
    });


    $('#city_location').on('change',function(){
        var cityID = $(this).val();  
        //alert(stateID);
            if(cityID){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-address-lookup')}}?city_id="+cityID,
                    beforeSend: function() { $("body").addClass("loading");  },
                    complete: function() {  $("body").removeClass("loading"); },
                    success:function(res){        
                        if(res){
                            $("#address_location").empty();
                            $("#address_location").append('<option selected disabled>Select Address</option>');
                            $.each(res,function(key,value){
                                $("#address_location").append('<option value="'+key+'">'+value+'</option>');
                            });
                        
                        }else{
                            $("#address_location").append('<option value="" selected disabled>get value error</option>');
                        }
                    }
                });
            }else{
                $("#address_location").append('<option value="" selected disabled>countryID null</option>');
                
            }
            
    });
</script>


<script type="text/javascript">

    //triggered when modal is about to be shown
    $('#addlocdetailmodaldata').on('show.bs.modal', function(e) {

         //get data-id attribute of the clicked element

        var codesl = $(e.relatedTarget).data('look-id');
        //alert(codesl);
        $('#insurednoloc').val(codesl);
    });

</script>


<script type='text/javascript'>
     $('#form-addlocation').submit(function(e){
        e.preventDefault();

        var lookupcode = $('#address_location').val();
        var insured_id = $('#insuredIDtxt').val();
        var token = $('input[name=_token]').val();
        
        var country = $('#country_location').val();
        var state = $('#state_location').val();
        var city = $('#city_location').val();        
        var adrress = $('#address_location').val();
        
        //var slipinterestid = $('#slipinterestlistlocation').val();
        //var cnno = $('#cnno').val();
        //var certno = $('#certno').val();
        //var refno = $('#refno').val();
        //var amountlocation = $('#amountlocation').val();
        
        //var conv_amount = amountlocation.replace(/,/g, "");
        //console.log(conv_amount)
        //var real_amount = parseInt(conv_amount);
        //console.log(real_amount)
        
        $.ajax({
            url:"{{ route('locationlist.store') }}",
            type:"POST",
            data:{
                lookupcode:lookupcode,
                country:country,
                state:state,
                city:city,
                adrress:adrress,
                insuredID:insured_id,
                _token:token
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
            console.log(response)
                    
                    //var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amountlocation);
                    
                    $('#locRiskTable > tbody:last-child').prepend('<tr id="sid'+response.id+'">'+
                                                    '<td>'+response.loc_code+'</td>'+
                                                    '<td>'+response.address+'<br>'+response.city_name+'<br>'+response.state_name+'<br>'+response.latitude+' , '+response.longtitude+'<br>'+ response.postal_code+'</td>'+
                                                    '<td>'+response.latitude+' , '+response.longtitude+'<br></td>'+
                                                    '<td>'+
                                                    '<a class="text-primary mr-3 float-right " data-toggle="modal" data-look-id="'+response.id+'" data-target="#addlocdetailmodaldata">'+
                                                        '<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addlocdetailmodaldata2">Add</button>'+
                                                    '</a>'+
                                                    '<a href="javascript:void(0)" onclick="deletelocationdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td>'+
                                                    '</tr>'+
                                                    
                                                    '<tr id="cid'+response.id+'">'+
                                                        '<td></td>'+
                                                        '<td colspan="3">'+
                                                            '<table id="tcid'+response.id+'" width="600" class="table table-bordered table-striped">'+
                                                                '<thead>'+
                                                                '<tr>'+
                                                                '<th>Interest Insured</th>'+
                                                                '<th>Ceding/Broker</th>'+
                                                                '<th>CN No</th>'+
                                                                '<th>Cert No</th>'+
                                                                '<th>Ref No</th>'+
                                                                '<th>amount</th>'+
                                                                '<th>Action</th>'+
                                                                '</tr>'+
                                                                '</thead>'+
                                                                '<tbody id="tbcid'+response.id+'">'+
                                                                '</tbody>'+
                                                            '</table>'+
                                                        '</td>'+
                                                    '</tr>');
                                                    
                    
                    $('#addlocation').modal('toggle');
                    $('#slipamount').val('');
                    $('#slipinterestlist').val('');
                    
                    
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
                console.log(response);
                
                $('#sid'+id).remove();
                $('#cid'+id).remove();

                //var total =  parseFloat($("#sliptotalsum").val());
                //console.log(total)
                //var conv_total = total.replace(/,/g, "");
                //console.log(conv_total)
                //var real_total = parseInt(conv_total);
                //console.log(real_total)
                //var sum = isNaN(real_total - parseFloat(response.amountlocation)) ? 0 :(real_total - parseFloat(response.amountlocation)) ;
                //console.log(sum)
                //var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                //$("#sliptotalsum").val(real_sum);
                //$("#feshareto").val(real_sum);

            }
        });
    }
</script>



<script type='text/javascript'>
     $('#form-addlocationdetail').submit(function(e){
        e.preventDefault();

        var insurednoloc = $('#insurednoloc').val();
        var token = $('input[name=_token]').val();
        
        var slipinterestid = $('#slipinterestlistlocation').val();
        var cnno = $('#cnno').val();
        var certno = $('#certno').val();
        var ceding_id = $('#ceding_id').val();
        var refno = $('#refno').val();
        var amountlocation = $('#amountlocation').val();

        var conv_amount = amountlocation.replace(/,/g, "");
        console.log(conv_amount)
        var real_amount = parseInt(conv_amount);
        console.log(real_amount)
        

        $.ajax({
            url:"{{ route('locationlistdetail.store') }}",
            type:"POST",
            data:{
                slipinterestid:slipinterestid,
                cnno:cnno,
                certno:certno,
                refno:refno,
                ceding_id:ceding_id,
                amountlocation:real_amount,
                insurednoloc:insurednoloc,
                _token:token
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
            console.log(response)
                    
                    var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amountlocation);
                    
                    $('#tcid'+insurednoloc+' > tbody:last-child').prepend('<tr id="riskdetailsid'+response.id+'">'+
                                                    '<td>'+response.interest_name+'</td>'+
                                                    '<td>'+response.cedingbroker+'</td>'+
                                                    '<td>'+response.cnno+'</td>'+
                                                    '<td>'+response.certno+'</td>'+
                                                    '<td>'+response.refno+'</td>'+
                                                    '<td>'+curr_amount+'</td>'+
                                                    '<td>'+
                                                    '<a href="javascript:void(0)" onclick="deletelocationriskdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td>'+
                                                    '</tr>');
                                                    
                    
                    $('#addlocdetailmodaldata').modal('toggle');
                    $('#slipamount').val('');
                    $('#slipinterestlist').val('');
                    
                    var totalnre = $('#feshareto').val();
                    
                    if(totalnre){
                        var conv_totalnre = totalnre.replace(/,/g, "");
                        var sumtotalnre = isNaN(parseFloat(conv_totalnre) + parseFloat(response.amountlocation)) ? (parseFloat(conv_totalnre) + parseFloat(response.amountlocation)) : (parseFloat(conv_totalnre) + parseFloat(response.amountlocation)) ;
                        var real_sumtotalnre = sumtotalnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        
                        console.log(conv_totalnre)
                        console.log(real_sumtotalnre)

                        $('#feshareto').val(real_sumtotalnre);
                    }
                    else{
                        var conv_totalnre = totalnre.replace(/,/g, "");
                        var sumtotalnre = isNaN(0 + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (0 + parseFloat(response.amountlocation)) ;
                        var real_sumtotalnre = sumtotalnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        
                        console.log(conv_totalnre)
                        console.log(real_sumtotalnre)

                        $('#feshareto').val(real_sumtotalnre)
                    }
                    

                    var ceding_curr = $('#slipceding').val();
                    var totalsum = $("#sliptotalsum").val();
                    if(response.cedinglocation == ceding_curr){
                        if(totalsum == '')
                        {
                            var total_num = 0;
                            var sum = isNaN(total_num + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total_num + parseFloat(response.amountlocation)) ;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            console.log(' sum : ' + sum)
                            console.log(' real sum : ' + real_sum)
                            $("#sliptotalsum").val(real_sum);
                            // $("#msishareto").val(real_sum);
                            // $("#fesharefrom").val(real_sum);
                            // $("#feshareto").val(real_sum);
                        }
                        else
                        {
                            
                            var conv_total = totalsum.replace(/,/g, "");
                            console.log('conv total : ' + conv_total)
                            var real_total = parseInt(conv_total);
                            console.log('real total : ' + real_total)
                            var total =  parseFloat(real_total);
                            console.log(' total : ' + total)
                            var sum = isNaN(total + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (total + parseFloat(response.amountlocation)) ;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            console.log(' sum : ' + sum)
                            console.log(' real sum : ' + real_sum)
                            $("#sliptotalsum").val(real_sum);
                            // $("#fesharefrom").val(real_sum);
                            // $("#feshareto").val(real_sum);
                        }
                    }else{
                        swal("Warning!", "TSI not increase because this ceding is not same with ceding in slip", "Tsi not increase");
                        
                    }
            }
        });

    });


    function deletelocationriskdetail(id){
        var token = $('input[name=_token]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-sliplocationdetail-list/'+id,
            type:"DELETE",
            data:{
                _token:token
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                console.log(response);
                
                $('#riskdetailsid'+id).remove();
                var ceding_curr = $('#slipceding').val();

                var totalnre = $('#feshareto').val();
                var conv_totalnre = totalnre.replace(/,/g, "");
                
                var sumtotalnre = isNaN(parseFloat(conv_totalnre) - parseFloat(response.amountlocation)) ? (parseFloat(conv_totalnre) - parseFloat(response.amountlocation)) : (parseFloat(conv_totalnre) - parseFloat(response.amountlocation)) ;
                var real_sumtotalnre = sumtotalnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                
                $('#feshareto').val(real_sumtotalnre);

                //$('#cid'+id).remove();
                if(response.cedinglocation == ceding_curr){
                    var total =  parseFloat($("#sliptotalsum").val());
                    console.log(total)
                    var conv_total = total.replace(/,/g, "");
                    console.log(conv_total)
                    var real_total = parseInt(conv_total);
                    console.log(real_total)
                    var sum = isNaN(real_total - parseFloat(response.amountlocation)) ? 0 :(real_total - parseFloat(response.amountlocation)) ;
                    console.log(sum)
                    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $("#sliptotalsum").val(real_sum);
                    // $("#feshareto").val(real_sum);
                }else{
                    swal("Warning!", "TSI not decrease because this ceding is not same with ceding in slip", "Tsi not decrease");
                    var total =  parseFloat($("#sliptotalsum").val());
                    console.log(total)
                    var conv_total = total.replace(/,/g, "");
                    console.log(conv_total)
                    var real_total = parseInt(conv_total);
                    console.log(real_total)
                    var sum = isNaN(real_total - parseFloat(response.amountlocation)) ? 0 :(real_total - parseFloat(response.amountlocation)) ;
                    console.log(sum)
                    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    // $("#sliptotalsum").val(real_sum);
                    // $("#feshareto").val(real_sum);
                }


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
       var token2 = $('input[name=_token]').val();

       var conv_amount = amount.replace(/,/g, "");
       console.log(conv_amount)
       var real_amount = parseInt(conv_amount);
       console.log(real_amount)
       
       $.ajax({
           url:"{{ route('interestlist.store') }}",
           type:"POST",
           data:{
               interest_insured:interest,
               slipamount:real_amount,
               id_slip:slip_id,
               _token:token2
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.description+'">'+response.description+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
               $('#slipamount').val('');
               $('#slipinterestlist').val('');
               var totalsum = $("#sliptotalsum").val();
               if(totalsum == '')
               {
                    var sum = isNaN(total + parseFloat(response.amount)) ? (0 + parseFloat(response.amount)) : (total + parseFloat(response.amount)) ;
                    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        console.log(' sum : ' + sum)
                        console.log(' real sum : ' + real_sum)
                    $("#sliptotalsum").val(real_sum);
                    $("#feshareto").val(real_sum);
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
                    $("#feshareto").val(real_sum);
               }
               

           }
       });

   });
</script>
    

<script type='text/javascript'>
    $('#addinterestinsuredupdate-btn').click(function(e){
       e.preventDefault();

       var interest = $('#slipinterestlistupdate').val();
       var amount = $('#slipamountupdate').val();
       var slip_id = $('#slipnumberupdate').val();
       var token2 = $('input[name=_token]').val();
       
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
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#interestInsuredTableupdate tbody').prepend('<tr id="iidupdate'+response.id+'" data-name="interestupdatevalue[]"><td data-name="'+response.description+'">'+response.description+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestupdate('+response.id+')">delete</a></td></tr>')
               $('#slipamountupdate').val('');
               $('#slipinterestlistupdate').val('');
               var total =  parseFloat($("#sliptotalsumupdate").val());
               var sum = isNaN(total + parseFloat(response.amount)) ? (0 + parseFloat(response.amount)) : (total + parseFloat(response.amount)) ;
               $("#sliptotalsumupdate").val(sum);
               $("#fesharetoupdate").val(sum);

               

           }
       });

   });
</script>


<script type='text/javascript'>
    $('#addinterestinsuredendorsement-btn').click(function(e){
       e.preventDefault();

       var interest = $('#slipinterestlistendorsement').val();
       var amount = $('#slipamountendorsement').val();
       var slip_id = $('#slipnumberendorsement').val();
       var token2 = $('input[name=_token]').val();
       
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
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#interestInsuredTableendorsement tbody').prepend('<tr id="iidendorsement'+response.id+'" data-name="interestendorsementvalue[]"><td data-name="'+response.description+'">'+response.description+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestendorsement('+response.id+')">delete</a></td></tr>')
               $('#slipamountendorsement').val('');
               $('#slipinterestlistendorsement').val('');
               var total =  parseFloat($("#sliptotalsumendorsement").val());
               var sum = isNaN(total + parseFloat(response.amount)) ? (0 + parseFloat(response.amount)) : (total + parseFloat(response.amount)) ;
               $("#sliptotalsumendorsement").val(sum);
               $("#fesharetoendorsement").val(sum);

               

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
                $("#feshareto").val(sum);
            }
        });
    }
</script>


<script type='text/javascript'>
    function deleteinterestupdate(id){
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
                
                $('#iidupdate'+id).remove();
                console.log(response);
                var total =  parseFloat($("#sliptotalsumupdate").val());
                var sum = isNaN(total - parseFloat(response.amount)) ? 0 :(total - parseFloat(response.amount)) ;
                $("#sliptotalsumupdate").val(sum);
                $("#fesharetoupdate").val(sum);
            }
        });
    }
</script>



<script type='text/javascript'>
    function deleteinterestendorsement(id){
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
                
                $('#iidendorsement'+id).remove();
                console.log(response);
                var total =  parseFloat($("#sliptotalsumendorsement").val());
                var sum = isNaN(total - parseFloat(response.amount)) ? 0 :(total - parseFloat(response.amount)) ;
                $("#sliptotalsumendorsement").val(sum);
                $("#fesharetoendorsement").val(sum);
            }
        });
    }
</script>


<script  type='text/javascript'>
     $('#slippct').keyup(function () {
        var pct =  parseFloat($(this).val())/100;
        
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));

        var sum = isNaN(pct * parseFloat(conv_tsi)) ? 0 :(pct * parseFloat(conv_tsi)).toFixed(3) ;
        console.log(sum)
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

     $('#slipshare').keyup(function () 
     {
        // var rateslip =  parseFloat($('#sliprate').val()) / 1000 ;
        var shareslip =  parseFloat($(this).val()) / 100 ;
        // var ourshare =  parseFloat($('#msisharev').val()) / 100 ;
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        // var mtsi = $("#msitsi").val();
        // var conv_mtsi = parseInt(mtsi.replace(/,/g, ""));
        var sumshare =isNaN( shareslip * parseFloat(conv_tsi)) ? 0 :( shareslip * parseFloat(conv_tsi)).toFixed(3) ;
        var real_sumshare = sumshare.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        // var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));
        // var orpercent = parseFloat($('#slipor').val()) / 100;
        // var sumor = isNaN(orpercent * parseFloat(conv_sumshare)) ? 0 :(orpercent * parseFloat(conv_sumshare));
        // var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // var sum = isNaN(rateslip * shareslip * parseFloat(conv_tsi)) ? 0 :(rateslip * shareslip * parseFloat(conv_tsi)) ;
        // var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // var sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;
        // var real_sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;

        // $('#slipgrossprmtonr').val(real_sum);
        // $('#msisharefrom').val(real_sumourshare);
        // $('#msisumsharev').val(sumourshare);
        
        // $('#slipsumor').val(real_sumor);

        $('#slipsumshare').val(real_sumshare);
        // $('#msishare').val(shareslip);
        // $('#msisharev').val(shareslip);
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
        var sum = isNaN((rateslip * parseFloat(conv_tsi)) * insurance) ? 0 :((rateslip * parseFloat(conv_tsi)) * insurance).toFixed(3) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        $('#slipbasicpremium').val(real_sum);
     });

     $('#slipshare').change(function () {
        var rateslip =  parseFloat($('#sliprate').val()) / 1000 ;
        var shareslip =  parseFloat($('#slipshare').val()) / 100 ;
        var nasionalreinsurance =  $('#fesharefrom').val();
        var totalnre =  $('#feshareto').val();
        var conv_totalnre =  parseInt(totalnre.replace(/,/g, ""));

        console.log('nre' + nasionalreinsurance)
        // console.log(conv_nasionalreinsurance)
        console.log('totalnre' + totalnre)
        console.log('convtotnre' + conv_totalnre)
        
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));

        var sumshare = $('#slipsumshare').val() ;
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

        var orpercent = parseFloat($('#slipor').val()) / 100;
       
        var sumor = isNaN(orpercent * parseFloat(conv_sumshare)) ? 0 :(orpercent * parseFloat(conv_sumshare)).toFixed(3);
        var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        var sum = isNaN(rateslip * shareslip * parseFloat(conv_tsi)) ? 0 :(rateslip * shareslip * parseFloat(conv_tsi)).toFixed(3);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        if(nasionalreinsurance){
            var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
            var sumnre = isNaN(parseFloat(conv_nasionalreinsurance) + parseFloat(conv_sumshare) ) ? 0 :(parseFloat(conv_nasionalreinsurance) + parseFloat(conv_sumshare)).toFixed(3) ;
            var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }else{
            var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
            var sumnre = isNaN(0 + parseFloat(conv_sumshare) ) ? 0 :(0 + parseFloat(conv_sumshare)).toFixed(3) ;
            var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        
        var sumourshare = isNaN((sumnre / conv_totalnre) * 100 ) ? 0 :((sumnre / conv_totalnre) * 100 ).toFixed(3) ;
       
       console.log('sumnre' + sumnre)
       console.log('realnre' + real_sumnre)
       console.log('sumourshare' + sumourshare)

        $('#slipgrossprmtonr').val(real_sum);
        $('#slipsumor').val(real_sumor);
        $('#feshare').val(parseFloat(sumourshare.replace(/,/g, ".")));
        $('#fesharefrom').val(real_sumnre);

        // $('#slipsumshare').val(real_sum);
        // $('#msisharev').val(shareslip);
         // $('#msisharefrom').val(real_sumourshare);
        // $('#msisumsharev').val(sumourshare);
     });

     $('#slipcommission').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = $("#slipgrossprmtonr").val();
        var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));
        
        var sum = isNaN(commision * parseFloat(conv_sumgrossprmtonr)) ? 0 :(commision * parseFloat(conv_sumgrossprmtonr)).toFixed(3);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        var sumnetprmtonr = isNaN( parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)) ? 0 :(parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)).toFixed(3);
        var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        $('#slipsumcommission').val(real_sum);
        $('#slipnetprmtonr').val(real_sumnetprmtonr);
    });

    $('#slipippercentage').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        
        var sumnetprtonr = $("#slipnetprmtonr").val();
        var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

        var sum = isNaN(percent *  parseFloat(conv_sumnetprtonr)) ? 0 :(percent *  parseFloat(conv_sumnetprtonr)).toFixed(3);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipipamount').val(real_sum);
    });

    $('#slipor').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = $("#slipsumshare").val();
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

        var sum = isNaN(percent * parseFloat(conv_sumshare)) ? 0 :(percent * parseFloat(conv_sumshare)).toFixed(3);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipsumor').val(real_sum);
    });

    $('#sliprppercentage').keyup(function () {
        var percentval =  parseFloat($(this).val()) / 100;
        var sumor = $('#slipsumor').val() ;
        var conv_sumor = parseInt(sumor.replace(/,/g, ""));
        var sumrpamount = isNaN(percentval * parseFloat(conv_sumor)) ? 0 :(percentval * parseFloat(conv_sumor)).toFixed(3);
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

        var sum = isNaN(pct * parseFloat(conv_tsi)) ? 0 :(pct * parseFloat(conv_tsi)).toFixed(3) ;
        console.log(sum)
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

     $('#slipshareupdate').keyup(function () 
     {
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
        var sum = isNaN((rateslip * parseFloat(conv_tsi)) * insurance) ? 0 :((rateslip * parseFloat(conv_tsi)) * insurance).toFixed(3) ;
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
        var sumor = isNaN(orpercent * parseFloat(conv_sumshare)) ? 0 :(orpercent * parseFloat(conv_sumshare)).toFixed(3);
        var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var sum = isNaN(rateslip * shareslip * parseFloat(conv_tsi)) ? 0 :(rateslip * shareslip * parseFloat(conv_tsi)).toFixed(3) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)).toFixed(3) ;
        var real_sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;

        $('#slipgrossprmtonrupdate').val(real_sum);
        $('#msisharefromupdate').val(real_sumourshare);
        $('#msisumsharevupdate').val(sumourshare);
        
        $('#slipsumorupdate').val(real_sumor);

        $('#slipsumshareupdate').val(real_sum);
        // $('#msishare').val(shareslip);
        $('#msisharevupdate').val(shareslip);
     });

     $('#slipcommissionupdate').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = $("#slipgrossprmtonrupdate").val();
        var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));
        
        var sum = isNaN(commision * parseFloat(conv_sumgrossprmtonr)) ? 0 :(commision * parseFloat(conv_sumgrossprmtonr)).toFixed(3);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        var sumnetprmtonr = isNaN( parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)) ? 0 :(parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)).toFixed(3);
        var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        $('#slipsumcommissionupdate').val(real_sum);
        $('#slipnetprmtonrupdate').val(real_sumnetprmtonr);
    });

    $('#slipippercentageupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        
        var sumnetprtonr = $("#slipnetprmtonrupdate").val();
        var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

        var sum = isNaN(percent *  parseFloat(conv_sumnetprtonr)) ? 0 :(percent *  parseFloat(conv_sumnetprtonr)).toFixed(3);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipipamountupdate').val(real_sum);
    });

    $('#sliporupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = $("#slipsumshareupdate").val();
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

        var sum = isNaN(percent * parseFloat(conv_sumshare)) ? 0 :(percent * parseFloat(conv_sumshare)).toFixed(3);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipsumorupdate').val(real_sum);
    });

    $('#sliprppercentageupdate').keyup(function () {
        var percentval =  parseFloat($(this).val()) / 100;
        var sumor = $('#slipsumor').val() ;
        var conv_sumor = parseInt(sumor.replace(/,/g, ""));
        var sumrpamount = isNaN(percentval * parseFloat(conv_sumor)) ? 0 :(percentval * parseFloat(conv_sumor)).toFixed(3);
        var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
        // $('#slipor').val(sumpercentor);
        $('#sliprpamountupdate').val(real_sumrpamount);
    });

    $('#sliprppercentageupdate').change(function () {
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#slipor').val());
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#sliporupdate').val(sumpercentor);
    });
</script>

<script  type='text/javascript'>
    $('#slippctendorsement').keyup(function () {
       var pct =  parseFloat($(this).val())/100;
       
       var tsi = $("#sliptotalsumendorsement").val();
       var conv_tsi = parseInt(tsi.replace(/,/g, ""));

       var sum = isNaN(pct * parseFloat(conv_tsi)) ? 0 :(pct * parseFloat(conv_tsi)).toFixed(3) ;
       console.log(sum)
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

    $('#slipshareendorsement').keyup(function () 
    {
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
       var sum = isNaN((rateslip * parseFloat(conv_tsi)) * insurance) ? 0 :((rateslip * parseFloat(conv_tsi)) * insurance).toFixed(3) ;
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
       var sumor = isNaN(orpercent * parseFloat(conv_sumshare)) ? 0 :(orpercent * parseFloat(conv_sumshare)).toFixed(3);
       var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       var sum = isNaN(rateslip * shareslip * parseFloat(conv_tsi)) ? 0 :(rateslip * shareslip * parseFloat(conv_tsi)).toFixed(3) ;
       var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       var sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)).toFixed(3) ;
       var real_sumourshare = isNaN(ourshare * parseFloat(conv_mtsi) ) ? 0 :(ourshare * parseFloat(conv_mtsi)) ;

       $('#slipgrossprmtonrendorsement').val(real_sum);
       $('#msisharefromendorsement').val(real_sumourshare);
       $('#msisumsharevendorsement').val(sumourshare);
       
       $('#slipsumorendorsement').val(real_sumor);

       $('#slipsumshareendorsement').val(real_sum);
       // $('#msishare').val(shareslip);
       $('#msisharevendorsement').val(shareslip);
    });

    $('#slipcommissionendorsement').keyup(function () {
       var commision =  parseFloat($(this).val()) / 100;
       var sumgrossprmtonr = $("#slipgrossprmtonrendorsement").val();
       var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));
       
       var sum = isNaN(commision * parseFloat(conv_sumgrossprmtonr)) ? 0 :(commision * parseFloat(conv_sumgrossprmtonr)).toFixed(3);
       var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


       var sumnetprmtonr = isNaN( parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)) ? 0 :(parseFloat(conv_sumgrossprmtonr) * (100/100 - commision)).toFixed(3);
       var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


       $('#slipsumcommissionendorsement').val(real_sum);
       $('#slipnetprmtonrendorsement').val(real_sumnetprmtonr);
   });

   $('#slipippercentageendorsement').keyup(function () {
       var percent =  parseFloat($(this).val()) / 100;
       
       var sumnetprtonr = $("#slipnetprmtonrendorsement").val();
       var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

       var sum = isNaN(percent *  parseFloat(conv_sumnetprtonr)) ? 0 :(percent *  parseFloat(conv_sumnetprtonr)).toFixed(3);
       var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

       $('#slipipamountendorsement').val(real_sum);
   });

   $('#sliporendorsement').keyup(function () {
       var percent =  parseFloat($(this).val()) / 100;
       var sumshare = $("#slipsumshareendorsement").val();
       var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

       var sum = isNaN(percent * parseFloat(conv_sumshare)) ? 0 :(percent * parseFloat(conv_sumshare)).toFixed(3);
       var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

       $('#slipsumorendorsement').val(real_sum);
   });

   $('#sliprppercentageendorsement').keyup(function () {
       var percentval =  parseFloat($(this).val()) / 100;
       var sumor = $('#slipsumor').val() ;
       var conv_sumor = parseInt(sumor.replace(/,/g, ""));
       var sumrpamount = isNaN(percentval * parseFloat(conv_sumor)) ? 0 :(percentval * parseFloat(conv_sumor)).toFixed(3);
       var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

       // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
       // $('#slipor').val(sumpercentor);
       $('#sliprpamountendorsement').val(real_sumrpamount);
   });

   $('#sliprppercentageendorsement').change(function () {
       var percentval =  parseFloat($(this).val());
       var orpercent = parseFloat($('#slipor').val());
       var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
       $('#sliporendorsement').val(sumpercentor);
   });
</script>

<script type='text/javascript'>
    
    $('#slipnilaiec').keyup(function () {
       var persentage =  parseFloat($('#slipnilaiec').val()) / 1000;
       var sliptotalsum =  $('#sliptotalsum').val();
       var conv_sliptotalsum = parseInt(sliptotalsum.replace(/,/g, ""));
       //alert(premiumnr);
       //alert(persentage);
       var sum = isNaN(conv_sliptotalsum * persentage) ? 0 :(conv_sliptotalsum * persentage).toFixed(3) ;
       var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       //alert(sum);
       $('#slipamountec').val(real_sum);
    });

    // $('#slipnilaiec').change(function () {
    //    var persentage =  parseFloat($('#slipnilaiec').val());
    //    var sliptotalsum =  parseFloat($('#sliptotalsum').val());
    //    //alert(premiumnr);
    //    //alert(persentage);
    //    var conv_sliptotalsum = parseInt(sliptotalsum.replace(/,/g, ""));
    //    //alert(premiumnr);
    //    //alert(persentage);
    //    var sum = isNaN(conv_sliptotalsum * (persentage)) ? 0 :(conv_sliptotalsum * (persentage)) ;
    //    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //    //alert(sum);
    //    $('#slipamountec').val(real_sum);
    // });

</script>

<script type='text/javascript'>
   
    $('#slipnilaiecupdate').keyup(function () {
       var persentage =  parseFloat($('#slipnilaiecupdate').val()) / 1000;
       var sliptotalsum =  $('#sliptotalsumupdate').val();
       //alert(premiumnr);
       //alert(persentage);
       var conv_sliptotalsum = parseInt(sliptotalsum.replace(/,/g, ""));
       //alert(premiumnr);
       //alert(persentage);
       var sum = isNaN(conv_sliptotalsum * persentage) ? 0 :(conv_sliptotalsum * persentage).toFixed(3) ;
       var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       //alert(sum);
       $('#slipamountecupdate').val(real_sum);
    });

    // $('#slipnilaiecupdate').change(function () {
    //    var persentage =  parseFloat($('#slipnilaiecupdate').val());
    //    var sliptotalsum =  parseFloat($('#sliptotalsumupdate').val());
    //    //alert(premiumnr);
    //    //alert(persentage);
    //    var conv_sliptotalsum = parseInt(sliptotalsum.replace(/,/g, ""));
    //    //alert(premiumnr);
    //    //alert(persentage);
    //    var sum = isNaN(conv_sliptotalsum * (persentage)) ? 0 :(conv_sliptotalsum * (persentage)) ;
    //    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //    //alert(sum);
    //    $('#slipamountecupdate').val(real_sum);
    // });

</script>

<script type='text/javascript'>
   
    $('#slipnilaiecendorsement').keyup(function () {
       var persentage =  parseFloat($('#slipnilaiecendorsement').val()) / 1000;
       var sliptotalsum =  $('#sliptotalsumendorsement').val();
       //alert(premiumnr);
       //alert(persentage);
       var conv_sliptotalsum = parseInt(sliptotalsum.replace(/,/g, ""));
       //alert(premiumnr);
       //alert(persentage);
       var sum = isNaN(conv_sliptotalsum * persentage) ? 0 :(conv_sliptotalsum * persentage).toFixed(3) ;
       var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       //alert(sum);
       $('#slipamountecendorsement').val(real_sum);
    });

    // $('#slipnilaiecendorsement').change(function () {
    //    var persentage =  parseFloat($('#slipnilaiecendorsement').val());
    //    var sliptotalsum =  parseFloat($('#sliptotalsumendorsement').val());
    //    //alert(premiumnr);
    //    //alert(persentage);
    //    var conv_sliptotalsum = parseInt(sliptotalsum.replace(/,/g, ""));
    //    //alert(premiumnr);
    //    //alert(persentage);
    //    var sum = isNaN(conv_sliptotalsum * (persentage)) ? 0 :(conv_sliptotalsum * (persentage)) ;
    //    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //    //alert(sum);
    //    $('#slipamountecendorsement').val(real_sum);
    // });

</script>


{{-- <script type='text/javascript'>
    
     $('#slipdppercentage').keyup(function () {
        var persentage =  parseFloat($('#slipdppercentage').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipdpamount').val(sum);
     });

     $('#slipdppercentage').change(function () {
        var persentage =  parseFloat($('#slipdppercentage').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipdpamount').val(sum);
     });

</script> --}}

<script type='text/javascript'>
    
     $('#slipdppercentageupdate').keyup(function () {
        var persentage =  parseFloat($('#slipdppercentageupdate').val());
        var sliptotalsum =  parseFloat($('#sliptotalsumupdate').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipdpamountupdate').val(sum);
     });

     $('#slipdppercentageupdate').change(function () {
        var persentage =  parseFloat($('#slipdppercentageupdate').val());
        var sliptotalsum =  parseFloat($('#sliptotalsumupdate').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipdpamountupdate').val(sum);
     });

</script>


<script type='text/javascript'>
    
     $('#slipdppercentageendorsement').keyup(function () {
        var persentage =  parseFloat($('#slipdppercentageendorsement').val());
        var sliptotalsum =  parseFloat($('#sliptotalsumendorsement').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipdpamountendorsement').val(sum);
     });

     $('#slipdppercentageendorsement').change(function () {
        var persentage =  parseFloat($('#slipdppercentageendorsement').val());
        var sliptotalsum =  parseFloat($('#sliptotalsumendorsement').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipdpamountendorsement').val(sum);
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
           url:"{{ route('installment.store') }}",
           type:"POST",
           data:{
               installmentdate:installmentdate,
               percentage:percentage,
               slipamount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#installmentPanel tbody').prepend('<tr id="iidinstallment'+response.id+'" data-name="installmentvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentdetail('+response.id+')">delete</a></td></tr>')
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
    $('#addinstallmentinsuredupdate-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var installmentdate = $('#dateinstallmentdataupdate').val();
       
       var percentage = $('#slipippercentageupdate').val();
       var amount = $('#slipipamountupdate').val();
       var slip_id = $('#slipnumberupdate').val();
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
           url:"{{ route('installment.store') }}",
           type:"POST",
           data:{
               installmentdate:installmentdate,
               percentage:percentage,
               slipamount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#installmentPanelupdate tbody').prepend('<tr id="iidinstallmentupdate'+response.id+'" data-name="installmentupdatevalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentupdate('+response.id+')">delete</a></td></tr>')
               $('#dateinstallmentupdate').val('');
               $('#slipippercentageupdate').val('');
               $('#slipipamountupdate').val('');
               
               //var total =  parseFloat($("#sliptotalsum").val());
               //var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
               //$("#sliptotalsum").val(sum);

           }
       });

   });
</script>


<script type='text/javascript'>
    $('#addinstallmentinsuredendorsement-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var installmentdate = $('#dateinstallmentdataendorsement').val();
       
       var percentage = $('#slipippercentageendorsement').val();
       var amount = $('#slipipamountendorsement').val();
       var slip_id = $('#slipnumberendorsement').val();
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
           url:"{{ route('installment.store') }}",
           type:"POST",
           data:{
               installmentdate:installmentdate,
               percentage:percentage,
               slipamount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#installmentPanelendorsement tbody').prepend('<tr id="iidinstallmentendorsement'+response.id+'" data-name="installmentendorsementvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentendorsement('+response.id+')">delete</a></td></tr>')
               $('#dateinstallmentendorsement').val('');
               $('#slipippercentageendorsement').val('');
               $('#slipipamountendorsement').val('');
               
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
    function deleteinstallmentupdate(id)
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
                
                $('#iidinstallmentupdate'+id).remove();
                console.log(response);
            }
        });
    }
</script>


<script type='text/javascript'>
    function deleteinstallmentendorsement(id)
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
                
                $('#iidinstallmentendorsement'+id).remove();
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

       var conv_amount = amount.replace(/,/g, "");
       console.log(conv_amount)
       var real_amount = parseInt(conv_amount);
       console.log(real_amount)

       var conv_minamount = minamount.replace(/,/g, "");
       console.log(conv_minamount)
       var real_minamount = parseInt(conv_minamount);
       console.log(real_minamount)
       
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
               amount:real_amount,
               minamount:real_minamount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               var curr_minamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.min_claimamount);
               $('#deductiblePanel tbody').prepend('<tr id="iiddeductible'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype+'">'+response.deductibletype+'</td><td data-name="'+response.currencydata+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td data-name="'+curr_minamount+'">'+curr_minamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibledetail('+response.id+')">delete</a></td></tr>');
               $('#slipdppercentage').val('');
               $('#slipdpamount').val('');
               $('#slipdpminamount').val('');
               
           }
       });

   });
</script>


<script type='text/javascript'>
    $('#adddeductibleinsuredupdate-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slipdptype = $('#slipdptypeupdate').val();
       var slipdpcurrency = $('#slipdpcurrencyupdate').val();
       
       var percentage = $('#slipdppercentageupdate').val();
       var amount = $('#slipdpamountupdate').val();
       var minamount = $('#slipdpminamountupdate').val();
       
       var slip_id = $('#slipnumberupdate').val();
       var token2 = $('input[name=_token2]').val();

       var conv_amount = amount.replace(/,/g, "");
       console.log(conv_amount)
       var real_amount = parseInt(conv_amount);
       console.log(real_amount)

       var conv_minamount = minamount.replace(/,/g, "");
       console.log(conv_minamount)
       var real_minamount = parseInt(conv_minamount);
       console.log(real_minamount)
       
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
               amount:real_amount,
               minamount:real_minamount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#deductiblePanelupdate tbody').prepend('<tr id="iiddeductibleupdate'+response.id+'" data-name="deductibleupdatevalue[]"><td data-name="'+response.deductibletype+'">'+response.deductibletype+'</td><td data-name="'+response.currencydata+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibleupdate('+response.id+')">delete</a></td></tr>');
               $('#slipdppercentageupdate').val('');
               $('#slipdpamountupdate').val('');
               $('#slipdpminamountupdate').val('');
               
           }
       });

   });
</script>

<script type='text/javascript'>
    $('#adddeductibleinsuredendorsement-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slipdptype = $('#slipdptypeendorsement').val();
       var slipdpcurrency = $('#slipdpcurrencyendorsement').val();
       
       var percentage = $('#slipdppercentageendorsement').val();
       var amount = $('#slipdpamountendorsement').val();
       var minamount = $('#slipdpminamountendorsement').val();
       
       var slip_id = $('#slipnumberendorsement').val();
       var token2 = $('input[name=_token2]').val();

       var conv_amount = amount.replace(/,/g, "");
       console.log(conv_amount)
       var real_amount = parseInt(conv_amount);
       console.log(real_amount)

       var conv_minamount = minamount.replace(/,/g, "");
       console.log(conv_minamount)
       var real_minamount = parseInt(conv_minamount);
       console.log(real_minamount)
       
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
               amount:real_amount,
               minamount:real_minamount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#deductiblePanelendorsement tbody').prepend('<tr id="iiddeductibleendorsement'+response.id+'" data-name="deductibleendorsementvalue[]"><td data-name="'+response.deductibletype+'">'+response.deductibletype+'</td><td data-name="'+response.currencydata+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibleendorsement('+response.id+')">delete</a></td></tr>');
               $('#slipdppercentageendorsement').val('');
               $('#slipdpamountendorsement').val('');
               $('#slipdpminamountendorsement').val('');
               
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
    function deletedeductibleupdate(id)
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
                
                $('#iiddeductibleupdate'+id).remove();
                console.log(response);
            }
        });
    }
</script>


<script type='text/javascript'>
    function deletedeductibleendorsement(id)
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
                
                $('#iiddeductibleendorsement'+id).remove();
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
           url:"{{ route('extendcoverage.store') }}",
           type:"POST",
           data:{
               slipcncode:slipcncode,
               percentage:percentage,
               amount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
        
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#ExtendCoveragePanel tbody').prepend('<tr id="iidextendcoverage'+response.id+'" data-name="extendcoveragevalue[]"><td data-name="'+response.coveragetype+'">'+response.coveragetype+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteextendcoveragedetail('+response.id+')">delete</a></td></tr>');
               $('#slipnilaiec').val('');
               $('#slipamountec').val('');
               
           }
       });

   });
</script>



<script type='text/javascript'>
    $('#addextendcoverageinsuredupdate-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slipcncode = $('#slipcncodeupdate').val();
       var percentage = $('#slipnilaiecupdate').val();
       var amount = $('#slipamountecupdate').val();
       
       var slip_id = $('#slipnumberupdate').val();
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
           url:"{{ route('extendcoverage.store') }}",
           type:"POST",
           data:{
               slipcncode:slipcncode,
               percentage:percentage,
               amount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#ExtendCoveragePanelupdate tbody').prepend('<tr id="iidextendcoverageupdate'+response.id+'" data-name="extendcoverageupdatevalue[]"><td data-name="'+response.coveragetype+'">'+response.coveragetype+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteextendcoverageupdate('+response.id+')">delete</a></td></tr>');
               $('#slipnilaiecupdate').val('');
               $('#slipamountecupdate').val('');
               
           }
       });

   });
</script>


<script type='text/javascript'>
    $('#addextendcoverageinsuredendorsement-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slipcncode = $('#slipcncodeendorsement').val();
       var percentage = $('#slipnilaiecendorsement').val();
       var amount = $('#slipamountecendorsement').val();
       
       var slip_id = $('#slipnumberendorsement').val();
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
           url:"{{ route('extendcoverage.store') }}",
           type:"POST",
           data:{
               slipcncode:slipcncode,
               percentage:percentage,
               amount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#ExtendCoveragePanelendorsement tbody').prepend('<tr id="iidextendcoverageendorsement'+response.id+'" data-name="extendcoverageendorsementvalue[]"><td data-name="'+response.coveragetype+'">'+response.coveragetype+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteextendcoverageendorsement('+response.id+')">delete</a></td></tr>');
               $('#slipnilaiecendorsement').val('');
               $('#slipamountecendorsement').val('');
               
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
    function deleteextendcoverageupdate(id)
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
                
                $('#iidextendcoverageupdate'+id).remove();
                console.log(response);
            }
        });
    }
</script>



<script type='text/javascript'>
    function deleteextendcoverageendorsement(id)
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
                
                $('#iidextendcoverageendorsement'+id).remove();
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
           url:"{{ route('retrocession.store') }}",
           type:"POST",
           data:{
               type:type,
               contract:contract,
               percentage:percentage,
               amount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#retrocessionPanel tbody').prepend('<tr id="iidretrocession'+response.id+'" data-name="retrocessionvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteretrocessiondetail('+response.id+')">delete</a></td></tr>');
               $('#sliprppercentage').val('');
               $('#sliprpamount').val('');
               
           }
       });

   });
</script>


<script type='text/javascript'>
    $('#addretrocessioninsuredupdate-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var type = $('#sliprptypeupdate').val();
       var contract = $('#sliprpcontractupdate').val();
       var percentage = $('#sliprppercentageupdate').val();
       var amount = $('#sliprpamountupdate').val();
       
       var slip_id = $('#slipnumberupdate').val();
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
           url:"{{ route('retrocession.store') }}",
           type:"POST",
           data:{
               type:type,
               contract:contract,
               percentage:percentage,
               amount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#retrocessionPanelupdate tbody').prepend('<tr id="iidretrocessionupdate'+response.id+'" data-name="retrocessionupdatevalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+')</td><td><a href="javascript:void(0)" onclick="deleteretrocessionupdate('+response.id+')">delete</a></td></tr>');
               $('#sliprppercentageupdate').val('');
               $('#sliprpamountupdate').val('');
               
           }
       });

   });
</script>


<script type='text/javascript'>
    $('#addretrocessioninsuredendorsement-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var type = $('#sliprptypeendorsement').val();
       var contract = $('#sliprpcontractendorsement').val();
       var percentage = $('#sliprppercentageendorsement').val();
       var amount = $('#sliprpamountendorsement').val();
       
       var slip_id = $('#slipnumberendorsement').val();
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
           url:"{{ route('retrocession.store') }}",
           type:"POST",
           data:{
               type:type,
               contract:contract,
               percentage:percentage,
               amount:real_amount,
               id_slip:slip_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#retrocessionPanelendorsement tbody').prepend('<tr id="iidretrocessionendorsement'+response.id+'" data-name="retrocessionendorsementvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+')</td><td><a href="javascript:void(0)" onclick="deleteretrocessionendorsement('+response.id+')">delete</a></td></tr>');
               $('#sliprppercentageendorsement').val('');
               $('#sliprpamountendorsement').val('');
               
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

<script type='text/javascript'>
    function deleteretrocessionupdate(id)
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
                
                $('#iidretrocessionupdate'+id).remove();
                console.log(response);
            }
        });
    }
</script>

<script type='text/javascript'>
    function deleteretrocessionendorsement(id)
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
                
                $('#iidretrocessionendorsement'+id).remove();
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
        z-index: 1100 !important;
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


<script type='text/javascript'>
    $('#addinsuredsave-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();
       

       var fesnumber = $('#insuredIDtxt').val();
       var fesinsured = $('#feinsured').val();
       var fessuggestinsured = $('#autocomplete').val();
       var fessuffix = $('#autocomplete2').val();
       var fesshare = $('#feshare').val();
       var fessharefrom  = $('#fesharefrom').val();
       var fesshareto = $('#feshareto').val();
       var fescoinsurance = $('#fecoinsurance').val();
       var feuy = $('#feuy').val();

       var conv_fessharefrom = fessharefrom.replace(/,/g, "");
       console.log(conv_fessharefrom)
       var real_fessharefrom = parseInt(conv_fessharefrom);
       console.log(real_fessharefrom)
       var conv_fesshareto = fesshareto.replace(/,/g, "");
       console.log(conv_fesshareto)
       var real_fesshareto = parseInt(conv_fesshareto);
       console.log(real_fesshareto)

       if(isNaN(real_fesshareto))
       {
         real_fesshareto=0;
       }

       if(isNaN(real_fessharefrom))
       {
        real_fessharefrom=0;
       }
       
       
       var token2 = $('input[name=_token]').val();

       console.log(fesinsured)
       console.log(fessuggestinsured)
       console.log(fesnumber)
       console.log(fessuffix)

       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/fe-insured/store') }}",
           type:"POST",
           data:{
               fesnumber:fesnumber,
               fesinsured:fesinsured,
               fessuggestinsured:fessuggestinsured,
               fessuffix:fessuffix,
               fesshare:fesshare,
               fessharefrom:real_fessharefrom,
               fesshareto:real_fesshareto,
               fescoinsurance:fescoinsurance,
               feuy:feuy
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Insured Insert Error", "Insert Error");
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
       var slipdatetransfer = $('#sliptd').val();
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
       var slippolicy_no =  $('#slippolicy_no').val();
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
       var slipvbroker =  $('#slipvbroker').val();
       var slipshare =  $('#slipshare').val();
       var slipsumshare =  $('#slipsumshare').val();
       var slipbasicpremium =  $('#slipbasicpremium').val();
       var slipgrossprmtonr =  $('#slipgrossprmtonr').val();
       var slipsumcommission =  $('#slipsumcommission').val();
       var slipcommission =  $('#slipcommission').val();
       var slipnetprmtonr =  $('#slipnetprmtonr').val();
       var sliprb =  $('#sliprb').val();
       var slipor =  $('#slipor').val();
       var slipsumor =  $('#slipsumor').val();
       var wpc =  $('#wpc').val();

       var token2 = $('input[name=_token]').val();

       var conv_sliptotalsum = sliptotalsum.replace(/,/g, "");
       console.log(conv_sliptotalsum)
       var real_sliptotalsum = parseInt(conv_sliptotalsum);
       console.log(real_sliptotalsum)
       
       var conv_sliptotalsumpct = sliptotalsumpct.replace(/,/g, "");
       console.log(conv_sliptotalsumpct)
       var real_sliptotalsumpct = parseInt(conv_sliptotalsumpct);
       console.log(real_sliptotalsumpct)

       var conv_slipsumshare = slipsumshare.replace(/,/g, "");
       console.log(conv_slipsumshare)
       var real_slipsumshare = parseInt(conv_slipsumshare);
       console.log(real_slipsumshare)

       var conv_slipbasicpremium = slipbasicpremium.replace(/,/g, "");
       console.log(conv_slipbasicpremium)
       var real_slipbasicpremium = parseInt(conv_slipbasicpremium);
       console.log(real_slipbasicpremium)

       var conv_slipgrossprmtonr = slipgrossprmtonr.replace(/,/g, "");
       console.log(conv_slipgrossprmtonr)
       var real_slipgrossprmtonr = parseInt(conv_slipgrossprmtonr);
       console.log(real_slipgrossprmtonr)

       var conv_slipsumcommission = slipsumcommission.replace(/,/g, "");
       console.log(conv_slipsumcommission)
       var real_slipsumcommission = parseInt(conv_slipsumcommission);
       console.log(real_slipsumcommission)

       var conv_slipnetprmtonr = slipnetprmtonr.replace(/,/g, "");
       console.log(conv_slipnetprmtonr)
       var real_slipnetprmtonr = parseInt(conv_slipnetprmtonr);
       console.log(real_slipnetprmtonr)

       var conv_slipsumor = slipsumor.replace(/,/g, "");
       console.log(conv_slipsumor)
       var real_slipsumor = parseInt(conv_slipsumor);
       console.log(real_slipsumor)

       
       
       //ajaxfilefunction(e);

       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/fe-slip/store')}}",
           type:"POST",
           data:{
               code_ms:code_ms,
               slipnumber:slipnumber,
               slipdatetransfer:slipdatetransfer,
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
               sliptotalsum:real_sliptotalsum,
               sliptype:sliptype,
               slippct:slippct,
               sliptotalsumpct:real_sliptotalsumpct,
               slipipfrom:slipipfrom,
               slipipto:slipipto,
               sliprpfrom:sliprpfrom,
               sliprpto:sliprpto,
               proportional:proportional,
               sliplayerproportional:sliplayerproportional,
               sliprate:sliprate,
               slipvbroker:slipvbroker,
               slipshare:slipshare,
               slipsumshare:real_slipsumshare,
               slipbasicpremium:real_slipbasicpremium,
               slipgrossprmtonr:real_slipgrossprmtonr,
               slipcommission:slipcommission,
               slipsumcommission:real_slipsumcommission,
               slipnetprmtonr:real_slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipsumor:real_slipsumor,
               wpc:wpc
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Slip Insert Success", "success")
                console.log(response)

                
                $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.number+'">'+response.number+'</td><td data-name="'+response.cedingbroker+'">"'+response.cedingbroker+'"</td><td data-name="'+response.ceding+'">'+response.ceding+'</td><td data-name="'+response.slipstatus+'">"'+slipstatus+'"</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+response.number+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#updatemodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#endorsementmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                    +'</a><td></td></tr>');
                    
                $('#slipnumber').val(response.code_sl);

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Slip Insert Error", "Insert Error");
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


      // insured save
       var fesnumber = $('#insuredIDtxt').val();
       var fessuffix = $('#autocomplete2').val();
       var fesshare = $('#feshare').val();
       var fessharefrom  = $('#fesharefrom').val();
       var fesshareto = $('#feshareto').val();
       
       
       var conv_fessharefrom = fessharefrom.replace(/,/g, "");
       console.log(conv_fessharefrom)
       var real_fessharefrom = parseInt(conv_fessharefrom);
       console.log(real_fessharefrom)
       var conv_fesshareto = fesshareto.replace(/,/g, "");
       console.log(conv_fesshareto)
       var real_fesshareto = parseInt(conv_fesshareto);
       console.log(real_fesshareto)
       
       
       var token2 = $('input[name=_token]').val();

       console.log(fesinsured)
       console.log(fessuggestinsured)
       console.log(fesnumber)
       console.log(fessuffix)

       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/fe-insured/store') }}",
           type:"POST",
           data:{
               fesnumber:fesnumber,
               fesshare:fesshare,
               fessharefrom:real_fessharefrom,
               fesshareto:real_fesshareto
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Insured Insert Error", "Insert Error");
           }
       });

 
       $('#installmentPanel tbody').empty();
       $('#ExtendCoveragePanel tbody').empty();
       $('#deductiblePanel tbody').empty();
       $('#retrocessionPanel tbody').empty();
       

       
   });
</script>

<script type='text/javascript'>
    $('#multi-file-upload-ajax2').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ms = $('#insuredIDtxt').val();
       var slipnumber = $('#slipnumber').val();
       var prevslipnumber = $('#prevslipnumber').val();
       var slipdatetransfer = $('#sliptd').val();
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
       var slippolicy_no =  $('#slippolicy_no').val();
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
       var slipvbroker =  $('#slipvbroker').val();
       var slipshare =  $('#slipshare').val();
       var slipsumshare =  $('#slipsumshare').val();
       var slipbasicpremium =  $('#slipbasicpremium').val();
       var slipgrossprmtonr =  $('#slipgrossprmtonr').val();
       var slipsumcommission =  $('#slipsumcommission').val();
       var slipcommission =  $('#slipcommission').val();
       var slipnetprmtonr =  $('#slipnetprmtonr').val();
       var sliprb =  $('#sliprb').val();
       var slipor =  $('#slipor').val();
       var slipsumor =  $('#slipsumor').val();
       var wpc =  $('#wpc').val();

       var token2 = $('input[name=_token]').val();

       var conv_sliptotalsum = sliptotalsum.replace(/,/g, "");
       console.log(conv_sliptotalsum)
       var real_sliptotalsum = parseInt(conv_sliptotalsum);
       console.log(real_sliptotalsum)
       
       var conv_sliptotalsumpct = sliptotalsumpct.replace(/,/g, "");
       console.log(conv_sliptotalsumpct)
       var real_sliptotalsumpct = parseInt(conv_sliptotalsumpct);
       console.log(real_sliptotalsumpct)

       var conv_slipsumshare = slipsumshare.replace(/,/g, "");
       console.log(conv_slipsumshare)
       var real_slipsumshare = parseInt(conv_slipsumshare);
       console.log(real_slipsumshare)

       var conv_slipbasicpremium = slipbasicpremium.replace(/,/g, "");
       console.log(conv_slipbasicpremium)
       var real_slipbasicpremium = parseInt(conv_slipbasicpremium);
       console.log(real_slipbasicpremium)

       var conv_slipgrossprmtonr = slipgrossprmtonr.replace(/,/g, "");
       console.log(conv_slipgrossprmtonr)
       var real_slipgrossprmtonr = parseInt(conv_slipgrossprmtonr);
       console.log(real_slipgrossprmtonr)

       var conv_slipsumcommission = slipsumcommission.replace(/,/g, "");
       console.log(conv_slipsumcommission)
       var real_slipsumcommission = parseInt(conv_slipsumcommission);
       console.log(real_slipsumcommission)

       var conv_slipnetprmtonr = slipnetprmtonr.replace(/,/g, "");
       console.log(conv_slipnetprmtonr)
       var real_slipnetprmtonr = parseInt(conv_slipnetprmtonr);
       console.log(real_slipnetprmtonr)

       var conv_slipsumor = slipsumor.replace(/,/g, "");
       console.log(conv_slipsumor)
       var real_slipsumor = parseInt(conv_slipsumor);
       console.log(real_slipsumor)
       
       
       //ajaxfilefunction(e);

       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/fe-slip/endorsementstore')}}",
           type:"POST",
           data:{
               code_ms:code_ms,
               slipnumber:slipnumber,
               slipdatetransfer:slipdatetransfer,
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
               sliptotalsum:real_sliptotalsum,
               sliptype:sliptype,
               slippct:slippct,
               sliptotalsumpct:real_sliptotalsumpct,
               slipipfrom:slipipfrom,
               slipipto:slipipto,
               sliprpfrom:sliprpfrom,
               sliprpto:sliprpto,
               proportional:proportional,
               sliplayerproportional:sliplayerproportional,
               sliprate:sliprate,
               slipvbroker:slipvbroker,
               slipshare:slipshare,
               slipsumshare:real_slipsumshare,
               slipbasicpremium:real_slipbasicpremium,
               slipgrossprmtonr:real_slipgrossprmtonr,
               slipcommission:slipcommission,
               slipsumcommission:real_slipsumcommission,
               slipnetprmtonr:real_slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipsumor:real_slipsumor,
               wpc:wpc
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Slip Insert Success", "success")
                console.log(response)

                $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.number+'">'+response.number+'</td><td data-name="'+response.cedingbroker+'">"'+response.cedingbroker+'"</td><td data-name="'+response.ceding+'">'+response.ceding+'</td><td data-name="'+response.slipstatus+'">"'+slipstatus+'"</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+response.number+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#updatemodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                    +'</a>'
                    +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#endorsementmodaldata">'
                    +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                    +'</a><td></td></tr>');

                $('#slipnumber').val(response.code_sl);

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Slip Insert Error", "Insert Error");
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


      // insured save
       var fesnumber = $('#insuredIDtxt').val();
       var fesinsured = $('#feinsured').val();
       var fessuggestinsured = $('#autocomplete').val();
       var fessuffix = $('#autocomplete2').val();
       var fesshare = $('#feshare').val();
       var fessharefrom  = $('#fesharefrom').val();
       var fesshareto = $('#feshareto').val();
       var fescoinsurance = $('#fecoinsurance').val();
       
       
       var conv_fessharefrom = fessharefrom.replace(/,/g, "");
       console.log(conv_fessharefrom)
       var real_fessharefrom = parseInt(conv_fessharefrom);
       console.log(real_fessharefrom)
       var conv_fesshareto = fesshareto.replace(/,/g, "");
       console.log(conv_fesshareto)
       var real_fesshareto = parseInt(conv_fesshareto);
       console.log(real_fesshareto)
       
       
       var token2 = $('input[name=_token]').val();

       console.log(fesinsured)
       console.log(fessuggestinsured)
       console.log(fesnumber)
       console.log(fessuffix)

       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


       $.ajax({
           url:"{{ url('transaction-data/fe-insured/store') }}",
           type:"POST",
           data:{
               fesnumber:fesnumber,
               fesinsured:fesinsured,
               fessuggestinsured:fessuggestinsured,
               fessuffix:fessuffix,
               fesshare:fesshare,
               fessharefrom:real_fessharefrom,
               fesshareto:real_fesshareto,
               fescoinsurance:fescoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Insured Insert Error", "Insert Error");
           }
       });


       $('#installmentPanel tbody').empty();
       $('#ExtendCoveragePanel tbody').empty();
       $('#deductiblePanel tbody').empty();
       $('#retrocessionPanel tbody').empty();


   });
</script>

<script type='text/javascript'>
    $('#multi-file-upload-ajaxupdate').submit(function(e){
       //alert('masuk');
       e.preventDefault();
    

       var code_ms = $('#insuredIDtxt').val();
       var slipnumber = $('#slipnumberupdate').val();
       var slipdatetransfer = $('#sliptdupdate').val();
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
       var slipvbroker =  $('#v_brokerupdate').val();
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
       var wpc =  $('#wpcupdate').val();

       var token2 = $('input[name=_token]').val();

       var conv_sliptotalsum = sliptotalsum.replace(/,/g, "");
       console.log(conv_sliptotalsum)
       var real_sliptotalsum = parseInt(conv_sliptotalsum);
       console.log(real_sliptotalsum)
       
       var conv_sliptotalsumpct = sliptotalsumpct.replace(/,/g, "");
       console.log(conv_sliptotalsumpct)
       var real_sliptotalsumpct = parseInt(conv_sliptotalsumpct);
       console.log(real_sliptotalsumpct)

       var conv_slipsumshare = slipsumshare.replace(/,/g, "");
       console.log(conv_slipsumshare)
       var real_slipsumshare = parseInt(conv_slipsumshare);
       console.log(real_slipsumshare)

       var conv_slipbasicpremium = slipbasicpremium.replace(/,/g, "");
       console.log(conv_slipbasicpremium)
       var real_slipbasicpremium = parseInt(conv_slipbasicpremium);
       console.log(real_slipbasicpremium)

       var conv_slipgrossprmtonr = slipgrossprmtonr.replace(/,/g, "");
       console.log(conv_slipgrossprmtonr)
       var real_slipgrossprmtonr = parseInt(conv_slipgrossprmtonr);
       console.log(real_slipgrossprmtonr)

       var conv_slipsumcommission = slipsumcommission.replace(/,/g, "");
       console.log(conv_slipsumcommission)
       var real_slipsumcommission = parseInt(conv_slipsumcommission);
       console.log(real_slipsumcommission)

       var conv_slipnetprmtonr = slipnetprmtonr.replace(/,/g, "");
       console.log(conv_slipnetprmtonr)
       var real_slipnetprmtonr = parseInt(conv_slipnetprmtonr);
       console.log(real_slipnetprmtonr)

       var conv_slipsumor = slipsumor.replace(/,/g, "");
       console.log(conv_slipsumor)
       var real_slipsumor = parseInt(conv_slipsumor);
       console.log(real_slipsumor)
       
       
       //ajaxfilefunction(e);

       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/fe-slip/store')}}",
           type:"POST",
           data:{
               code_ms:code_ms,
               slipnumber:slipnumber,
               slipdatetransfer:slipdatetransfer,
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
               sliptotalsum:real_sliptotalsum,
               sliptype:sliptype,
               slippct:slippct,
               sliptotalsumpct:real_sliptotalsumpct,
               slipipfrom:slipipfrom,
               slipipto:slipipto,
               sliprpfrom:sliprpfrom,
               sliprpto:sliprpto,
               proportional:proportional,
               sliplayerproportional:sliplayerproportional,
               sliprate:sliprate,
               slipvbroker:slipvbroker,
               slipshare:slipshare,
               slipsumshare:real_slipsumshare,
               slipbasicpremium:real_slipbasicpremium,
               slipgrossprmtonr:real_slipgrossprmtonr,
               slipcommission:slipcommission,
               slipsumcommission:real_slipsumcommission,
               slipnetprmtonr:real_slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipsumor:real_slipsumor,
               wpc:wpc
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Slip Insert Success", "success")
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
                swal("Error!", "Insured Fire & Engineering Slip Insert Error", "Insert Error");
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
       var fesnumber = $('#insuredIDtxt').val();
       var fesinsured = $('#feinsured').val();
       var fessuggestinsured = $('#autocomplete').val();
       var fessuffix = $('#autocomplete2').val();
       var fesshare = $('#feshare').val();
       var fessharefrom  = $('#fesharefrom').val();
       var fesshareto = $('#feshareto').val();
       var fescoinsurance = $('#fecoinsurance').val();
       
       
       var conv_fessharefrom = fessharefrom.replace(/,/g, "");
       console.log(conv_fessharefrom)
       var real_fessharefrom = parseInt(conv_fessharefrom);
       console.log(real_fessharefrom)
       var conv_fesshareto = fesshareto.replace(/,/g, "");
       console.log(conv_fesshareto)
       var real_fesshareto = parseInt(conv_fesshareto);
       console.log(real_fesshareto)
       
       
       var token2 = $('input[name=_token]').val();

       console.log(fesinsured)
       console.log(fessuggestinsured)
       console.log(fesnumber)
       console.log(fessuffix)

       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/fe-insured/store') }}",
           type:"POST",
           data:{
               fesnumber:fesnumber,
               fesinsured:fesinsured,
               fessuggestinsured:fessuggestinsured,
               fessuffix:fessuffix,
               fesshare:fesshare,
               fessharefrom:real_fessharefrom,
               fesshareto:real_fesshareto,
               fescoinsurance:fescoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Insured Insert Error", "Insert Error");
           }
       });


       $('#installmentPanelupdate tbody').empty();
       $('#ExtendCoveragePanelupdate tbody').empty();
       $('#deductiblePanelupdate tbody').empty();
       $('#retrocessionPanelupdate tbody').empty();


   });
</script>

<script type='text/javascript'>
    $('#multi-file-upload-ajaxendorsement').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ms = $('#insuredIDtxt').val();
       var slipid = $('#slipidendorsement').val();
       var slipnumber = $('#slipnumberendorsement').val();
       var prevslipnumber = $('#prevslipnumberendorsement').val();
       var slipdatetransfer = $('#sliptdendorsement').val();
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
       var slipvbroker =  $('#v_brokerendorsement').val();
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
       var wpc =  $('#wpcendorsement').val();

       var token2 = $('input[name=_token]').val();
       

       var conv_sliptotalsum = sliptotalsum.replace(/,/g, "");
       console.log(conv_sliptotalsum)
       var real_sliptotalsum = parseInt(conv_sliptotalsum);
       console.log(real_sliptotalsum)
       
       var conv_sliptotalsumpct = sliptotalsumpct.replace(/,/g, "");
       console.log(conv_sliptotalsumpct)
       var real_sliptotalsumpct = parseInt(conv_sliptotalsumpct);
       console.log(real_sliptotalsumpct)

       var conv_slipsumshare = slipsumshare.replace(/,/g, "");
       console.log(conv_slipsumshare)
       var real_slipsumshare = parseInt(conv_slipsumshare);
       console.log(real_slipsumshare)

       var conv_slipbasicpremium = slipbasicpremium.replace(/,/g, "");
       console.log(conv_slipbasicpremium)
       var real_slipbasicpremium = parseInt(conv_slipbasicpremium);
       console.log(real_slipbasicpremium)

       var conv_slipgrossprmtonr = slipgrossprmtonr.replace(/,/g, "");
       console.log(conv_slipgrossprmtonr)
       var real_slipgrossprmtonr = parseInt(conv_slipgrossprmtonr);
       console.log(real_slipgrossprmtonr)

       var conv_slipsumcommission = slipsumcommission.replace(/,/g, "");
       console.log(conv_slipsumcommission)
       var real_slipsumcommission = parseInt(conv_slipsumcommission);
       console.log(real_slipsumcommission)

       var conv_slipnetprmtonr = slipnetprmtonr.replace(/,/g, "");
       console.log(conv_slipnetprmtonr)
       var real_slipnetprmtonr = parseInt(conv_slipnetprmtonr);
       console.log(real_slipnetprmtonr)

       var conv_slipsumor = slipsumor.replace(/,/g, "");
       console.log(conv_slipsumor)
       var real_slipsumor = parseInt(conv_slipsumor);
       console.log(real_slipsumor)
       
       //ajaxfilefunction(e);

       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/fe-slip/endorsementstore')}}",
           type:"POST",
           data:{
               code_ms:code_ms,
               slipnumber:slipnumber,
               slipdatetransfer:slipdatetransfer,
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
               sliptotalsum:real_sliptotalsum,
               sliptype:sliptype,
               slippct:slippct,
               sliptotalsumpct:real_sliptotalsumpct,
               slipipfrom:slipipfrom,
               slipipto:slipipto,
               sliprpfrom:sliprpfrom,
               sliprpto:sliprpto,
               proportional:proportional,
               sliplayerproportional:sliplayerproportional,
               sliprate:sliprate,
               slipvbroker:slipvbroker,
               slipshare:slipshare,
               slipsumshare:real_slipsumshare,
               slipbasicpremium:real_slipbasicpremium,
               slipgrossprmtonr:real_slipgrossprmtonr,
               slipcommission:slipcommission,
               slipsumcommission:real_slipsumcommission,
               slipnetprmtonr:real_slipnetprmtonr,
               sliprb:sliprb,
               slipor:slipor,
               slipsumor:real_slipsumor,
               wpc:wpc
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Slip Endorsement Success", "success")
                console.log(response)

                
                // $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.number+'">'+response.number+'</td><td data-name="'+response.cedingbroker+'">"'+response.cedingbroker+'"</td><td data-name="'+response.ceding+'">'+response.ceding+'</td><td data-name="'+response.slipstatus+'">"'+slipstatus+'"</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+response.id+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                //     +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                //     +'</a>'
                //     +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#updatemodaldata">'
                //     +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                //     +'</a>'
                //     +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.number+'" data-target="#endorsementmodaldata">'
                //     +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                //     +'</a><td></td></tr>');


                // $('#slipnumberendorsement').val(response.number);

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Slip Endorsement Error", "Insert Error");
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
       var fesnumber = $('#insuredIDtxt').val();
       var fesinsured = $('#feinsured').val();
       var fessuggestinsured = $('#autocomplete').val();
       var fessuffix = $('#autocomplete2').val();
       var fesshare = $('#feshare').val();
       var fessharefrom  = $('#fesharefrom').val();
       var fesshareto = $('#feshareto').val();
       var fescoinsurance = $('#fecoinsurance').val();
       
       
       var conv_fessharefrom = fessharefrom.replace(/,/g, "");
       console.log(conv_fessharefrom)
       var real_fessharefrom = parseInt(conv_fessharefrom);
       console.log(real_fessharefrom)
       var conv_fesshareto = fesshareto.replace(/,/g, "");
       console.log(conv_fesshareto)
       var real_fesshareto = parseInt(conv_fesshareto);
       console.log(real_fesshareto)
       
       
       var token2 = $('input[name=_token]').val();

       console.log(fesinsured)
       console.log(fessuggestinsured)
       console.log(fesnumber)
       console.log(fessuffix)

       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/fe-insured/store') }}",
           type:"POST",
           data:{
               fesnumber:fesnumber,
               fesinsured:fesinsured,
               fessuggestinsured:fessuggestinsured,
               fessuffix:fessuffix,
               fesshare:fesshare,
               fessharefrom:real_fessharefrom,
               fesshareto:real_fesshareto,
               fescoinsurance:fescoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Fire & Engineering Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Insured Insert Error", "Insert Error");
           }
       });

       $('#installmentPanelendorsement tbody').empty();
       $('#ExtendCoveragePanelendorsement tbody').empty();
       $('#deductiblePanelendorsement tbody').empty();
       $('#retrocessionPanelendorsement tbody').empty();



   });
</script>



