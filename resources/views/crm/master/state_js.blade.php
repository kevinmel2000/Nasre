<script>
    $(function () {
      "use strict";
  
      var states = <?php echo(($state_ids->content())) ?>;
      for(const id of states) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
    });
  
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this State data and related data?')}}")
        if(choice){
            document.getElementById('delete-state-'+id).submit();
        }
    }
  
  </script>