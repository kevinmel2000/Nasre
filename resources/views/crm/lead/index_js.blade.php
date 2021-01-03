<script>
  $(function () {
    "use strict";

    var leads = <?php echo(($lead_ids->content())) ?>;
    for(const id of leads) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }

  $('#date_sort').on('change',()=>{
    var date_sort = $('#date_sort').val();
      if(date_sort == 'custom'){
        $('#date_range_col').show();
      }else{
        $('#date_range_col').hide();
      }
  });
  
  //Date range picker
    $('#reservation').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    })

    $("#leadsTable").DataTable({
      "order": [[ 0, "desc" ]],
      dom: '<"top"Bf>rt<"bottom"lip><"clear">',
      lengthMenu: [
          [ 10, 25, 50,100, -1 ],
          [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
      ],
      
      initComplete: function () {
  
          this.api().columns().every( function () {
              var column = this;
              var colVal = column.header().textContent;
              if(colVal == 'Source' || colVal == 'Status' || colVal == 'Owner' || colVal == 'Temp' || colVal == 'Score' || colVal == 'Prospect' || colVal == 'Industry'){
                var select = $('<select><option value="">All '+column.header().textContent+'</option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
              }
          } );
      }

    });

  });

  function confirmDelete(id){
      let choice = confirm("{{__('Are you sure, you want to delete this lead and related data ?')}}")
      if(choice){
          document.getElementById('delete-lead-'+id).submit();
      }
  }

</script>