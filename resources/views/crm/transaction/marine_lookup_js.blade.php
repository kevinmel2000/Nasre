<script>
    $(function () {
      "use strict";
  
      var mlu = <?php echo(($mlu_ids->content())) ?>;
      for(const id of mlu) {
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
        ],
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
        ]
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this marine and related data?')}}")
        if(choice){
            document.getElementById('delete-mlu-'+id).submit();
        }
    }
  
  </script>