<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>
<style>
    .hide {
        display: none;
    }
</style>

<script>
    $( "#autocomplete" ).autocomplete({
      source: [
      @foreach (@$customer as $costumerdata)
       "{{@$costumerdata->company_name }}",
      @endforeach
      ]
    });
    </script>
    
    <script>
        $( "#autocomplete2" ).autocomplete({
          source: [
          @foreach (@$customer as $costumerdata)
           "{{@$costumerdata->company_name }}",
          @endforeach
          ]
        });
    </script>

<script>
    var CSRF_TOKEN = $('meta[name="_token2"]').attr('content');
    
   $(document).ready(function() { 
           
           $(".e1").select2({ width: '100%' }); 
           
           $("#btn-success2").click(function(){ 
           var html = $(".clone2").html();
           $(".increment2").after(html);
           });
   
           $("body").on("click","#btn-danger2",function(){ 
           $(this).parents("#control-group2").remove();
           });
   
   
        //    $( "#employee_search" ).autocomplete({
        //    source: function( request, response ) {
             // Fetch data
            //  $.ajax({
            //    url:"{{route('customer.getCostumers')}}",
            //    type: 'post',
            //    dataType: "json",
            //    data: {
            //       _token: CSRF_TOKEN,
            //       search: request.term
            //    },
            //    success: function( data ) {
            //       response( data );
            //      // alert(data[0].label);
            //    },
            //    fail : function ( jqXHR, textStatus, errorThrown ) {
            //        console.log(jqXHR);
            //        console.log(textStatus);
            //        console.log(errorThrown);
            //    }
            //  });
        //    },
        //    select: function (event, ui) {
        //       // Set selection
        //       //alert(ui.item.label);
   
        //       $('#employee_search').val(ui.item.label); // display the selected text
        //       //$('#employeeid').val(ui.item.value); // save selected id to input
        //       return false;
        //    }
        //  });
           
   });
   </script>



<script type="text/javascript">
     $('#shipcodetxt').change(function(){
        var shipcode = $(this).val();

        if(shipcode){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-ship-list')}}?ship_code="+shipcode,
                success:function(response){        
                    if(response){
                        $("#shipnametxt").val(response.shipname);
                    }else{
                        $("#shipnametxt").empty();
                    }
                }
            });
        }else{
            $("#shipnametxt").empty();
        }
    });
</script>

<script type='text/javascript'>
     $('#form-addship').submit(function(e){
        e.preventDefault();

        var shipcode = $('#shipcodetxt').val();
        var shipname = $('#shipnametxt').val();
        var insured_id = $('#insuredIDtxt').val();
        var token = $('input[name=_token]').val();
        
        $.ajax({
            url:"{{ route('shiplist.store') }}",
            type:"POST",
            data:{
                ship_code:shipcode,
                ship_name:shipname,
                insuredID:insured_id,
                _token:token
            },
            success:function(response){
                console.log(response)
                $('#shipdetailTable tbody').prepend('<tr id="sid'+response.id+'"><td>'+shipcode+'</td><td>'+shipname+'</td><td><a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
                $('#ModalAddShip').modal('toggle');
                $('#form-addship')[0].reset();
            }
        });

    });
</script>



<script type='text/javascript'>
    function deleteshipdetail(id){
        var token = $('input[name=_token]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-ship-list/'+id,
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
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('interestlist.store') }}",
           type:"POST",
           data:{
               interest_insured:interest,
               slipamount:amount,
               id_slip:slip_id
           },
           success:function(response){
            
               console.log(response)
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.interest_id+'">'+response.description+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
               $('#slipamount').val('');
               $('#slipinterestlist').val('');
               
               
               var total =  parseFloat($("#sliptotalsum").val());
               var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
               $("#sliptotalsum").val(sum);
               $("#msishareto").val(sum);
               
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
        $('#msisharefrom').val(shareslip);
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
                var total =  parseFloat($("#sliptotalsum").val());
                var sum = isNaN(total - parseFloat(response.amount)) ? 0 :(total - parseFloat(response.amount)) ;
                $("#sliptotalsum").val(sum);
                $("#msishareto").val(sum);
                
            }
        });
    }
</script>

<script>
    $(function () {
      "use strict";
  
      var marineslip = <?php echo(($ms_ids->content())) ?>;
      for(const id of marineslip) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#marineSlip").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"Bf>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this product and related data?')}}")
        if(choice){
            document.getElementById('delete-country-'+id).submit();
        }
    }
  
</script>

