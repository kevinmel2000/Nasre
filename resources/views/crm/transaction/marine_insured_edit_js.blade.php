<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2(); });
</script>

<script type="text/javascript">
    $('#shipcodetxt').change(function(){
       var shipcode = $(this).val();

       if(shipcode){
           $.ajax({
               type:"GET",
               dataType: 'json',
               url:"{{url('get-ship-list')}}?ship_code="+shipcode,
               success:function(response){        
                   if(response){
                       $("#shipnametxt").val(response.shipname);
                   }else{
                       $("#shipnametxt").empty();
                   }
               }
           });
       }else{
           $("#shipnametxt").empty();
       }
   });

   $('#shipcodems').change(function(){
       var shipcode = $(this).val();

       if(shipcode){
           $.ajax({
               type:"GET",
               dataType: 'json',
               url:"{{url('get-ship-list')}}?ship_code="+shipcode,
               success:function(response){        
                   if(response){
                       $("#shipnamems").val(response.shipname);
                   }else{
                       $("#shipnamems").empty();
                   }
               }
           });
       }else{
           $("#shipnamems").empty();
       }
   });
</script>

<script type='text/javascript'>
    $('#form-addship').submit(function(e){
       e.preventDefault();

       var shipcode = $('#shipcodetxt').val();
       var shipname = $('#shipnametxt').val();
       var insured_id = $('#msinumber').val();
       var token = $('input[name=_token]').val();
       
       $.ajax({
           url:"{{ route('shiplist.store') }}",
           type:"POST",
           data:{
               ship_code:shipcode,
               ship_name:shipname,
               insuredID:insured_id,
               _token:token
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
               console.log(response)
               $('#shipdetailTable tbody').prepend('<tr id="sid'+response.id+'"  data-name="shiplistvalue[]"><td data-name="'+shipcode+'">'+shipcode+'</td><td data-name="'+shipname+'">'+shipname+'</td><td><a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
               $('#ModalAddShip').modal('toggle');
               $('#form-addship')[0].reset();
           }
       });

   });

   $('#form-updateship').submit(function(e){
       e.preventDefault();

       var shipcode = $('#shipcodetxt').val();
       var shipname = $('#shipnametxt').val();
       var insured_id = $('#msinumber').val();
       var token = $('input[name=_token]').val();
       
       $.ajax({
           url:"{{ route('shiplist.store') }}",
           type:"POST",
           data:{
               ship_code:shipcode,
               ship_name:shipname,
               insuredID:insured_id,
               _token:token
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
               console.log(response)
               $('#shipdetailTable tbody').prepend('<tr id="sid'+response.id+'"  data-name="shiplistvalue[]"><td data-name="'+shipcode+'">'+shipcode+'</td><td data-name="'+shipname+'">'+shipname+'</td><td><a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
               $('#ModalAddShip').modal('toggle');
               $('#form-addship')[0].reset();
           }
       });

   });
</script>



<script type='text/javascript'>
   function deleteshipdetail(id){
       var token = $('input[name=_token]').val();

       $.ajax({
           url:'{{ url("/") }}/delete-ship-list/'+id,
           type:"DELETE",
           data:{
               _token:token
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response){
               
               $('#sid'+id).remove();
               console.log(response);
           }
       });
   }
</script>

<script>
    $(function () {
      "use strict";
  
      var insured = <?php echo(($insured_ids->content())) ?>;
      for(const id of insured) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
      $("#marineinsured").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
        
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Marine Insured related data?')}}")
        if(choice){
            document.getElementById('delete-marineinsured-'+id).submit();
        }
    }
  
</script>
