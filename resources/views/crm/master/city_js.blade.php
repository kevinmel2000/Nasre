<script>
    $(function () {
      "use strict";
  
      var cities = <?php echo(($city_ids->content())) ?>;
      for(const id of cities) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this City data and related data?')}}")
        if(choice){
            document.getElementById('delete-city-'+id).submit();
        }
    }
  
  </script>