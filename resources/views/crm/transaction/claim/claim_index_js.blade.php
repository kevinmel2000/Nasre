<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script>
        $(document).ready(function() { 
            $(".e1").select2(); 
            $('.uang').mask("#,##0.00", {reverse: true});
        }); 
</script>

<script>
    $(function () {
      "use strict";
  
      var insured = <?php echo(($claimlist_ids->content())) ?>;
      for(const id of insured) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
      $("#felookupTable2").DataTable({
        "paging":   false,
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
        
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Claim related data?')}}")
        if(choice){
            document.getElementById('delete-claim-'+id).submit();
        }
    }
  
</script>

