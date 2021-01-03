<script>
  $(function(){
    'use strict';
    var taxrates = <?php echo(($taxRate_ids->content())) ?>;
    for(const id of taxrates) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }
    $('#taxRatesTable').DataTable();
  });
  function confirmDelete(id){
      let choice = confirm("{{__('Are You sure, you want to delete this tax rate and related data ?')}}")
      if(choice){
          document.getElementById('delete-taxRate-'+id).submit();
      }
  }
  
</script>