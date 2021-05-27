<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script>
        $(document).ready(function() { 
            
            $(".e1").select2({ width: '100%' }); 
        
        });
</script>

<script type="text/javascript">
    $('#companynamefield').change(function(){
        var str = $(this).val();
        var ret = str.split(" ");
        var count = ret.length;
        console.log(ret)
        console.log(ret.length)
        var res;
        if(count > 2){
            var str0 = ret[0].substr(0,1).toUpperCase();
            var str1 = ret[1].substr(0,1).toUpperCase();
            var str2 = ret[2].substr(0,1).toUpperCase();

            res = (str1 + str2);
        }
        else
        {
            var str0 = ret[0].substr(0,1).toUpperCase();
            var str1 = ret[1].substr(0,1).toUpperCase();
            res = (str0 + str1);
        }
        if(str){
            $.ajax({
                    type: "GET",
                    url: "{{route('cedingbroker.getcode')}}",
                    dataType: 'json',
                    success:function(response){        
                        if(response){
                            console.log(response.autocode);
                            // console.log(res + response.autocode);
                            $('#codecedbrok').val(res + response.autocode);     
                        }else{
                            // $('#codecedbrok').val(res);
                            console.log(res);
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

     
     
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Ceding Broker Data and related data?')}}")
        if(choice){
            document.getElementById('delete-ceding-'+id).submit();
        }
    }
  
  </script>