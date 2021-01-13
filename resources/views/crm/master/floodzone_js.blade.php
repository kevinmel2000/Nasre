<script>
    $(function () {
      "use strict";
  
      var floodzones = <?php echo(($floodzone_ids->content())) ?>;
      for(const id of floodzones) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
    });
  
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Flood zone data and related data?')}}")
        if(choice){
            document.getElementById('delete-floodzone-'+id).submit();
        }
    }
  
  </script>