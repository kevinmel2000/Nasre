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
             extrarecovery:extrarecovery
             
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
             extrarecovery:extrarecovery


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

