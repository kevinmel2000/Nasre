<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); 
        
        $.ajax({
            type:"GET",
            url:"{{url('get-city-all')}},
            success:function(res){        
                if(res){
                    $("#spcity").attr('class','e1 form-control form-control-sm')
                    $("#spcity").append('<option selected disabled>Select City</option>');
                    $.each(res,function(key,value){
                    $("#spcity").append('<option value="'+key+'">'+value+'</option>');
                    });
                
                }else{
                    $("#spcity").empty();
                }
            }
        });
        
        
        });
</script>

<script>
    $(function () {
      "use strict";
  
      var shipport = <?php echo(($shipport_ids->content())) ?>;
      for(const id of shipport) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#shipportTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
        
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Ship Port and related data?')}}")
        if(choice){
            document.getElementById('delete-shipport-'+id).submit();
        }
    }
  
</script>