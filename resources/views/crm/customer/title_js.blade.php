<script>
  $(function () {
    "use strict";

    var titles = <?php echo(($title_ids->content())) ?>;
    for(const id of titles) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }



    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });


  });

  function confirmDelete(id){
      let choice = confirm("Are You sure, You want to Delete this record ?")
      if(choice){
          document.getElementById('delete-title-'+id).submit();
      }
  }

</script>