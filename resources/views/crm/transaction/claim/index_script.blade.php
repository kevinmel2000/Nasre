<script type="text/javascript">
	$(document).ready(function(){

		
	})
</script>


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

