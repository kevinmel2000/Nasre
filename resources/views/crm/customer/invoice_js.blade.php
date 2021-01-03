<script>
  $(function(){
    "use strict";

    var invoices = <?php echo(($invoice_ids->content())) ?>;
    for(const id of invoices) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }

  });

  function confirmDelete(id) {
      let choice = confirm("{{__('Are you sure, you want to delete this invoice and related data?')}}")
      if (choice) {
          document.getElementById('delete-contact-' + id).submit();
      }
  }
</script>