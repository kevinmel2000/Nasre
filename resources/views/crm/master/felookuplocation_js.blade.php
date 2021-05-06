<script type="text/javascript">
  $(document).ready(function() { 
    $("#state").attr('disabled','disabled');
    $("#city").attr('disabled','disabled');
    
        var countryID = 102; 
        if(countryID){
        $.ajax({
          type:"GET",
          url:"{{url('get-state-list')}}?country_id="+countryID,
          beforeSend: function() { $("body").addClass("loading");  },
          complete: function() {  $("body").removeClass("loading"); },
          success:function(res){        
          if(res){
            // $("#state").empty();
            $("#province").removeAttr('disabled');
            $("#province").append('<option selected disabled>Select Province</option>');
            $.each(res,function(key,value){
              $("#province").append('<option value="'+key+'">'+value+'</option>');
            });
          
          }else{
            $("#province").empty();
          }
          }
        });
      }else{
        $("#province").empty();
        $("#city").empty();
      }   

  });
</script>

<script type=text/javascript>

  $('#country').change(function(){
  var countryID = $(this).val();  
  //alert(countryID);
  if(countryID){
    $.ajax({
      type:"GET",
      url:"{{url('get-state-list')}}?country_id="+countryID,
      beforeSend: function() { $("body").addClass("loading");  },
      complete: function() {  $("body").removeClass("loading"); },
      success:function(res){        
      if(res){
        // $("#state").empty();
        $("#province").removeAttr('disabled');
        $("#province").append('<option selected disabled>Select Province</option>');
        $.each(res,function(key,value){
          $("#province").append('<option value="'+key+'">'+value+'</option>');
        });
      
      }else{
        $("#province").empty();
      }
      }
    });
  }else{
    $("#province").empty();
    $("#city").empty();
  }   
  });


  $('#province').on('change',function(){
  var stateID = $(this).val();  
  //alert(stateID);
  if(stateID){
    $.ajax({
      type:"GET",
      url:"{{url('get-city-list')}}?state_id="+stateID,
      beforeSend: function() { $("body").addClass("loading");  },
      complete: function() {  $("body").removeClass("loading"); },
      success:function(res){        
      if(res)
      {
        $("#city").empty();
        $("#city").removeAttr('disabled');
        $("#city").append('<option selected disabled>Select City</option>');
        $.each(res,function(key,value){
          $("#city").append('<option value="'+key+'">'+value+'</option>');
        });
      
        var arraystring=$("#address").val().split(","); 

        var citydata=arraystring[arraystring.length-3];
        var citydataup=citydata.toUpperCase();
        //alert(arraystring);
        //alert(citydata);

        var dd = document.getElementById('city');
        for (var i = 0; i < dd.options.length; i++) 
        {
              //alert('hasil sama -1 :'+dd.options[i].text);
              //alert('hasil sama -2 :'+citydataup);
            

            if(dd.options[i].text.trim() == citydataup.trim()) 
            {
                dd.selectedIndex = dd.options[i].value;
                //alert('hasil sama 3:'+dd.options[i].text);
                //alert('hasil sama 2:'+dd.options[i].value);
                idcity=dd.options[i].value;

                $('#city').select2('data', {id: dd.options[i].value, a_key: dd.options[i].text});
                $('#city').val(dd.options[i].value);
                $('#city').select2().trigger('change');

                break;
            }
        }

        
        //var textdata=dd.options[4131].text;
        idcity=dd.options[i].value;
        //alert('hasil sama2 :'+idcity);

      


      }else{
        //$("#city").empty();
      }
      }
    });
  }else{
    //$("#city").empty();
  }
    
  });

</script>


<script type=text/javascript>

  $('#country2').change(function(){
  var countryID = $(this).val();  
  //alert(countryID);
    if(countryID){
      $.ajax({
        type:"GET",
        url:"{{url('get-state-list')}}?country_id="+countryID,
        beforeSend: function() { $("body").addClass("loading");  },
        complete: function() {  $("body").removeClass("loading"); },
        success:function(res){        
          if(res){
            $("#state2").empty();
            $("#state2").append('<option>Select</option>');
            $.each(res,function(key,value){
              $("#state2").append('<option value="'+key+'">'+value+'</option>');
            });
          
          }else{
            $("#state2").empty();
          }
        }
      });
    }else{
      $("#state2").empty();
      $("#city2").empty();
    }   
  });


  $('#state2').on('change',function(){
  var stateID = $(this).val();  
  //alert(stateID);
    if(stateID){
      $.ajax({
        type:"GET",
        url:"{{url('get-city-list')}}?state_id="+stateID,
        beforeSend: function() { $("body").addClass("loading");  },
        complete: function() {  $("body").removeClass("loading"); },
        success:function(res){        
          if(res){
            $("#city2").empty();
            $.each(res,function(key,value){
              $("#city2").append('<option value="'+key+'">'+value+'</option>');
            });
          
          }else{
           $("#city2").empty();
          }
        }
      });
    }else{
      $("#city2").empty();
    }
    
  });

</script>



<script src="//maps.google.com/maps/api/js?sensor=false&key=AIzaSyD4yhKiCvJpWtee_7Bobk_9qjDUAZTTOKE&&callback=initAutocomplete&libraries=places&v=weekly" type="text/javascript"></script>

<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>
<script>
    $(function () {
      "use strict";
  
      var felookuplocation = <?php echo(($felookuplocation_ids->content())) ?>;
      for(const id of felookuplocation) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
      $("#felookupTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
        
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Fe Lookup Location and related data?')}}")
        if(choice){
            document.getElementById('delete-felookuplocation-'+id).submit();
        }
    }
  
  </script>

<script type="text/javascript">

function GoogleGeocode() {
  geocoder = new google.maps.Geocoder();
  this.geocode = function(address, callbackFunction) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var result = {};
          // console.log(results)
          result.latitude = results[0].geometry.location.lat();
          result.longitude = results[0].geometry.location.lng();
          callbackFunction(result);
        } else {
          //alert("Geocode was not successful for the following reason: " + status);
          callbackFunction(null);
        }
      });
  };
}


function GoogleGeocode2() {
  geocoder = new google.maps.Geocoder();
  this.geocode = function(address, callbackFunction) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var result = {};
          result.latitude = results[0].geometry.location.lat();
          result.longitude = results[0].geometry.location.lng();
          callbackFunction(result);
        } else {
          //alert("Geocode was not successful for the following reason: " + status);
          callbackFunction(null);
        }
      });
  };
}


//Process form input
$('input[name=address]').on('input',function(e){
    //alert('Changed!');
    e.preventDefault();
    //Get the user input and use it
    var userinput = $('form #address').val();
      if (userinput == "")
      {
        //alert("The input box is blank.");
        return false;
      }
      var g = new GoogleGeocode2();
      var address = userinput;
      g.geocode(address, function(data) {
        
        if(data != null) {
          olat = data.latitude;
          olng = data.longitude;
          //$('#result').append("<p><strong>"+userinput+" -> </strong> Latitude: " + olat + " , " + "Longitude: " + olng + "</p>")
          //alert(olat);
          var latLng2 = new google.maps.LatLng(olat,olng);
          

          var addressarray = address.split(" ");

          var firstWordsdata = [];
          if(addressarray!=null)
          {
            for (var i = 0; i < 4; i++) {
              //What to do here to get the first word of every spilt
              var firstWord = addressarray[i].substr(0,1);
              firstWordsdata.push(firstWord);
            }

            updateMarkerPosition2(latLng2); 
          }

          var firstWordsdata2 = firstWordsdata.join('');
          var codenew=document.getElementById('code').value;
          
          
               $.ajax({
                  type:"GET",
                  url:'{{ url("/") }}/master-data/felookuplocationgetloccountcode/'+firstWordsdata2,
                  beforeSend: function() { $("body").addClass("loading");  },
                  complete: function() {  $("body").removeClass("loading"); },
                  success:function(res){  
                      console.log(res)      
                      if(res){
                           document.getElementById('code').value=res[0].codecount;

                      }else{
                          
                          var codenew2=firstWordsdata2+""+codenew.slice(codenew.length - 4);
                          document.getElementById('code').value=codenew2;

                      }
                  }
              });
          

          
            var arraystring=results[0].formatted_address.split(","); 

            //alert(arraystring);
            var country=arraystring[arraystring.length-1];

            var stastecodepos=arraystring[arraystring.length-2];
            var stastecodeposarray=stastecodepos.split(" ");
            var codepos=stastecodeposarray[stastecodeposarray.length-1];
            var citydata=arraystring[arraystring.length-3];

            //var arraystate=stastecodeposarray.splice(-1,1);
            stastecodeposarray.pop();
            var arraystate=stastecodeposarray;
            var state=arraystate.toString();


            //alert(country);

            var statefix=state.replace(/,/g, ' ');
            //alert(statefix.trim());
            //alert(codepos);
            //alert(citydata);
            document.getElementById('postal_code').value=codepos;
            var idcountry=102;
            var idstate='';

            if(country)
            {
              //alert(results[0].address_components[8].long_name);
              
              //document.getElementById('country').value=results[0].address_components[8].long_name;

              var dd = document.getElementById('country');
              for (var i = 0; i < dd.options.length; i++) 
              {
                  if (dd.options[i].text == country.trim()) 
                  {
                      dd.selectedIndex = i;
                      break;
                  }
              }

              //alert(i);
              idcountry=i;
              //document.getElementById('country').value=i;
              $('#country').select2('data', {id: i, a_key: country.trim()});
              $('#country').val(i);
              $('#country').select2().trigger('change');

            }
            if(statefix)
            {

              if(idcountry)
              {
                var statedataup=statefix.toUpperCase();
                $.ajax({
                  type:"GET",
                  url:"{{url('get-state-list')}}?country_id="+idcountry,
                  beforeSend: function() { $("body").addClass("loading");  },
                  complete: function() {  $("body").removeClass("loading"); },
                  success:function(res)
                  {       

                    if(res)
                    {
                      // $("#state").empty();
                      $("#province").removeAttr('disabled');
                      $("#province").append('<option selected disabled>Select Province</option>');
                      $.each(res,function(key,value){
                        $("#province").append('<option value="'+key+'">'+value+'</option>');
                      });

                      //alert(results[0].address_components[7].long_name);
                      //4131
                      //"Daerah Khusus Ibukota Jakarta"
                      //"Daerah Khusus Ibukota Jakarta"
                      
                        var dd = document.getElementById('province');
                        for (var i = 0; i < dd.options.length; i++) 
                        {
                            //alert('hasil sama -1 :'+dd.options[i].text);

                            if(dd.options[i].text == statedataup.trim()) 
                            {
                                dd.selectedIndex = dd.options[i].value;
                                //alert('hasil sama :'+dd.options[i].value);
                                idstate=dd.options[i].value;
                                break;
                            }
                        }

                        //alert('hasil sama2 :'+dd.options[i].value);
                        //var textdata=dd.options[4131].text;
                        idstate=dd.options[i].value;

                        $('#province').select2('data', {id: dd.options[i].value, a_key: dd.options[i].text});
                        $('#province').val(dd.options[i].value);
                        $('#province').select2().trigger('change');

                    
                    }
                    else
                    {
                      //$("#province").empty();
                    }

                  }
                });

              }

            }


            var idcity='';
            if(citydata)
            {

                var citydataup=citydata.toUpperCase();
                
                if(!empty(idstate))
                {
                    $.ajax({
                      type:"GET",
                      url:"{{url('get-city-list')}}?state_id="+idstate,
                      beforeSend: function() { $("body").addClass("loading");  },
                      complete: function() {  $("body").removeClass("loading"); },
                      success:function(res)
                      {        
                        if(res)
                        {

                          $("#city").empty();
                          $("#city").removeAttr('disabled');
                          $("#city").append('<option selected disabled>Select City</option>');
                          $.each(res,function(key,value){
                            $("#city").append('<option value="'+key+'">'+value+'</option>');
                          });
                          

                          var dd = document.getElementById('city');
                          for (var i = 0; i < dd.options.length; i++) 
                          {
                            // alert('hasil sama -1 :'+dd.options[i].text);
                            // alert('hasil sama -2 :'+citydataup);

                              if(dd.options[i].text.trim() == citydataup.trim()) 
                              {
                                  dd.selectedIndex = dd.options[i].value;
                                  //alert('hasil sama 3:'+dd.options[i].text);
                                  //alert('hasil sama 2:'+dd.options[i].value);
                                  idcity=dd.options[i].value;
                                  break;
                              }
                          }

                          
                          //var textdata=dd.options[4131].text;
                          idcity=dd.options[i].value;
                          //alert('hasil sama2 :'+idcity);

                          $('#city').select2('data', {id: dd.options[i].value, a_key: dd.options[i].text});
                          $('#city').val(dd.options[i].value);
                          $('#city').select2().trigger('change');

                        }

                      }
                    });
                }

            }

          
          
        
        } 
        else {
          //Unable to geocode
          //alert('ERROR! Unable to geocode address');
        }
     
      });  

});

</script>


<script type="text/javascript">
var geocoder = geocoder = new google.maps.Geocoder();

//* Fungsi untuk mendapatkan nilai latitude longitude
function updateMarkerPosition(latLng) 
{
  document.getElementById('latitude').value = [latLng.lat()]
  document.getElementById('longitude').value = [latLng.lng()]

  geocoder.geocode({
        'latLng': latLng
    }, function(results, status) {
      //alert('masuk1');
      //alert(results[4].formatted_address);
      console.log(results);
      
      var addressstring=results[0].formatted_address;
      var addressarray = addressstring.split(" ");

      var firstWordsdata = [];

      if(addressarray!=null)
      {
        for (var i = 0; i < 4; i++) {
          //What to do here to get the first word of every spilt
          var firstWord = addressarray[i].substr(0,1);
          firstWordsdata.push(firstWord);
        }
      }

      var firstWordsdata2 = firstWordsdata.join('');
     
      var codenew=document.getElementById('code').value;
      
      //var codenew2=firstWordsdata2+""+codenew.slice(codenew.length - 6);
      //document.getElementById('code').value=codenew2;

      $.ajax({
            type:"GET",
            url:'{{ url("/") }}/master-data/felookuplocationgetloccountcode/'+firstWordsdata2,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res){  
                console.log(res)      
                if(res){
                    document.getElementById('code').value=res[0].codecount;

                }else{
                    
                    var codenew2=firstWordsdata2+""+codenew.slice(codenew.length - 4);
                    document.getElementById('code').value=codenew2;

                }
            }
        });
          


      document.getElementById('address').value=results[0].formatted_address;
      var arraystring=results[0].formatted_address.split(","); 

      //alert(arraystring);
      var country=arraystring[arraystring.length-1];
      
      var stastecodepos=arraystring[arraystring.length-2];
      var stastecodeposarray=stastecodepos.split(" ");
      var codepos=stastecodeposarray[stastecodeposarray.length-1];
      var citydata=arraystring[arraystring.length-3];

      //var arraystate=stastecodeposarray.splice(-1,1);
      stastecodeposarray.pop();
      var arraystate=stastecodeposarray;
      var state=arraystate.toString();
     
      
      //alert(country);
     
      var statefix=state.replace(/,/g, ' ');
      //alert(statefix.trim());
      //alert(codepos);
      //alert(citydata);
      document.getElementById('postal_code').value=codepos;
      var idcountry=102;
      var idstate='';

      if(country)
      {
        //alert(results[0].address_components[8].long_name);
        
        //document.getElementById('country').value=results[0].address_components[8].long_name;

        var dd = document.getElementById('country');
        for (var i = 0; i < dd.options.length; i++) 
        {
            if (dd.options[i].text == country.trim()) 
            {
                dd.selectedIndex = i;
                break;
            }
        }

        //alert(i);
        idcountry=i;
        //document.getElementById('country').value=i;
        $('#country').select2('data', {id: i, a_key: country.trim()});
        $('#country').val(i);
        $('#country').select2().trigger('change');

      }

      
      
      if(statefix)
      {

        if(idcountry)
        {

          var statedataup=statefix.toUpperCase();
          $.ajax({
            type:"GET",
            url:"{{url('get-state-list')}}?country_id="+idcountry,
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(res)
            {       

              if(res)
              {
                // $("#state").empty();
                $("#province").removeAttr('disabled');
                $("#province").append('<option selected disabled>Select Province</option>');
                $.each(res,function(key,value){
                  $("#province").append('<option value="'+key+'">'+value+'</option>');
                });

                 //alert(results[0].address_components[7].long_name);
                 //4131
                 //"Daerah Khusus Ibukota Jakarta"
                 //"Daerah Khusus Ibukota Jakarta"
                 
                  var dd = document.getElementById('province');
                  for (var i = 0; i < dd.options.length; i++) 
                  {
                      //alert('hasil sama -1 :'+dd.options[i].text);

                      if(dd.options[i].text == statedataup.trim()) 
                      {
                           dd.selectedIndex = dd.options[i].value;
                           //alert('hasil sama :'+dd.options[i].value);
                           idstate=dd.options[i].value;
                           break;
                      }
                  }

                  //alert('hasil sama2 :'+dd.options[i].value);
                  //var textdata=dd.options[4131].text;
                  idstate=dd.options[i].value;

                  $('#province').select2('data', {id: dd.options[i].value, a_key: dd.options[i].text});
                  $('#province').val(dd.options[i].value);
                  $('#province').select2().trigger('change');

              
              }
              else
              {
                //$("#province").empty();
              }

            }
          });

        }

      }


      var idcity='';
      
      if(citydata)
      { 
           var citydataup=citydata.toUpperCase().trim();
           //alert(citydataup);

          
              $.ajax({
                type:"GET",
                url:"{{url('get-city-list')}}?state_id="+idstate,
                beforeSend: function() { $("body").addClass("loading");  },
                complete: function() {  $("body").removeClass("loading"); },
                success:function(res)
                {        
                  if(res)
                  {

                    $("#city").empty();
                    $("#city").removeAttr('disabled');
                    $("#city").append('<option selected disabled>Select City</option>');
                    $.each(res,function(key,value){
                      $("#city").append('<option value="'+key+'">'+value+'</option>');
                    });
                    

                    var dd = document.getElementById('city');
                    for (var i = 0; i < dd.options.length; i++) 
                    {
                        //alert('hasil sama -1 :'+dd.options[i].text);
                        //alert('hasil sama -2 :'+citydataup);

                        if(dd.options[i].text.trim() == citydataup.trim()) 
                        {
                            dd.selectedIndex = dd.options[i].value;
                            //alert('hasil sama 3:'+dd.options[i].text);
                            //alert('hasil sama 2:'+dd.options[i].value);
                            idcity=dd.options[i].value;
                            break;
                        }
                    }

                    
                    //var textdata=dd.options[4131].text;
                    idcity=dd.options[i].value;
                    //alert('hasil sama2 :'+idcity);

                    $('#city').select2('data', {id: dd.options[i].value, a_key: dd.options[i].text});
                    $('#city').val(dd.options[i].value);
                    $('#city').select2().trigger('change');

                  }

                }
              });
          

        } 
      
    
    
  });

   
  var position = new google.maps.LatLng(latLng.lat(), latLng.lng());
  marker.setPosition(position);

}


function updateMarkerPosition2(latLng) 
{
  document.getElementById('latitude').value = [latLng.lat()]
  document.getElementById('longitude').value = [latLng.lng()]

  geocoder.geocode({
        'latLng': latLng
    }, function(results, status) {
      //alert('masuk1');
      //alert(results[4].formatted_address);
      console.log(results);
      
      var addressstring=results[0].formatted_address;
      var addressarray = addressstring.split(" ");

      var firstWordsdata = [];

      if(addressarray!=null)
      {
        for (var i = 0; i < 4; i++) {
          //What to do here to get the first word of every spilt
          var firstWord = addressarray[i].substr(0,1);
          firstWordsdata.push(firstWord);
        }
      }

      var firstWordsdata2 = firstWordsdata.join('');
     
      
      var codenew=document.getElementById('code').value;

      $.ajax({
          type:"GET",
          url:'{{ url("/") }}/master-data/felookuplocationgetloccountcode/'+firstWordsdata2,
          beforeSend: function() { $("body").addClass("loading");  },
          complete: function() {  $("body").removeClass("loading"); },
          success:function(res){  
              console.log(res)      
              if(res){
                   document.getElementById('code').value=res[0].codecount;

              }else{
                  
                  var codenew2=firstWordsdata2+""+codenew.slice(codenew.length - 4);
                  document.getElementById('code').value=codenew2;

              }
          }
      });
        
      //document.getElementById('address').value=results[0].formatted_address;
    
        var arraystring=results[0].formatted_address.split(","); 

        //alert(arraystring);
        var country=arraystring[arraystring.length-1];

        var stastecodepos=arraystring[arraystring.length-2];
        var stastecodeposarray=stastecodepos.split(" ");
        var codepos=stastecodeposarray[stastecodeposarray.length-1];
        var citydata=arraystring[arraystring.length-3];

        //var arraystate=stastecodeposarray.splice(-1,1);
        stastecodeposarray.pop();
        var arraystate=stastecodeposarray;
        var state=arraystate.toString();


        //alert(country);

        var statefix=state.replace(/,/g, ' ');
        //alert(statefix.trim());
        //alert(codepos);
        //alert(citydata);
        document.getElementById('postal_code').value=codepos;
        var idcountry=102;
        var idstate='';

        if(country)
        {
          //alert(results[0].address_components[8].long_name);
          
          //document.getElementById('country').value=results[0].address_components[8].long_name;

          var dd = document.getElementById('country');
          for (var i = 0; i < dd.options.length; i++) 
          {
              if (dd.options[i].text == country.trim()) 
              {
                  dd.selectedIndex = i;
                  break;
              }
          }

          //alert(i);
          idcountry=i;
          //document.getElementById('country').value=i;
          $('#country').select2('data', {id: i, a_key: country.trim()});
          $('#country').val(i);
          $('#country').select2().trigger('change');

        }



        if(statefix)
        {

          var statedataup=statefix.toUpperCase();
          if(idcountry)
          {
            $.ajax({
              type:"GET",
              url:"{{url('get-state-list')}}?country_id="+idcountry,
              beforeSend: function() { $("body").addClass("loading");  },
              complete: function() {  $("body").removeClass("loading"); },
              success:function(res)
              {       

                if(res)
                {
                  // $("#state").empty();
                  $("#province").removeAttr('disabled');
                  $("#province").append('<option selected disabled>Select Province</option>');
                  $.each(res,function(key,value){
                    $("#province").append('<option value="'+key+'">'+value+'</option>');
                  });

                  //alert(results[0].address_components[7].long_name);
                  //4131
                  //"Daerah Khusus Ibukota Jakarta"
                  //"Daerah Khusus Ibukota Jakarta"
                  
                    var dd = document.getElementById('province');
                    for (var i = 0; i < dd.options.length; i++) 
                    {
                        //alert('hasil sama -1 :'+dd.options[i].text);

                        if(dd.options[i].text == statedataup.trim()) 
                        {
                            dd.selectedIndex = dd.options[i].value;
                            //alert('hasil sama :'+dd.options[i].value);
                            idstate=dd.options[i].value;
                            break;
                        }
                    }

                    //alert('hasil sama2 :'+dd.options[i].value);
                    //var textdata=dd.options[4131].text;
                    idstate=dd.options[i].value;

                    $('#province').select2('data', {id: dd.options[i].value, a_key: dd.options[i].text});
                    $('#province').val(dd.options[i].value);
                    $('#province').select2().trigger('change');

                
                }
                else
                {
                  //$("#province").empty();
                }

              }
            });

          }

        }


          var idcity='';
        
          if(citydata)
          { 
              var citydataup=citydata.toUpperCase().trim();
              //alert(citydataup);

              
                  $.ajax({
                    type:"GET",
                    url:"{{url('get-city-list')}}?state_id="+idstate,
                    beforeSend: function() { $("body").addClass("loading");  },
                    complete: function() {  $("body").removeClass("loading"); },
                    success:function(res)
                    {        
                      if(res)
                      {

                        $("#city").empty();
                        $("#city").removeAttr('disabled');
                        $("#city").append('<option selected disabled>Select City</option>');
                        $.each(res,function(key,value){
                          $("#city").append('<option value="'+key+'">'+value+'</option>');
                        });
                        

                        var dd = document.getElementById('city');
                        for (var i = 0; i < dd.options.length; i++) 
                        {
                             //alert('hasil sama -1 :'+dd.options[i].text);
                             //alert('hasil sama -2 :'+citydataup);

                            if(dd.options[i].text.trim() == citydataup.trim()) 
                            {
                                dd.selectedIndex = dd.options[i].value;
                                //alert('hasil sama 3:'+dd.options[i].text);
                                //alert('hasil sama 2:'+dd.options[i].value);
                                idcity=dd.options[i].value;
                                break;
                            }
                        }

                        
                        //var textdata=dd.options[4131].text;
                        idcity=dd.options[i].value;
                        //alert('hasil sama2 :'+idcity);

                        $('#city').select2('data', {id: dd.options[i].value, a_key: dd.options[i].text});
                        $('#city').val(dd.options[i].value);
                        $('#city').select2().trigger('change');

                      }

                    }
                  });
              

          } 
        
     

      //var text1 = results[0].address_components[8].long_name;
      //$("#country option").filter(function() {
          //return this.text == text1; 
     // }).attr('selected', true);
      
  
  });

   
  var position = new google.maps.LatLng(latLng.lat(), latLng.lng());
  marker.setPosition(position);

}
       
var map = new google.maps.Map(document.getElementById('map'), {
zoom: 12,
center: new google.maps.LatLng(-6.175392,106.827153),
 mapTypeId: google.maps.MapTypeId.ROADMAP
  });
//posisi awal marker   
var latLng = new google.maps.LatLng(-6.175392,106.827153);

const input = document.getElementById("pac-input");
const searchBox = new google.maps.places.SearchBox(input);

map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
// Bias the SearchBox results towards current map's viewport.
//map.addListener("bounds_changed", () => {
  //searchBox.setBounds(map.getBounds());
//});

let markers = [];

searchBox.addListener("places_changed", () => {
  const places = searchBox.getPlaces();

  if (places.length == 0) {
    return;
  }

  // Clear out the old markers.
  markers.forEach((marker) => {
    marker.setMap(null);
  });
  
  markers = [];
  // For each place, get the icon, name and location.
  const bounds = new google.maps.LatLngBounds();
  places.forEach((place) => {
    if (!place.geometry || !place.geometry.location) {
      console.log("Returned place contains no geometry");
      return;
    }

    const icon = {
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25),
    };

    // Create a marker for each place.
    markers.push(
      new google.maps.Marker({
        map,
        icon,
        title: place.name,
        position: place.geometry.location,
      })
    );
    
    console.log("latitude: " + place.geometry.location.lat() + ", longitude: " + place.geometry.location.lng());
    var latLng2 = new google.maps.LatLng(place.geometry.location.lat(),place.geometry.location.lng());
    updateMarkerPosition(latLng2);
    

    if (place.geometry.viewport) {
      // Only geocodes have viewport.
      bounds.union(place.geometry.viewport);
    } else {
      bounds.extend(place.geometry.location);
    }
  });
  map.fitBounds(bounds);
});


/* buat marker yang bisa di drag lalu 
  panggil fungsi updateMarkerPosition(latLng)
 dan letakan posisi terakhir di id=latitude dan id=longitude
 */
var marker = new google.maps.Marker({
    position : latLng,
    title : 'lokasi',
    map : map,
    draggable : true
  });
   
//updateMarkerPosition(latLng);

geocoder.geocode({
        'latLng': latLng
    }, function(results, status) {
      //alert('masuk1');
      //alert(results[4].formatted_address);
      //document.getElementById('address').value=results[4].formatted_address;
});

google.maps.event.addListener(marker, 'drag', function() {
 // ketika marker di drag, otomatis nilai latitude dan longitude
 //menyesuaikan dengan posisi marker 
    updateMarkerPosition(marker.getPosition());
});



</script>



<style>
    .overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1100 !important;
        background: rgba(255,255,255,0.8) url("{{asset('loader.gif')}}") center no-repeat;
    }
    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;   
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }
</style>
