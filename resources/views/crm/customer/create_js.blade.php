<script>
  function getTitles(){
      $('#title_id').empty();
      var url="{{url('api/contact/getTitles')}}";
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          
        }
      });
      $.ajax({
        type: 'GET',
        url: url,
        success: function (data) { 
          data.contactTitle.forEach(element => {
            var option = (`<option value="${element.id}">${element.name}</option>`);
            $('#title_id').append(option);
          });
        },
        error: function(err){
          console.log(err.responseJSON);
        }
      });

  }
  getTitles();

  $(function(){
    "use strict";
    $('#show_password').on('click',()=>{
      $('#password').attr('type','text');
      $('#show_password').hide();
      $('#hide_password').show();
    });
    $('#hide_password').on('click',()=>{
      $('#password').attr('type','password');
      $('#show_password').show();
      $('#hide_password').hide();
    });

    $('#title_id').select2({
      width:'85%'
    });
    $('#languages').select2({
      width: '100%'
    });
    $('#industries').select2({
      width: '100%'
    });
  })


  $('#addTitleBtn').on('click',(e)=>{
    // Have function called inside
    e.preventDefault();
    var new_contact_title = $('#new_contact_title').val();
    if(new_contact_title == ''){
      return toastr.error('{{__("Please enter some title!")}}')
    }

    var url="{{url('api/contact/storeTitle')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      data: {name:new_contact_title},
      dataType: 'JSON',
      success: function (data) { 
        if (data.status == 'error') {
          $('#new_contact_title').val('');
          return toastr.error(data.message);
        }else{
          $('#new_contact_title').val('');
          getTitles();
          return toastr.success(data.message);
        }
      },
      error: function(err){
        console.log(err.responseJSON);
        return toastr.error(err.responseJSON.message);
      }
    });
  });

  
  $('#type').select2({
    width: '100%'
  });

  $('#prospect_status').select2({
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
  
  // Check Email if already exisits
  $('#email').on('change',()=>{
    $('#email_error').empty();
    var email = $('#email').val();
    url="{{url('api/contact/check_email_availability')}}";
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
        $('#email_error').append('{{__("This email address is already registered, please try another!")}}');
      }else{
        $('#email_error').append('');
      }
      }
    });
  });

  // Check Username if already exisits
  $('#username').on('change',()=>{
    $('#username_error').empty();
    var username = $('#username').val();
    console.log(username);
    url="{{url('api/customer/check_user_id')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      data: {username:username},
      dataType: 'JSON',
      success: function (data) { 
      if(data.message == 'username_found'){
        $('#username_error').append('{{__("This username is already registered, please try another!")}}');
      }else{
        $('#username_error').append('');
      }
      }
    });
  });

</script>