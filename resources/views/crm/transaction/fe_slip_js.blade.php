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