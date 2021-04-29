(function($){
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

  $('.submit').on('change',function(){
    this.form.submit();
  })  

  $.validate({
      modules : 'date, security'
  });
  $('[data-toggle="tooltip"]').tooltip();
}(jQuery));