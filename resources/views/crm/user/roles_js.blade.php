<script>
  $(function () {
    "use strict";
    var roles = <?php echo(($role_ids->content())) ?>;
    for(const id of roles) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }

    $('#roles').DataTable( {
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
                      columns: [ 0, 1, 2, 3, 4]
                  }
              },
              {
                  extend: 'csv',
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4]
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4]
                  }
              },
              {
                  extend: 'pdf',
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4]
                  }
              },
              {
                  extend: 'print',
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4]
                  }
              },
            ]
      });
  });

  function confirmDelete(id){
    "use strict";
      let choice = confirm("{{__('Are you sure, you want to delete this record ?')}}")
      if(choice){
        document.getElementById('delete-role-'+id).submit();
      }
    }
</script>