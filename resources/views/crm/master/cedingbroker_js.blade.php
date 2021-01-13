<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2(); });
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