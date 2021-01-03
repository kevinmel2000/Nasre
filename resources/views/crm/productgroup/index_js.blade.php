<script>

  $(function(){
    "use strict";
    var pgs = <?php echo(($pg_ids->content())) ?>;
    for(const id of pgs) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }
    $("#productsTable").DataTable();
  });

  function confirmDelete(id){
      let choice = confirm("{{__('Are you sure, you want to delete this productgroup and related data ?')}}")
      if(choice){
          document.getElementById('delete-productgroup-'+id).submit();
      }
  }

</script>