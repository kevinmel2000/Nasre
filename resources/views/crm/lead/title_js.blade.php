<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  function confirmDelete(id){
      let choice = confirm("{{__('Are You sure, You want to Delete this record ?')}}")
      if(choice){
          document.getElementById('delete-title-'+id).submit();
      }
  }
</script>