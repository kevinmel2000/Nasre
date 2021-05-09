<link href="{{asset('css/sweetalert2.min.css')}}" rel="stylesheet"/>
<script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('/js/select2.js')}}"></script>
<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }

  /* Firefox */
  input[type=number] {
      -moz-appearance: textfield;
  }
</style>



<!-- <script>

//var $tabsTop = $(".nav-tabs");
//var $tabsBottom = $tabsTop.clone().addClass("nav-tabs-bottom").insertAfter(".tab-contentbottom");
//$tabsTop.addClass("nav-tabs-top");

$('.nav-tabs-top a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    console.log("click top");
    var target = $(e.target).attr("href") // activated tab
     alert(target);
    $('.nav-tabs-bottom a.active').removeClass('active');
    $('.nav-tabs-bottom a[href="'+$(this).attr('href')+'"]').addClass('active');
})


$('#custom-tabs-three-tab a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    console.log("click top");
    var target = $(e.target).attr("href") // activated tab
     alert(target);
    $('.nav-tabs-bottom a.active').removeClass('active');
    $('.nav-tabs-bottom a[href="'+$(this).attr('href')+'"]').addClass('active');
})

$('.nav-tabs-bottom a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    var target = $(e.target).attr("href") // activated tab
     alert(target);
    $('.nav-tabs-top a.active').removeClass('active');
    $('.nav-tabs-top a[href="'+$(this).attr('href')+'"]').addClass('active');
});

$('#custom-tabs-three-tabbottom a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    var target = $(e.target).attr("href") // activated tab
     alert(target);
    $('.nav-tabs-top a.active').removeClass('active');
    $('.nav-tabs-top a[href="'+$(this).attr('href')+'"]').addClass('active');
});

</script> -->

<script type="text/javascript">
    $('.nav-tabs li a').click(function (e) {     
    //get selected href
    var href = $(this).attr('href');    
    var id = href.substring(1);  
    console.log('id = '+id)  
    
    //set all nav tabs to inactive
    $('.nav-tabs li').removeClass('active');
    $('.nav-tabs li a').removeClass('active');
    
    //get all nav tabs matching the href and set to active
    $('.nav-tabs li[href="'+href+'"]').addClass('active');
    $('.nav-tabs li a[href="'+href+'"]').addClass('active');

    //active tab
    $('.tab-pane').removeClass('show');
    $('.tab-pane').removeClass('active');
    $('.tab-pane[id="'+id+'"]').addClass('show');
    $('.tab-pane[id="'+id+'"]').addClass('active');
});
</script>

<script>
    $(document).ready(function() 
    { 

        $(".e1").select2({ width: '100%' }); 

        // document.getElementByTagName("html").setAttribute("lang","id-ID");

        $("#tabretro").attr('hidden','true');
            // $("#tabretrodetail").attr('hidden','true');
            // $("#tabretroupdate").attr('hidden','true');
            // $("#tabretroendorsement").attr('hidden','true');
            $("#sliptotalsum").val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            var dtdef = new Date($.now());
            var datetimedef =  dtdef.getFullYear() + "-" + dtdef.getMonth() + "-" + dtdef.getDate() + " " + dtdef.getHours() + ":" + dtdef.getMinutes() + ":" + dtdef.getSeconds();
            $('#slipStatusTable tbody').append('<tr id="stlid"><td >'+ $("#slipstatus").val() +'</td><td >'+datetimedef+'</td><td >'+ $("#slipusername").val() +'</td></tr>')
            $('#feshareto2 .insertins').prop("disabled", false);
            var tbl_long = document.getElementById("locRiskTable").rows.length;
            console.log(tbl_long)
            if(tbl_long < 2){
                var attr = $('#feshareto2 .insertins').prop("disabled", true);
                if(typeof attr !== typeof undefined && attr !== false){
                    $('#feshareto2 .insertins').prop("disabled", false);
                }
            }else if(tbl_long > 1){
                $('#feshareto2 .insertins').prop("disabled", true);
            }

            var countryID = 102; 
            //alert(countryID);
            if(countryID){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-state-lookup')}}?country_id="+countryID,
                    beforeSend: function() { $("body").addClass("loading");  },
                    complete: function() {  $("body").removeClass("loading"); },
                    success:function(res){  
                        console.log(res)      
                        if(res){
                            $("#state_location").empty();
                            $("#state_location").append('<option selected disabled>Select States/Province</option>');
                            $.each(res,function(key,value){
                                $("#state_location").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#state_location").append('<option value="" selected disabled>get value error</option>');
                        }
                    }
                });
            }else{
                $("#state_location").append('<option value="" selected disabled>countryID null</option>');
                $("#city_location").empty();
            }  


        });

    function treatAsUTC(date) {
        var result = new Date(date);
        result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
        return result;
    }

    function daysBetween(startDate, endDate) {
        var millisecondsPerDay = 24 * 60 * 60 * 1000;
        return (treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay;
    }

</script>

<script type="text/javascript">

    function setInputFilter(textbox, inputFilter) {
      ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        if(textbox){
            var i;
            for (i=0; i<textbox.length; i++) {
                textbox[i].addEventListener(event, function() {
                  if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                  } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                  } else {
                    this.value = "";
                  }
                });
            }
        }
      });
    }

    setInputFilter(document.getElementsByClassName("floatTextBox"), function(value) {
        return /^-?\d*[.,]?\d{0,3}$/.test(value) });
    setInputFilter(document.getElementsByClassName("floatTextBox2"), function(value) {
        return /^-?\d*[.,]?\d{0,10}$/.test(value) });
    setInputFilter(document.getElementsByClassName("intTextBox"), function(value) {
        return /^-?\d*$/.test(value); });

</script>







