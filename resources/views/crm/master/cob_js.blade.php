<script>
    $(function () {
      "use strict";
  
      var cob = <?php echo(($cob_ids->content())) ?>;
      for(const id of cob) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#cobTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"Bf>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this cob and related data?')}}")
        if(choice){
            document.getElementById('delete-cob-'+id).submit();
        }
    }
  
  </script>