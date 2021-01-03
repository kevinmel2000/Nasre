<script>
  $(function () {
    "use strict";
    var sources = <?php echo(($source_ids->content())) ?>;
    for(const id of sources) {
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
  });

  function confirmDelete(id){
      let choice = confirm("{{'Are You sure, You want to Delete this record ?'}}")
      if(choice){
          document.getElementById('delete-source-'+id).submit();
      }
  }

</script>