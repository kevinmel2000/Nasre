<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>


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

                    if(response.interest_insured)
                    {
                        var interestdata = JSON.parse(response.interest_insured); 

                        for(var i = 0; i < interestdata.length; i++) 
                        {
                            var obj = interestdata[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            
                            $('#interestInsuredTabledetail tbody').empty();
                            $('#interestInsuredTabledetail tbody').prepend('<tr id="iiddetail'+obj.id+'" data-name="interestdetailvalue[]"><td data-name="'+obj.description+'">'+obj.description+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>')
                
                        }
                    }


                    if(response.deductible_panel)
                    {

                        var deductibledata = JSON.parse(response.deductible_panel); 

                        for(var i = 0; i < deductibledata.length; i++) 
                        {
                            var obj = deductibledata[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#deductiblePaneldetail tbody').empty();
                            $('#deductiblePaneldetail tbody').prepend('<tr id="iiddeductible'+obj.id+'" data-name="deductibledetailvalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.currencydata+'">'+obj.currencydata+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td data-name="'+obj.min_claimamount+'">'+obj.min_claimamount+'</td><td></td></tr>');
              
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
                            $('#ExtendCoveragePaneldetail tbody').empty();
                            $('#ExtendCoveragePaneldetail tbody').prepend('<tr id="iidextendcoveragedetail'+obj.id+'" data-name="extendcoveragedetailvalue[]"><td data-name="'+obj.coveragetype+'">'+obj.coveragetype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>');
                            
                        }
                    }


                    if(response.installment_panel)
                    {

                        var installment_panel = JSON.parse(response.installment_panel); 

                        for(var i = 0; i < installment_panel.length; i++) 
                        {
                            var obj = installment_panel[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#installmentPaneldetail tbody').empty();
                           $('#installmentPaneldetail tbody').prepend('<tr id="iidinstallmentdetail'+obj.id+'" data-name="installmentdetailvalue[]"><td data-name="'+obj.installment_date+'">'+obj.installment_date+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>')
               
                        }
                    }



                    if(response.retrocession_panel)
                    {

                        var retrocession_panel = JSON.parse(response.retrocession_panel); 

                        for(var i = 0; i < retrocession_panel.length; i++) 
                        {
                            var obj = retrocession_panel[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#retrocessionPaneldetail tbody').empty();
                            
                            $('#retrocessionPaneldetail tbody').prepend('<tr id="iidretrocessiondetail'+obj.id+'" data-name="retrocessiondetailvalue[]"><td data-name="'+obj.type+'">'+obj.type+'</td><td data-name="'+obj.contract+'">'+obj.contract+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+')</td><td></td></tr>');
              
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
                      //$("#slipbld_constdetail option[value=" + response.build_const + "]:first")[0].selected = true;
                    }

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
                        //$("#sliprbdetail option[value=" + response.retro_backup + "]:first")[0].selected = true;
                    }


                    $('#slipnodetail').val(response.slip_no);
                    $('#slipcndndetail').val(response.cn_dn);
                    $('#slippolicy_nodetail').val(response.policy_no);
                    $('#sliptotalsumdetail').val(response.total_sum_insured);
                
                    $('#slippctdetail').val(response.insured_pct);
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
                    
                    
                    swal("Good job!", "Data Show")
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
                    
                    $('#slipnumberupdate').val(response.number);
                    $('#slipusernameupdate').val(response.username);
                    $('#slipprodyearupdate').val(response.prod_year);
                    $('#slipuyupdate').val(response.uy);
                    $('#slipedupdate').val(response.endorsment);
                    $('#slipslsupdate').val(response.selisih);

                    if(response.interest_insured)
                    {
                        var interestdata = JSON.parse(response.interest_insured); 

                        for(var i = 0; i < interestdata.length; i++) 
                        {
                            var obj = interestdata[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#interestInsuredTableupdate tbody').empty();
                            $('#interestInsuredTableupdate tbody').prepend('<tr id="iidupdate'+obj.id+'" data-name="interestupdatevalue[]"><td data-name="'+obj.description+'">'+obj.description+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>')
                
                        }
                    }


                    if(response.deductible_panel)
                    {

                        var deductibledata = JSON.parse(response.deductible_panel); 

                        for(var i = 0; i < deductibledata.length; i++) 
                        {
                            var obj = deductibledata[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#deductiblePanelupdate tbody').empty();
                            $('#deductiblePanelupdate tbody').prepend('<tr id="iiddeductibleupdate'+obj.id+'" data-name="deductibleupdatevalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.currencydata+'">'+obj.currencydata+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td data-name="'+obj.min_claimamount+'">'+obj.min_claimamount+'</td><td></td></tr>');
              
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
                            $('#ExtendCoveragePanelupdate tbody').empty();
                            $('#ExtendCoveragePanelupdate tbody').prepend('<tr id="iidextendcoverageupdate'+obj.id+'" data-name="extendcoverageupdatevalue[]"><td data-name="'+obj.coveragetype+'">'+obj.coveragetype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>');
                            
                        }
                    }


                    if(response.installment_panel)
                    {

                        var installment_panel = JSON.parse(response.installment_panel); 

                        for(var i = 0; i < installment_panel.length; i++) 
                        {
                            var obj = installment_panel[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#installmentPanelupdate tbody').empty();
                           $('#installmentPanelupdate tbody').prepend('<tr id="iidinstallmentupdate'+obj.id+'" data-name="installmentupdatevalue[]"><td data-name="'+obj.installment_date+'">'+obj.installment_date+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>')
               
                        }
                    }



                    if(response.retrocession_panel)
                    {

                        var retrocession_panel = JSON.parse(response.retrocession_panel); 

                        for(var i = 0; i < retrocession_panel.length; i++) 
                        {
                            var obj = retrocession_panel[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#retrocessionPanelupdate tbody').empty();
                            
                            $('#retrocessionPanelupdate tbody').prepend('<tr id="iidretrocessionupdate'+obj.id+'" data-name="retrocessionupdatevalue[]"><td data-name="'+obj.type+'">'+obj.type+'</td><td data-name="'+obj.contract+'">'+obj.contract+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+')</td><td></td></tr>');
              
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
                      //$("#slipbld_constupdate option[value=" + response.build_const + "]:first")[0].selected = true;
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
                        //$("#sliprbupdate option[value=" + response.retro_backup + "]:first")[0].selected = true;
                    }

                    
                   

                    $('#slipnoupdate').val(response.slip_no);
                    $('#slipcndnupdate').val(response.cn_dn);
                    $('#slippolicy_noupdate').val(response.policy_no);
                    $('#sliptotalsumupdate').val(response.total_sum_insured);
                    
                    $('#slippctupdate').val(response.insured_pct);
                    $('#sliptotalsumpctupdate').val(response.total_sum_pct);

                    $('#slipipfromupdate').val(response.insurance_period_from);
                    $('#slipiptoupdate').val(response.insurance_period_to);
                    $('#sliprpfromupdate').val(response.reinsurance_period_from);
                    $('#sliprptoupdate').val(response.reinsurance_period_to);

                    $('#switch-proportional').val(response.proportional);

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
                    
                    
                    swal("Good job!", "Data Show")
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
        var codesl = $(e.relatedTarget).data('book-id');
        //alert(codesl);
        
        $.ajax({
            url:'{{ url("/") }}/transaction-data/detailendorsementslip/'+codesl,
            type:"GET",
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response)
            {
                    //$('#slipnumberendorsement').val(response.number);
                    $('#slipnumberendorsement').val(response.code_sl);
                    $('#slipusernameendorsement').val(response.username);
                    $('#slipprodyearendorsement').val(response.prod_year);
                    $('#slipuyendorsement').val(response.uy);
                    $('#slipedendorsement').val(response.endorsment);
                    $('#slipslsendorsement').val(response.selisih);

                    if(response.interest_insured)
                    {
                        var interestdata = JSON.parse(response.interest_insured); 

                        for(var i = 0; i < interestdata.length; i++) 
                        {
                            var obj = interestdata[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#interestInsuredTableendorsement tbody').empty();
                            $('#interestInsuredTableendorsement tbody').prepend('<tr id="iidendorsement'+obj.id+'" data-name="interestendorsementvalue[]"><td data-name="'+obj.description+'">'+obj.description+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>')
                
                        }
                    }


                    if(response.deductible_panel)
                    {

                        var deductibledata = JSON.parse(response.deductible_panel); 

                        for(var i = 0; i < deductibledata.length; i++) 
                        {
                            var obj = deductibledata[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#deductiblePanelendorsement tbody').empty();
                            $('#deductiblePanelendorsement tbody').prepend('<tr id="iiddeductibleendorsement'+obj.id+'" data-name="deductibleendorsementvalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.currencydata+'">'+obj.currencydata+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td data-name="'+obj.min_claimamount+'">'+obj.min_claimamount+'</td><td></td></tr>');
              
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
                            $('#ExtendCoveragePanelendorsement tbody').empty();
                            $('#ExtendCoveragePanelendorsement tbody').prepend('<tr id="iidextendcoverageendorsement'+obj.id+'" data-name="extendcoverageendorsementvalue[]"><td data-name="'+obj.coveragetype+'">'+obj.coveragetype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>');
                            
                        }
                    }


                    if(response.installment_panel)
                    {

                        var installment_panel = JSON.parse(response.installment_panel); 

                        for(var i = 0; i < installment_panel.length; i++) 
                        {
                            var obj = installment_panel[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#installmentPanelendorsement tbody').empty();
                            $('#installmentPanelendorsement tbody').prepend('<tr id="iidinstallmentendorsement'+obj.id+'" data-name="installmentendorsementvalue[]"><td data-name="'+obj.installment_date+'">'+obj.installment_date+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+'</td><td></td></tr>')
               
                        }
                    }



                    if(response.retrocession_panel)
                    {

                        var retrocession_panel = JSON.parse(response.retrocession_panel); 

                        for(var i = 0; i < retrocession_panel.length; i++) 
                        {
                            var obj = retrocession_panel[i];

                            //console.log(obj.id);
                            //$('#interestInsuredTabledetail tbody').prepend('');
                            $('#retrocessionPanelendorsement tbody').empty();
                            
                            $('#retrocessionPanelendorsement tbody').prepend('<tr id="iidretrocessionendorsement'+obj.id+'" data-name="retrocessionendorsementvalue[]"><td data-name="'+obj.type+'">'+obj.type+'</td><td data-name="'+obj.contract+'">'+obj.contract+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+obj.amount+'">'+obj.amount+')</td><td></td></tr>');
              
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
                        //$("#slipoccupacyendorsement option[value=" + response.occupacy + "]:first")[0].selected = true;
                    }

                    if(response.build_const)
                    {
                       //$("#slipbld_constendorsement option[value=" + response.build_const + "]:first")[0].selected = true;
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
                        //$("#sliprbendorsement option[value=" + response.retro_backup + "]:first")[0].selected = true;
                    }

                    $('#slipnoendorsement').val(response.slip_no);
                    $('#slipcndnendorsement').val(response.cn_dn);
                    $('#slippolicy_noendorsement').val(response.policy_no);
                    $('#sliptotalsumendorsement').val(response.total_sum_insured);
                  
                    $('#slippctendorsement').val(response.insured_pct);
                    $('#sliptotalsumpctendorsement').val(response.total_sum_pct);
                    $('#slipipfromendorsement').val(response.insurance_period_from);
                    $('#slipiptoendorsement').val(response.insurance_period_to);
                    $('#sliprpfromendorsement').val(response.reinsurance_period_from);
                    $('#sliprptoendorsement').val(response.reinsurance_period_to);
                    $('#switch-proportional').val(response.proportional);

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
                    
                    
                    swal("Good job!", "Data Show")
                    console.log(response)

            },
            error: function (request, status, error) {
                    //alert(request.responseText);
                    swal("Error!", "Get Slip Data Error", "Get Data Error");
            }
        });
        

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


 $("#btnaddlayer").attr('hidden','true');
        $("#sliplayerproportional").attr('hidden','true');
        $("#labelnonprop").attr('hidden','true');
        $("#tabretro").attr('hidden','true');


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
        if(typeof attr !== typeof undefined && attr !== false){
            // $("#retrocessionPanel").removeAttr('hidden');
            $("#tabretro").removeAttr('hidden');
        }
        else{
            // $("#retrocessionPanel").attr('hidden','true');
            $("#tabretro").attr('hidden','true');
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
                //$('#locRiskTable tbody').prepend('<tr id="sid'+response.id+'"><td>'+shipcode+'</td><td>'+shipname+'</td><td><a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
                
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
               var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(response.amount);
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.description+'">'+response.description+'</td><td data-name="'+response.amount+'">'+curr_amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
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
            }
        });
    }
</script>

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
        $('#feshareupdate').val(shareslip);
     });

     $('#sliprateupdate').keyup(function () {
        var rateslip =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsumupdate").val());
        var sum = isNaN(rateslip * tsi/100) ? 0 :(rateslip * tsi/100) ;
        $('#slipbasicpremiumupdate').val(sum);
     });

     $('#slipshareupdate').change(function () {
        var rateslip =  parseFloat($('#sliprateupdate').val()) / 100 ;
        var shareslip =  parseFloat($('#slipshareupdate').val()) / 100 ;
        var ourshare =  parseFloat($('#feshareupdate').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsumupdate").val());
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * tsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonrupdate').val(sum);
        $('#fesharefromupdate').val(sumourshare);
     });

     $('#slipcommissionupdate').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = parseFloat($("#slipgrossprmtonrupdate").val());
        var sum = isNaN(commision * sumgrossprmtonr/100) ? 0 :(commision * sumgrossprmtonr/100);
        var sumnetprmtonr = isNaN( sumgrossprmtonr * (100/100 - commision)) ? 0 :(sumgrossprmtonr * (100/100 - commision));
        $('#slipsumcommissionupdate').val(sum);
        $('#slipnetprmtonrupdate').val(sumnetprmtonr);
    });

    $('#sliporupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = parseFloat($("#slipsumshareupdate").val());
        var sum = isNaN(percent * sumshare) ? 0 :(percent * sumshare);
        $('#slipsumorupdate').val(sum);
    });

    $('#sliprppercentageupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumshare = parseFloat($("#slipsumshareupdate").val());
        var sum = isNaN(percent * sumshare) ? 0 :(percent * sumshare);
        $('#sliprpamountupdate').val(sum);
    });

    $('#slipippercentageupdate').keyup(function () {
        var percent =  parseFloat($(this).val()) / 100;
        var sumnetprtonr = parseFloat($("#slipnetprmtonrupdate").val());
        var sum = isNaN(percent * sumnetprtonr) ? 0 :(percent * sumnetprtonr);
        $('#slipipamountupdate').val(sum);
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
        $('#feshareendorsement').val(shareslip);
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
        var ourshare =  parseFloat($('#feshareendorsement').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsumendorsement").val());
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * tsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonrendorsement').val(sum);
        $('#fesharefromendorsement').val(sumourshare);
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

<script type='text/javascript'>
     
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
        $('#mpshare').val(shareslip);
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
        var ourshare =  parseFloat($('#mpshare').val()) / 100 ;
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        var sumourshare = isNaN(ourshare * tsi ) ? 0 :(ourshare * tsi) ;
        $('#slipgrossprmtonr').val(sum);
        $('#mpsharefrom').val(sumourshare);
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




<script type='text/javascript'>
    
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

</script>

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
    $('#addpropertyinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var property_type_id = $('#mppropertytypelist').val();
       
       var slip_id = $('#slipnumber').val();
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
               id_slip:slip_id
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
       var slipsumcommission =  $('#slipsumcommission').val();
       var slipcommission =  $('#slipcommission').val();
       var slipnetprmtonr =  $('#slipnetprmtonr').val();
       var sliprb =  $('#sliprb').val();
       var slipor =  $('#slipor').val();
       var slipsumor =  $('#slipsumor').val();

       var token2 = $('input[name=_token]').val();
       
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
               slipsumor:slipsumor
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Moveable Property Slip Insert Success", "success")
                console.log(response)

           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Insured Moveable Property Slip Insert Error", "Insert Error");
           }
       });


       var mpnumber = $('#insuredIDtxt').val();
       var mpinsured = $('#mpinsured').val();
       var mpsuggestinsured = $('#autocomplete').val();
       var mpsuffix = $('#autocomplete2').val();
       var mpshare = $('#mpshare').val();
       var mpsharefrom  = $('#mpsharefrom').val();
       var mpshareto = $('#mpshareto').val();
       var mpcoinsurance = $('#mpcoinsurance').val();
       
       
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
               mpsharefrom:mpsharefrom,
               mpshareto:mpshareto,
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
       var slipsumcommission =  $('#slipsumcommission').val();
       var slipcommission =  $('#slipcommission').val();
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
                swal("Good job!", "Moveable Property Slip Insert Success", "success")
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


        //save insured

       var mpnumber = $('#insuredIDtxt').val();
       var mpinsured = $('#mpinsured').val();
       var mpsuggestinsured = $('#autocomplete').val();
       var mpsuffix = $('#autocomplete2').val();
       var mpshare = $('#mpshare').val();
       var mpsharefrom  = $('#mpsharefrom').val();
       var mpshareto = $('#mpshareto').val();
       var mpcoinsurance = $('#mpcoinsurance').val();
       
       
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
               mpsharefrom:mpsharefrom,
               mpshareto:mpshareto,
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

   });
</script>


<script type='text/javascript'>
   $('#multi-file-upload-ajax2').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var code_ms = $('#insuredIDtxt').val();
       var prevslipnumber = $('#prevslipnumber').val();
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
       var slipcommission =  $('#slipcommission').val();
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
           url:"{{url('transaction-data/mp-slip/endorsementstore')}}",
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
                swal("Good job!", "Moveable Property Slip Insert Success", "success")
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


        //save insured

       var mpnumber = $('#insuredIDtxt').val();
       var mpinsured = $('#mpinsured').val();
       var mpsuggestinsured = $('#autocomplete').val();
       var mpsuffix = $('#autocomplete2').val();
       var mpshare = $('#mpshare').val();
       var mpsharefrom  = $('#mpsharefrom').val();
       var mpshareto = $('#mpshareto').val();
       var mpcoinsurance = $('#mpcoinsurance').val();
       
       
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
               mpsharefrom:mpsharefrom,
               mpshareto:mpshareto,
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

   });
</script>