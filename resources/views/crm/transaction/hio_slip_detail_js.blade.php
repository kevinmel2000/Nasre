<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script type="text/javascript">
        $(document).ready(function() { 
            
            $(".e1").select2({ width: '100%' }); 
            
        
        });
</script>
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>

<script  type='text/javascript'>
    $('#slippctupdate').keyup(function () {
        var pct =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumupdate").val());
        var sum = isNaN(pct * tsi/100) ? 0 :(pct * tsi/100) ;
         $('#sliptotalsumpctupdate').val(sum);
         
     });

     $('#slipdppercentageupdate').keyup(function () {
        var percent =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumupdate").val());
        var sum = isNaN(percent * tsi/100) ? 0 :(percent * tsi/100) ;
        $('#slipdpamountupdate').val(sum);
     });

     $('#slipshareupdate').keyup(function () {
        var shareslip =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumupdate").val());
        var sum = isNaN(shareslip * tsi/100) ? 0 :(shareslip * tsi/100) ;
        $('#slipsumshareupdate').val(sum);
        // $('#msishare').val(shareslip);
        $('#msisharevupdate').val(shareslip);
     });

     $('#sliprateupdate').keyup(function () {
        var insurance_period_from = $('#slipipfromupdate').val().split('-');
        var insurance_period_to = $('#slipiptoupdate').val().split('-');
        var month_from = parseInt(insurance_period_from[1]);
        var month_to = parseInt(insurance_period_to[1]);
        var month = (month_to - month_from);
        var insurance = (month/365);
        console.log(insurance_period_from)
        console.log(insurance_period_to)
        console.log(month_from)
        console.log(month_to)
        console.log(month)
        console.log(insurance)
        var rateslip =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumupdate").val());
        var sum = isNaN(rateslip * tsi/100 * insurance) ? 0 :(rateslip * tsi/100 * insurance) ;
        $('#slipbasicpremiumupdate').val(sum);
     });

     $('#slipshare').change(function () {
        var rateslip =  parseFloat($('#sliprateupdate').val()) / 100 ;
        var shareslip =  parseFloat($('#slipshareupdate').val()) / 100 ;
        var ourshare =  parseFloat($('#msisharevupdate').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsumupdate").val());
        var mtsi = parseFloat($("#msitsiupdate").val());
        var sumshare = parseFloat($('#slipsumshareupdate').val()) ;
        var orpercent = parseFloat($('#sliporupdate').val()) / 100;
        var sumor = isNaN(orpercent * sumshare) ? 0 :(orpercent * sumshare);
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * mtsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonrupdate').val(sum);
        // $('#msisharefrom').val(sumourshare);
        $('#msisumsharevupdate').val(sumourshare);
        
        $('#slipsumorupdate').val(sumor);
     });

     $('#slipcommissionupdate').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = parseFloat($("#slipgrossprmtonrupdate").val());
        var sum = isNaN(commision * sumgrossprmtonr/100) ? 0 :(commision * sumgrossprmtonr/100);
        var sumnetprmtonr = isNaN( sumgrossprmtonr * (100/100 - commision)) ? 0 :(sumgrossprmtonr * (100/100 - commision));
        $('#slipsumcommissionupdate').val(sum);
        $('#slipnetprmtonrupdate').val(sumnetprmtonr);
    });

    $('#slipippercentageupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumnetprtonr = parseFloat($("#slipnetprmtonrupdate").val());
        var sum = isNaN(percent * sumnetprtonr) ? 0 :(percent * sumnetprtonr);
        $('#slipipamountupdate').val(sum);
    });

    $('#sliporupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = parseFloat($("#slipsumshareupdate").val());
        var sum = isNaN(percent * sumshare) ? 0 :(percent * sumshare);
        $('#slipsumorupdate').val(sum);
    });

    $('#sliprppercentageupdate').keyup(function () {
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#sliporupdate').val());
        var sumshare = parseFloat($('#slipsumshareupdate').val()) ;
        var orpercentage = parseFloat($('#sliporupdate').val()) / 100;
        var sumor = isNaN(orpercentage * sumshare) ? 0 :(orpercentage * sumshare);
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#sliporupdate').val(sumpercentor);
        $('#slipsumorupdate').val(sumor);
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
        var pct =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumendorsement").val());
        var sum = isNaN(pct * tsi/100) ? 0 :(pct * tsi/100) ;
         $('#sliptotalsumpctendorsement').val(sum);
         
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
        // $('#msishare').val(shareslip);
        $('#msisharevendorsement').val(shareslip);
     });

     $('#sliprateendorsement').keyup(function () {
        var insurance_period_from = $('#slipipfromendorsement').val().split('-');
        var insurance_period_to = $('#slipiptoendorsement').val().split('-');
        var month_from = parseInt(insurance_period_from[1]);
        var month_to = parseInt(insurance_period_to[1]);
        var month = (month_to - month_from);
        var insurance = (month/365);
        console.log(insurance_period_from)
        console.log(insurance_period_to)
        console.log(month_from)
        console.log(month_to)
        console.log(month)
        console.log(insurance)
        var rateslip =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumendorsement").val());
        var sum = isNaN(rateslip * tsi/100 * insurance) ? 0 :(rateslip * tsi/100 * insurance) ;
        $('#slipbasicpremiumendorsement').val(sum);
     });

     $('#slipshare').change(function () {
        var rateslip =  parseFloat($('#sliprateendorsement').val()) / 100 ;
        var shareslip =  parseFloat($('#slipshareendorsement').val()) / 100 ;
        var ourshare =  parseFloat($('#msisharevendorsement').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsumendorsement").val());
        var mtsi = parseFloat($("#msitsiendorsement").val());
        var sumshare = parseFloat($('#slipsumshareendorsement').val()) ;
        var orpercent = parseFloat($('#sliporendorsement').val()) / 100;
        var sumor = isNaN(orpercent * sumshare) ? 0 :(orpercent * sumshare);
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * mtsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonrendorsement').val(sum);
        // $('#msisharefrom').val(sumourshare);
        $('#msisumsharevendorsement').val(sumourshare);
        
        $('#slipsumorendorsement').val(sumor);
     });

     $('#slipcommissionendorsement').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = parseFloat($("#slipgrossprmtonrendorsement").val());
        var sum = isNaN(commision * sumgrossprmtonr/100) ? 0 :(commision * sumgrossprmtonr/100);
        var sumnetprmtonr = isNaN( sumgrossprmtonr * (100/100 - commision)) ? 0 :(sumgrossprmtonr * (100/100 - commision));
        $('#slipsumcommissionendorsement').val(sum);
        $('#slipnetprmtonrendorsement').val(sumnetprmtonr);
    });

    $('#slipippercentageendorsement').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumnetprtonr = parseFloat($("#slipnetprmtonrendorsement").val());
        var sum = isNaN(percent * sumnetprtonr) ? 0 :(percent * sumnetprtonr);
        $('#slipipamountendorsement').val(sum);
    });

    $('#sliporendorsement').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = parseFloat($("#slipsumshareendorsement").val());
        var sum = isNaN(percent * sumshare) ? 0 :(percent * sumshare);
        $('#slipsumorendorsement').val(sum);
    });

    $('#sliprppercentageendorsement').keyup(function () {
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#sliporendorsement').val());
        var sumshare = parseFloat($('#slipsumshareendorsement').val()) ;
        var orpercentage = parseFloat($('#sliporendorsement').val()) / 100;
        var sumor = isNaN(orpercentage * sumshare) ? 0 :(orpercentage * sumshare);
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#sliporendorsement').val(sumpercentor);
        $('#slipsumorendorsement').val(sumor);
    });

    $('#sliprppercentageendorsement').change(function () {
        var percentval =  parseFloat($(this).val());
        var orpercent = parseFloat($('#sliporendorsement').val());
        var sumpercentor = isNaN(orpercent - percentval) ? 0 :(orpercent - percentval);
        $('#sliporendorsement').val(sumpercentor);
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
                                var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(interest_insured[i].amount);
                                
                                $('#interestInsuredTabledetail tbody').prepend('<tr id="itsid'+interest_insured[i].id+'"><td >'+code+' - '+interest+'</td><td >'+amount+'</td></tr>')
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
                                var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(deductible[i].amount);
                                var min_claimamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(deductible[i].min_claimamount);
                                $('#deductiblePaneldetail tbody').prepend('<tr id="dbtid'+deductible[i].id+'"><td >'+abbreviation+' - '+description+'</td><td >'+currency_code+'-'+currency+'</td><td>'+percentage+'</td><td>'+amount+'</td><td>'+min_claimamount+'</td></tr>')
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
                                var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(installment_panel[i].amount);
                                $('#installmentPaneldetail tbody').prepend('<tr id="isptid'+installment_panel[i].id+'" ><td >'+date+'</td><td >'+percentage+'</td><td >'+amount+'</td></tr>')
                            };
                            var retrocession = response.retrocession;
                            for (var i = 0; i < retrocession.length; i++){
                                var type = retrocession[i].type;
                                var contract = retrocession[i].contract;
                                var percentage = retrocession[i].percentage;
                                var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(retrocession[i].amount);
                                $('#retrocessionPaneldetail tbody').prepend('<tr id="rcstid'+retrocession[i].id+'" ><td >'+type+'</td><td >'+contract+'</td><td >'+percentage+'</td><td >'+amount+'</td></tr>')
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
                            $('#slippctdetail').val(response.insured_pct);
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
                            $('#slipvbrokerdetail').val(response.v_broker);
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
                                var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(interest_insured[i].amount);
                                $('#interestInsuredTableupdate tbody').prepend('<tr id="itsid'+interest_insured[i].id+'"><td >'+code+' - '+interest+'</td><td >'+amount+'</td></tr>')
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
                                var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(deductible[i].amount);
                                var min_claimamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(deductible[i].min_claimamount);
                                $('#deductiblePanelupdate tbody').prepend('<tr id="dbtid'+deductible[i].id+'"><td >'+abbreviation+' - '+description+'</td><td >'+currency_code+'-'+currency+'</td><td>'+percentage+'</td><td>'+amount+'</td><td>'+min_claimamount+'</td></tr>')
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
                                var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(installment_panel[i].amount);
                                $('#installmentPanelupdate tbody').prepend('<tr id="isptid'+installment_panel[i].id+'" ><td >'+date+'</td><td >'+percentage+'</td><td >'+amount+'</td></tr>')
                            };
                            var retrocession = response.retrocession;
                            for (var i = 0; i < retrocession.length; i++){
                                var type = retrocession[i].type;
                                var contract = retrocession[i].contract;
                                var percentage = retrocession[i].percentage;
                                var amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(retrocession[i].amount);
                                $('#retrocessionPanelupdate tbody').prepend('<tr id="rcstid'+retrocession[i].id+'" ><td >'+type+'</td><td >'+contract+'</td><td >'+percentage+'</td><td >'+amount+'</td></tr>')
                            };

                            $("#slipnumberupdate").val(response.slip_number);
                            $("#msinumberupdate").val(response.insured_id);
                            $("#slipusernameupdate").val(response.username);
                            $("#slipprodyearupdate").val(response.prod_year);
                            $("#slipuyupdate").val(response.uy);
                            $("#slipstatusupdate").append('<option value="'+response.status+'" selected>'+response.status+' - current choice</option>');
                            $('#slipcedingbrokerupdate').append(' <option value="'+response.cedbrok_id+'" selected>'+response.cedbrok_cn+' - '+response.cedbrok_code+' - '+response.cedbrok+' - current choice</option>');
                            $('#slipcedingupdate').append(' <option value="'+response.ceding_id+'" selected>'+response.ceding_cn+' - '+response.ceding_code+' - '+response.ceding+'- current choice</option>');
                            $('#slipcurrencyupdate').append('<option value="'+response.currency_id+'"selected>'+response.currency_code+' - '+response.currency+'- current choice</option>');
                            $('#slipcobupdate').append('<option value="'+response.cob_id+'"selected>'+response.cob_code+' - '+response.cob+'- current choice</option>');
                            $('#slipkocupdate').append('<option value="'+response.koc_id+'"selected>'+response.koc_code+' - '+response.koc+'- current choice</option>');
                            $('#slipoccupacyupdate').append('<option value="'+response.occupacy_id+'"selected>'+response.occupacy_code+' - '+response.occupacy+'- current choice</option>');
                            $('#slipbld_constupdate').append('<option value="'+response.build_const+'"selected>'+response.build_const+'- current choice</option>');
                            $('#sliptypeupdate').append('<option value="'+response.insured_type+'"selected>'+response.insured_type+'- current choice</option>');
                            $('#sliplayerproportionalupdate').append('<option value="'+response.layer_non_proportional+'"selected>'+response.layer_non_proportional+'- current choice</option>');
                            $('#sliprbupdate').append('<option value="'+response.retro_backup+'"selected>'+response.retro_backup+'- current choice</option>');
                            if(response.retro_backup == 'NO'){
                                $("#tabretroupdate").attr('hidden','true');
                            }
                            $('#slipnoupdate').val(response.slip_no);
                            $('#slipcndnupdate').val(response.cn_dn);
                            $('#slippolicy_noupdate').val(response.policy_no);
                            $('#slipcoinsuranceupdate').val(response.coinsurance_slip);
                            $('#sliptotalsumupdate').val(response.total_sum_insured);
                            $('#slippctupdate').val(response.insured_pct);
                            $('#sliptotalsumpctupdate').val(response.total_sum_pct);
                            $('#slipipfromupdate').val(response.insurance_period_from);
                            $('#slipiptoupdate').val(response.insurance_period_to);
                            $('#sliprpfromupdate').val(response.reinsurance_period_from);
                            $('#sliprptoupdate').val(response.reinsurance_period_to);
                            $('#switch-proportionalupdate').val(response.proportional);
                            if(response.proportional == null ){
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
                    url:'{{ url("/") }}/transaction-data/getmodal-marine-endorsement/'+id,
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

                            $("#slipidendorsement").val(response.id);
                            $("#slipnumberendorsement").val(response.slip_new_number);
                            $("#oldnumberendorsement").val(response.slip_old_number);
                            $("#countendorsement").val(response.count_endorsement);
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
                        $("#slipinterestlistupdate").val(response.interest_id);
                        $("#slipamountupdate").val(response.amount);
                        $("#idinterestinsuredupdate").val(response.id);
                        $(':input','#addinterestinsuredupdate')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#slipinterestlistupdate").empty();
                        $("#slipamountupdate").empty();
                        $("#idinterestinsuredupdate").empty();
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
                        $("#slipdptypeupdate").val(response.deductibletype_id);
                        $("#slipdpcurrencyupdate").val(response.currency_id);
                        $("#slipdppercentageupdate").val(response.perceentage);
                        $("#slipdpamountupdate").val(response.amount);
                        $("#slipdpminamountupdate").val(response.min_claimamount);
                        $('#id_deductupdate').val(response.id);
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#slipdptypeupdate").empty();
                        $("#slipdpcurrencyupdate").empty();
                        $("#slipdppercentageupdate").empty();
                        $("#slipdpamountupdate").empty();
                        $("#slipdpminamountupdate").empty();
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
                        $("#slipcncodeupdate").val(response.condition_id);
                        $("#id_cntupdate").val(response.id);
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#slipcncodeupdate").empty();
                        $("#id_cntupdate").empty();
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
                        $("#slipipdateupdate").val(response.installment_date);
                        $("#slipippercentageupdate").val(response.percentage);
                        $("#slipipamountupdate").val(response.amount);
                        $("#id_inspanupdate").val(response.id);
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#slipipdateupdate").empty();
                        $("#slipippercentageupdate").empty();
                        $("#slipipamountupdate").empty();
                        $("#id_inspanupdate").empty();
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
                        $("#sliprptypeupdate").val(response.type);
                        $("#sliprpcontractupdate").val(response.contract);
                        $("#sliprppercentageupdate").val(response.percentage);
                        $("#sliprpamountupdate").val(response.amount);
                        $("#id_rspupdate").val(response.id);
                    }else{
                        swal("Ohh no!", "Data failed to get", "failed")
                        $("#sliprptypeupdate").empty();
                        $("#sliprpcontractupdate").empty();
                        $("#sliprppercentageupdate").empty();
                        $("#sliprpamountupdate").empty();
                        $("#id_rspupdate").empty();
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
        var token = $('input[name=_token3]').val();
        var interestins = $('#slipinterestlistupdate').val();
        var interestamount = $('#slipamountupdate').val();
        var slipnumber = $('#slipnumberupdate').val();
        var id = $('#idinterestinsuredupdate').val();

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
               $('#interestInsuredTableupdate tbody').prepend('<tr id="iid'+response.id+'"  data-name="interestlistvalue[]"><td data-name="'+response.interest_id+'">'+response.description+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td> <input type="hidden" id="interestidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editinterestinsured" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
               console.log(response);
            }
        });
    }

    function deductibledetailupdate(){
        var token = $('input[name=_token3]').val();
        var deduct_type = $('#slipdptypeupdate').val();
        var deduct_currency = $('#slipdpcurrencyupdate').val();
        var deduct_percent = $('#slipdppercentageupdate').val();
        var deduct_amount = $('#slipdpamountupdate').val();
        var deduct_minamount = $('#slipdpminamountupdate').val();
        var slipnumber = $('#slipnumberupdate').val();
        var id = $('#id_deductupdate').val();

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
                $('#deductiblePanelupdate tbody').prepend('<tr id="ddtid'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype_id+'">'+ response.dtabbrev +' - '+ response.dtdescript+'</td><td data-name="'+response.currency_id+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><input type="hidden" id="deductidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editdeductibletype" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deletedeductibletype('+response.id+')">delete</a></td></tr>')
               console.log(response);
            }
        });
    }

    function conditionneededdetailupdate(){
        var token = $('input[name=_token3]').val();
        var cncode = $('#slipcncodeupdate').val();
        var slipnumber = $('#slipnumberupdate').val();
        var id = $('#id_cntupdate').val();

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
                $('#conditionNeededupdate tbody').prepend('<tr id="cnid'+response.id+'" data-name="conditionneededvalue[]"><td data-name="'+response.conditionneeded_id+'">'+response.condition+'</td><td data-name="'+response.information+'">-</td><td><input type="hidden" id="cnidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editconditionneeded" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deleteconditionneeded('+response.id+')">delete</a></td></tr>')
               console.log(response);
            }
        });
    }

    function installmentdetailupdate(){
        var token = $('input[name=_token3]').val();
        var ip_date = $('#slipipdateupdate').val();
        var ip_percent = $('#slipippercentageupdate').val();
        var ip_amount = $('#slipipamountupdate').val();
        var slipnumber = $('#slipnumberupdate').val();
        var id = $('#id_inspanupdate').val();

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
                $('#installmentPanelupdate tbody').prepend('<tr id="ispid'+response.id+'" data-name="installmentvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><input type="hidden" id="impidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editinstallmentpanel" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deleteinstallmentpanel('+response.id+')">delete</a></td></tr>')
               console.log(response);
            }
        });
    }

    function retrocessiondetailupdate(){
        var token = $('input[name=_token3]').val();
        var retro_type = $('#sliprptypeupdate').val();
        var retro_contract = $('#sliprpcontractupdate').val();
        var retro_percent = $('#sliprppercentageupdate').val();
        var retro_amount = $('#sliprpamountupdate').val();
        var slipnumber = $('#slipnumberupdate').val();
        var id = $('#id_rspupdate').val();

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
                $('#retrocessionPanelupdate tbody').prepend('<tr id="rscid'+response.id+'" data-name="retrocessionvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><input type="hidden" id="rscidupdate" value="'+response.id+'"/><a class="text-primary mr-3" id="editretrocessionpanel" type="button" href="javascript:void(0)"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" onclick="deleteretrocessiontemp('+response.id+')">delete</a></td></tr>')
               console.log(response);
            }
        });
    }
</script>

{{-- <script type="text/javascript">
$('#multi-file-upload-ajaxupdate').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var slip_id = $('#idslipupdate').val();
       var code_ins = $('#msinumberupdate').val();
       var slipnumber = $('#slipnumberupdate').val();
       var slipprodyear = $('#slipprodyearupdate').val();
       var slipuy = $('#slipuyupdate').val();
       var slipstatus = $('#slipstatusupdate').val();
    //    var sliped = $('#slipedupdate').val();
    //    var slipsls = $('#slipslsupdate').val();
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
       var slipnetprmtonr =  $('#slipnetprmtonrupdate').val();
       var sliprb =  $('#sliprbupdate').val();
       var slipor =  $('#sliporupdate').val();
       var slipsumor =  $('#slipsumorupdate').val();
       var token = $('input[name=_token3]').val();
       

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
           url:'{{ url("/") }}/transaction-data/marine-slip/update/'+slip_id,
           type:"POST",
           data:{
               code_ins:code_ins,
               slipnumber:slipnumber,
               prod_year:slipprodyear,
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
               formData:formData
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Marine Slip Update Success", "success")
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
                     swal("Error!", data.responseJSON.errors.files[0], "Insert Error");
                     console.log(data.responseJSON.errors);
                    }
        });

   });





</script>

<script type="text/javascript">
$('#multi-file-upload-ajaxendorsement').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var slip_id = $('#idslipendorsement').val();
       var code_ins = $('#msinumberendorsement').val();
       var oldslipnumber = $('#oldslipnumberendorsement').val();
       var slipnumber = $('#slipnumberendorsement').val();
       var slipusername = $('#slipusernameendorsement').val();
       var slipprodyear = $('#slipprodyearendorsement').val();
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
       var slipnetprmtonr =  $('#slipnetprmtonrendorsement').val();
       var sliprb =  $('#sliprbendorsement').val();
       var slipor =  $('#sliporendorsement').val();
       var slipsumor =  $('#slipsumorendorsement').val();
       var token2 = $('input[name=_token4]').val();
       

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
               slip_id:slip_id,
               code_ins:code_ins,
               slipnumber:slipnumber,
               oldslipnumber:oldslipnumber,
               slip_username:slipusername,
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
</script> --}}

<script type='text/javascript'>
    $('#multi-file-upload-ajaxupdate').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ms = $('#msinumberupdate').val();
       var slipnumber = $('#slipnumberupdate').val();
       var slipuy = $('#slipuyupdate').val();
       var slip_prodyear = $('#slipprodyearupdate').val();
       var slipstatus = $('#slipstatusupdate').val();
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
               prod_year:slip_prodyear,
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
                swal("Good job!", "Insured Marine Slip Update Success", "success")
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

       var code_ms = $('#msinumberendorsement').val();
       var slipnumber = $('#slipnumberendorsement').val();
       var slip_id = $('#slipidendorsement').val();
       var oldslipnumber = $('#oldnumberendorsement').val();
       var countendorsement = $('#countendorsement').val();
       var slipuy = $('#slipuyendorsement').val();
       var slipstatus = $('#slipstatusendorsement').val();
       var sliped = $('#countendorsement').val();
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
           url:"{{url('transaction-data/marine-endorsement')}}",
           type:"POST",
           data:{
                slip_id:slip_id,
               code_ms:code_ms,
               slipnumber:slipnumber,
               oldslipnumber:oldslipnumber,
               countendorsement:countendorsement,
               slipuy:slipuy,
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