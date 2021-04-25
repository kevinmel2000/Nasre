<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); 
        
       

        });
</script>
<script>
    $('#kocparentdd').change(function(){
        var parentkoc = $(this).val();
        console.log(parentkoc)
        if(parentkoc){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-koc-autocode')}}?koc_code="+parentkoc,
                success:function(response){        
                    if(response){
                        console.log(response);
                        $("#koccode").val(response.autocode);
                        $("#koccode").attr('readonly',false);
                    }else{
                        console.log("data gak ada");
                    }
                }
            });
        }else{
            $("#koccode").val(" ");
            $("#koccode").attr('readonly',false);
        }
    });

</script>

<script>
    $(function () {
      "use strict";
  
      var kocs = <?php echo(($causeofloss_ids->content())) ?>;
      for(const id of kocs) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#causeoflossTable").DataTable({
        "order": [[ 0, "asc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Cause Of Loss data and related data?')}}")
        if(choice){
            document.getElementById('delete-causeofloss-'+id).submit();
        }
    }
  
  </script>