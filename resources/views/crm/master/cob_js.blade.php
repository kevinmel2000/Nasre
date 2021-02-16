<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>

<script>
    $('#cobparentdd').change(function(){
        var parentcob = $(this).val();

        if(parentcob){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-cob-autocode')}}?cob_code="+parentcob,
                success:function(response){        
                    if(response){
                        console.log(response);
                        $("#cobcode").val(response.autocode);
                        $("#cobcode").attr('readonly',false);
                    }else{
                        console.log("data gak ada");
                    }
                }
            });
        }else{
            $("#cobcode").val(" ");
            $("#cobcode").attr('readonly',false);
        }
    });

</script>

<script>
    $(function () {
      "use strict";
  
      var cob = <?php echo(($cob_ids->content())) ?>;
      for(const id of cob) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#cobTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        initComplete: function () {
            // Apply the search
            this.columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this cob and related data?')}}")
        if(choice){
            document.getElementById('delete-cob-'+id).submit();
        }
    }
  
  </script>