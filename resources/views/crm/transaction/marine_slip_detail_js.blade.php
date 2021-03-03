<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script type="text/javascript">
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); 
       
        
        });
</script>
<link rel="stylesheet" href="{{url('/')}}/css/sweetalert2.min.css">
<script src="{{url('/')}}/js/sweetalert2.all.min.js"></script>

<script type="text/javascript">
    function detailslip(id){
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
                            
                            $('#slipbld_constdetail').val(response.build_const);
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

    function editslip(id){
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
                            $("#slipstatusupdate").append('<option value="'+response.status+'" selected>'+response.status+'</option>');
                            $('#slipcedingbrokerupdate').append(' <option value="'+response.cedbrok_id+'" selected>'+response.cedbrok_cn+' - '+response.cedbrok_code+' - '+response.cedbrok+'</option>');
                            $('#slipcedingupdate').append(' <option value="'+response.ceding_id+'" selected>'+response.ceding_cn+' - '+response.ceding_code+' - '+response.ceding+'</option>');
                            $('#slipcurrencyupdate').append('<option value="'+response.currency_id+'"selected>'+response.currency_code+' - '+response.currency+'</option>');
                            $('#slipcobupdate').append('<option value="'+response.cob_id+'"selected>'+response.cob+'</option>');
                            $('#slipkocupdate').append('<option value="'+response.koc_id+'"selected>'+response.koc+'</option>');
                            $('#slipoccupacyupdate').append('<option value="'+response.occupacy_id+'"selected>'+response.occupacy+'</option>');
                            $('#slipbld_constupdate').append('<option value="'+response.build_const+'"selected>'+response.build_const+'</option>');
                            $('#sliptypeupdate').append('<option value="'+response.insured_type+'"selected>'+response.insured_type+'</option>');
                            $('#sliplayerproportionalupdate').append('<option value="'+response.layer_non_proportional+'"selected>'+response.layer_non_proportional+'</option>');
                            $('#sliprbupdate').append('<option value="'+response.retro_backup+'"selected>'+response.retro_backup+'</option>');
                            
                            $('#slipbld_constupdate').val(response.build_const);
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

    function endorsementslip(id){
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
                            $("#slipstatusendorsement").append('<option value="'+response.status+'" selected>'+response.status+'</option>');
                            $('#slipcedingbrokerendorsement').append(' <option value="'+response.cedbrok_id+'" selected>'+response.cedbrok_cn+' - '+response.cedbrok_code+' - '+response.cedbrok+'</option>');
                            $('#slipcedingendorsement').append(' <option value="'+response.ceding_id+'" selected>'+response.ceding_cn+' - '+response.ceding_code+' - '+response.ceding+'</option>');
                            $('#slipcurrencyendorsement').append('<option value="'+response.currency_id+'"selected>'+response.currency_code+' - '+response.currency+'</option>');
                            $('#slipcobendorsement').append('<option value="'+response.cob_id+'"selected>'+response.cob+'</option>');
                            $('#slipkocendorsement').append('<option value="'+response.koc_id+'"selected>'+response.koc+'</option>');
                            $('#slipoccupacyendorsement').append('<option value="'+response.occupacy_id+'"selected>'+response.occupacy+'</option>');
                            $('#slipbld_constendorsement').append('<option value="'+response.build_const+'"selected>'+response.build_const+'</option>');
                            $('#sliptypeendorsement').append('<option value="'+response.insured_type+'"selected>'+response.insured_type+'</option>');
                            $('#sliplayerproportionalendorsement').append('<option value="'+response.layer_non_proportional+'"selected>'+response.layer_non_proportional+'</option>');
                            $('#sliprbendorsement').append('<option value="'+response.retro_backup+'"selected>'+response.retro_backup+'</option>');
                            
                            $('#slipbld_constendorsement').val(response.build_const);
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
       var token2 = $('input[name=_token3]').val();
       

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