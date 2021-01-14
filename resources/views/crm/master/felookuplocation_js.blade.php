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