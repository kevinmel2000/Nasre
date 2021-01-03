<script>

  $(function(){
    "use strict";
    var formfields = <?php echo(($formfield_ids->content())) ?>;
    for(const id of formfields) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }
    $('#fieldsTable').DataTable();
  });

  function confirmDelete(id){
      let choice = confirm("{{__('Are you sure, you want to delete this field data ?')}}")
      if(choice){
          document.getElementById('delete-formfield-'+id).submit();
      }
  }

</script>