<script>
    $(function(){
        'use strict';
        var media = <?php echo(($media_ids->content())) ?>;
        for(const id of media) {
            var btn = `
                <a href="#" onclick="confirmDelete('${id}')">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            `;
            $(`#delbtn${id}`).append(btn);
        }

    })


  // SECTION Get Customers or Leads as per relation 
  $('.relation').on('change',() => {
      $('#lead_customer_id').empty();
      var relation = $('.relation').val();
      if (relation == 'Customer') {
         var url = "{{url('api/media/getCustomers')}}";
      } else {
         var url = "{{url('api/media/getLeads')}}";
      }
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              
          }
      });
      $.ajax({
          url: url,
          type: 'POST',
          data: {
              relation: relation
          },
          dataType: 'JSON',
          /* remind that 'data' is the response of the AjaxController */
          success: function (data) {
              if (relation == 'Customer') {
                  data.customers.forEach(customer => {
                      let tmp =
                          `<option value="${customer.id}">${customer.username}</option>`;
                      $('#lead_customer_id').append(tmp);
                  });
              } else {
                  data.leads.forEach(lead => {
                      let tmp =
                          `<option value="${lead.id}">${lead.first_name} ${lead.last_name} ${lead.email}</option>`;
                      $('#lead_customer_id').append(tmp);
                  });
              }
          }

      });
  });


  $('select').select2({
      width: '100%'
  });

  $('#featured_image').on('change', function () {
      var file = $(this).get(0).files;
      var reader = new FileReader();
      reader.readAsDataURL(file[0]);
      reader.addEventListener("load", function (e) {
          var image = e.target.result;
          $("#imgthumbnail").attr('src', image);
      });
  });

  function copyToClipboard(item) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val(item).select();
      document.execCommand("copy");
      alert("Link copied to your clipboard: " + item);
      $temp.remove();
  }

  function confirmDelete(id){
  let choice = confirm("Are You sure, You want to delete this record ?")
  if(choice){
    document.getElementById('delete-item-'+id).submit();
  }
}
</script>