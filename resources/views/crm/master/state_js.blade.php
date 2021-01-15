<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2(); });
</script>

<script>
    $(function () {
      "use strict";
  
      var states = <?php echo(($state_ids->content())) ?>;
      for(const id of states) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
      $("#stateTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
      });
  
    });
  
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this State data and related data?')}}")
        if(choice){
            document.getElementById('delete-state-'+id).submit();
        }
    }
  
  </script>