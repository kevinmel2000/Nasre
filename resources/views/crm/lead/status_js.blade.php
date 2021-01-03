<script>
  $(function () {
    "use strict";

    var statuss = <?php echo(($status_ids->content())) ?>;
    for(const id of statuss) {
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
      let choice = confirm("{{__('Are You sure, You want to Delete this record ?')}}")
      if(choice){
          document.getElementById('delete-status-'+id).submit();
      }
  }
</script>