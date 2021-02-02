<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>
<script type="text/javascript">
    $('#companynamefield').change(function(){
        var str = $(this).val();
        var ret = str.split(" ");
        var str1 = ret[0];
        var res = str1.substr(0,2).toUpperCase();
        
        if(str){
        $.ajax({
                type:"GET",
                url:"{{route('cedingbroker.getcode')}},
                dataType: 'jsonp',
                success:function(response){        
                    if(response){
                        console.log(res + response.autocode);
                        $('#codecedbrok').val(res + response.autocode);     
                    }else{
                        console.log(res + response.autocode);
                    }
                }
            });
        }
    });
</script>

<script>
    $(function () {
      "use strict";
  
      var cedingbrokers = <?php echo(($cedingbroker_ids->content())) ?>;
      for(const id of cedingbrokers) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }

      $("#cedingbrokerTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
        
      });
  
  
     
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Ceding Broker Data and related data?')}}")
        if(choice){
            document.getElementById('delete-ceding-'+id).submit();
        }
    }
  
  </script>