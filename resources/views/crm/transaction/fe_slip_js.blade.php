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