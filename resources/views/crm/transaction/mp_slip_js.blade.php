<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>

<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }

  /* Firefox */
  input[type=number] {
      -moz-appearance: textfield;
  }
</style>


<script type="text/javascript">
    $('.nav-tabs li a').click(function (e) {     
    //get selected href
    var href = $(this).attr('href');    
    var id = href.substring(1);  
    console.log('id = '+id)  
    
    //set all nav tabs to inactive
    $('.nav-tabs li').removeClass('active');
    $('.nav-tabs li a').removeClass('active');
    
    //get all nav tabs matching the href and set to active
    $('.nav-tabs li[href="'+href+'"]').addClass('active');
    $('.nav-tabs li a[href="'+href+'"]').addClass('active');

    //active tab
    $('.tab-pane').removeClass('show');
    $('.tab-pane').removeClass('active');
    $('.tab-pane[id="'+id+'"]').addClass('show');
    $('.tab-pane[id="'+id+'"]').addClass('active');
});
</script>


<script type="text/javascript">
    $(document).ready(function() { 
        
        if(($('#sliprate').val() != 0) && ($('#slipshare').val() != 0) )
        {
            
        }
        
        document.getElementByTagName("html").setAttribute("lang","id-ID");

        $("#tabretro").attr('hidden','true');
        // $("#tabretrodetail").attr('hidden','true');
        // $("#tabretroupdate").attr('hidden','true');
        // $("#tabretroendorsement").attr('hidden','true');
        $("#sliptotalsum").val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        var dtdef = new Date($.now());
        var datetimedef =  dtdef.getFullYear() + "-" + dtdef.getMonth() + "-" + dtdef.getDate() + " " + dtdef.getHours() + ":" + dtdef.getMinutes() + ":" + dtdef.getSeconds();
        $('#slipStatusTable tbody').append('<tr id="stlid"><td >'+ $("#slipstatus").val() +'</td><td >'+datetimedef+'</td><td >'+ $("#slipusername").val() +'</td></tr>')


        var countryID = 102; 
        //alert(countryID);
        if(countryID)
        {
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
        }
        else
        {
          $("#state_location").append('<option value="" selected disabled>countryID null</option>');
          $("#city_location").empty();
        }  

     });
   
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

    // $('input.tanggal').keyup(function(event) {
    //         // skip for arrow keys
    //         if(event.which >= 37 && event.which <= 40) return;
    //         console.log(event.which)
    //         console.log($(this).val())
    //             // format number
    //             $(this).val(function(index, value) {
    //                 return value.replace(/\D/g, "").replace(/\B(?=(\d{2})+(?!\d))/g, "/");
    //             });
    //         });



    $(".money").click(function() {
        var inputLength = $(".money").val().length;
        setCaretToPos($(".money")[0], inputLength)
    });


    var options = {
    onKeyPress: function(cep, e, field, options){
        if (cep.length<=6)
        {
        
            var inputVal = parseFloat(cep);
            jQuery('.money').val(inputVal.toFixed(2));
        }
        
        // setCaretToPos(jQuery('#money')[0], 4);
                    
        var masks = ['#,##0.00', '0.00'];
        mask = (cep == 0) ? masks[1] : masks[0];
        $('.money').mask(mask, options);
    },
    reverse: true
    };


    $('.money').mask('#,##0.00', options);
</script>


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
            console.log(response);
            $('#slipnumberdetail').val(response.number);
            $('#slipusernamedetail').val(response.username);
            $('#slipprodyeardetail').val(response.prod_year);
            $('#slipuydetail').val(response.uy);
            $('#slipeddetail').val(response.endorsment);
            $('#slipslsdetail').val(response.selisih);
            $('#wpcdetail').val(response.wpc);
            $('#slipvbrokerdetail').val(response.v_broker);


            if(response.deductible_panel)
            {

                var deductibledata = JSON.parse(response.deductible_panel); 

                for(var i = 0; i < deductibledata.length; i++) 
                {
                    var obj = deductibledata[i];

                        //console.log(obj.id);
                        //$('#interestInsuredTabledetail tbody').prepend('');
                        // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                        var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        // var curr_minamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.min_claimamount);
                        var curr_minamount = obj.min_claimamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $('#deductiblePaneldetail tbody').empty();
                        $('#deductiblePaneldetail tbody').prepend('<tr id="iiddeductible'+obj.id+'" data-name="deductibledetailvalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td data-name="'+curr_minamount+'">'+curr_minamount+'</td><td></td></tr>');

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
                        // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                        var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
                        // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                        var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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
                        // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                        var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                        //console.log(obj.id);
                        //$('#interestInsuredTabledetail tbody').prepend('');
                        $('#retrocessionPaneldetail tbody').empty();
                        
                        $('#retrocessionPaneldetail tbody').prepend('<tr id="iidretrocessiondetail'+obj.id+'" data-name="retrocessiondetailvalue[]"><td data-name="'+obj.type+'">'+obj.type+'</td><td data-name="'+obj.contract+'">'+obj.contract+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td></td></tr>');

                    }
                }
                
                
                if(response.status)
                {
                    $("#slipstatusdetail option").attr('hidden',true);
                    $("#slipstatusdetail option[value=" + response.status + "]:first")[0].hidden = false;
                    $("#slipstatusdetail option[value=" + response.status + "]:first")[0].selected = true;
                }

                if(response.source)
                {
                    $("#slipcedingbrokerdetail option").attr('hidden',true);
                    $("#slipcedingbrokerdetail option[value=" + response.source + "]:first")[0].hidden = false;
                    $("#slipcedingbrokerdetail option[value=" + response.source + "]:first")[0].selected = true;
                }

                if(response.source_2)
                {
                    $("#slipcedingdetail option").attr('hidden',true);
                    $("#slipcedingdetail option[value=" + response.source_2 + "]:first")[0].hidden = false;
                    $("#slipcedingdetail option[value=" + response.source_2 + "]:first")[0].selected = true;
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
                    $("#slipbld_constdetail option").attr('hidden',true);
                    $("#slipbld_constdetail option[value='" + response.build_const + "']:first")[0].hidden = false;
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
                    for (var i = 0; i < 5; i++){

                        if(status_log[i])
                        {
                        var status = status_log[i].status;
                        var datetime = status_log[i].datetime;
                        var user = status_log[i].user;
                        $('#stlid'+status_log[i].id).remove();
                        $('#slipStatusTabledetail tbody').append('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                    }

                };
            }

            if(response.attacment_file){
                $('#aidlistdetail li').remove();
                var attacment_file = response.attacment_file;
                for (var i = 0; i < attacment_file.length; i++){
                    var filename = attacment_file[i].filename;
                    $('#aidlistdetail').append('<li><div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+filename+'">'+filename+'</a></div></li>')
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

            var insurance_period_from2 = response.insurance_period_from.split("/").reverse().join("-");
            var insurance_period_to2 = response.insurance_period_to.split("/").reverse().join("-");
            var days=daysBetween(insurance_period_from2, insurance_period_to2);
            
            var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
            var constday = days.toString() + "/365";

            console.log(insurance_period_from2)
            console.log(insurance_period_to2)
            console.log(days)
            console.log(constday)
            console.log(parseFloat(sum))

            /*
            var fulltgl = $(this).val();

            var tgl = parseInt(fulltgl.substring(0,2));
            console.log(tgl)
            var month = parseInt(fulltgl.substring(3,5));
            console.log(month)
            */
            

            $('#slipdaytotaldetail').val(days);
            $('#slipdaytotaldetail2').val(days);
            $('#slipdaytotaldetail3').val("365");
            $('#slipdaytotaldetail4').val("365");
            
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
                
                $('#countendorsmentdetail').val(response.endorsment);
                $('#remarksdetail').val(response.remarks);
                
                swal("Success!", "Data Show")
                console.log(response)

            },
            error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Get Slip Data Error", "Get Data Error");
            }
        });





        });
</script>


<script type="text/javascript">

    //triggered when modal is about to be shown
    $('#updatemodaldata').on('show.bs.modal', function(e) {

        $("#tabretroupdate").attr('hidden','true');
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

            $('#insuredIDtxtupdate').val(response.insured_id);
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
                        // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                        var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        // var curr_minamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.min_claimamount);
                        var curr_minamount = obj.min_claimamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                        $('#deductiblePanelupdate tbody').empty();
                        $('#deductiblePanelupdate tbody').prepend('<tr id="iiddeductibleupdate'+obj.id+'" data-name="deductibleupdatevalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td data-name="'+curr_minamount+'">'+curr_minamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibleupdate('+obj.id+')">delete</a></td></tr>');

                    }
                }


                if(response.extend_coverage)
                {

                    var extend_coverage = JSON.parse(response.extend_coverage); 

                    for(var i = 0; i < extend_coverage.length; i++) 
                    {
                        var obj = extend_coverage[i];
                        // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                        var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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
                        // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                        var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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
                        // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                        var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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

            if(response.source_2)
            {
                $("#slipcedingupdate option[value=" + response.source_2 + "]:first")[0].selected = true;
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
                for (var i = 0; i < 5; i++){

                    if(status_log[i])
                    {
                        var status = status_log[i].status;
                        var datetime = status_log[i].datetime;
                        var user = status_log[i].user;
                        $('#stlid'+status_log[i].id).remove();
                        $('#slipStatusTableupdate tbody').append('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                    }
                };
            }

            if(response.attacment_file){
                $('#aidlistupdate li').remove();
                var attacment_file = response.attacment_file;
                for (var i = 0; i < attacment_file.length; i++){
                    var filename = attacment_file[i].filename;
                    $('#aidlistupdate').append('<li><div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+filename+'">'+filename+'</a></div></li>')
                };
            }


            $('#slipnoupdate').val(response.slip_no);
            $('#slipcndnupdate').val(response.cn_dn);
            $('#slippolicy_noupdate').val(response.policy_no);
            $('#sliptotalsumupdate').val(response.total_sum_insured.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#sliptotalsumupdate2').val(response.total_sum_insured.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#sliptdupdate').val(response.date_transfer);
            $('#slippctupdate').val(response.insured_pct);
            $('#sliptotalsumpctupdate').val(response.total_sum_pct.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#sliptotalsumpctupdate2').val(response.total_sum_pct.replace(/\B(?=(\d{3})+(?!\d))/g, ","));


            $('#remarksupdate').val(response.remarks);
            $('#countendorsmentupdate').val(response.endorsment);

            $('#slipipfromupdate').val(response.insurance_period_from);
            $('#slipiptoupdate').val(response.insurance_period_to);

            var insurance_period_from2 = response.insurance_period_from.split("/").reverse().join("-");
            var insurance_period_to2 = response.insurance_period_to.split("/").reverse().join("-");
            var days=daysBetween(insurance_period_from2, insurance_period_to2);
            var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
            var constday = days.toString() + "/365";
            console.log(insurance_period_from2)
            console.log(insurance_period_to2)
            console.log(days)
            console.log(constday)
            console.log(parseFloat(sum))

            //$('#slipdaytotalupdate').val(constday);
            //$('#slipdaytotalupdate2').val(constday);


            $('#slipdaytotalupdate').val(days);
            $('#slipdaytotalupdate2').val(days);
            $('#slipdaytotalupdate3').val("365");
            $('#slipdaytotalupdate4').val("365");


            $('#sliptotalsumdateupdate').val(parseFloat(sum));
            $('#sliptotalsumdateupdate2').val(parseFloat(sum));

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
                $('#slipoldsumshareupdate').val(response.sum_share);
                $('#slipsumshareupdate').val(response.sum_share.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipbasicpremiumupdate').val(response.basic_premium.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipgrossprmtonrupdate').val(response.grossprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipcommissionupdate').val(response.commission);
                $('#slipsumcommissionupdate').val(response.sum_commission.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipnetprmtonrupdate').val(response.netprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                $('#slipoldsumshareupdate2').val(response.sum_share);
                $('#slipsumshareupdate2').val(response.sum_share.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipbasicpremiumupdate2').val(response.basic_premium.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipgrossprmtonrupdate2').val(response.grossprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipcommissionupdate2').val(response.commission);
                $('#slipsumcommissionupdate2').val(response.sum_commission.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipnetprmtonrupdate2').val(response.netprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                


                $('#sliporupdate').val(response.own_retention);
                $('#slipsumorupdate').val(response.sum_own_retention.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#slipsumorupdate2').val(response.sum_own_retention.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                
                
                swal("Success!", "Data Show")
                console.log(response)

            },
            error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Get Slip Data Error", "Get Data Error");
            }
        });




        });
</script>


<script type="text/javascript">

    //triggered when modal is about to be shown
    $('#endorsementmodaldata').on('show.bs.modal', function(e) {

         //get data-id attribute of the clicked element
         $("#tabretroendorsement").attr('hidden','true');
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
                    $('#insuredIDtxtendorsement').val(response.insured_id);
                    $('#slipidendorsement').val(response.id);
                    $('#slipnumberendorsement').val(response.code_sl);
                    
                    $('#codeslreal').val(response.code_slreal);

                    $('#slipusernameendorsement').val(response.username);
                    $('#slipprodyearendorsement').val(response.prod_year);
                    // $('#slipuyendorsement').val(response.uy);
                    $('#slipedendorsement').val(response.endorsment);
                    $('#slipslsendorsement').val(response.selisih);
                    $('#wpcendorsement').val(response.wpc);
                    $('#slipvbrokerendorsement').val(response.v_broker);




                    if(response.deductible_panel)
                    {

                        var deductibledata = JSON.parse(response.deductible_panel); 

                        for(var i = 0; i < deductibledata.length; i++) 
                        {
                            var obj = deductibledata[i];
                            // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                            var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            // var curr_minamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.min_claimamount);
                            var curr_minamount = obj.min_claimamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#deductiblePanelendorsement tbody').empty();
                            $('#deductiblePanelendorsement tbody').prepend('<tr id="iiddeductibleendorsement'+obj.id+'" data-name="deductibleendorsementvalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td data-name="'+curr_minamount+'">'+curr_minamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibleendorsement('+obj.id+')">delete</a></td></tr>');

                        }
                    }


                    if(response.extend_coverage)
                    {

                        var extend_coverage = JSON.parse(response.extend_coverage); 

                        for(var i = 0; i < extend_coverage.length; i++) 
                        {
                            var obj = extend_coverage[i];
                            // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                            var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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
                            // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                            var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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
                            // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                            var curr_amount =obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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

                if(response.source_2)
                {
                    $("#slipcedingendorsement option[value=" + response.source_2 + "]:first")[0].selected = true;
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
                for (var i = 0; i < 5; i++){
                    if(status_log[i])
                    {
                        var status = status_log[i].status;
                        var datetime = status_log[i].datetime;
                        var user = status_log[i].user;
                        $('#stlid'+status_log[i].id).remove();
                        $('#slipStatusTableendorsement tbody').append('<tr id="stlid'+status_log[i].id+'" data-name="slipvalue[]"><td >'+status+'</td><td >'+datetime+'</td><td >'+user+'</td></tr>')
                    }
                };
            }

            if(response.attacment_file){
                $('#aidlistendorsement li').remove();
                var attacment_file = response.attacment_file;
                for (var i = 0; i < attacment_file.length; i++){
                    var filename = attacment_file[i].filename;

                    $('#aidlistendorsement').append('<li><div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+filename+'">'+filename+'</a></div></li>')
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

            var insurance_period_from2 = response.insurance_period_from.split("/").reverse().join("-");
            var insurance_period_to2 = response.insurance_period_to.split("/").reverse().join("-");
            var days=daysBetween(insurance_period_from2, insurance_period_to2);
            var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
            var constday = days.toString() + "/365";
            console.log(insurance_period_from2)
            console.log(insurance_period_to2)
            console.log(days)
            console.log(constday)
            console.log(parseFloat(sum))

            //$('#slipdaytotalendorsement').val(constday);

            $('#slipdaytotalendorsement').val(days);
            $('#slipdaytotalendorsement2').val(days);
            $('#slipdaytotalendorsement3').val("365");
            $('#slipdaytotalendorsement4').val("365");
                
            $('#countendorsmentdata').val(response.endorsment);
            $('#remarksendorsement').val(response.remarks);
           

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
                    
                    
                    swal("Success!", "Data Show")
                    console.log(response)
                    // addendorsement();

                },
                error: function (request, status, error) {
                    //alert(request.responseText);
                    swal("Error!", "Get Slip Data Error", "Get Data Error");
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
       

       $('#slipipdate').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

     
       $('#dateinfrom').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#dateinto').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#daterefrom').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#datereto').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#slipipfrom').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#slipipto').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliprpfrom').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliprpto').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       
       $('#slipprodyear').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliptd').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliptddetail').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });  


       $('#slipprodyearendorsement').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliptdendorsement').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#slipipfromendorsement').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#slipiptoendorsement').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliprpfromendorsement').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliprptoendorsement').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#dateinstallmentdataendorsement').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });
           

       $('#slipprodyearupdate').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliptdupdate').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#slipipfromupdate').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#slipiptoupdate').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliprpfromupdate').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#sliprptoupdate').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });

       $('#dateinstallmentdataupdate').datepicker({
           dateFormat: 'dd/mm/yy',
           changeYear: true,
           yearRange: '-50:+100',
       });
           
    
    });      
   

   
    $('#slipipfrom').change(function(){
        $('#sliprpfrom').val($(this).val());

        var date_to = $('#slipipto').val();
        if(date_to){
            var insurance_period_from2 = $('#sliprpfrom').val();
            var insurance_period_to2 = $('#sliprpto').val();
            var days=daysBetween(insurance_period_from2, insurance_period_to2);
            var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
            // var constday = days.toString() + "/365";
            var constday1 = days.toString();
            var constday2 = "365";
            console.log(insurance_period_from2)
            console.log(insurance_period_to2)
            console.log(days)
            console.log(constday1)
            console.log(constday2)
            console.log(parseFloat(sum))
            
            $('#slipdaytotal').val(constday1);
            $('#slipdaytotal2').val(constday1);
            $('#slipdaytotal3').val(constday2);
            $('#slipdaytotal4').val(constday2);
            $('#sliptotalsumdate').val(parseFloat(sum));
            $('#sliptotalsumdate2').val(parseFloat(sum));
        }
    });

    $('#slipipto').change(function(){
        $('#sliprpto').val($(this).val());
        
        var insurance_period_from2 = $('#sliprpfrom').val();
        var insurance_period_to2 = $('#sliprpto').val();
        var days=daysBetween(insurance_period_from2, insurance_period_to2);
        var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
        // var constday = days.toString() + "/365";
        var constday1 = days.toString();
        var constday2 = "365";
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(days)
        console.log(constday1)
        console.log(constday2)
        console.log(parseFloat(sum))
        
        $('#slipdaytotal').val(constday1);
        $('#slipdaytotal2').val(constday1);
        $('#slipdaytotal3').val(constday2);
        $('#slipdaytotal4').val(constday2);
        $('#sliptotalsumdate').val(parseFloat(sum));
        $('#sliptotalsumdate2').val(parseFloat(sum));

        // document.getElementById("daytotal").innerHTML = "Total Days :"+days;
    });

    $('#sliprpto').change(function(){
        var insurance_period_from2 = $('#sliprpfrom').val();
        var insurance_period_to2 = $('#sliprpto').val();
        var days=daysBetween(insurance_period_from2, insurance_period_to2);
        var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
        // var constday = days.toString() + "/365";
        var constday1 = days.toString();
        var constday2 = "365";
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(days)
        console.log(constday1)
        console.log(constday2)  
        console.log(parseFloat(sum))
        
        $('#slipdaytotal').val(constday1);
        $('#slipdaytotal2').val(constday1);
        $('#slipdaytotal3').val(constday2);
        $('#slipdaytotal4').val(constday2);
        $('#sliptotalsumdate').val(parseFloat(sum));
        $('#sliptotalsumdate2').val(parseFloat(sum));
    });

    $('#sliprpfrom').change(function(){
        var date_to = $('#sliprpto').val();
        if(date_to){
            var insurance_period_from2 = $('#sliprpfrom').val();
            var insurance_period_to2 = $('#sliprpto').val();
            var days=daysBetween(insurance_period_from2, insurance_period_to2);
            var sum = isNaN(days / 365) ? 0 :(days / 365).toFixed(3);
            // var constday = days.toString() + "/365";
            var constday1 = days.toString();
            var constday2 = "365";
            console.log(insurance_period_from2)
            console.log(insurance_period_to2)
            console.log(days)
            console.log(constday1)
            console.log(constday2)
            console.log(parseFloat(sum))
            
            $('#slipdaytotal').val(constday1);
            $('#slipdaytotal2').val(constday1);
            $('#slipdaytotal3').val(constday2);
            $('#slipdaytotal4').val(constday2);
            $('#sliptotalsumdate').val(parseFloat(sum));
            $('#sliptotalsumdate2').val(parseFloat(sum));
        }
    });


    $('#slipdaytotal2').keyup(function(){
        var day = $(this).val();
        $('#slipdaytotal').val(day);

    });

    $('#slipdaytotal2').change(function(){
        var day = $(this).val();

        var sum = isNaN(day / 365) ? 0 :(day / 365).toFixed(3);

        $('#sliptotalsumdate').val(parseFloat(sum));
        $('#sliptotalsumdate2').val(parseFloat(sum));
    });

    $('#slipdaytotal4').keyup(function(){
        var day = $(this).val();
        $('#slipdaytotal3').val(day);
        
    });

    $('#slipdaytotal4').change(function(){
        var day = $('#slipdaytotal2').val();
        var year = $(this).val();

        var sum = isNaN(day / year) ? 0 :(day / year).toFixed(3);

        $('#sliptotalsumdate').val(parseFloat(sum));
        $('#sliptotalsumdate2').val(parseFloat(sum));
        
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
    $('#slipoccupacy').change(function(){
         var bld = $('#slipbld_const').val();
        var ocp_id = $('#slipoccupacy').val();
        console.log(bld)
        console.log(ocp_id)
        if(bld != ''){


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
        }
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
    $('#sliptypetsi').change(function(){
        var choice = $(this).val();
        var valtsi = $('#mpshareto').val();
        var valcedshare = $('#mpshare').val();

        if(choice == '1'){
            if(valtsi == null){
                    swal('warning','please fill tsi insured value first','error')
                }else{
                    
                    var tsi = $('#mpshareto').val();
                    $('#sliptotalsum').val(tsi);
                    $('#sliptotalsum2').val(tsi);

                    var pctval = $('#sliptotalsumpct').val();

                    if(pctval != null){
                        var pct =  parseFloat($('#slippct').val())/100;

                    
                        var conv_tsi = parseInt(tsi.replace(/,/g, ""));

                        var sum = isNaN(pct * conv_tsi) ? 0 :(pct * conv_tsi).toFixed(2) ;
                        console.log(sum)
                        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $('#sliptotalsumpct').val(real_sum);
                        $('#sliptotalsumpct2').val(real_sum);
                        swal('success','changed to tsi','success')


                        var dpamount = $('#slipdpamount').val();
                        var ecamount = $('#slipamountec').val();

                        if(dpamount != null){

                            var percent =  parseFloat($('#slipdppercentage').val()) / 100;
                            
                            var sum = isNaN(percent * conv_tsi) ? 0 :(percent * conv_tsi).toFixed(2) ;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            console.log($('#slipdppercentage').val())
                            console.log(percent)
                            console.log(sum)
                            console.log(real_sum)

                            $('#slipdpamount').val(real_sum);
                            $('#slipdpamount2').val(real_sum);

                        }

                        if(ecamount != null){

                            var persentage =  parseFloat($('#slipnilaiec').val()) / 1000;
                            var sum = isNaN(conv_tsi * persentage) ? 0 :(conv_tsi * persentage).toFixed(2) ;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            console.log($('#slipnilaiec').val())
                            console.log(persentage)
                            console.log(sum)
                            console.log(real_sum)

                            $('#slipamountec').val(real_sum);
                            $('#slipamountec2').val(real_sum);

                        }

                    }
                }



        }else if(choice == '2')
        {
            if(valcedshare != null){
                var ceding_share = $('#mpshare').val();
                $('#sliptotalsum').val(ceding_share);
                $('#sliptotalsum2').val(ceding_share);

                 var pctval = $('#sliptotalsumpct').val();

                if(pctval != null){

                    var pct =  parseFloat($('#slippct').val())/100;

                    // var tsi = $("#sliptotalsum").val();
                    var conv_tsi = parseInt(ceding_share.replace(/,/g, ""));

                    var sum = isNaN(pct * conv_tsi) ? 0 :(pct * conv_tsi).toFixed(2) ;
                    console.log(sum)
                    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $('#sliptotalsumpct').val(real_sum);
                    $('#sliptotalsumpct2').val(real_sum);
                    swal('success','changed to ceding share','success')

                    var dpamount = $('#slipdpamount').val();
                    var ecamount = $('#slipamountec').val();

                    if(dpamount != null){
                        var percent =  parseFloat($('#slipdppercentage').val()) / 100;
                        
                        var sum = isNaN(percent * conv_tsi) ? 0 :(percent * conv_tsi).toFixed(2) ;
                        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        console.log($('#slipdppercentage').val())
                        console.log(percent)
                        console.log(sum)
                        console.log(real_sum)

                        $('#slipdpamount').val(real_sum);
                        $('#slipdpamount2').val(real_sum);
                    }

                    if(ecamount != null){

                        var persentage =  parseFloat($('#slipnilaiec').val()) / 1000;
                        var sum = isNaN(conv_tsi * persentage) ? 0 :(conv_tsi * persentage).toFixed(2) ;
                        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        console.log($('#slipnilaiec').val())
                        console.log(persentage)
                        console.log(sum)
                        console.log(real_sum)

                        $('#slipamountec').val(real_sum);
                        $('#slipamountec2').val(real_sum);
                        
                    }

                }
            }else{
                swal('warning','please fill ceding share first','error')
            }


        }

    });
</script>

<script type="text/javascript">
    $('#sharetypetsi').change(function(){
        var choice = $(this).val();
        if(choice == '1'){

            var tsi = $('#mpshareto').val();
            $('#sharetotalsum').val(tsi);
            $('#sharetotalsum2').val(tsi);

            var shareslipval = $('#slipshare').val();
            if(shareslipval != null){
                var shareslip =  parseFloat($('#slipshare').val()) / 100 ;
                var conv_tsi = parseInt(tsi.replace(/,/g, ""));
                var sumshare =isNaN( shareslip * conv_tsi) ? 0 :( shareslip * conv_tsi).toFixed(2) ;
                var real_sumshare = sumshare.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


                $('#slipsumshare').val(real_sumshare);
                $('#slipsumshare2').val(real_sumshare);

                var rateslipval = $('#sliprate').val();

                if(sliprate != null){

                    var insurance_period_from2 = $('#sliprpfrom').val();
                    var insurance_period_to2 = $('#sliprpto').val();
                    var newinsurance_period_from2 = insurance_period_from2.split("/").reverse().join("-");
                    var newinsurance_period_to2 = insurance_period_to2.split("/").reverse().join("-");
                    var days=daysBetween(newinsurance_period_from2, newinsurance_period_to2);
                    var insurance = (days/365);
                    
                    console.log(insurance_period_from2)
                    console.log(insurance_period_to2)
                    console.log(newinsurance_period_from2)
                    console.log(newinsurance_period_to2)
                    console.log(days)
                    console.log(insurance)

                    var rateslip =  parseFloat($(this).val()) / 1000;
                    var sumrate = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
                    var real_sumrate = sumrate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    $('#slipbasicpremium').val(real_sumrate);

                    var grossprm_to_nr = $('#slipgrossprmtonr').val();

                    if(grossprm_to_nr != null){
                        var nasionalreinsurance =  $('#mpsharefrom').val();
                        var totalnre =  $('#mpshareto').val();
                        var conv_totalnre =  parseInt(totalnre.replace(/,/g, ""));

                        console.log('nre' + nasionalreinsurance)
                            // console.log(conv_nasionalreinsurance)
                            console.log('totalnre' + totalnre)
                            console.log('convtotnre' + conv_totalnre)
                            
                            var sumshare2 = $('#slipsumshare').val() ;
                            var conv_sumshare = parseInt(sumshare2.replace(/,/g, ""));

                            var orpercent = $('#slipor').val() / 100;

                            var sumor = isNaN(orpercent * conv_sumshare) ? 0 :(orpercent * conv_sumshare).toFixed(2);
                            var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            
                            var sumgrtoprm = isNaN(rateslip * shareslip * conv_tsi) ? 0 :(rateslip * shareslip * conv_tsi).toFixed(2);
                            var real_sumgrtoprm = sumgrtoprm.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            
                            if(nasionalreinsurance){
                                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                                var sumnre = isNaN(conv_nasionalreinsurance + conv_sumshare ) ? 0 :(conv_nasionalreinsurance + conv_sumshare).toFixed(2) ;
                                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else{
                                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                                var sumnre = isNaN(0 + conv_sumshare ) ? 0 :(0 + conv_sumshare).toFixed(2) ;
                                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                            
                            
                            var sumourshare = isNaN((sumnre / conv_totalnre) * 100 ) ? 0 :((sumnre / conv_totalnre) * 100 ).toFixed(2) ;

                            console.log('sumnre' + sumnre)
                            console.log('realnre' + real_sumnre)
                            console.log('sumourshare' + sumourshare)

                            $('#slipgrossprmtonr').val(real_sumgrtoprm);
                            $('#slipgrossprmtonr2').val(real_sumgrtoprm);
                            $('#slipsumor').val(real_sumor);
                            $('#slipsumor2').val(real_sumor);
                            // $('#mpshare').val(sumourshare.replace(/,/g, "."));
                            $('#mpsharefrom').val(real_sumnre);


                            var commision =  parseFloat($(this).val()) / 100;
                            var feebroker = parseFloat($('#slipvbroker').val()) / 100;
                            var sumgrossprmtonr2 = $("#slipgrossprmtonr").val();
                            var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr2.replace(/,/g, ""));

                            var sumcomm = isNaN(commision * conv_sumgrossprmtonr) ? 0 :(commision * conv_sumgrossprmtonr).toFixed(2);
                            var real_sumcomm = sumcomm.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            $('#slipsumcommission').val(real_sumcomm);
                            $('#slipsumcommission2').val(real_sumcomm);

                            var sumgrossprmtonr3 = $("#slipgrossprmtonr").val();
                            var conv_sumgrossprmtonr2 = parseInt(sumgrossprmtonr3.replace(/,/g, ""));

                            var sumnetprmtonr = isNaN( conv_sumgrossprmtonr2 * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr2 * (100/100 - commision - feebroker)).toFixed(2);
                            var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            var sumfeebroker = isNaN( conv_sumgrossprmtonr2 * feebroker) ? 0 :(conv_sumgrossprmtonr2 * feebroker).toFixed(2);
                            var real_sumfeebroker = sumfeebroker.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


                            $('#slipnetprmtonr').val(real_sumnetprmtonr);
                            $('#slipnetprmtonr2').val(real_sumnetprmtonr);
                            // $('#slipsumfee').val("100" + "-" + commision.toString() + "-" + feebroker.toString() + "*" + conv_sumgrossprmtonr.toString());
                            $('#slipsumfee').val(real_sumfeebroker);

                            var sumipamountval = $('#slipipamount').val();

                            if(sumipamountval != null){
                                var percent =  parseFloat($(this).val()) / 100;

                                var sumnetprtonr2 = $("#slipnetprmtonr").val();
                                var conv_sumnetprtonr = parseInt(sumnetprtonr2.replace(/,/g, ""));

                                var sumipamount = isNaN(percent *  conv_sumnetprtonr) ? 0 :(percent *  conv_sumnetprtonr).toFixed(2);
                                var real_sumipamount = sumipamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                $('#slipipamount').val(real_sumipamount);
                                $('#slipipamount2').val(real_sumipamount);
                            }

                    }



                }

            }

            swal('warning!','change to tsi please change installment and retrocession amount manually','success')
        }else if(choice == '2')
        {

            var insuredid = $('#insuredIDtxt').val(); 
            var cedbrok = $('#slipcedingbroker').val();
            var ceding = $('#slipceding').val();
            if(cedbrok != null && ceding != null){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-ceding-detail')}}?ceding_id="+ceding+"&insured_id="+insuredid,
                    beforeSend: function() { $("body").addClass("loading");  },
                    complete: function() {  $("body").removeClass("loading"); },
                    success:function(res){  
                        console.log(res)      
                        if(res.type == 4){
                        // $("#slipceding option").remove();


                        // $("#slipceding").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');

                        var ceding_curr = $('#slipceding').val();
                        var totalsum = $("#sliptotalsum").val();
                        if(res.amountlist > 0)
                        {
                            console.log('sum amount ' + res.sumamount)
                            var sum = res.sumamount;
                            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            $("#sharetotalsum").val(real_sum);
                            $("#sharetotalsum2").val(real_sum);
                        }
                        else
                        {
                            console.log('hasilnya ' + res)
                        }


                    }else{
                        // $("#slipceding option").remove();
                        // $("#slipceding").append('<option value="#" selected disabled> select ceding </option>');
                        // $("#sliptotalsum").val('');
                        // $("#sliptotalsum2").val('');
                        // $.each(res,function(key,value){
                        //     $("#slipceding").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');

                        // });

                    }
                }
            });
            }else{
                swal("Error!", "Please choose Ceding/Broker first", "Get Ceding Error");
            }  
            var tsi = $('#mpshare').val();
            $('#sharetotalsum').val(tsi);
            $('#sharetotalsum2').val(tsi);

            var shareslipval = $('#slipshare').val();
            if(shareslipval != null){
                var shareslip =  parseFloat($('#slipshare').val()) / 100 ;
                var conv_tsi = parseInt(tsi.replace(/,/g, ""));
                var sumshare =isNaN( shareslip * conv_tsi) ? 0 :( shareslip * conv_tsi).toFixed(2) ;
                var real_sumshare = sumshare.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


                $('#slipsumshare').val(real_sumshare);
                $('#slipsumshare2').val(real_sumshare);

                var rateslipval = $('#sliprate').val();

                if(sliprate != null){

                    var insurance_period_from2 = $('#sliprpfrom').val();
                    var insurance_period_to2 = $('#sliprpto').val();
                    var newinsurance_period_from2 = insurance_period_from2.split("/").reverse().join("-");
                    var newinsurance_period_to2 = insurance_period_to2.split("/").reverse().join("-");
                    var days=daysBetween(newinsurance_period_from2, newinsurance_period_to2);
                    var insurance = (days/365);
                    
                    console.log(insurance_period_from2)
                    console.log(insurance_period_to2)
                    console.log(newinsurance_period_from2)
                    console.log(newinsurance_period_to2)
                    console.log(days)
                    console.log(insurance)

                    var rateslip =  parseFloat($(this).val()) / 1000;
                    var sumrate = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
                    var real_sumrate = sumrate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    $('#slipbasicpremium').val(real_sumrate);

                    var grossprm_to_nr = $('#slipgrossprmtonr').val();

                    if(grossprm_to_nr != null){
                        var nasionalreinsurance =  $('#mpsharefrom').val();
                        var totalnre =  $('#mpshareto').val();
                        var conv_totalnre =  parseInt(totalnre.replace(/,/g, ""));

                        console.log('nre' + nasionalreinsurance)
                            // console.log(conv_nasionalreinsurance)
                            console.log('totalnre' + totalnre)
                            console.log('convtotnre' + conv_totalnre)
                            
                            var sumshare2 = $('#slipsumshare').val() ;
                            var conv_sumshare = parseInt(sumshare2.replace(/,/g, ""));

                            var orpercent = $('#slipor').val() / 100;

                            var sumor = isNaN(orpercent * conv_sumshare) ? 0 :(orpercent * conv_sumshare).toFixed(2);
                            var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            
                            var sumgrtoprm = isNaN(rateslip * shareslip * conv_tsi) ? 0 :(rateslip * shareslip * conv_tsi).toFixed(2);
                            var real_sumgrtoprm = sumgrtoprm.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            
                            if(nasionalreinsurance){
                                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                                var sumnre = isNaN(conv_nasionalreinsurance + conv_sumshare ) ? 0 :(conv_nasionalreinsurance + conv_sumshare).toFixed(2) ;
                                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else{
                                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                                var sumnre = isNaN(0 + conv_sumshare ) ? 0 :(0 + conv_sumshare).toFixed(2) ;
                                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                            
                            
                            var sumourshare = isNaN((sumnre / conv_totalnre) * 100 ) ? 0 :((sumnre / conv_totalnre) * 100 ).toFixed(2) ;

                            console.log('sumnre' + sumnre)
                            console.log('realnre' + real_sumnre)
                            console.log('sumourshare' + sumourshare)

                            $('#slipgrossprmtonr').val(real_sumgrtoprm);
                            $('#slipgrossprmtonr2').val(real_sumgrtoprm);
                            $('#slipsumor').val(real_sumor);
                            $('#slipsumor2').val(real_sumor);
                            // $('#mpshare').val(sumourshare.replace(/,/g, "."));
                            $('#mpsharefrom').val(real_sumnre);


                            var commision =  parseFloat($(this).val()) / 100;
                            var feebroker = parseFloat($('#slipvbroker').val()) / 100;
                            var sumgrossprmtonr2 = $("#slipgrossprmtonr").val();
                            var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr2.replace(/,/g, ""));

                            var sumcomm = isNaN(commision * conv_sumgrossprmtonr) ? 0 :(commision * conv_sumgrossprmtonr).toFixed(2);
                            var real_sumcomm = sumcomm.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            $('#slipsumcommission').val(real_sumcomm);
                            $('#slipsumcommission2').val(real_sumcomm);

                            var sumgrossprmtonr3 = $("#slipgrossprmtonr").val();
                            var conv_sumgrossprmtonr2 = parseInt(sumgrossprmtonr3.replace(/,/g, ""));

                            var sumnetprmtonr = isNaN( conv_sumgrossprmtonr2 * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr2 * (100/100 - commision - feebroker)).toFixed(2);
                            var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            var sumfeebroker = isNaN( conv_sumgrossprmtonr2 * feebroker) ? 0 :(conv_sumgrossprmtonr2 * feebroker).toFixed(2);
                            var real_sumfeebroker = sumfeebroker.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


                            $('#slipnetprmtonr').val(real_sumnetprmtonr);
                            $('#slipnetprmtonr2').val(real_sumnetprmtonr);
                            // $('#slipsumfee').val("100" + "-" + commision.toString() + "-" + feebroker.toString() + "*" + conv_sumgrossprmtonr.toString());
                            $('#slipsumfee').val(real_sumfeebroker);

                            var sumipamountval = $('#slipipamount').val();

                            if(sumipamountval != null){
                                var percent =  parseFloat($(this).val()) / 100;

                                var sumnetprtonr2 = $("#slipnetprmtonr").val();
                                var conv_sumnetprtonr = parseInt(sumnetprtonr2.replace(/,/g, ""));

                                var sumipamount = isNaN(percent *  conv_sumnetprtonr) ? 0 :(percent *  conv_sumnetprtonr).toFixed(2);
                                var real_sumipamount = sumipamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                $('#slipipamount').val(real_sumipamount);
                                $('#slipipamount2').val(real_sumipamount);
                            }

                    }



                }

            }

            swal('warning!','change to ceding share please change installment and retrocession amount manually','success')

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
                        $("#slipceding option").remove();


                        $("#slipceding").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');

                        // var ceding_curr = $('#slipceding').val();
                        // var totalsum = $("#sliptotalsum").val();
                        // if(res.amountlist > 0)
                        // {
                        //     console.log('sum amount ' + res.sumamount)
                        //     var sum = res.sumamount;
                        //     var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        //     $("#sliptotalsum").val(real_sum);
                        //     $("#sliptotalsum2").val(real_sum);
                        // }
                        // else
                        // {
                        //     console.log('hasilnya ' + res)
                        // }


                    }else{
                        $("#slipceding option").remove();
                        $("#slipceding").append('<option value="#" selected disabled> select ceding </option>');
                        $("#sliptotalsum").val('');
                        $("#sliptotalsum2").val('');
                        $.each(res,function(key,value){
                            $("#slipceding").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');

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
        if(ceding){
            $.ajax({
                type:"GET",
                url:"{{url('get-ceding-detail')}}?ceding_id="+ceding+"&insured_id="+insuredid,
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(res){  
                    console.log(res)      
                    if(res.type == 4){
                    // $("#slipceding option").remove();


                    $("#slipceding").append('<option value="'+res.id+'">'+res.type+' - '+res.code+' - '+res.name+'</option>');
                    var ceding_curr = $('#slipceding').val();
                    var totalsum = $("#sliptotalsum").val();
                    // if(res.amountlist > 0)
                    // {
                    //     console.log('sum amount ' + res.sumamount)
                    //     var sum = res.sumamount;
                    //     var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    //     $("#sliptotalsum").val(real_sum);
                    //     $("#sliptotalsum2").val(real_sum);
                    // }
                    // else
                    // {
                    //     console.log('hasilnya ' + res)
                    // }
                    

                }else{
                    $("#slipceding option").remove();

                    $.each(res,function(key,value){
                       $("#slipceding").append('<option value="'+value.id+'">'+value.type+' - '+value.code+' - '+value.name+'</option>');

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
                            // $("#mpsharefrom").val(real_sum);
                            // // $("#mpshareto").val(real_sum);
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
                            // // $("#mpsharefrom").val(real_sum);
                            // $("#mpshareto").val(real_sum);
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
                            // $("#mpsharefrom").val(real_sum);
                            // // $("#mpshareto").val(real_sum);
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
                            // // $("#mpsharefrom").val(real_sum);
                            // $("#mpshareto").val(real_sum);
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
                            // $("#mpsharefrom").val(real_sum);
                            // // $("#mpshareto").val(real_sum);
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
                            // // $("#mpsharefrom").val(real_sum);
                            // $("#mpshareto").val(real_sum);
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
                            // $("#mpsharefrom").val(real_sum);
                            // // $("#mpshareto").val(real_sum);
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
                            // // $("#mpsharefrom").val(real_sum);
                            // $("#mpshareto").val(real_sum);
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
$(document).ready(function(){

 var count = 1;
 $(".e1").select2({ width: '100%' });

 $('.uang').mask("#,##0.00", {reverse: true});

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


 $("#btnaddlayer").attr('hidden','true');
        $("#sliplayerproportional").attr('hidden','true');
        $("#labelnonprop").attr('hidden','true');
        $("#tabretro").attr('hidden','true');
        $("#tabretrodetail").attr('hidden','true');
        $("#tabretroupdate").attr('hidden','true');
        $("#tabretroendorsement").attr('hidden','true');

        $("#mpsharefrom").val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $("#mpshareto").val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


    $("#slipipfrom").change(function(){
        console.log($(this).val())
        $("#sliprpfrom").val($(this).val());
    });

    $("#slipipto").change(function(){
        console.log($(this).val())
        $("#sliprpto").val($(this).val());
    });

    $("#btn-success2").click(function(){ 
    var html = $(".clone2").html();
    $(".increment2").after(html);
    });

    $("body").on("click","#btn-danger2",function(){ 
    $(this).parents("#control-group2").remove();
    });

 dynamic_field(count);

 function dynamic_field(number)
 {
  html = '<tr>';
        html += '<td><input type="text" name="first_name[]" class="form-control" /></td>';
        html += '<td><input type="text" name="last_name[]" class="form-control" /></td>';
        if(number > 1)
        {
            html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
            $('#user_table tbody').append(html);
        }
        else
        {   
            html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
            $('#user_table tbody').html(html);
        }
 }

 $(document).on('click', '#add', function(){
  count++;
  dynamic_field(count);
 });

 $(document).on('click', '.remove', function(){
  count--;
  $(this).closest("tr").remove();
 });

 $('#dynamic_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            method:'post',
            data:$(this).serialize(),
            dataType:'json',
            beforeSend:function(){
                $('#save').attr('disabled','disabled');
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(data)
            {
                if(data.error)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<p>'+data.error[count]+'</p>';
                    }
                    $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                }
                else
                {
                    dynamic_field(1);
                    $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                }
                $('#save').attr('disabled', false);
            }
        })
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
                        '<th>CN/DN</th>'+
                        '<th>Cert No</th>'+
                        '<th>Slip No</th>'+
                        '<th>Policy No</th>'+
                        '<th>Share</th>'+
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
                //$("#mpshareto").val(real_sum);

            }
        });
}
</script>



<script type='text/javascript'>
   $('#form-addlocationdetail').submit(function(e){
    e.preventDefault();

    var insurednoloc = $('#insurednoloc').val();
    var token = $('input[name=_token]').val();
        // var kurs = $('#slipcurrency').val();

        // if(kurs)
        // {
        // }
        // else
        // {
        //     kurs=3;
        // }
        
        
        var slipinterestid = $('#slipinterestlistlocation').val();
        var cndn = $('#cndn').val();
        var certno = $('#certno').val();
        var ceding_id = $('#ceding_id').val();
        var slipno = $('#slipno').val();
        var policyno = $('#policyno').val();
        var percent = $('#percentceding').val();
        var amountlocation = $('#amountlocation').val();

        var conv_amount = amountlocation.replace(/,/g, "");
        console.log(conv_amount)
        var real_amount = parseInt(conv_amount);
        console.log(real_amount)
        

        if(slipinterestid == null || ceding_id == null){
            swal('warning','please choose interest or ceding first','insert error')
        }else{
            $.ajax({
            url:"{{ route('locationlistdetail.store') }}",
            type:"POST",
            data:{
                slipinterestid:slipinterestid,
                cndn:cndn,
                certno:certno,
                slipno:slipno,
                policyno:policyno,
                ceding_id:ceding_id,
                percent_ceding:percent,
                amountlocation:real_amount,
                insurednoloc:insurednoloc,
                // kurs:kurs,
                _token:token
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                console.log(response)

                    // if(response.kurs)
                    // {
                    //     var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: response.kurs,}).format(response.amountlocation);

                    // }
                    // else
                    // {
                    //     var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amountlocation);
                    // }

                    var amount = response.amountlocation;
                    var ceding_share = $('#mpshare').val();
                    if(ceding_share == ''){
                        var sum_ceding = isNaN(parseFloat(0) + parseFloat(amount)) ? 0 :(parseFloat(0) + parseFloat(amount));
                        var conv_sum_ceding = sum_ceding.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $('#mpshare').val(conv_sum_ceding);
                        console.log('ceding awal' + conv_sum_ceding)
                    }else{
                        var conv_ceding_share = ceding_share.replace(/,/g, "");
                        var real_ceding_share = parseInt(conv_ceding_share);
                        var sum_ceding = isNaN(parseFloat(real_ceding_share) + parseFloat(amount)) ? 0 :(parseFloat(real_ceding_share) + parseFloat(amount));
                        var conv_sum_ceding = sum_ceding.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $('#mpshare').val(conv_sum_ceding);
                        console.log('ceding bertambah' + conv_sum_ceding)


                    }


                    var curr_amount = response.amountlocation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    var cndn = '';
                    var certno = '';
                    var slipno = '';
                    var policyno = '';

                    if(response.cndn == null){
                        cndn = '-';
                    }else{
                        cndn = response.cndn;
                    }

                    if(response.certno == null){
                        certno = '-';
                    }else{
                        certno = response.certno;
                    }

                    if(response.slipno == null){
                        slipno = '-';
                    }else{
                        slipno = response.slipno;
                    }

                    if(response.policyno == null){
                        policyno = '-';
                    }else{
                        policyno = response.policyno;
                    }

                    
                    $('#tcid'+insurednoloc+' > tbody:last-child').prepend('<tr id="riskdetailsid'+response.id+'">'+
                        '<td>'+response.interest_name+'</td>'+
                        '<td>'+response.cedingbroker+'</td>'+
                        '<td>'+cndn+'</td>'+
                        '<td>'+certno+'</td>'+
                        '<td>'+slipno+'</td>'+
                        '<td>'+policyno+'</td>'+
                        '<td>'+response.percent+'</td>'+
                        '<td>'+curr_amount+'</td>'+
                        '<td>'+
                        '<a href="javascript:void(0)" onclick="deletelocationriskdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td>'+
                        '</tr>');

                    
                    $('#addlocdetailmodaldata').modal('toggle');
                    // $('#slipamount').val('');
                    // $('#slipinterestlist').val('');
                    
                    // var totalnre = $('#mpshareto').val();
                    
                    // if(totalnre){
                    //     var conv_totalnre = parseFloat(totalnre.replace(/,/g, ""));
                    //     var sumtotalnre = isNaN(conv_totalnre +  parseFloat(response.amountlocation)) ? (conv_totalnre +  parseFloat(response.amountlocation)) : (conv_totalnre +  parseFloat(response.amountlocation)) ;
                    //     var real_sumtotalnre = sumtotalnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    //     console.log(conv_totalnre)
                    //     console.log(real_sumtotalnre)

                    //     $('#mpshareto').val(real_sumtotalnre);
                    // }
                    // else{
                    //     var conv_totalnre = totalnre.replace(/,/g, "");
                    //     var sumtotalnre = isNaN(0 + parseFloat(response.amountlocation)) ? (0 + parseFloat(response.amountlocation)) : (0 + parseFloat(response.amountlocation)) ;
                    //     var real_sumtotalnre = sumtotalnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    //     console.log(conv_totalnre)
                    //     console.log(real_sumtotalnre)

                    //     $('#mpshareto').val(real_sumtotalnre)
                    // }
                    

                    // var ceding_curr = $('#slipceding').val();
                    // var totalsum = $("#sliptotalsum").val();
                    // if(response.cedinglocation == ceding_curr)
                    // {
                    //     if(totalsum == '')
                    //     {
                    //         var total_num = 0;
                    //         var sum = isNaN(total_num + response.amountlocation) ? (0 + response.amountlocation) : (total_num + response.amountlocation) ;
                    //         var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    //         console.log(' sum : ' + sum)
                    //         console.log(' real sum : ' + real_sum)
                    //         $("#sliptotalsum").val(real_sum);
                    //         $("#sliptotalsum2").val(real_sum);
                    //         // $("#msishareto").val(real_sum);
                    //         // $("#mpsharefrom").val(real_sum);
                    //         // $("#mpshareto").val(real_sum);
                    //     }
                    //     else
                    //     {

                    //         var conv_total = totalsum.replace(/,/g, "");
                    //         console.log('conv total : ' + conv_total)
                    //         var real_total = parseInt(conv_total);
                    //         console.log('real total : ' + real_total)
                    //         var total =  parseFloat(real_total);
                    //         console.log(' total : ' + total)
                    //         var sum = isNaN(total + response.amountlocation) ? (0 + response.amountlocation) : (total + response.amountlocation) ;
                    //         var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    //         console.log(' sum : ' + sum)
                    //         console.log(' real sum : ' + real_sum)
                    //         $("#sliptotalsum").val(real_sum);
                    //         $("#sliptotalsum2").val(real_sum);
                    //         // $("#mpsharefrom").val(real_sum);
                    //         // $("#mpshareto").val(real_sum);
                    //     }
                    // }else{
                        swal("success!", "ceding share has increase", "success");
                        
                    // }
                }
            });
        }

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

            // var totalnre = $('#mpshareto').val();
            // var conv_totalnre = totalnre.replace(/,/g, "");

            // var sumtotalnre = isNaN(parseFloat(conv_totalnre) - parseFloat(response.amountlocation)) ? (parseFloat(conv_totalnre) - parseFloat(response.amountlocation)) : (parseFloat(conv_totalnre) - parseFloat(response.amountlocation)) ;
            // var real_sumtotalnre = sumtotalnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // $('#mpshareto').val(real_sumtotalnre);

                //$('#cid'+id).remove();
                var amount = response.amountlocation;
                var ceding_share = $('#mpshare').val();
                
                var conv_ceding_share = ceding_share.replace(/,/g, "");
                var real_ceding_share = parseInt(conv_ceding_share);
                var sum_ceding = isNaN(parseFloat(real_ceding_share) - parseFloat(amount)) ? 0 :(parseFloat(real_ceding_share) - parseFloat(amount));
                var conv_sum_ceding = sum_ceding.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $('#mpshare').val(conv_sum_ceding);
                console.log('ceding bertambah' + conv_sum_ceding)
                
                    // $("#mpshareto").val(real_sum);

            // swal("Warning!", "TSI not decrease because this ceding is not same with ceding in slip", "Tsi not decrease");
            swal("success!", "ceding share has decrease", "success");

                    // $("#sliptotalsum").val(real_sum);
                    // $("#mpshareto").val(real_sum);



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
                    $("#mpshareto").val(real_sum);
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
                    $("#mpshareto").val(real_sum);
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
               $("#mpsharetoupdate").val(sum);

               

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
               $("#mpsharetoendorsement").val(sum);

               

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
                $("#mpsharetoupdate").val(sum);
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
                $("#mpsharetoendorsement").val(sum);
            }
        });
    }
</script>

<script type="text/javascript">
    $('#percentceding').keyup(function(e){
        if(e.keyCode != 9){
            var percentceding = parseFloat($(this).val()) / 100 ;
            var valtsi = $('#mpshareto').val();

            if(valtsi != null){
                var tsi = $('#mpshareto').val();
                var conv_tsi = parseInt(tsi.replace(/,/g, ""));

                var sum_amount = isNaN(percentceding * conv_tsi) ? 0 :(percentceding * conv_tsi).toFixed(2);
                var real_sum = sum_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $('#amountlocation').val(real_sum);
            }else{
                swal('warning!','please fill TSI insured first','error')
            }
        }
        else{
            var percentceding = parseFloat($(this).val()) / 100 ;
            var valtsi = $('#mpshareto').val();

            if(valtsi != null){
                var tsi = $('#mpshareto').val();
                var conv_tsi = parseInt(tsi.replace(/,/g, ""));

                var sum_amount = isNaN(percentceding * conv_tsi) ? 0 :(percentceding * conv_tsi).toFixed(2);
                var real_sum = sum_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $('#amountlocation').val(real_sum);
            }else{
                swal('warning!','please fill TSI insured first','error')
            }
        }

    });
</script>

<script type="text/javascript">
    $('#amountlocation').change(function(e){
        if(e.keyCode != 9){
            var amountlocation = $(this).val();
            var conv_amountlocation = parseInt(amountlocation.replace(/,/g, ""));
            console.log(amountlocation)
            console.log(conv_amountlocation)
            var valtsi = $('#mpshareto').val();

            if(valtsi != null){
                var tsi = $('#mpshareto').val();
                var conv_tsi = parseInt(tsi.replace(/,/g, ""));

                var sum_amount = isNaN((conv_amountlocation / conv_tsi)*100) ? 0 :((conv_amountlocation / conv_tsi)*100).toFixed(2);
                var real_sum = sum_amount.toString();
                console.log(sum_amount)
                console.log(real_sum)
                $('#percentceding').val(real_sum);
            }else{
                swal('warning!','please fill TSI insured first','error')
            }
        }
        else{
            var amountlocation = $(this).val() ;
            var conv_amountlocation = parseInt(amountlocation.replace(/,/g, ""));

            console.log(amountlocation)
            console.log(conv_amountlocation)
            var valtsi = $('#mpshareto').val();

            if(valtsi != null){
                var tsi = $('#mpshareto').val();
                var conv_tsi = parseInt(tsi.replace(/,/g, ""));

                var sum_amount = isNaN((conv_amountlocation / conv_tsi)*100) ? 0 :((conv_amountlocation / conv_tsi)*100).toFixed(2);
                var real_sum = sum_amount.toString();
                console.log(sum_amount)
                console.log(real_sum)
                $('#percentceding').val(real_sum);
            }else{
                swal('warning!','please fill TSI insured first','error')
            }
        }

    });
</script>


<script  type='text/javascript'>
    $('#slippctupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var pct =  parseFloat($(this).val())/100;
            
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));

            var sum = isNaN(pct * conv_tsi) ? 0 :(pct * conv_tsi).toFixed(2) ;
            console.log(sum)
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#sliptotalsumpctupdate').val(real_sum);
            $('#sliptotalsumpctupdate2').val(real_sum);
        }
    });

    $('#slipdppercentageupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var percent =  $(this).val() / 100;
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));
            var sum = isNaN(percent * conv_tsi) ? 0 :(percent * conv_tsi).toFixed(2) ;
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#slipdpamountupdate').val(real_sum);
            $('#slipdpamountupdate2').val(real_sum);
        }
    });

    $('#slipshareupdate').keyup(function (e) 
    {
        if(e.keyCode != 9){
            var shareslip =  $(this).val() / 100 ;
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));
            var sumshare =isNaN( shareslip * conv_tsi) ? 0 :( shareslip * conv_tsi).toFixed(2) ;
            var real_sumshare = sumshare.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            $('#slipsumshareupdate').val(real_sumshare);
            $('#slipsumshareupdate2').val(real_sumshare);
        }
    });


    $('#sliprateupdate').keyup(function (e) {
        if(e.keyCode != 9){
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
            
            var rateslip =  $(this).val() / 1000;
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));
            var sum = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            $('#slipbasicpremiumupdate').val(real_sum);
        }
    });

    $('#slipshareupdate').change(function (e) {
        if(e.keyCode != 9){
            var rateslip =  $('#sliprateupdate').val() / 1000 ;
            var shareslip =  $('#slipshareupdate').val() / 100 ;
            var nasionalreinsurance =  $('#mpsharefromupdate').val();
            var totalnre =  $('#mpsharetoupdate').val();
            var conv_totalnre =  parseInt(totalnre.replace(/,/g, ""));

            console.log('nre' + nasionalreinsurance)
            // console.log(conv_nasionalreinsurance)
            console.log('totalnre' + totalnre)
            console.log('convtotnre' + conv_totalnre)
            
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));

            var sumshare = $('#slipsumshareupdate').val() ;
            var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

            var orpercent = $('#sliporupdate').val() / 100;
            
            var sumor = isNaN(orpercent * conv_sumshare) ? 0 :(orpercent * conv_sumshare).toFixed(2);
            var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            var sum = isNaN(rateslip * shareslip * conv_tsi) ? 0 :(rateslip * shareslip * conv_tsi).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            if(nasionalreinsurance){
                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                var sumnre = isNaN(conv_nasionalreinsurance + conv_sumshare ) ? 0 :(conv_nasionalreinsurance + conv_sumshare).toFixed(2) ;
                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }else{
                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                var sumnre = isNaN(0 + conv_sumshare ) ? 0 :(0 + conv_sumshare).toFixed(2) ;
                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            
            
            var sumourshare = isNaN((sumnre / conv_totalnre) * 100 ) ? 0 :((sumnre / conv_totalnre) * 100 ).toFixed(2) ;
            
            console.log('sumnre' + sumnre)
            console.log('realnre' + real_sumnre)
            console.log('sumourshare' + sumourshare)

            $('#slipgrossprmtonrupdate').val(real_sum);
            $('#slipgrossprmtonrupdate2').val(real_sum);
            $('#slipsumorupdate').val(real_sumor);
            $('#slipsumorupdate2').val(real_sumor);
            $('#mpshareupdate').val(sumourshare.replace(/,/g, "."));
            $('#mpsharefromupdate').val(real_sumnre);

            // $('#slipsumshare').val(real_sum);
            // $('#msisharev').val(shareslip);
                // $('#msisharefrom').val(real_sumourshare);
            // $('#msisumsharev').val(sumourshare);
        }
    });

    $('#slipcommissionupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var commision =  $(this).val() / 100;
            var feebroker = $('#slipvbrokerupdate').val() / 100;

            var sumgrossprmtonr = $("#slipgrossprmtonrupdate").val();
            var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));
            
            var sum = isNaN(commision * conv_sumgrossprmtonr) ? 0 :(commision * conv_sumgrossprmtonr).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            var sumnetprmtonr = isNaN( conv_sumgrossprmtonr * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr * (100/100 - commision - feebroker)).toFixed(2);
            var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            $('#slipsumcommissionupdate').val(real_sum);
            $('#slipsumcommissionupdate2').val(real_sum);
            $('#slipnetprmtonrupdate').val(real_sumnetprmtonr);
            $('#slipnetprmtonrupdate2').val(real_sumnetprmtonr);

            
        }
    });

    $('#slipvbrokerupdate').keyup(function(){
        var feebroker = $('#slipvbrokerupdate').val() / 100;
        var commision =  $('#slipcommissionupdate').val() / 100;
        var sumgrossprmtonr = $("#slipgrossprmtonrupdate").val();
        var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));

        var sumnetprmtonr = isNaN( conv_sumgrossprmtonr * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr * (100/100 - commision - feebroker)).toFixed(2);
        var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipnetprmtonrupdate').val(real_sumnetprmtonr);
        $('#slipnetprmtonrupdate2').val(real_sumnetprmtonr);
        $('#slipsumfeeupdate').val("100" + "-" + commision.toString() + "-" + feebroker.toString() + "*" + conv_sumgrossprmtonr.toString());

    });

    $('#slipippercentageupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var percent =  $(this).val() / 100;
            
            var sumnetprtonr = $("#slipnetprmtonrupdate").val();
            var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

            var sum = isNaN(percent *  conv_sumnetprtonr) ? 0 :(percent *  conv_sumnetprtonr).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $('#slipipamountupdate').val(real_sum);
            $('#slipipamountupdate2').val(real_sum);
        }
    });

    $('#sliporupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var percent =  $(this).val() / 100;
            var sumshare = $("#slipsumshareupdate").val();
            var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

            var sum = isNaN(percent * conv_sumshare) ? 0 :(percent * conv_sumshare).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $('#slipsumorupdate').val(real_sum);
            $('#slipsumorupdate2').val(real_sum);
        }
    });

    $('#sliprppercentageupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var percentval =  $(this).val() / 100;
            var sumor = $('#slipsumorupdate').val() ;
            var conv_sumor = parseInt(sumor.replace(/,/g, ""));
            var sumrpamount = isNaN(percentval * conv_sumor) ? 0 :(percentval * conv_sumor).toFixed(2);
            var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
            // $('#slipor').val(sumpercentor);
            $('#sliprpamountupdate').val(real_sumrpamount);
            $('#sliprpamountupdate2').val(real_sumrpamount);
        }
    });

    $('#sliprppercentageupdate').change(function (e) {
        if(e.keyCode != 9){
            var percentval =  $(this).val();
            var orpercent = $('#sliporupdate').val();
            var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval).toFixed(2);
            $('#sliporupdate').val(sumpercentor);

            var percent =  $('#sliporupdate').val() / 100;
            var sumshare = $("#slipsumshareupdate").val();
            var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

            var sum = isNaN(percent * conv_sumshare) ? 0 :(percent * conv_sumshare).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $('#slipsumorupdate').val(real_sum);
            $('#slipsumorupdate2').val(real_sum);
        }
    });
</script>


<script  type='text/javascript'>
    $('#slippctendorsement').keyup(function (e) {
        if(e.keyCode != 9){
            var pct =  parseFloat($(this).val())/100;
            
            var tsi = $("#sliptotalsumendorsement").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));

            var sum = isNaN(pct * conv_tsi) ? 0 :(pct * conv_tsi).toFixed(2) ;
            console.log(sum)
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#sliptotalsumpctendorsement').val(real_sum);
        }
    });

     $('#slipdppercentageendorsement').keyup(function () {
        var percent =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumendorsement").val());
        var sum = isNaN(percent * tsi/100) ? 0 :(percent * tsi/100) ;
        $('#slipdpamountendorsement').val(sum);
     });

     $('#slipshareendorsement').keyup(function () {
        var shareslip =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumendorsement").val());
        var sum = isNaN(shareslip * tsi/100) ? 0 :(shareslip * tsi/100) ;
        $('#slipsumshareendorsement').val(sum);
        $('#mpshareendorsement').val(shareslip);
     });

     $('#sliprateendorsement').keyup(function () {
        var rateslip =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumendorsement").val());
        var sum = isNaN(rateslip * tsi/100) ? 0 :(rateslip * tsi/100) ;
        $('#slipbasicpremiumendorsement').val(sum);
     });

     $('#slipshareendorsement').change(function () {
        var rateslip =  parseFloat($('#sliprateendorsement').val()) / 100 ;
        var shareslip =  parseFloat($('#slipshareendorsement').val()) / 100 ;
        var ourshare =  parseFloat($('#mpshareendorsement').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsumendorsement").val());
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * tsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonrendorsement').val(sum);
        $('#mpsharefromendorsement').val(sumourshare);
     });

     $('#slipcommissionendorsement').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = parseFloat($("#slipgrossprmtonrendorsement").val());
        var sum = isNaN(commision * sumgrossprmtonr/100) ? 0 :(commision * sumgrossprmtonr/100);
        var sumnetprmtonr = isNaN( sumgrossprmtonr * (100/100 - commision)) ? 0 :(sumgrossprmtonr * (100/100 - commision));
        $('#slipsumcommissionendorsement').val(sum);
        $('#slipnetprmtonrendorsement').val(sumnetprmtonr);
    });

    $('#sliporendorsement').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = parseFloat($("#slipsumshareendorsement").val());
        var sum = isNaN(percent * sumshare) ? 0 :(percent * sumshare);
        $('#slipsumorendorsement').val(sum);
    });

    $('#sliprppercentageendorsement').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = parseFloat($("#slipsumshareendorsement").val());
        var sum = isNaN(percent * sumshare) ? 0 :(percent * sumshare);
        $('#sliprpamountendorsement').val(sum);
    });

    $('#slipippercentageendorsement').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumnetprtonr = parseFloat($("#slipnetprmtonrendorsement").val());
        var sum = isNaN(percent * sumnetprtonr) ? 0 :(percent * sumnetprtonr);
        $('#slipipamountendorsement').val(sum);
    });
</script>


<script type="text/javascript">
    $('#mpshareto').keyup(function(){
        var tsislip = $('#sliptotalsum').val();
        var typetsi = $('#sliptypetsi').val();
        

        if(tsislip != null && typetsi == '1'){
            $('#sliptotalsum').val($(this).val());
            $('#sliptotalsum2').val($(this).val());
                    
        }
    });

     $('#mpshareto').change(function(){
        var sumpct = $('#sliptotalsumpct').val();
        var typetsi = $('#sliptypetsi').val();


        if(sumpct != '' && typetsi == '1'){
                var pct =  parseFloat($('#slippct').val())/100;

                var tsi = $("#sliptotalsum").val();
                var conv_tsi = parseInt(tsi.replace(/,/g, ""));

                var sum = isNaN(pct * conv_tsi) ? 0 :(pct * conv_tsi).toFixed(2) ;
                console.log(sum)
                var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $('#sliptotalsumpct').val(real_sum);
                $('#sliptotalsumpct2').val(real_sum);

                var dpamount = $('#slipdpamount').val();
                var ecamount = $('#slipamountec').val();

                swal('Success!','tsi in slip changed, please change value in risk detail, deductible and extendcoverage manually','success')

                if(dpamount != null){
                    var percent =  parseFloat($('#slipdppercentage').val()) / 100;
                    
                    var sum = isNaN(percent * conv_tsi) ? 0 :(percent * conv_tsi).toFixed(2) ;
                    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    console.log($('#slipdppercentage').val())
                    console.log(percent)
                    console.log(sum)
                    console.log(real_sum)

                    $('#slipdpamount').val(real_sum);
                    $('#slipdpamount2').val(real_sum);
                }

                if(ecamount != null){

                    var persentage =  parseFloat($('#slipnilaiec').val()) / 1000;
                    var sum = isNaN(conv_tsi * persentage) ? 0 :(conv_tsi * persentage).toFixed(2) ;
                    var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    console.log($('#slipnilaiec').val())
                    console.log(persentage)
                    console.log(sum)
                    console.log(real_sum)

                    $('#slipamountec').val(real_sum);
                    $('#slipamountec2').val(real_sum);
                    
                }

                


            }
            else{
                swal('Success!','tsi in slip changed, please change value in risk detail','success')
            }    
     });
</script>


<script  type='text/javascript'>
   $('#slippct').keyup(function (e) {
    if(e.keyCode != 9){
        var pct =  parseFloat($(this).val())/100;

        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));

        var sum = isNaN(pct * conv_tsi) ? 0 :(pct * conv_tsi).toFixed(2) ;
        console.log(sum)
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('#sliptotalsumpct').val(real_sum);
        $('#sliptotalsumpct2').val(real_sum);
    }
});

   $('#slipdppercentage').keyup(function (e) {
    if(e.keyCode != 9){
        var percent =  parseFloat($(this).val()) / 100;
        var tsi = $("#sliptotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN(percent * conv_tsi) ? 0 :(percent * conv_tsi).toFixed(2) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        console.log($(this).val())
        console.log(percent)
        console.log(sum)
        console.log(real_sum)

        $('#slipdpamount').val(real_sum);
        $('#slipdpamount2').val(real_sum);
    }
});

   $('#slipshare').keyup(function (e) 
   {
    if(e.keyCode != 9){
        var shareslip =  parseFloat($(this).val()) / 100 ;
        var tsi = $("#sharetotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sumshare =isNaN( shareslip * conv_tsi) ? 0 :( shareslip * conv_tsi).toFixed(2) ;
        var real_sumshare = sumshare.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


        $('#slipsumshare').val(real_sumshare);
        $('#slipsumshare2').val(real_sumshare);
    }
});


   $('#sliprate').keyup(function (e) {
    if(e.keyCode != 9){
        var insurance_period_from2 = $('#sliprpfrom').val();
        var insurance_period_to2 = $('#sliprpto').val();
        var newinsurance_period_from2 = insurance_period_from2.split("/").reverse().join("-");
        var newinsurance_period_to2 = insurance_period_to2.split("/").reverse().join("-");
        var days=daysBetween(newinsurance_period_from2, newinsurance_period_to2);
        var insurance = (days/365);
        
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(newinsurance_period_from2)
        console.log(newinsurance_period_to2)
        console.log(days)
        console.log(insurance)

        var rateslip =  parseFloat($(this).val()) / 1000;
        var tsi = $("#sharetotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipbasicpremium').val(real_sum);
    }else{
        var insurance_period_from2 = $('#sliprpfrom').val();
        var insurance_period_to2 = $('#sliprpto').val();
        var newinsurance_period_from2 = insurance_period_from2.split("/").reverse().join("-");
        var newinsurance_period_to2 = insurance_period_to2.split("/").reverse().join("-");
        var days=daysBetween(newinsurance_period_from2, newinsurance_period_to2);
        var insurance = (days/365);
        
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(newinsurance_period_from2)
        console.log(newinsurance_period_to2)
        console.log(days)
        console.log(insurance)

        var rateslip =  parseFloat($(this).val()) / 1000;
        var tsi = $("#sharetotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipbasicpremium').val(real_sum);
    }
});

    $('#sliprate').change(function(){
        var rate_lower = $('#slipbcla').val();
        var rate_upper = $('#slipbcua').val();
        var rate = $('#sliprate').val();
        if(rate_upper != '' || rate_lower != ''){
            var rate_lower_val = parseFloat(rate_lower);
            var rate_upper_val = parseFloat(rate_upper);
            var rate_val = parseFloat(rate) / 1000;
            console.log(rate_lower_val)
            console.log(rate_upper_val)
            console.log(rate_val)
            if(rate_val < rate_lower_val || rate_val > rate_upper_val ){
                swal('warning','please input rate between rate lower and rate upper building','input error')
            }
        }else{
            swal('warning','please choose building const first','error')
        }
   });

   $("#slipbasicpremium").keydown(function(e) { 
    var keyCode = e.keyCode || e.which; 

      if (keyCode == 9) { 
        // e.preventDefault(); 

        var insurance_period_from2 = $('#sliprpfrom').val();
        var insurance_period_to2 = $('#sliprpto').val();
        var newinsurance_period_from2 = insurance_period_from2.split("/").reverse().join("-");
        var newinsurance_period_to2 = insurance_period_to2.split("/").reverse().join("-");
        var days=daysBetween(newinsurance_period_from2, newinsurance_period_to2);
        var insurance = (days/365);
        
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(newinsurance_period_from2)
        console.log(newinsurance_period_to2)
        console.log(days)
        console.log(insurance)

        var rateslip =  parseFloat($('#sliprate').val()) / 1000;
        var tsi = $("#sharetotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipbasicpremium').val(real_sum);
        // call custom function here
      } 
    });

   $("#slipbasicpremium").keyup(function(e) { 
    var keyCode = e.keyCode || e.which; 

      if (keyCode == 9) { 
        // e.preventDefault(); 
        // call custom function here
        var insurance_period_from2 = $('#sliprpfrom').val();
        var insurance_period_to2 = $('#sliprpto').val();
        var newinsurance_period_from2 = insurance_period_from2.split("/").reverse().join("-");
        var newinsurance_period_to2 = insurance_period_to2.split("/").reverse().join("-");
        var days=daysBetween(newinsurance_period_from2, newinsurance_period_to2);
        var insurance = (days/365);
        
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(newinsurance_period_from2)
        console.log(newinsurance_period_to2)
        console.log(days)
        console.log(insurance)

        var rateslip =  parseFloat($('#sliprate').val()) / 1000;
        var tsi = $("#sharetotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipbasicpremium').val(real_sum);
      } 
    });

   $("#slipbasicpremium").keypress(function(e) { 
    var keyCode = e.keyCode || e.which; 

      if (keyCode == 9) { 
        // e.preventDefault(); 
        // call custom function here
        var insurance_period_from2 = $('#sliprpfrom').val();
        var insurance_period_to2 = $('#sliprpto').val();
        var newinsurance_period_from2 = insurance_period_from2.split("/").reverse().join("-");
        var newinsurance_period_to2 = insurance_period_to2.split("/").reverse().join("-");
        var days=daysBetween(newinsurance_period_from2, newinsurance_period_to2);
        var insurance = (days/365);
        
        console.log(insurance_period_from2)
        console.log(insurance_period_to2)
        console.log(newinsurance_period_from2)
        console.log(newinsurance_period_to2)
        console.log(days)
        console.log(insurance)

        var rateslip =  parseFloat($('#sliprate').val()) / 1000;
        var tsi = $("#sharetotalsum").val();
        var conv_tsi = parseInt(tsi.replace(/,/g, ""));
        var sum = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipbasicpremium').val(real_sum);
      } 
    });

   $('#slipshare').change(function (e) {
    if(e.keyCode != 9){
        var rateslip =  parseFloat($('#sliprate').val()) / 1000 ;
        var shareslip =  parseFloat($('#slipshare').val()) / 100 ;
        var nasionalreinsurance =  $('#mpsharefrom').val();
        var totalnre =  $('#mpshareto').val();
        var conv_totalnre =  parseInt(totalnre.replace(/,/g, ""));

        console.log('nre' + nasionalreinsurance)
            // console.log(conv_nasionalreinsurance)
            console.log('totalnre' + totalnre)
            console.log('convtotnre' + conv_totalnre)
            
            var tsi = $("#sharetotalsum").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));

            var sumshare = $('#slipsumshare').val() ;
            var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

            var orpercent = $('#slipor').val() / 100;

            var sumor = isNaN(orpercent * conv_sumshare) ? 0 :(orpercent * conv_sumshare).toFixed(2);
            var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            var sum = isNaN(rateslip * shareslip * conv_tsi) ? 0 :(rateslip * shareslip * conv_tsi).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            if(nasionalreinsurance){
                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                var sumnre = isNaN(conv_nasionalreinsurance + conv_sumshare ) ? 0 :(conv_nasionalreinsurance + conv_sumshare).toFixed(2) ;
                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }else{
                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                var sumnre = isNaN(0 + conv_sumshare ) ? 0 :(0 + conv_sumshare).toFixed(2) ;
                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            
            
            var sumourshare = isNaN((sumnre / conv_totalnre) * 100 ) ? 0 :((sumnre / conv_totalnre) * 100 ).toFixed(2) ;

            console.log('sumnre' + sumnre)
            console.log('realnre' + real_sumnre)
            console.log('sumourshare' + sumourshare)

            $('#slipgrossprmtonr').val(real_sum);
            $('#slipgrossprmtonr2').val(real_sum);
            $('#slipsumor').val(real_sumor);
            $('#slipsumor2').val(real_sumor);
            // $('#mpshare').val(sumourshare.replace(/,/g, "."));
            $('#mpsharefrom').val(real_sumnre);

            var slipsumcommissionval = $('#slipsumcommission').val();
            if(slipsumcommissionval != null){
                var commision =  parseFloat($('#slipcommission').val()) / 100;
                var feebroker = parseFloat($('#slipvbroker').val()) / 100;
                var sumgrossprmtonr = $("#slipgrossprmtonr").val();
                var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));

                var sumcomm = isNaN(commision * conv_sumgrossprmtonr) ? 0 :(commision * conv_sumgrossprmtonr).toFixed(2);
                var real_sumcomm = sumcomm.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                $('#slipsumcommission').val(real_sumcomm);
                $('#slipsumcommission2').val(real_sumcomm);

                var netprm_to_nr = $('#slipnetprmtonr').val();
                if(netprm_to_nr != null){


                    var sumnetprmtonr = isNaN( conv_sumgrossprmtonr * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr * (100/100 - commision - feebroker)).toFixed(2);
                    var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    var sumfeebroker = isNaN( conv_sumgrossprmtonr * feebroker) ? 0 :(conv_sumgrossprmtonr * feebroker).toFixed(2);
                    var real_sumfeebroker = sumfeebroker.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


                    $('#slipnetprmtonr').val(real_sumnetprmtonr);
                    $('#slipnetprmtonr2').val(real_sumnetprmtonr);
                    // $('#slipsumfee').val("100" + "-" + commision.toString() + "-" + feebroker.toString() + "*" + conv_sumgrossprmtonr.toString());
                    $('#slipsumfee').val(real_sumfeebroker);

                    var retro_backup = $('#sliprb').val();
                    if(retro_backup == 'YES'){
                        swal('warning!','please change retrocession amount manually','success')
                    }

                }

            }
        }
    });

   $('#slipcommission').keyup(function (e) {
    if(e.keyCode != 9){
        var commision =  parseFloat($(this).val()) / 100;
        var feebroker = parseFloat($('#slipvbroker').val()) / 100;
        var sumgrossprmtonr = $("#slipgrossprmtonr").val();
        var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));

        var sum = isNaN(commision * conv_sumgrossprmtonr) ? 0 :(commision * conv_sumgrossprmtonr).toFixed(2);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipsumcommission').val(real_sum);
        $('#slipsumcommission2').val(real_sum);

    }
});



   $('#slipvbroker').keyup(function(){
        var netprm_to_nr = $('#slipnetprmtonr').val();
        
            var feebroker = parseFloat($('#slipvbroker').val()) / 100;
            var commision =  parseFloat($('#slipcommission').val()) / 100;
            var sumgrossprmtonr = $("#slipgrossprmtonr").val();
            var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));

            var sumnetprmtonr = isNaN( conv_sumgrossprmtonr * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr * (100/100 - commision - feebroker)).toFixed(2);
            var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            var sumfeebroker = isNaN( conv_sumgrossprmtonr * feebroker) ? 0 :(conv_sumgrossprmtonr * feebroker).toFixed(2);
            var real_sumfeebroker = sumfeebroker.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            $('#slipnetprmtonr').val(real_sumnetprmtonr);
            $('#slipnetprmtonr2').val(real_sumnetprmtonr);
            // $('#slipsumfee').val("100" + "-" + commision.toString() + "-" + feebroker.toString() + "*" + conv_sumgrossprmtonr.toString());
            $('#slipsumfee').val(real_sumfeebroker);

});

   $('#slipvbroker').change(function(){

        if( $('#installmentPanel tbody').find('tr').val().length > 0){
            swal('warning!','netprm to nr changed, please change installment amount manually','success')
        }

   });

   $('#slipippercentage').keyup(function (e) {
    if(e.keyCode != 9){
        var percent =  parseFloat($(this).val()) / 100;

        var sumnetprtonr = $("#slipnetprmtonr").val();
        var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

        var sum = isNaN(percent *  conv_sumnetprtonr) ? 0 :(percent *  conv_sumnetprtonr).toFixed(2);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipipamount').val(real_sum);
        // $('#slipipamount2').val(real_sum);
    }else{
        var percent =  parseFloat($(this).val()) / 100;

        var sumnetprtonr = $("#slipnetprmtonr").val();
        var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

        var sum = isNaN(percent *  conv_sumnetprtonr) ? 0 :(percent *  conv_sumnetprtonr).toFixed(2);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipipamount').val(real_sum);
    }
});

   $('#slipipamount').change(function(e){
        if(e.keyCode != 9){
                var amount =  $(this).val();
                var conv_amount = parseFloat(amount.replace(/,/g, ""));
                console.log(amount)
                console.log(conv_amount)
                var sumnetprtonr = $("#slipnetprmtonr").val();
                var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

                var sum = isNaN((conv_amount /  conv_sumnetprtonr) * 100) ? 0 :((conv_amount /  conv_sumnetprtonr) * 100).toFixed(2);
                var real_sum = sum.toString();
                console.log(sum)
                console.log(real_sum)

                $('#slipippercentage').val(real_sum);
                // $('#slipipamount2').val(real_sum);
            }else{
                 var amount =  $(this).val();
                var conv_amount = parseFloat(amount.replace(/,/g, ""));
                console.log(amount)
                console.log(conv_amount)
                var sumnetprtonr = $("#slipnetprmtonr").val();
                var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));
                
                var sum = isNaN((conv_amount /  conv_sumnetprtonr) * 100) ? 0 :((conv_amount /  conv_sumnetprtonr) * 100).toFixed(2);
                var real_sum = sum.toString();
                console.log(sum)
                console.log(real_sum)
                $('#slipippercentage').val(real_sum);
            }
   });

   $('#slipor').keyup(function(e) {
    if(e.keyCode != 9){
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = $("#slipsumshare").val();
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

        var sum = isNaN(percent * conv_sumshare) ? 0 :(percent * conv_sumshare).toFixed(2);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        if($(this).val() > 100){
            swal('warning!','percentage cannot more than 100%','sum value error');
            $('#slipsumor').empty();
            $('#slipsumor2').empty();
        }else{
            $('#slipsumor').val(real_sum);
            $('#slipsumor2').val(real_sum);
        }

        


    }
});

   $('#sliprppercentage').keyup(function (e) {
    if(e.keyCode != 9){
        var percentval =  parseFloat($(this).val()) / 100;
        var sumor = $('#slipsumor').val() ;
        var conv_sumor = parseInt(sumor.replace(/,/g, ""));
        var sumrpamount = isNaN(percentval * conv_sumor) ? 0 :(percentval * conv_sumor).toFixed(2);
        var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
            // $('#slipor').val(sumpercentor);
            $('#sliprpamount').val(real_sumrpamount);
            $('#sliprpamount2').val(real_sumrpamount);
        }
    });

   $('#sliprppercentage').change(function (e) {
    if(e.keyCode != 9){
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#slipor').val());
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval).toFixed(2);
        $('#slipor').val(sumpercentor);

        var percent =  parseFloat($('#slipor').val()) / 100;
        var sumshare = $("#slipsumshare").val();
        var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

        var sum = isNaN(percent * conv_sumshare) ? 0 :(percent * conv_sumshare).toFixed(2);
        var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipsumor').val(real_sum);
        $('#slipsumor2').val(real_sum);
    }
});
</script>


<script  type='text/javascript'>
    $('#slippctupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var pct =  parseFloat($(this).val())/100;
            
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));

            var sum = isNaN(pct * conv_tsi) ? 0 :(pct * conv_tsi).toFixed(2) ;
            console.log(sum)
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#sliptotalsumpctupdate').val(real_sum);
            $('#sliptotalsumpctupdate2').val(real_sum);
        }
    });

    $('#slipdppercentageupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var percent =  $(this).val() / 100;
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));
            var sum = isNaN(percent * conv_tsi) ? 0 :(percent * conv_tsi).toFixed(2) ;
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#slipdpamountupdate').val(real_sum);
            $('#slipdpamountupdate2').val(real_sum);
        }
    });

    $('#slipshareupdate').keyup(function (e) 
    {
        if(e.keyCode != 9){
            var shareslip =  $(this).val() / 100 ;
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));
            var sumshare =isNaN( shareslip * conv_tsi) ? 0 :( shareslip * conv_tsi).toFixed(2) ;
            var real_sumshare = sumshare.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            $('#slipsumshareupdate').val(real_sumshare);
            $('#slipsumshareupdate2').val(real_sumshare);
        }
    });


    $('#sliprateupdate').keyup(function (e) {
        if(e.keyCode != 9){
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
            
            var rateslip =  $(this).val() / 1000;
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));
            var sum = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            $('#slipbasicpremiumupdate').val(real_sum);
        }
    });

    $('#slipshareupdate').change(function (e) {
        if(e.keyCode != 9){
            var rateslip =  $('#sliprateupdate').val() / 1000 ;
            var shareslip =  $('#slipshareupdate').val() / 100 ;
            var nasionalreinsurance =  $('#mpsharefromupdate').val();
            var totalnre =  $('#mpsharetoupdate').val();
            var conv_totalnre =  parseInt(totalnre.replace(/,/g, ""));

            console.log('nre' + nasionalreinsurance)
            // console.log(conv_nasionalreinsurance)
            console.log('totalnre' + totalnre)
            console.log('convtotnre' + conv_totalnre)
            
            var tsi = $("#sliptotalsumupdate").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));

            var sumshare = $('#slipsumshareupdate').val() ;
            var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

            var orpercent = $('#sliporupdate').val() / 100;
            
            var sumor = isNaN(orpercent * conv_sumshare) ? 0 :(orpercent * conv_sumshare).toFixed(2);
            var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            var sum = isNaN(rateslip * shareslip * conv_tsi) ? 0 :(rateslip * shareslip * conv_tsi).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            if(nasionalreinsurance){
                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                var sumnre = isNaN(conv_nasionalreinsurance + conv_sumshare ) ? 0 :(conv_nasionalreinsurance + conv_sumshare).toFixed(2) ;
                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }else{
                var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
                var sumnre = isNaN(0 + conv_sumshare ) ? 0 :(0 + conv_sumshare).toFixed(2) ;
                var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            
            
            var sumourshare = isNaN((sumnre / conv_totalnre) * 100 ) ? 0 :((sumnre / conv_totalnre) * 100 ).toFixed(2) ;
            
            console.log('sumnre' + sumnre)
            console.log('realnre' + real_sumnre)
            console.log('sumourshare' + sumourshare)

            $('#slipgrossprmtonrupdate').val(real_sum);
            $('#slipgrossprmtonrupdate2').val(real_sum);
            $('#slipsumorupdate').val(real_sumor);
            $('#slipsumorupdate2').val(real_sumor);
            $('#mpshareupdate').val(sumourshare.replace(/,/g, "."));
            $('#mpsharefromupdate').val(real_sumnre);

            // $('#slipsumshare').val(real_sum);
            // $('#msisharev').val(shareslip);
                // $('#msisharefrom').val(real_sumourshare);
            // $('#msisumsharev').val(sumourshare);
        }
    });

    $('#slipcommissionupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var commision =  $(this).val() / 100;
            var feebroker = $('#slipvbrokerupdate').val() / 100;

            var sumgrossprmtonr = $("#slipgrossprmtonrupdate").val();
            var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));
            
            var sum = isNaN(commision * conv_sumgrossprmtonr) ? 0 :(commision * conv_sumgrossprmtonr).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            var sumnetprmtonr = isNaN( conv_sumgrossprmtonr * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr * (100/100 - commision - feebroker)).toFixed(2);
            var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            $('#slipsumcommissionupdate').val(real_sum);
            $('#slipsumcommissionupdate2').val(real_sum);
            $('#slipnetprmtonrupdate').val(real_sumnetprmtonr);
            $('#slipnetprmtonrupdate2').val(real_sumnetprmtonr);

            
        }
    });

    $('#slipvbrokerupdate').keyup(function(){
        var feebroker = $('#slipvbrokerupdate').val() / 100;
        var commision =  $('#slipcommissionupdate').val() / 100;
        var sumgrossprmtonr = $("#slipgrossprmtonrupdate").val();
        var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));

        var sumnetprmtonr = isNaN( conv_sumgrossprmtonr * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr * (100/100 - commision - feebroker)).toFixed(2);
        var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $('#slipnetprmtonrupdate').val(real_sumnetprmtonr);
        $('#slipnetprmtonrupdate2').val(real_sumnetprmtonr);
        $('#slipsumfeeupdate').val("100" + "-" + commision.toString() + "-" + feebroker.toString() + "*" + conv_sumgrossprmtonr.toString());

    });

    $('#slipippercentageupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var percent =  $(this).val() / 100;
            
            var sumnetprtonr = $("#slipnetprmtonrupdate").val();
            var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

            var sum = isNaN(percent *  conv_sumnetprtonr) ? 0 :(percent *  conv_sumnetprtonr).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $('#slipipamountupdate').val(real_sum);
            $('#slipipamountupdate2').val(real_sum);
        }
    });

    $('#sliporupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var percent =  $(this).val() / 100;
            var sumshare = $("#slipsumshareupdate").val();
            var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

            var sum = isNaN(percent * conv_sumshare) ? 0 :(percent * conv_sumshare).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $('#slipsumorupdate').val(real_sum);
            $('#slipsumorupdate2').val(real_sum);
        }
    });

    $('#sliprppercentageupdate').keyup(function (e) {
        if(e.keyCode != 9){
            var percentval =  $(this).val() / 100;
            var sumor = $('#slipsumorupdate').val() ;
            var conv_sumor = parseInt(sumor.replace(/,/g, ""));
            var sumrpamount = isNaN(percentval * conv_sumor) ? 0 :(percentval * conv_sumor).toFixed(2);
            var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
            // $('#slipor').val(sumpercentor);
            $('#sliprpamountupdate').val(real_sumrpamount);
            $('#sliprpamountupdate2').val(real_sumrpamount);
        }
    });

    $('#sliprppercentageupdate').change(function (e) {
        if(e.keyCode != 9){
            var percentval =  $(this).val();
            var orpercent = $('#sliporupdate').val();
            var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval).toFixed(2);
            $('#sliporupdate').val(sumpercentor);

            var percent =  $('#sliporupdate').val() / 100;
            var sumshare = $("#slipsumshareupdate").val();
            var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

            var sum = isNaN(percent * conv_sumshare) ? 0 :(percent * conv_sumshare).toFixed(2);
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $('#slipsumorupdate').val(real_sum);
            $('#slipsumorupdate2').val(real_sum);
        }
    });
</script>

<script  type='text/javascript'>
    $('#slippctendorsement').keyup(function (e) {
        if(e.keyCode != 9){
            var pct =  parseFloat($(this).val())/100;
            
            var tsi = $("#sliptotalsumendorsement").val();
            var conv_tsi = parseInt(tsi.replace(/,/g, ""));

            var sum = isNaN(pct * conv_tsi) ? 0 :(pct * conv_tsi).toFixed(2) ;
            console.log(sum)
            var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#sliptotalsumpctendorsement').val(real_sum);
        }
    });

    $('#slipdppercentageendorsement').keyup(function () {
     var percent =  $(this).val() / 100;
     var tsi = $("#sliptotalsumendorsement").val();
     var conv_tsi = parseInt(tsi.replace(/,/g, ""));
     var sum = isNaN(percent * conv_tsi) ? 0 :(percent * conv_tsi).toFixed(2) ;
     var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
     $('#slipdpamountendorsement').val(real_sum);
 });

    $('#slipshareendorsement').keyup(function () 
    {
     var shareslip =  $(this).val() / 100 ;
     var tsi = $("#sliptotalsumendorsement").val();
     var conv_tsi = parseInt(tsi.replace(/,/g, ""));
     var sumshare =isNaN( shareslip * conv_tsi) ? 0 :( shareslip * conv_tsi).toFixed(2) ;
     var real_sumshare = sumshare.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


     $('#slipsumshareendorsement').val(real_sumshare);
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

     var rateslip =  $(this).val() / 1000;
     var tsi = $("#sliptotalsumendorsement").val();
     var conv_tsi = parseInt(tsi.replace(/,/g, ""));
     var sum = isNaN((rateslip * conv_tsi) * insurance) ? 0 :((rateslip * conv_tsi) * insurance).toFixed(2) ;
     var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

     $('#slipbasicpremiumendorsement').val(real_sum);
 });

    $('#slipshareendorsement').change(function () {
     var rateslip =  $('#sliprateendorsement').val() / 1000 ;
     var shareslip =  $('#slipshareendorsement').val() / 100 ;
     var nasionalreinsurance =  $('#mpsharefromendorsement').val();
     var totalnre =  $('#mpsharetoendorsement').val();
     var conv_totalnre =  parseInt(totalnre.replace(/,/g, ""));

     console.log('nre' + nasionalreinsurance)
       // console.log(conv_nasionalreinsurance)
       console.log('totalnre' + totalnre)
       console.log('convtotnre' + conv_totalnre)
       
       var tsi = $("#sliptotalsumendorsement").val();
       var conv_tsi = parseInt(tsi.replace(/,/g, ""));

       var sumshare = $('#slipsumshareendorsement').val() ;
       var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

       var orpercent = $('#sliporendorsement').val() / 100;

       var sumor = isNaN(orpercent * conv_sumshare) ? 0 :(orpercent * conv_sumshare).toFixed(2);
       var real_sumor = sumor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       
       var sum = isNaN(rateslip * shareslip * conv_tsi) ? 0 :(rateslip * shareslip * conv_tsi).toFixed(2);
       var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       
       if(nasionalreinsurance){
         var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
         var sumnre = isNaN(conv_nasionalreinsurance + conv_sumshare ) ? 0 :(conv_nasionalreinsurance + conv_sumshare).toFixed(2) ;
         var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
     }else{
         var conv_nasionalreinsurance =  parseInt(nasionalreinsurance.replace(/,/g, ""));
         var sumnre = isNaN(0 + conv_sumshare ) ? 0 :(0 + conv_sumshare).toFixed(2) ;
         var real_sumnre = sumnre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
     }


     var sumourshare = isNaN((sumnre / conv_totalnre) * 100 ) ? 0 :((sumnre / conv_totalnre) * 100 ).toFixed(2) ;

     console.log('sumnre' + sumnre)
     console.log('realnre' + real_sumnre)
     console.log('sumourshare' + sumourshare)

     $('#slipgrossprmtonrendorsement').val(real_sum);
     $('#slipsumorendorsement').val(real_sumor);
     $('#mpshareendorsement').val(sumourshare.replace(/,/g, "."));
     $('#mpsharefromendorsement').val(real_sumnre);

       // $('#slipsumshare').val(real_sum);
       // $('#msisharev').val(shareslip);
        // $('#msisharefrom').val(real_sumourshare);
       // $('#msisumsharev').val(sumourshare);
   });

    $('#slipcommissionendorsement').keyup(function () {
     var commision =  $(this).val() / 100;
     var feebroker = $('#slipvbrokerendorsement').val() / 100;

     var sumgrossprmtonr = $("#slipgrossprmtonrendorsement").val();
     var conv_sumgrossprmtonr = parseInt(sumgrossprmtonr.replace(/,/g, ""));

     var sum = isNaN(commision * conv_sumgrossprmtonr) ? 0 :(commision * conv_sumgrossprmtonr).toFixed(2);
     var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


     var sumnetprmtonr = isNaN( conv_sumgrossprmtonr * (100/100 - commision - feebroker)) ? 0 :(conv_sumgrossprmtonr * (100/100 - commision - feebroker)).toFixed(2);
     var real_sumnetprmtonr = sumnetprmtonr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


     $('#slipsumcommissionendorsement').val(real_sum);
     $('#slipnetprmtonrendorsement').val(real_sumnetprmtonr);
 });

    $('#slipippercentageendorsement').keyup(function () {
     var percent =  $(this).val() / 100;

     var sumnetprtonr = $("#slipnetprmtonrendorsement").val();
     var conv_sumnetprtonr = parseInt(sumnetprtonr.replace(/,/g, ""));

     var sum = isNaN(percent *  conv_sumnetprtonr) ? 0 :(percent *  conv_sumnetprtonr).toFixed(2);
     var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

     $('#slipipamountendorsement').val(real_sum);
 });

    $('#sliporendorsement').keyup(function () {
     var percent =  $(this).val() / 100;
     var sumshare = $("#slipsumshareendorsement").val();
     var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

     var sum = isNaN(percent * conv_sumshare) ? 0 :(percent * conv_sumshare).toFixed(2);
     var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

     $('#slipsumorendorsement').val(real_sum);
 });

    $('#sliprppercentageendorsement').keyup(function () {
     var percentval =  $(this).val() / 100;
     var sumor = $('#slipsumorendorsement').val() ;
     var conv_sumor = parseInt(sumor.replace(/,/g, ""));
     var sumrpamount = isNaN(percentval * conv_sumor) ? 0 :(percentval * conv_sumor).toFixed(2);
     var real_sumrpamount = sumrpamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

       // var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval); 
       // $('#slipor').val(sumpercentor);
       $('#sliprpamountendorsement').val(real_sumrpamount);
   });

    $('#sliprppercentageendorsement').change(function () {
     var percentval =  $(this).val();
     var orpercent = $('#sliporendorsement').val();
     var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval).toFixed(2);
     $('#sliporendorsement').val(sumpercentor);

     var percent =  $('#sliporendorsement').val() / 100;
     var sumshare = $("#slipsumshareendorsement").val();
     var conv_sumshare = parseInt(sumshare.replace(/,/g, ""));

     var sum = isNaN(percent * conv_sumshare) ? 0 :(percent * conv_sumshare).toFixed(2);
     var real_sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

     $('#slipsumorendorsement').val(real_sum);
 });
</script>




<script type='text/javascript'>
    
     $('#slipnilaiec').keyup(function () {
        var persentage =  parseFloat($('#slipnilaiec').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipamountec').val(sum);
     });

     $('#slipnilaiec').change(function () {
        var persentage =  parseFloat($('#slipnilaiec').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipamountec').val(sum);
     });

</script>

<script type='text/javascript'>
    
     $('#slipnilaiecupdate').keyup(function () {
        var persentage =  parseFloat($('#slipnilaiecupdate').val());
        var sliptotalsum =  parseFloat($('#sliptotalsumupdate').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipamountecupdate').val(sum);
     });

     $('#slipnilaiecupdate').change(function () {
        var persentage =  parseFloat($('#slipnilaiecupdate').val());
        var sliptotalsum =  parseFloat($('#sliptotalsumupdate').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipamountecupdate').val(sum);
     });

</script>



<script type='text/javascript'>
    
     $('#slipnilaiecendorsement').keyup(function () {
        var persentage =  parseFloat($('#slipnilaiecendorsement').val());
        var sliptotalsum =  parseFloat($('#sliptotalsumendorsement').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipamountecendorsement').val(sum);
     });

     $('#slipnilaiecendorsement').change(function () {
        var persentage =  parseFloat($('#slipnilaiecendorsement').val());
        var sliptotalsum =  parseFloat($('#sliptotalsumendorsement').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * (persentage/100)) ? 0 :(sliptotalsum * (persentage/100)) ;
        //alert(sum);
        $('#slipamountecendorsement').val(sum);
     });

</script>

<script type='text/javascript'>
    $('#addinstallmentinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var installmentdate = $('#slipipdate').val();
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
             if(response.code_error){
                swal("Error!", response.message , "Insert Error");
                $('#addinstallmentinsured-btn').attr('hidden','true')
            }else{
                    // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
                    var curr_amount = response.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $('#installmentPanel tbody').prepend('<tr id="iidinstallment'+response.id+'" data-name="installmentvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentdetail('+response.id+')">delete</a></td></tr>')
                    $('#dateinstallment').val('');
                    $('#slipippercentage').val('');
                    $('#slipipamount').val('');
                    $('#slipipamount2').val('');

                    if(response.message){
                        swal("Success!", response.message, "success")
                    }       
                    

                    var total_percent =  $('#sliptotalpercentinspan').val();

                    if(total_percent == ''){
                        var sum_percent = isNaN(parseInt(0) + parseInt(response.percentage)) ? 0 :(parseInt(0) + parseInt(response.percentage)) ;
                        $('#sliptotalpercentinspan').val(sum_percent.toString());
                        console.log($('#sliptotalpercentinspan').val())
                    }else{
                        var sum_percent = isNaN(parseInt(total_percent) + parseInt(response.percentage)) ? 0 :(parseInt(total_percent) + parseInt(response.percentage))
                        $('#sliptotalpercentinspan').val(sum_percent.toString());
                        console.log($('#sliptotalpercentinspan').val())
                        
                    }
                }

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
        var real_minamount = 0;
        if(minamount == ''){
            real_minamount = 0;
        }
        else{
        var conv_minamount = minamount.replace(/,/g, "");
        console.log(conv_minamount)
        real_minamount = parseInt(conv_minamount);
        }

        var slip_id = $('#slipnumber').val();
        var token2 = $('input[name=_token2]').val();




        var conv_amount = amount.replace(/,/g, "");
        console.log(conv_amount)
        var real_amount = parseInt(conv_amount);
        console.log(real_amount)


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
               $('#deductiblePanel tbody').prepend('<tr id="iiddeductible'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype+'">'+response.deductibletype+'</td><td data-name="'+response.currencydata+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibledetail('+response.id+')">delete</a></td></tr>');
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
               $('#deductiblePanelupdate tbody').prepend('<tr id="iiddeductibleupdate'+response.id+'" data-name="deductibleupdatevalue[]"><td data-name="'+response.deductibletype+'">'+response.deductibletype+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibleupdate('+response.id+')">delete</a></td></tr>');
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
       var or_percent = $('#slipor').val();
       
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
             or_percent:or_percent,
             id_slip:slip_id
         },
         beforeSend: function() { $("body").addClass("loading");  },
         complete: function() {  $("body").removeClass("loading"); },
         success:function(response)
         {

             console.log(response)
            //    var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
            if(response.code_error){
                swal("Error!", response.message , "Insert Error");
                    
            }else{
                var curr_amount = response.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $('#retrocessionPanel tbody').prepend('<tr id="iidretrocession'+response.id+'" data-name="retrocessionvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteretrocessiondetail('+response.id+')">delete</a></td></tr>');
                $('#sliprppercentage').val('');
                $('#sliprpamount').val('');
                $('#sliprpamount2').val('');
                if(response.message){
                        swal("Success!", response.message, "success")
                    }
                var or = $('#slipor').val();
                var total_percent = $('#sliptotalpercentrpor').val();

                if(total_percent == 100){
                        var sum_percent = isNaN(parseInt(0) + parseInt(response.percentage) + parseInt(or)) ? 0 :(parseInt(0) + parseInt(response.percentage) + parseInt(or)) ;
                        $('#sliptotalpercentrpor').val(sum_percent);
                    }else{
                        var sum_percent = isNaN(parseInt(total_percent) + parseInt(response.percentage) + parseInt(or)) ? 0 :(parseInt(total_percent) + parseInt(response.percentage) + parseInt(or))
                        $('#sliptotalpercentrpor').val(sum_percent);
                    }

            }

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

<script type='text/javascript'>
    $('#addpropertyinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var property_type_id = $('#mppropertytypelist').val();
       
       var slip_id = $('#slipnumber').val();
       var insured_id = $('#insuredIDtxt').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('propertytype.store') }}",
           type:"POST",
           data:{
               property_type_id:property_type_id,
               id_slip:slip_id,
               insured_id:insured_id
           },
           beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
            
               console.log(response)
               $('#propertyTypePanel tbody').prepend('<tr id="iidproperty'+response.id+'" data-name="propertytypevalue[]"><td data-name="'+response.propertydata+'">'+response.propertydata+'</td><td><a href="javascript:void(0)" onclick="deletepropertytypedetail('+response.id+')">delete</a></td></tr>');
              
           }
       });

   });
</script>

<script type='text/javascript'>
    function deletepropertytypedetail(id)
    {
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-propertytype-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                
                $('#iidproperty'+id).remove();
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

       var mpnumber = $('#insuredIDtxt').val();
       var mpinsured = $('#mpinsured').val();
       var mpsuggestinsured = $('#autocomplete').val();
       var mpsuffix = $('#autocomplete2').val();
       var mpshare = $('#mpshare').val();
       var mpsharefrom  = $('#mpsharefrom').val();
       var mpshareto = $('#mpshareto').val();
       var mpcoinsurance = $('#mpcoinsurance').val();
       var mpuy = $('#mpuy').val();
       

       var conv_mpsharefrom = mpshare.replace(/,/g, "");
       console.log(conv_mpsharefrom)
       var real_mpsharefrom = parseInt(conv_mpsharefrom);
       console.log(real_mpsharefrom)

       var conv_mpshareto = mpsharefrom.replace(/,/g, "");
       console.log(conv_mpshareto)
       var real_mpshareto = parseInt(conv_mpshareto);
       console.log(real_mpshareto)

       if(isNaN(real_mpshareto))
       {
        real_mpshareto=0;
       }

       if(isNaN(real_mpsharefrom))
       {
        real_mpsharefrom=0;
       }
       
       
       var token2 = $('input[name=_token]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/mp-insured/store') }}",
           type:"POST",
           data:{
               mpnumber:mpnumber,
               mpinsured:mpinsured,
               mpsuggestinsured:mpsuggestinsured,
               mpsuffix:mpsuffix,
               mpshare:mpshare,
               mpsharefrom:real_mpsharefrom,
               mpshareto:real_mpshareto,
               mpcoinsurance:mpcoinsurance,
               mpuy:mpuy
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Moveable Property Insert Success", "success")
                console.log(response)

                var real_ceding_share = response.ceding_share.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $('#mpshare').val(real_ceding_share);
                $('#mpcountendorsement').val(response.count_endorsement);

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
       var slipdatetransfer = $('#sliptd').val();
       var slipstatus = $('#slipstatus').val();
       
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
       var slipsharetotalsum = $('#sharetotalsum').val();
       var sliptypetotalsum = $('#sliptypetsi').val();
       var sliptypetsishare = $('#sharetypetsi').val();
       var sliptotalday = $('#slipdaytotal').val();
       var sliptotalyear = $('#slipdaytotal3').val();
       var slipdatesum = $('#sliptotalsumdate').val();

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
       var insuredshare = $('#mpsharefrom').val();

       var token2 = $('input[name=_token]').val();

       var conv_sliptotalsum = sliptotalsum.replace(/,/g, "");
       console.log(code_ms)
       console.log(slipnumber)
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

       var conv_slipsharetotalsum = slipsharetotalsum.replace(/,/g, "");
       console.log(conv_slipsharetotalsum)
       var real_slipsharetotalsum = parseInt(conv_slipsharetotalsum);
       console.log(real_slipsharetotalsum)

       var conv_slipdatesum = slipdatesum.replace(/,/g, "");
       console.log(conv_slipdatesum)
       var real_slipdatesum = parseInt(conv_slipdatesum);
       console.log(real_slipdatesum)

       var conv_insuredshare = insuredshare.replace(/,/g, "");
       console.log(conv_insuredshare)
       var real_insuredshare = parseInt(conv_insuredshare);
       console.log(real_insuredshare)

       var current_percent = $('#sliptotalpercentinspan').val();
       var current_percent_rp = $('#sliptotalpercentrpor').val();


       //ajaxfilefunction(e);

       //if(current_percent == 100 && current_percent_rp == 100)
       if(current_percent == '100')
       {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       $.ajax({
                 url:"{{url('transaction-data/fe-slip/store')}}",
                 type:"POST",
                 data:{

                       //sliped:sliped,
                       //slipsls:slipsls,
                       code_ms:code_ms,
                       slipnumber:slipnumber,
                       slipdatetransfer:slipdatetransfer,
                       slipstatus:slipstatus,
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
                       slipsharetotalsum:real_slipsharetotalsum,
                       sliptypetotalsum:sliptypetotalsum,
                       sliptypetsishare:sliptypetsishare,
                       sliptotalday:sliptotalday,
                       sliptotalyear:sliptotalyear,
                       slipdatesum:real_slipdatesum,
                       insured_share:real_insuredshare,
                       wpc:wpc
                   },
                   beforeSend: function() { $("body").addClass("loading");  },
                   complete: function() {  $("body").removeClass("loading"); },
                   success:function(response)
                   {
                    swal("Success!", "Insured Fire & Engineering Slip Insert Success", "success")
                    console.log(response)


                    $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.number+'">'+response.number+'</td><td data-name="'+response.cedingbroker+'">'+response.cedingbroker+'</td><td data-name="'+response.ceding+'">'+response.ceding+'</td><td data-name="'+response.slipstatus+'">'+response.slipstatus+'</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+response.id+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                        +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                        +'</a>'
                        +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+response.id+'" data-target="#updatemodaldata">'
                        +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                        +'</a>'
                        +'<td></td></tr>');

                   
                    $('#slipnumber').val(response.number);
                    //$('#mpshare').val(response.ourshare);
                    //$('#mpsharefrom').val(response.sumshare);

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
            formData.append('insured_id', code_ms);


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
                            swal("Success!", "Files has been uploaded", "success")
                        },
                        error: function(data){
                             //alert(data.responseJSON.errors.files[0]);
                             //swal("Error!", data.responseJSON.errors.files[0], "Insert Error");
                             //console.log(data.responseJSON.errors);
                         }
                     });

                $('#installmentPanel tbody').empty();
                $('#ExtendCoveragePanel tbody').empty();
                $('#deductiblePanel tbody').empty();
                $('#retrocessionPanel tbody').empty();
       }else{
        swal("Error!", "Please input installment panel and Total own retention until 100%", "Insert Error");
       }


      // // insured save
      var mpnumber = $('#insuredIDtxt').val();
       var mpinsured = $('#mpinsured').val();
       var mpsuggestinsured = $('#autocomplete').val();
       var mpsuffix = $('#autocomplete2').val();
       var mpshare = $('#mpshare').val();
       var mpsharefrom  = $('#mpsharefrom').val();
       var mpshareto = $('#mpshareto').val();
       var mpcoinsurance = $('#mpcoinsurance').val();
       var mpuy = $('#mpuy').val();
       

       var conv_mpsharefrom = mpshare.replace(/,/g, "");
       console.log(conv_mpsharefrom)
       var real_mpsharefrom = parseInt(conv_mpsharefrom);
       console.log(real_mpsharefrom)

       var conv_mpshareto = mpsharefrom.replace(/,/g, "");
       console.log(conv_mpshareto)
       var real_mpshareto = parseInt(conv_mpshareto);
       console.log(real_mpshareto)

       if(isNaN(real_mpshareto))
       {
        real_mpshareto=0;
       }

       if(isNaN(real_mpsharefrom))
       {
        real_mpsharefrom=0;
       }
       
       
       var token2 = $('input[name=_token]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/mp-insured/store') }}",
           type:"POST",
           data:{
               mpnumber:mpnumber,
               mpinsured:mpinsured,
               mpsuggestinsured:mpsuggestinsured,
               mpsuffix:mpsuffix,
               mpshare:mpshare,
               mpsharefrom:real_mpsharefrom,
               mpshareto:real_mpshareto,
               mpcoinsurance:mpcoinsurance,
               mpuy:mpuy
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                //swal("Good job!", "Moveable Property Insert Success", "success")
                console.log(response)

                var real_ceding_share = response.ceding_share.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $('#mpshare').val(real_ceding_share);
                $('#mpcountendorsement').val(response.count_endorsement);

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", request.responseText, "Insert Error");
           }
       });



});
</script>



<script type='text/javascript'>
   $('#multi-file-upload-ajax2').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ms = $('#insuredIDtxt').val();
       var slipnumber = $('#slipnumber').val();
       var slipdatetransfer = $('#sliptd').val();
       var slipstatus = $('#slipstatus').val();
       
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
       var slipsharetotalsum = $('#sharetotalsum').val();
       var sliptypetotalsum = $('#sliptypetsi').val();
       var sliptypetsishare = $('#sharetypetsi').val();
       var sliptotalday = $('#slipdaytotal').val();
       var sliptotalyear = $('#slipdaytotal3').val();
       var slipdatesum = $('#sliptotalsumdate').val();

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
           url:"{{url('transaction-data/mp-slip/store')}}",
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
                swal("Good job!", "Moveable Property Slip Insert Success", "success")
                console.log(response)

                
                $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+response.id+'" data-name="slipvalue[]"><td data-name="'+response.number+'">'+response.number+'</td><td data-name="'+response.slipuy+'">'+slipuy+'</td><td data-name="'+response.cedingbroker+'">"'+response.cedingbroker+'"</td><td data-name="'+response.slipstatus+'">"'+slipstatus+'"</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+response.number+'" data-target="#detailmodaldata" href="#detailmodaldata">'
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
                swal("Error!", "Moveable PropertySlip Insert Error", "Insert Error");
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
       formData.append('insured_id', code_ms);

     
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


        //save insured

       var mpnumber = $('#insuredIDtxt').val();
       var mpinsured = $('#mpinsured').val();
       var mpsuggestinsured = $('#autocomplete').val();
       var mpsuffix = $('#autocomplete2').val();
       var mpshare = $('#mpshare').val();
       var mpsharefrom  = $('#mpsharefrom').val();
       var mpshareto = $('#mpshareto').val();
       var mpcoinsurance = $('#mpcoinsurance').val();
       
       var conv_mpsharefrom = mpshare.replace(/,/g, "");
       console.log(conv_mpsharefrom)
       var real_mpsharefrom = parseInt(conv_mpsharefrom);
       console.log(real_mpsharefrom)

       var conv_mpshareto = mpsharefrom.replace(/,/g, "");
       console.log(conv_mpshareto)
       var real_mpshareto = parseInt(conv_mpshareto);
       console.log(real_mpshareto)
       
       var token2 = $('input[name=_token]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/mp-insured/store') }}",
           type:"POST",
           data:{
               mpnumber:mpnumber,
               mpinsured:mpinsured,
               mpsuggestinsured:mpsuggestinsured,
               mpsuffix:mpsuffix,
               mpshare:mpshare,
               mpsharefrom:real_mpsharefrom,
               mpshareto:real_mpshareto,
               mpcoinsurance:mpcoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Moveable Property Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", request.responseText, "Insert Error");
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
           url:"{{url('transaction-data/mp-slip/store')}}",
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
       formData.append('insured_id', code_ms);

     
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
      var mpnumber = $('#insuredIDtxt').val();
       var mpinsured = $('#mpinsured').val();
       var mpsuggestinsured = $('#autocomplete').val();
       var mpsuffix = $('#autocomplete2').val();
       var mpshare = $('#mpshare').val();
       var mpsharefrom  = $('#mpsharefrom').val();
       var mpshareto = $('#mpshareto').val();
       var mpcoinsurance = $('#mpcoinsurance').val();
       
       var conv_mpsharefrom = mpshare.replace(/,/g, "");
       console.log(conv_mpsharefrom)
       var real_mpsharefrom = parseInt(conv_mpsharefrom);
       console.log(real_mpsharefrom)

       var conv_mpshareto = mpsharefrom.replace(/,/g, "");
       console.log(conv_mpshareto)
       var real_mpshareto = parseInt(conv_mpshareto);
       console.log(real_mpshareto)
       
       var token2 = $('input[name=_token]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/mp-insured/store') }}",
           type:"POST",
           data:{
               mpnumber:mpnumber,
               mpinsured:mpinsured,
               mpsuggestinsured:mpsuggestinsured,
               mpsuffix:mpsuffix,
               mpshare:mpshare,
               mpsharefrom:real_mpsharefrom,
               mpshareto:real_mpshareto,
               mpcoinsurance:mpcoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Moveable Property Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", request.responseText, "Insert Error");
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
           url:"{{url('transaction-data/mp-slip/endorsementstore')}}",
           type:"POST",
           data:{
               slipid:slipid
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

                var insured_data2=JSON.parse(response.insured_data);
                $('#fecountendorsement').val(insured_data2.count_endorsement);
                //alert(insured_data2.count_endorsement);

                var slip_data2array=JSON.parse(response.slip_dataarray);
                
                $('#SlipInsuredTableData tbody').empty();
                
                slip_data2array.forEach(function (arrayItem) 
                {
                    //var x = arrayItem.prop1 + 2;
                    
                    $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+arrayItem.id+'" data-name="slipvalue[]"><td data-name="'+arrayItem.number+'">'+arrayItem.number+'</td><td data-name="'+arrayItem.cedingbroker.name+'">"'+arrayItem.cedingbroker.name+'"</td><td data-name="'+arrayItem.ceding+'">'+arrayItem.ceding+'</td><td data-name="'+arrayItem.status+'">"'+arrayItem.status+'"</td><td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+arrayItem.id+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                        +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                        +'</a>'
                        +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+arrayItem.id+'" data-target="#updatemodaldata">'
                        +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                        +'</a>'
                        +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+arrayItem.id+'" data-target="#endorsementmodaldata">'
                        +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                        +'</a><td></td></tr>');

                });

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Fire & Engineering Slip Insert Error", "Insert Error");
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
       formData.append('insured_id', code_ms);


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
       var mpnumber = $('#insuredIDtxt').val();
       var mpinsured = $('#mpinsured').val();
       var mpsuggestinsured = $('#autocomplete').val();
       var mpsuffix = $('#autocomplete2').val();
       var mpshare = $('#mpshare').val();
       var mpsharefrom  = $('#mpsharefrom').val();
       var mpshareto = $('#mpshareto').val();
       var mpcoinsurance = $('#mpcoinsurance').val();
       
       var conv_mpsharefrom = mpshare.replace(/,/g, "");
       console.log(conv_mpsharefrom)
       var real_mpsharefrom = parseInt(conv_mpsharefrom);
       console.log(real_mpsharefrom)

       var conv_mpshareto = mpsharefrom.replace(/,/g, "");
       console.log(conv_mpshareto)
       var real_mpshareto = parseInt(conv_mpshareto);
       console.log(real_mpshareto)
       
       var token2 = $('input[name=_token]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ url('transaction-data/mp-insured/store') }}",
           type:"POST",
           data:{
               mpnumber:mpnumber,
               mpinsured:mpinsured,
               mpsuggestinsured:mpsuggestinsured,
               mpsuffix:mpsuffix,
               mpshare:mpshare,
               mpsharefrom:real_mpsharefrom,
               mpshareto:real_mpshareto,
               mpcoinsurance:mpcoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Moveable Property Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", request.responseText, "Insert Error");
           }
       });

       
       $('#installmentPanelendorsement tbody').empty();
       $('#ExtendCoveragePanelendorsement tbody').empty();
       $('#deductiblePanelendorsement tbody').empty();
       $('#retrocessionPanelendorsement tbody').empty();


   });


   function addendorsement(slipid){
    var slipid = slipid;
    var token2 = $('input[name=_token]').val();

    console.log(slipid)

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{url('transaction-data/fe-slip/endorsementstore')}}",
           type:"POST",
           data:{
                slipid:slipid
               
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                

             if(response){
                swal("Success!", "Insured Fire & Engineering Slip Endorsement Success", "Endorsement Success")
                console.log(response)
                if(response.insured_data)
                    {

                        var insured_list = JSON.parse(response.insured_data); 

                        for(var i = 0; i < insured_list.length; i++) 
                        {
                            var obj = insured_list[i];

                            $('#mpsnumber').val('');
                            $('#mpinsured').val('');
                            $('#autocomplete').val('');
                            $('#autocomplete2').val('');
                            $('#mpshare').val('');
                            $('#mpsharefrom').val('');
                            $('#mpuy').val('');
                            $('#mpshareto').val('');

                            $('#mpsnumber').val(obj.number);
                            $('#mpinsured').val(obj.insured_prefix);
                            $('#autocomplete').val(obj.insured_name);
                            $('#autocomplete2').val(obj.insured_suffix);
                            $('#mpshare').val(obj.share);
                            $('#mpsharefrom').val(obj.share_from);
                            $('#mpuy').val(obj.uy);
                            $('#mpshareto').val(obj.share_to);

                            
                        }
                    }

                    if(response.location_data)
                    {

                        var location_list = JSON.parse(response.location_data); 

                        for(var i = 0; i < location_list.length; i++) 
                        {
                            var obj = location_list[i];
                            $('#locRiskTable > tbody:last-child').empty();
                            $('#locRiskTable > tbody:last-child').prepend('<tr id="sid'+obj.id+'">'+
                                                    '<td>'+obj.loc_code+'</td>'+
                                                    '<td>'+obj.address+ obj.latitude+' , '+obj.longtitude+'<br>'+ obj.postal_code+'</td>'+
                                                    '<td>'+obj.latitude+' , '+obj.longtitude+'<br></td>'+
                                                    '<td>'+
                                                    '<a class="text-primary mr-3 float-right " data-toggle="modal" data-look-id="'+obj.id+'" data-target="#addlocdetailmodaldata">'+
                                                        '<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addlocdetailmodaldata2">Add</button>'+
                                                    '</a>'+
                                                    '<a href="javascript:void(0)" onclick="deletelocationdetail('+obj.id+')"><i class="fas fa-trash text-danger"></i></a></td>'+
                                                    '</tr>'+
                                                    
                                                    '<tr id="cid'+obj.id+'">'+
                                                        '<td></td>'+
                                                        '<td colspan="3">'+
                                                            '<table id="tcid'+obj.id+'" width="600" class="table table-bordered table-striped">'+
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
                                                                '<tbody id="tbcid'+obj.id+'">'+
                                                                '</tbody>'+
                                                            '</table>'+
                                                        '</td>'+
                                                    '</tr>');
                            
                            
                            if(response.risklocation_data)
                            {

                                var risklocation_list = JSON.parse(response.risklocation_data); 

                                for(var i = 0; i < risklocation_list.length; i++) 
                                {
                                    var obj2 = risklocation_list[i];

                                    $('#tcid'+obj2.id+' > tbody:last-child').empty();
                                    var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj2.amountlocation);

                                    $('#tcid'+obj.id+' > tbody:last-child').prepend('<tr id="riskdetailsid'+obj2.id+'">'+
                                                            '<td>'+obj2.description+'</td>'+
                                                            '<td>'+obj2.name+'</td>'+
                                                            '<td>'+obj2.cnno+'</td>'+
                                                            '<td>'+obj2.certno+'</td>'+
                                                            '<td>'+obj2.refno+'</td>'+
                                                            '<td>'+curr_amount+'</td>'+
                                                            '<td>'+
                                                            '<a href="javascript:void(0)" onclick="deletelocationriskdetail('+obj2.id+')"><i class="fas fa-trash text-danger"></i></a></td>'+
                                                            '</tr>');

                                   
                                    // +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+obj.number+'" data-target="#endorsementmodaldata">'
                                    // +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                                    // +'</a>'
                                    // +'<button type="button" class="btn btn-sm btn-primary float-right" onclick="'+obj.id+'">Endorsement</button>'
                                    // +'<td></td></tr>');

                                    
                                }
                            }



                        }
                    }

                    

                
                if(response.slip_data)
                    {

                        var slip_list = JSON.parse(response.slip_data); 

                        for(var i = 0; i < slip_list.length; i++) 
                        {
                            var obj = slip_list[i];

                            $('#SlipInsuredTableData tbody').empty();
                            $('#SlipInsuredTableData tbody').prepend('<tr id="slipiid'+obj.id+'" data-name="slipvalue[]"><td data-name="'+obj.number+'">'+obj.number+'</td><td data-name="'+obj.source+'">"'+obj.source+'"</td><td data-name="'+obj.source_2+'">'+obj.source_2+'</td><td data-name="'+obj.status+'">"'+obj.status+'"</td>'
                            +'<td><a class="text-primary mr-3 float-right" data-toggle="modal"  data-book-id="'+obj.number+'" data-target="#detailmodaldata" href="#detailmodaldata">'
                            +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">Detail</button>'
                            +'</a>'
                            +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+obj.number+'" data-target="#updatemodaldata">'
                            +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#updatemodaldata2">Edit</button>'
                            +'</a>'
                            // +'<a class="text-primary mr-3 float-right " data-toggle="modal" data-book-id="'+obj.number+'" data-target="#endorsementmodaldata">'
                            // +'<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#endorsementmodaldata2">Endorsement</button>'
                            // +'</a>'
                            +'<button type="button" class="btn btn-sm btn-primary float-right" onclick="'+obj.id+'">Endorsement</button>'
                            +'<td></td></tr>');
                            // $('#ExtendCoveragePaneldetail tbody').prepend('<tr id="iidextendcoveragedetail'+obj.id+'" data-name="extendcoveragedetailvalue[]"><td data-name="'+obj.coveragetype+'">'+obj.coveragetype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td></td></tr>');
                            
                        }
                    }
             }   
                

            else{
                swal("Error!", "Insured Fire & Engineering Slip Endorsement Data Error", "Endorsement Data Error");
            }
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
                swal("Error!", "Insured Fire & Engineering Slip Endorsement Error", "Endorsement Error");
           }
       });

   }
</script>

