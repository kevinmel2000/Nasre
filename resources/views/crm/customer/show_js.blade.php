<script>

  $(function(){
    "use strict";
    var contacts = <?php echo(($contact_ids->content())) ?>;
    for(const id of contacts) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }
  })

  // Check Username if already exisits
  $('#username').on('change',()=>{
    var customer_id = "{{$customer->id}}";
    $('#username_error').empty();
    var username = $('#username').val();
    var url="{{url('api/customer/check_user_id')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
    /* the route pointing to the post function */
      url: url,
      type: 'POST',
    /* send the csrf-token and the input to the controller */
      data: {username:username},
      dataType: 'JSON',
    /* remind that 'data' is the response of the AjaxController */
      success: function (data) { 
      if(customer_id == data.customer.id){
        $('#username_error').append('');
      }  
      else if(data.message == 'username_found'){
        $('#username_error').append('This contact username is already registered!.');
      }else{
        $('#username_error').append('');
      }
      }
    });
  });

  // Check Email if already exisits
  $('#email').on('change',()=>{
    $('#email_error').empty();
    var email = $('#email').val();
    var url="{{url('api/contact/check_email_availability')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      data: {email:email},
      dataType: 'JSON',
      success: function (data) { 
      if(data.message == 'email_found'){
        $('#email_error').append('This email address is already registered, please try another!');
      }else{
        $('#email_error').append('');
      }
      }
    });
  });

  // Check email for modal
  function check_email(id){
    $(`#email_error${id}`).empty();
    var email = $(`#email${id}`).val();
    var url="{{url('api/contact/check_email_availability')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      data: {email:email},
      dataType: 'JSON',
      success: function (data) { 
      if(data.message == 'email_found'){
        $(`#email_error${id}`).append('This email address is already registered, please try another!');
      }else{
        $(`#email_error${id}`).append('');
      }
      }
    });
  }

  $('#languages').select2({
    width: '100%'
  });
  $('#languages2').select2({
    width: '100%'
  });
  $('#industries').select2({
    width: '100%'
  });

  
  // Set up the Select2 control
  $('#countries').select2({
    width: '100%'
  }).trigger('change');
  $('#states').select2({
    width: '100%'
  });

  $('#cities').select2({
    width: '100%'
  });
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      
    }
  });

  //On Country Change
  $('#countries').on('change', function () {
      var id = $('#countries').select2('data')[0].id;
      $('#states').val(null);
      $('#states option').remove();

      var stateSelect = $('#states');
      $.ajax({
          type: 'GET',
          url: "{{url('api/getStates')}}/" + id
      }).then(function (data) {
          for (i = 0; i < data.length; i++) {
              var item = data[i]
              var option = new Option(item.name, item.id, false, false);
              stateSelect.append(option);
          }
          stateSelect.trigger('change');
      });
  })

  //On state Change
  $('#states').on('change', function () {
      var id = $('#states').select2('data')[0].id;
      var citySelect = $('#cities');
      $('#cities').val(null);
      $('#cities option').remove();
      $.ajax({
          type: 'GET',
          url: "{{url('api/getCities')}}/" + id
      }).then(function (data) {
          for (i = 0; i < data.length; i++) {
              var item = data[i]
              var option = new Option(item.name, item.id, false, false);
              citySelect.append(option);
          }
      });
      citySelect.trigger('change');
  });
  
  function confirmDelete(id){
    let choice = confirm("Are you sure, you want to delete this record?")
    if(choice){
        document.getElementById('delete-contact-'+id).submit();
    }
  }
</script>