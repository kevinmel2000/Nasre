<script>
  $(function () {
    "use strict";
    $('#role_id').select2({
      width:"100%"
    });
  });

  function confirmDelete(id){
    "use strict";
      let choice = confirm("{{__('Are You sure, You want to delete this record ?')}}")
      if(choice){
          document.getElementById('delete-user-'+id).submit();
      }
  }

</script>