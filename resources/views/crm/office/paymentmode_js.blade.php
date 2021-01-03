<script>
  $(function(){
    'use strict';

    var paymentmodes = <?php echo(($paymentmode_ids->content())) ?>;
    for(const id of paymentmodes) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }
    
    $('#paymentModesTable').DataTable();
  });

  
  function confirmDelete(id){
      let choice = confirm("{{__('Are You sure, you want to delete this payment mode and related data?')}}")
      if(choice){
          document.getElementById('delete-paymentMode-'+id).submit();
      }
  }
</script>