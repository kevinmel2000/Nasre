<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>


<style>
.hide {
    display: none;
}
</style>

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
        
        $(".e1").select2({ width: '100%' }); 
        
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
            success:function(response){
                console.log(response)
               
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
           success:function(response){
            
               console.log(response)
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.interest+'">'+response.interest+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
               $('#slipamount').val('');
               $('#slipinterestlist').val('');
               var total =  parseFloat($("#sliptotalsum").val());
               var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
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
    
<script  type='text/javascript'>
    
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
            success:function(response){
                
                $('#iid'+id).remove();
                console.log(response);
            }
        });
    }
</script>

<script  type='text/javascript'>
    $('#slippct').keyup(function () {
        var pct =  parseFloat($(this).val());
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(pct * tsi/100) ? 0 :(pct * tsi/100) ;
         $('#sliptotalsumpct').val(sum);
         $('#msishare').val(pct);
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
        var tsi = parseFloat($("#sliptotalsum").val());
        var sum = isNaN(rateslip * shareslip * tsi/100) ? 0 :(rateslip * shareslip * tsi/100) ;
        $('#slipgrossprmtonr').val(sum);
     });

     $('#slipcommission').keyup(function () {
        var commision =  parseFloat($(this).val()) / 100;
        var sumgrossprmtonr = parseFloat($("#slipgrossprmtonr").val());
        var sum = isNaN(commision * sumgrossprmtonr/100) ? 0 :(commision * sumgrossprmtonr/100);
        var sumnetprmtonr = isNaN( sumgrossprmtonr * (100/100 - commision)) ? 0 :(sumgrossprmtonr * (100/100 - commision));
        $('#slipsumcommission').val(sum);
        $('#slipnetprmtonr').val(sumnetprmtonr);
    });
</script>

<script type="text/javascript">
    $(document).ready(function() { 
        
        if(($('#sliprate').val() != 0) && ($('#slipshare').val() != 0) )
        {
            
        }
        

     });
   
    

    

    
</script>

<script type='text/javascript'>
    
     $('#slipippercentage').keyup(function () {
        var persentage =  parseFloat($('#slipippercentage').val());
        var premiumnr =  parseFloat($('#slipnetprmtonr').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(premiumnr * persentage/100) ? 0 :(premiumnr * persentage/100) ;
        //alert(sum);
        $('#slipipamount').val(sum);
     });

     $('#slipippercentage').change(function () {
        var persentage =  parseFloat($('#slipippercentage').val());
        var premiumnr =  parseFloat($('#slipnetprmtonr').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(premiumnr * persentage/100) ? 0 :(premiumnr * persentage/100) ;
        //alert(sum);
        $('#slipipamount').val(sum);
     });

</script>


<script type='text/javascript'>
    
     $('#slipdppercentage').keyup(function () {
        var persentage =  parseFloat($('#slipdppercentage').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipdpamount').val(sum);
     });

     $('#slipdppercentage').change(function () {
        var persentage =  parseFloat($('#slipdppercentage').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipdpamount').val(sum);
     });

</script>


<script type='text/javascript'>
    
     $('#slipnilaiec').keyup(function () {
        var persentage =  parseFloat($('#slipnilaiec').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipamountec').val(sum);
     });

     $('#slipnilaiec').change(function () {
        var persentage =  parseFloat($('#slipnilaiec').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipamountec').val(sum);
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
           success:function(response)
           {
            
               console.log(response)
               $('#installmentPanel tbody').prepend('<tr id="iidinstallment'+response.id+'" data-name="installmentvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentdetail('+response.id+')">delete</a></td></tr>')
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
    function deleteinstallmentdetail(id)
    {
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-installment-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            success:function(response){
                
                $('#iidinstallment'+id).remove();
                console.log(response);
            }
        });
    }
</script>


<script  type='text/javascript'>
    
</script>