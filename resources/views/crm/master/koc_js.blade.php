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
  
  
      $("#countryTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"Bf>rt<"bottom"lip><"clear">',
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