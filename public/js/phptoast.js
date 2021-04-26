(function($){

  
  toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "300",
      "timeOut": "2000",
  }
  function startTime() {
      var today = new Date();
      var h = today.getHours() > 12 ? today.getHours() - 12 : today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      var A = today.getHours() > 12 ? " PM" : " AM";
      h = checkTime(h);
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('js_timer').innerHTML =
      h + " : " + m + A;
      var t = setTimeout(startTime, 10000);
  }
  function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
  }

  switch(type){
    case 'info':
        toastr.info(message);
        break;
    case 'warning':
        toastr.warning(message);
        break;
    case 'success':
        toastr.success(message);
        break;
    case 'error':
        toastr.error(message);
        break;
  }
}(jQuery));