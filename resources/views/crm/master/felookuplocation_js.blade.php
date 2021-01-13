<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2(); });
</script>
<script>
    $(function () {
      "use strict";
  
      var felookuplocation = <?php echo(($felookuplocation_ids->content())) ?>;
      for(const id of felookuplocation) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Fe Lookup Location and related data?')}}")
        if(choice){
            document.getElementById('delete-felookuplocation-'+id).submit();
        }
    }
  
  </script>