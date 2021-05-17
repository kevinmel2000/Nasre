<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>    
<script src="{{asset('/js/select2.js')}}"></script>

<link href="{{asset('css/sweetalert2.min.css')}}" rel="stylesheet"/>
<script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){

		$('.datepicker').datepicker();
		$(".e1").select2({ width: '100%' }); 

	})
</script>


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
  
    //triggered when modal is about to be shown
    $('#detailmodaldata').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        //var codesl = $(e.relatedTarget).data('book-id');
         //alert(codesl);

        var slipnumberdata =$('#slipnumberdata').val();

        if(slipnumberdata)
        {
            $.ajax({
                url:'{{ url("/") }}/transaction-data/detailslipnumber/'+slipnumberdata,
                type:"GET",
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(response)
                {
                    console.log('bisa tampil')
                    console.log(response);
                    $('#slipnumberdetail').val(response.number);
                    $('#slipusernamedetail').val(response.username);
                    $('#slipprodyeardetail').val(response.prod_year);
                    $('#slipuydetail').val(response.uy);
                    $('#slipeddetail').val(response.endorsment);
                    $('#slipslsdetail').val(response.selisih);
                    $('#wpcdetail').val(response.wpc);

                    $('#slipvbrokerdetail').val(response.v_broker);


                    if(response.deductible_panel && response.deductible_panel.length > 10)
                    {

                        var deductibledata = JSON.parse(response.deductible_panel); 
                        $('#deductiblePaneldetail tbody').empty();
                        for(var i = 0; i < deductibledata.length; i++) 
                        {
                            var obj = deductibledata[i];

                                //console.log(obj.id);
                                //$('#interestInsuredTabledetail tbody').prepend('');
                                // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                                var conv_amount = obj.amount.toFixed(2);
                                var str_amount = conv_amount.toString();
                                var curr_amount = str_amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                // var curr_minamount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.min_claimamount);
                                var conv_minamount = obj.min_claimamount.toFixed(2);
                                var str_minamount = conv_minamount.toString();
                                var curr_minamount = str_minamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                // var curr_minamount = obj.min_claimamount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                
                                $('#deductiblePaneldetail tbody').prepend('<tr id="iiddeductible'+obj.id+'" data-name="deductibledetailvalue[]"><td data-name="'+obj.deductibletype+'">'+obj.deductibletype+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td data-name="'+curr_minamount+'">'+curr_minamount+'</td><td></td></tr>');

                            }
                        }


                        if(response.extend_coverage && response.extend_coverage.length > 10)
                        {

                            var extend_coverage = JSON.parse(response.extend_coverage); 
                            $('#ExtendCoveragePaneldetail tbody').empty();
                            for(var i = 0; i < extend_coverage.length; i++) 
                            {
                                var obj = extend_coverage[i];

                                //console.log(obj.id);
                                //$('#interestInsuredTabledetail tbody').prepend('');
                                // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                                var conv_amount = obj.amount.toFixed(2);
                                var str_amount = conv_amount.toString();
                                var curr_amount = str_amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                // var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                
                                $('#ExtendCoveragePaneldetail tbody').prepend('<tr id="iidextendcoveragedetail'+obj.id+'" data-name="extendcoveragedetailvalue[]"><td data-name="'+obj.coveragetype+'">'+obj.coveragecode + ' - ' + obj.coveragename+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td></td></tr>');
                                
                            }
                        }


                        if(response.installment_panel && response.installment_panel.length > 10)
                        {

                            var installment_panel = JSON.parse(response.installment_panel); 
                            $('#installmentPaneldetail tbody').empty();
                            for(var i = 0; i < installment_panel.length; i++) 
                            {
                                var obj = installment_panel[i];
                                // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                                // var conv_amount = obj.amount.toFixed(2);
                                // var str_amount = conv_amount.toString();
                                // var curr_amount = str_amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                var currdate = obj.installment_date;
                                var convdate = currdate.split("-").reverse().join("/");
                                console.log('conv date ' + convdate)
                                var strdate = convdate.toString();

                                //console.log(obj.id);
                                //$('#interestInsuredTabledetail tbody').prepend('');
                                
                                $('#installmentPaneldetail tbody').prepend('<tr id="iidinstallmentdetail'+obj.id+'" data-name="installmentdetailvalue[]"><td data-name="'+obj.installment_date+'">'+strdate+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td></td></tr>')

                            }
                        }



                        if(response.retrocession_panel && response.retrocession_panel.length > 10)
                        {

                            var retrocession_panel = JSON.parse(response.retrocession_panel); 
                            $('#retrocessionPaneldetail tbody').empty();
                            for(var i = 0; i < retrocession_panel.length; i++) 
                            {
                                var obj = retrocession_panel[i];
                                // var curr_amount = new Intl.NumberFormat('id-ID',  {style: 'currency',currency: 'IDR',}).format(obj.amount);
                                var conv_amount = obj.amount.toFixed(2);
                                var str_amount = conv_amount.toString();
                                var curr_amount = str_amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                // var curr_amount = obj.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                //console.log(obj.id);
                                //$('#interestInsuredTabledetail tbody').prepend('');
                                
                                
                                $('#retrocessionPaneldetail tbody').prepend('<tr id="iidretrocessiondetail'+obj.id+'" data-name="retrocessiondetailvalue[]"><td data-name="'+obj.type+'">'+obj.type+'</td><td data-name="'+obj.contract+'">'+obj.contract+'</td><td data-name="'+obj.percentage+'">'+obj.percentage+'</td><td data-name="'+curr_amount+'">'+curr_amount+'</td><td></td></tr>');

                            }
                        }
                        
                        
                        if(response.status)
                        {
                            $("#slipstatusdetail").val(response.status);
                            
                        // $("#slipstatusdetail option").attr('hidden',true);
                        // $("#slipstatusdetail option[value=" + response.status + "]:first")[0].hidden = false;
                        // $("#slipstatusdetail option[value=" + response.status + "]:first")[0].selected = true;
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
                                $("#tabretrodetail").attr('hidden','true');
                            }
                            else if(response.retro_backup == "YES"){
                                $("#tabretrodetail").removeAttr('hidden');
                            }
                        }

                        if(response.type_tsi)
                        {
                            $("#sliptypetsidetail option[value=" + response.type_tsi + "]:first")[0].selected = true;
                        }

                        if(response.type_share_tsi)
                        {
                            $("#sharetypetsidetail option[value=" + response.type_share_tsi + "]:first")[0].selected = true;
                        }


                        if(response.status_log){
                                $('#statuslogdetailform tbody').empty();
                                var status_log = response.status_log;
                                
                                for(var i = 0; i < status_log.length; i++){

                                    var status = status_log[i].status;
                                    var datetime = status_log[i].datetime;
                                    var user = status_log[i].user;

                                    $('#statuslogdetailform tbody').append('<tr id="stlid'+status_log[i].id+'"> <td>'+status+'</td> <td >'+ datetime +'</td> <td>'+user+'</td> </tr>')
                                    // $('#statlistdetail').append('<li><div class="control-group input-group" id="control-group2" style="margin-top:10px">'+datetime+' - '+ status + ' - ' + user +'</div></li>')
                            
                            };
                        }

                        console.log('status log')
                        console.log(response.status_log)


                    if(response.attacment_file)
                    {
                        $('#aidlistdetail li').remove();
                        var attacment_file = response.attacment_file;
                        for(var i = 0; i < attacment_file.length; i++){
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

                    if(response.share_tsi){
                        $('#sharetotalsumdetail').val(response.share_tsi.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    else
                    {
                        $('#sharetotalsumdetail').val("0");
                    }

                    
                    $('#slippctdetail').val(response.insured_pct);
                    if(response.total_sum_pct){
                        $('#sliptotalsumpctdetail').val(response.total_sum_pct.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    else{
                        $('#sliptotalsumpctdetail').val("0");
                    }

                    if(response.date_transfer == null || response.date_transfer == "" ){
                    $('#sliptddetail').val(''); 
                }else{
                        $('#sliptddetail').val(response.date_transfer); 
                }
                    
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
                            $('#slipsumsharedetail2').val(response.sum_share.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        }
                        else{
                            $('#slipsumsharedetail').val("0");
                            $('#slipsumsharedetail2').val("0");
                        }

                        if(response.sum_rate){
                            $('#sliptotalratedetail').val(response.sum_share.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            $('#sliptotalratedetail').val(response.sum_share.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        }
                        else{
                            $('#slipsumsharedetail').val("0");
                            $('#slipsumsharedetail2').val("0");
                        }

                        if(response.sum_feebroker){
                            $('#slipsumfeedetail').val(response.sum_feebroker.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            $('#slipsumfeedetail2').val(response.sum_feebroker.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        }
                        else{
                            $('#slipsumfeedetail').val("0");
                            $('#slipsumfeedetail2').val("0");
                        }


                        if(response.basic_premium){
                            $('#slipbasicpremiumdetail').val(response.basic_premium.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        }else
                        {
                            $('#slipbasicpremiumdetail').val("0");
                        }
                        
                        if(response.grossprm_to_nr){
                            $('#slipgrossprmtonrdetail').val(response.grossprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            $('#slipgrossprmtonrdetail2').val(response.grossprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        
                        }
                        else{
                            $('#slipgrossprmtonrdetail').val("0");
                            $('#slipgrossprmtonrdetail2').val("0");
                        }

                        if(response.commission){
                            $('#slipcommissiondetail').val(response.commission);
                        }
                        else{
                            $('#slipcommissiondetail').val(0);
                        }
                        

                        if(response.sum_commission){
                            $('#slipsumcommissiondetail').val(response.sum_commission.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            $('#slipsumcommissiondetail2').val(response.sum_commission.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        
                        }
                        else{
                            $('#slipsumcommissiondetail').val("0");
                            $('#slipsumcommissiondetail2').val("0");

                        }

                        if(response.netprm_to_nr){
                            $('#slipnetprmtonrdetail').val(response.netprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            $('#slipnetprmtonrdetail2').val(response.netprm_to_nr.replace(/\B(?=(\d{3})+(?!\d))/g, ",")); 
                        }
                        else{
                            $('#slipnetprmtonrdetail').val("0"); 
                            $('#slipnetprmtonrdetail2').val("0"); 
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
                        $('#countendorsmentdetail2').val(response.endorsment);
                        $('#remarksdetail').val(response.remarks);
                        
                        
                        swal("Success!", "Data Show")
                        console.log(response)

                    },
                    error: function (request, status, error) {
                        //alert(request.responseText);
                        swal("Error!", "Get Slip Data Error", "Get Data Error");
                    }
                });
                
        }
        else
        {
            swal("Error!", "Get Slip Data Empty", "Get Data Error");
     
        }

    });

</script>


<script type='text/javascript'>
    $('#detailclaimbutton').click(function(e){
       //alert('masuk');
       e.preventDefault();
       
        alert('test');
    });
</script>


<script type='text/javascript'>
    $('#addallclaiminsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();
       

    var regcomp = $('#regcomp').val();
	var number = $('#docnumber').val();
	var dateofreceipt = $('#dateofreceipt').val();
	var dateofdocument = $('#dateofdocument').val();

	var causeofloss = $('#causeofloss').val();
	var desccauseofloss = $('#desccauseofloss').val();
	
	var natureofloss = $('#natureofloss').val();
	var descnatureofloss = $('#descnatureofloss').val();
	var dateofloss = $('#dateofloss').val();
    
    var currofloss = $('#currofloss').val();
    var desccurrofloss = $('#desccurrofloss').val();

    var surveyoradjuster = $('#surveyoradjuster').val();
    var descsurveyoradjuster = $('#descsurveyoradjuster').val();

    var nationalresliab = $('#nationalresliab').val();
    var descnationalresliab = $('#descnationalresliab').val();
    var shareonloss = $('#shareonloss').val();
    var cedantshare = $('#cedantshare').val();
    var totallossamount = $('#totallossamount').val();

    var potentialrecoverydecision = $('#potentialrecoverydecision').val();
    var potentialrecovery = $('#potentialrecovery').val();
    var subrogasi = $('#subrogasi').val();
    var kronologi = $('#kronologi').val();
    var staffrecomend = $('#staffrecomend').val();
    var assistantmanagerrecomend = $('#assistantmanagerrecomend').val();

    var pureorliability = $('#pureorliability').val();
    var pureorloss = $('#pureorloss').val();
    var pureorcontract = $('#pureorcontract').val();
    var pureorrecovery = $('#pureorrecovery').val();

    var qsliability = $('#qsliability').val();
    var qsloss = $('#qsloss').val();
    var qscontract = $('#qscontract').val();
    var qsrecovery = $('#qsrecovery').val();

    var arr1liability = $('#arr1liability').val();
    var arr1loss = $('#arr1loss').val();
    var arr1contract = $('#arr1contract').val();
    var arr1recovery = $('#arr1recovery').val();

    var extraliability = $('#extraliability').val();
    var extraloss = $('#extraloss').val();
    var extracontract = $('#extracontract').val();
    var extrarecovery = $('#extrarecovery').val();

    var facultativeliability = $('#facultativeliability').val();
    var facultativeloss = $('#facultativeloss').val();
    var facultativecontract = $('#facultativecontract').val();
    var facultativerecovery = $('#facultativerecovery').val();

    var arr2liability = $('#arr2liability').val();
    var arr2loss = $('#arr2loss').val();
    var arr2contract = $('#arr2contract').val();
    var arr2recovery = $('#arr2recovery').val();

    var arr3liability = $('#arr3liability').val();
    var arr3loss = $('#arr3loss').val();
    var arr3contract = $('#arr3contract').val();
    var arr3recovery = $('#arr3recovery').val();


    var totalrecovery = $('#totalrecovery').val();
    var nrsgrossret = $('#nrsgrossret').val();
    var xol = $('#xol').val();
    var cereffno = $('#cereffno').val();
    var dateofprod = $('#dateofprod').val();
    var ceno = $('#ceno').val();
    var ceuser = $('#ceuser').val();
    var description = $('#description').val();
    var dateentry = $('#dateentry').val();
    var datetrans = $('#datetrans').val();
    var datesupporting = $('#datesupporting').val();
  

    var token2 = $('input[name=_token]').val();

    if(regcomp == ''){
        swal('given data was invalid!','please check input field','error input')
    }
	else
	{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
         url:"{{ url('claimtransaction-data/claim/store') }}",
         type:"POST",
         data:{
			 regcomp:regcomp,
			 number:number,
			 dateofreceipt:dateofreceipt,
			 dateofdocument:dateofdocument,
			 causeofloss:causeofloss,
			 desccauseofloss:desccauseofloss,
			 natureofloss:natureofloss,
			 descnatureofloss:descnatureofloss,
             dateofloss:dateofloss,	 
             currofloss:currofloss,	
             desccurrofloss:desccurrofloss,
             surveyoradjuster:surveyoradjuster,	
             descsurveyoradjuster:descsurveyoradjuster,
             nationalresliab:nationalresliab,
             descnationalresliab:descnationalresliab,
             shareonloss:shareonloss,
             cedantshare:cedantshare,
             totallossamount:totallossamount,
             potentialrecoverydecision:potentialrecoverydecision,
             potentialrecovery:potentialrecovery,
             subrogasi:subrogasi,
             kronologi:kronologi,
             staffrecomend:staffrecomend,
             assistantmanagerrecomend:assistantmanagerrecomend,
             pureorliability:pureorliability,
             pureorloss:pureorloss,
             pureorcontract:pureorcontract,
             pureorrecovery:pureorrecovery,
             qsliability:qsliability,
             qsloss:qsloss,
             qscontract:qscontract,
             qsrecovery:qsrecovery,
             arr1liability:arr1liability,
             arr1loss:arr1loss,
             arr1contract:arr1contract,
             arr1recovery:arr1recovery,
             extraliability:extraliability,
             extraloss:extraloss,
             extracontract:extracontract,
             extrarecovery:extrarecovery,
             facultativeliability:facultativeliability,
             facultativeloss:facultativeloss,
             facultativecontract:facultativecontract,
             facultativerecovery:facultativerecovery,
             arr2liability:arr2liability,
             arr2loss:arr2loss,
             arr2contract:arr2contract,
             arr2recovery:arr2recovery,
             arr3liability:arr3liability,
             arr3loss:arr3loss,
             arr3contract:arr3contract,
             arr3recovery:arr3recovery,
             totalrecovery:totalrecovery,
             nrsgrossret:nrsgrossret,
             xol:xol,
             cereffno:cereffno,
             dateofprod:dateofprod,
             ceno:ceno,
             ceuser:ceuser,
             description:description,
             dateentry:dateentry,
             datetrans:datetrans,
             datesupporting:datesupporting


         },
         beforeSend: function() { $("body").addClass("loading");  },
         complete: function() {  $("body").removeClass("loading"); },
         success:function(response)
         {
            swal("Success!", "Claim Insert Success", "success")
            console.log(response)
          
         },
         error: function (request, status, error) {
                    //alert(request.responseText);
                    swal("Error!"+ request.responseText , "Claim Insert Error, please check input", "Insert Error");
                }
        });
    }


});
</script>




<script type='text/javascript'>
    $('#addclaiminsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();
       

    var regcomp = $('#regcomp').val();
	var number = $('#docnumber').val();
	var dateofreceipt = $('#dateofreceipt').val();
	var dateofdocument = $('#dateofdocument').val();

	var causeofloss = $('#causeofloss').val();
	var desccauseofloss = $('#desccauseofloss').val();
	
	var natureofloss = $('#natureofloss').val();
	var descnatureofloss = $('#descnatureofloss').val();
    var dateofloss = $('#dateofloss').val();

    var currofloss = $('#currofloss').val();
    var desccurrofloss = $('#desccurrofloss').val();

    var surveyoradjuster = $('#surveyoradjuster').val();
    var descsurveyoradjuster = $('#descsurveyoradjuster').val();

    var nationalresliab = $('#nationalresliab').val();
    var descnationalresliab = $('#descnationalresliab').val();
    var shareonloss = $('#shareonloss').val();
    var cedantshare = $('#cedantshare').val();
    var totallossamount = $('#totallossamount').val();

    var potentialrecoverydecision = $('#potentialrecoverydecision').val();
    var potentialrecovery = $('#potentialrecovery').val();
    var subrogasi = $('#subrogasi').val();
    var kronologi = $('#kronologi').val();
    var staffrecomend = $('#staffrecomend').val();
    var assistantmanagerrecomend = $('#assistantmanagerrecomend').val();

    var pureorliability = $('#pureorliability').val();
    var pureorloss = $('#pureorloss').val();
    var pureorcontract = $('#pureorcontract').val();
    var pureorrecovery = $('#pureorrecovery').val();

    var qsliability = $('#qsliability').val();
    var qsloss = $('#qsloss').val();
    var qscontract = $('#qscontract').val();
    var qsrecovery = $('#qsrecovery').val();

    var arr1liability = $('#arr1liability').val();
    var arr1loss = $('#arr1loss').val();
    var arr1contract = $('#arr1contract').val();
    var arr1recovery = $('#arr1recovery').val();

    var extraliability = $('#extraliability').val();
    var extraloss = $('#extraloss').val();
    var extracontract = $('#extracontract').val();
    var extrarecovery = $('#extrarecovery').val();

    var facultativeliability = $('#facultativeliability').val();
    var facultativeloss = $('#facultativeloss').val();
    var facultativecontract = $('#facultativecontract').val();
    var facultativerecovery = $('#facultativerecovery').val();

    var arr2liability = $('#arr2liability').val();
    var arr2loss = $('#arr2loss').val();
    var arr2contract = $('#arr2contract').val();
    var arr2recovery = $('#arr2recovery').val();

    var arr3liability = $('#arr3liability').val();
    var arr3loss = $('#arr3loss').val();
    var arr3contract = $('#arr3contract').val();
    var arr3recovery = $('#arr3recovery').val();

    var totalrecovery = $('#totalrecovery').val();
    var nrsgrossret = $('#nrsgrossret').val();
    var xol = $('#xol').val();
    var cereffno = $('#cereffno').val();
    var dateofprod = $('#dateofprod').val();
    var ceno = $('#ceno').val();
    var ceuser = $('#ceuser').val();
    var description = $('#description').val();
    var dateentry = $('#dateentry').val();
    var datetrans = $('#datetrans').val();
    var datesupporting = $('#datesupporting').val();

    var token2 = $('input[name=_token]').val();
 
    if(regcomp == ''){
        swal('given data was invalid!','please check input field','error input')
    }
	else
	{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
         url:"{{ url('claimtransaction-data/claim/store') }}",
         type:"POST",
         data:{
			 regcomp:regcomp,
			 number:number,
			 dateofreceipt:dateofreceipt,
			 dateofdocument:dateofdocument,
			 causeofloss:causeofloss,
			 desccauseofloss:desccauseofloss,
			 natureofloss:natureofloss,
			 descnatureofloss:descnatureofloss,
             dateofloss:dateofloss,
             currofloss:currofloss,	
             desccurrofloss:desccurrofloss,
             surveyoradjuster:surveyoradjuster,	
             descsurveyoradjuster:descsurveyoradjuster,
             nationalresliab:nationalresliab,
             descnationalresliab:descnationalresliab,
             shareonloss:shareonloss,
             cedantshare:cedantshare,
             totallossamount:totallossamount,
             potentialrecoverydecision:potentialrecoverydecision,
             potentialrecovery:potentialrecovery,
             subrogasi:subrogasi,
             kronologi:kronologi,
             staffrecomend:staffrecomend,
             assistantmanagerrecomend:assistantmanagerrecomend,
             pureorliability:pureorliability,
             pureorloss:pureorloss,
             pureorcontract:pureorcontract,
             pureorrecovery:pureorrecovery,
             qsliability:qsliability,
             qsloss:qsloss,
             qscontract:qscontract,
             qsrecovery:qsrecovery,
             arr1liability:arr1liability,
             arr1loss:arr1loss,
             arr1contract:arr1contract,
             arr1recovery:arr1recovery,
             extraliability:extraliability,
             extraloss:extraloss,
             extracontract:extracontract,
             extrarecovery:extrarecovery,
             facultativeliability:facultativeliability,
             facultativeloss:facultativeloss,
             facultativecontract:facultativecontract,
             facultativerecovery:facultativerecovery,
             arr2liability:arr2liability,
             arr2loss:arr2loss,
             arr2contract:arr2contract,
             arr2recovery:arr2recovery,
             arr3liability:arr3liability,
             arr3loss:arr3loss,
             arr3contract:arr3contract,
             arr3recovery:arr3recovery,
             totalrecovery:totalrecovery,
             nrsgrossret:nrsgrossret,
             xol:xol,
             cereffno:cereffno,
             dateofprod:dateofprod,
             ceno:ceno,
             ceuser:ceuser,
             description:description,
             dateentry:dateentry,
             datetrans:datetrans,
             datesupporting:datesupporting


         },
         beforeSend: function() { $("body").addClass("loading");  },
         complete: function() {  $("body").removeClass("loading"); },
         success:function(response)
         {
            swal("Success!", "Claim Insert Success", "success")
            console.log(response)
          
         },
         error: function (request, status, error) {
                    //alert(request.responseText);
                    swal("Error!"+ request.responseText , "Claim Insert Error, please check input", "Insert Error");
                }
        });
    }


});
</script>




