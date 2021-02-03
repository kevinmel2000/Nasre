<script>
    $('#kocparentdd').change(function(){
        var parentkoc = $(this).val();

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
  
      var kocs = <?php echo(($koc_ids->content())) ?>;
      for(const id of kocs) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#kocTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Koc data and related data?')}}")
        if(choice){
            document.getElementById('delete-koc-'+id).submit();
        }
    }
  
  </script>