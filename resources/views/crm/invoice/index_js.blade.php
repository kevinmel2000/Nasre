<script>

  $(function(){
    'use strict';
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

  function showExtraButtons(id){
    $(`#extraButtons${id}`).show();
   }
   function hideExtraButtons(id){
    $(`#extraButtons${id}`).hide();
   }

  function get_payment_mode(){
      var id = $('#payment_mode').val();
      var url="{{url('invoice/get_details')}}" +"/"+ id;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          
        }
      });
      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) { 
          $('#payment_details').val(data.payment_mode.details);
          $('#details_card').show();
        }
      });
    }

  $('#invoicesTable').DataTable( {
  "order": [[ 0, "desc" ]],
  dom: '<"top"Bf>rt<"bottom"lip><"clear">',
  lengthMenu: [
      [ 10, 25, 50,100, -1 ],
      [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
  ],
  buttons: [
      {
          extend: 'copyHtml5',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
          }
      },
      {
          extend: 'csv',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
          }
      },
      {
          extend: 'excel',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
          }
      },
      {
          extend: 'pdf',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
          }
      },
      {
          extend: 'print',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
          }
      },
  ]
  } );

  function confirmDelete(id){
      let choice = confirm("Are you sure, You want to Delete this invoice and related data ?")
      if(choice){
          document.getElementById('delete-contact-'+id).submit();
      }
  }

</script>