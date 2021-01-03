<script>
  function getTitles(){
    $('#title_id').empty();
    var url="{{url('api/lead/getTitles')}}";
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
    
    $('#addTitleBtn').on('click',(e)=>{
      e.preventDefault();
      var new_lead_title = $('#new_lead_title').val();
      if(new_lead_title == ''){
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
        data: {name:new_lead_title},
        dataType: 'JSON',
        success: function (data) { 
          if (data.status == 'error') {
            $('#new_lead_title').val('');
            return toastr.error(data.message);
          }else{
            $('#new_lead_title').val('');
            getTitles();
            return toastr.success(data.message);
          }
        },
        error: function(err){
          return toastr.error(err.responseJSON.message);
        }
      });
    });
    $('#title_id').select2();
  });

  function getSources(){
    $('#lead_source_id').empty();
    var url="{{url('api/lead/getSources')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      type: 'GET',
      url: url,
      success: function (data) { 
        data.leadsource.forEach(element => {
          var option = (`<option value="${element.id}">${element.name}</option>`);
          $('#lead_source_id').append(option);
        });
      },
      error: function(err){
        return toastr.error(err.responseJSON.message);
      }
    });

  }
  getSources();
  $(function(){
  "use strict";
  
    $('#addSourceBtn').on('click',(e)=>{
      e.preventDefault();
      var new_lead_source = $('#new_lead_source').val();
      if(new_lead_source == ''){
        return toastr.error('Please enter some source!')
      }

      var url="{{url('api/lead/storeSource')}}";
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          
        }
      });
      $.ajax({
        url: url,
        type: 'POST',
        data: {name:new_lead_source},
        dataType: 'JSON',
        success: function (data) { 
          if (data.status == 'error') {
            $('#new_lead_source').val('');
            return toastr.error(data.message);
          }else{
            getSources();
            $('#new_lead_source').val('');
            return toastr.success(data.message);
          }
        },
        error: function(err){
          return toastr.error(err.responseJSON.message);
        }
      });
    });
    $('#lead_source_id').select2();
  });  


  //  ****************************** 
  //  SOURCE ENDS HERE
  //  ******************************

  
  //  ****************************** 
  //  ANCHOR STATUS-JS STARTS HERE
  //  ******************************
  function getStatuses(){
    $('#lead_status_id').empty();
    var url="{{url('api/lead/getStatuses')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      type: 'GET',
      url: url,
      success: function (data) { 
        data.leadstatus.forEach(element => {
          var option = (`<option value="${element.id}">${element.name}</option>`);
          $('#lead_status_id').append(option);
        });
      },
      error: function(err){
        return toastr.error(err.responseJSON.message);
      }
    });

  }
  getStatuses();
  $(function(){
  "use strict";
    
    $('#addStatusBtn').on('click',(e)=>{
      e.preventDefault();
      var new_lead_status = $('#new_lead_status').val();
      if(new_lead_status == ''){
        return toastr.error('Please enter some status!')
      }

      var url="{{url('api/lead/storeStatus')}}";
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          
        }
      });
      $.ajax({
        url: url,
        type: 'POST',
        data: {name:new_lead_status},
        dataType: 'JSON',
        success: function (data) { 
          if (data.status == 'error') {
            $('#new_lead_status').val('');
            return toastr.error(data.message);
          }else{
            getStatuses();
            $('#new_lead_status').val('');
            return toastr.success(data.message);
          }
        },
        error: function(err){
          return toastr.error(err.responseJSON.message);
        }
      });
    });
    $('#lead_status_id').select2();

  //  ****************************** 
  //  STATUS ENDS HERE
  //  ******************************      

  // Check Email if already exisits
  $('#email').on('change',()=>{
    
    $('#email_error').empty();
    var email = $('#email').val();
    var url="{{url('api/lead/check_email_availability')}}";
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
        $('#email_error').append('{{__("This email is already registered in the lead database.")}}');
      }else{
        $('#email_error').append('');
      }
      }
    });
  });

  $('#owner_id').select2();
  
  $('#languages_id').select2();

  $('#industries').select2();

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
          // create the option and append to Select2
          for (i = 0; i < data.length; i++) {
              var item = data[i]
              var option = new Option(item.name, item.id, false, false);
              stateSelect.append(option);
          }
          stateSelect.trigger('change');
      });
  })

  // On state Change
  $('#states').on('change', function () {
      var id = $('#states').select2('data')[0].id;
      // Fetch the preselected item, and add to the control
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
  
</script>