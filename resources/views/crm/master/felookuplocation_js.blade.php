<script type=text/javascript>

  $('#country').change(function(){
  var countryID = $(this).val();  
  //alert(countryID);
  if(countryID){
    $.ajax({
      type:"GET",
      url:"{{url('get-state-list')}}?country_id="+countryID,
      success:function(res){        
      if(res){
        $("#state").empty();
        $("#state").append('<option>Select</option>');
        $.each(res,function(key,value){
          $("#state").append('<option value="'+key+'">'+value+'</option>');
        });
      
      }else{
        $("#state").empty();
      }
      }
    });
  }else{
    $("#state").empty();
    $("#city").empty();
  }   
  });


  $('#state').on('change',function(){
  var stateID = $(this).val();  
  //alert(stateID);
  if(stateID){
    $.ajax({
      type:"GET",
      url:"{{url('get-city-list')}}?state_id="+stateID,
      success:function(res){        
      if(res){
        $("#city").empty();
        $.each(res,function(key,value){
          $("#city").append('<option value="'+key+'">'+value+'</option>');
        });
      
      }else{
        $("#city").empty();
      }
      }
    });
  }else{
    $("#city").empty();
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



<script src="http://maps.google.com/maps/api/js?sensor=false&amp;key=AIzaSyD4yhKiCvJpWtee_7Bobk_9qjDUAZTTOKE" type="text/javascript"></script>

<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2(); });
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
    //* Fungsi untuk mendapatkan nilai latitude longitude
function updateMarkerPosition(latLng) 
{
  document.getElementById('latitude').value = [latLng.lat()]
  document.getElementById('longitude').value = [latLng.lng()]
}
       
var map = new google.maps.Map(document.getElementById('map'), {
zoom: 12,
center: new google.maps.LatLng(-7.781921,110.364678),
 mapTypeId: google.maps.MapTypeId.ROADMAP
  });
//posisi awal marker   
var latLng = new google.maps.LatLng(-7.781921,110.364678);
 
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
   
updateMarkerPosition(latLng);
google.maps.event.addListener(marker, 'drag', function() {
 // ketika marker di drag, otomatis nilai latitude dan longitude
 //menyesuaikan dengan posisi marker 
    updateMarkerPosition(marker.getPosition());
  });
</script>