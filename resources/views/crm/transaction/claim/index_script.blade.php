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
			 regcomp:regcomp
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
			 regcomp:regcomp
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

