<script>
  $(function(){
    "use strict";
    var proposals = <?php echo(($proposal_ids->content())) ?>;
    for(const id of proposals) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }
  })

  function confirmDelete(id) {
      let choice = confirm("{{__('Are you sure, you want to delete this proposal and related data?')}}")
      if (choice) {
          document.getElementById('delete-proposal-' + id).submit();
      }
  }
</script>