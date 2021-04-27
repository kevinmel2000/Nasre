<script>
  $('#payment_mode').on('change',()=>{
    get_payment_mode();
  });


  function get_payment_mode(){
    var id = $('#payment_mode').val();
    var url="{{url('client/invoice/get_details')}}" +"/"+ id;
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
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
        }
    },
    {
        extend: 'print',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
        }
    },
    {
        extend: 'pdf',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
        }
    },
    {
        extend: 'csv',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
        }
    },
    {
        extend: 'excel',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
        }
    },


]
} );

  function confirmDelete(id){
      let choice = confirm("Are you sure, you want to delete this invoice and related data ?")
      if(choice){
          document.getElementById('delete-contact-'+id).submit();
      }
  }

</script>