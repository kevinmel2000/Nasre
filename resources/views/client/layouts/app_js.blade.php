<script src="{{asset('theme/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('theme/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}" ></script>
<script src="{{asset('theme/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('theme/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('theme/dist/js/adminlte.js')}}"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>

<script src="{{asset('js/select2.min.js')}}"></script>

<script src="{{asset('js/toastr.min.js')}}"></script>
<script>
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
@if(Session::has('message'))
  var type = "{{ Session::get('alert-type', 'info') }}";
  switch(type){
      case 'info':
          toastr.info("{{ Session::get('message') }}");
          break;

      case 'warning':
          toastr.warning("{{ Session::get('message') }}");
          break;

      case 'success':
          toastr.success("{{ Session::get('message') }}");
          break;

      case 'error':
          toastr.error("{{ Session::get('message') }}");
          break;
  }
@endif


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

</script>