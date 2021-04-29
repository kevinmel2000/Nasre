<script>
  $(function(){
    var estimates = <?php echo(($estimate_ids->content())) ?>;
    for(const id of estimates) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }
  });

  function confirmDelete(id) {
      let choice = confirm("{{__('Are you sure, You want to Delete this estimate and related data ?')}}")
      if (choice) {
          document.getElementById('delete-contact-' + id).submit();
      }
  }
</script>