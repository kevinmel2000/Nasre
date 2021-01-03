<script>

  $(function(){
    'use strict';

    var curencies = <?php echo(($currency_ids->content())) ?>;
    for(const id of curencies) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }

    $('#CurrenciesTable').DataTable();
  });

  function confirmDelete(id){
      let choice = confirm("{{__('Are You sure, you want to delete this currency and related data ?')}}")
      if(choice){
          document.getElementById('delete-Currency-'+id).submit();
      }
  }

</script>