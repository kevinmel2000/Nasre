<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
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



<script>
    // $('#ocpparentdd').change(function(){
    //     var parentocp = $(this).val();
    //     console.log(parentocp)
    //     if(parentocp){
    //         $.ajax({
    //             type:"GET",
    //             dataType: 'json',
    //             url:"{{url('get-ocp-autocode')}}?ocp_code="+parentocp,
    //             success:function(response){        
    //                 if(response){
    //                     console.log(response);
    //                     console.log(response.last_parent);
    //                     console.log(response.last_sum);
    //                     $("#ocpcode").val(response.autocode);
    //                     $("#ocpcode").attr('readonly',false);
    //                 }else{
    //                     console.log("data gak ada");
    //                 }
    //             }
    //         });
    //     }else{
    //         $("#ocpcode").val(" ");
    //         $("#ocpcode").attr('readonly',false);
    //     }
    // });

</script>


<script>
    $(function () {
      "use strict";
  
      var ocp = <?php echo(($ocp_ids->content())) ?>;
      for(const id of ocp) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#ocpTable").DataTable({
        "order": [[ 0, "asc" ]],
        "sScrollY": 300,
        "sScrollX": "100%",
        "sScrollXInner": "100%",
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Occupation and related data?')}}")
        if(choice){
            document.getElementById('delete-ocp-'+id).submit();
        }
    }
  
  </script>