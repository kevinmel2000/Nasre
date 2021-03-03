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
                                var amount = interest_insured[i].amount;
                                $('#interestInsuredTabledetail tbody').prepend('<tr id="itsid'+interest_insured[i].id+'"><td >'+code+' - '+interest+'</td><td >currency('+amount+')</td></tr>')
                            };
                            var attachment = response.attachment;
                            for (var i = 0; i < attachment.length; i++){
                                var filename = attachment[i].filename;
                                $('#aidlist').append('<li><div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+filename+'">'+filename+'</a></div></li>')
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
                                $('#conditionNeeded tbody').prepend('<tr id="cntid'+condition_needed[i].id+'" ><td >'+code+' - '+name+' - '+description+'</td><td >'+information+'</td></tr>')
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
                            
                            $('#slipbld_constdetail').val(response.build_const);
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
                            $('#switch-proportional').val(response.proportional);
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