<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>
<link rel="stylesheet" href="{{url('/')}}/css/sweetalert2.min.css">
<script src="{{url('/')}}/js/sweetalert2.all.min.js"></script>

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
               $('#shipdetailTable tbody').prepend('<tr id="sid'+response.id+'"  data-name="shiplistvalue[]"><td data-name="'+shipcode+'">'+shipcode+'</td><td data-name="'+shipname+'">'+shipname+'</td><td> <a href="javascript:void(0)" class="text-primary mr-3" data-toggle="modal" data-target="#updateshiplist'+response.id+'"><i class="fas fa-edit"></i> </a> <a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
               $('#ModalAddShip').modal('toggle');
               $('#form-addship')[0].reset();
           }
       });

   });

  
</script>


<script type='text/javascript'>
    function shipdetailupdate(id){
        var token = $('input[name=_token]').val();
        var shipcode = $('#shipcodems').val();
        var shipname = $('#shipnamems').val();
        var insured_id = $('#msinumber').val();

        console.log(token)
        console.log(shipcode)
        console.log(shipname)
        console.log(insured_id)

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
        $.ajax({
            url:'{{ url("/") }}/update-ship-list/'+id,
            type:"POST",
            data:{
                ship_code:shipcode,
                ship_name:shipname,
                insuredID:insured_id
            },
            beforeSend: function() { $("body").addClass("loading");  },
            complete: function() {  $("body").removeClass("loading"); },
            success:function(response){
                // $('#updateshiplist'+id).modal('hide');
                $('#sid'+id).remove();
               $('#shipdetailTable tbody').prepend('<tr id="sid'+response.id+'"  data-name="shiplistvalue[]"><td data-name="'+shipcode+'">'+shipcode+'</td><td data-name="'+shipname+'">'+shipname+'</td><td> <a href="javascript:void(0)" class="text-primary mr-3" data-toggle="modal" data-target="#updateshiplist'+response.id+'"><i class="fas fa-edit"></i> </a><a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
               console.log(response);
            }
        });
    }
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

<script type="text/javascript">
    $('#formmarineinsured').submit(function(e){
       //alert('masuk');
       e.preventDefault();

       var idinsured = $('#idinsured').val();
       var msinumber = $('#msinumber').val();
       var msiprefix = $('#msiprefix').val();
       var msisuggestinsured = $('#autocomplete').val();
       var msisuffix = $('#autocomplete2').val();
       var msishare = $('#msishare').val();
       var msisharefrom  = $('#msisharefrom').val();
       var msishareto = $('#msishareto').val();
       var msiroute = $('#msiroute').val();
       var msiroutefrom  = $('#msiroutefrom').val();
       var msirouteto = $('#msirouteto').val();
       var msicoinsurance = $('#msicoinsurance').val();
       
       
       var token2 = $('input[name=_token]').val();

       console.log(idinsured)
       console.log(msiprefix)
       console.log(msisuggestinsured)
       console.log(msinumber)
       console.log(msisuffix)

       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:'{{ url("/") }}/transaction-data/marine-insured/update/'+idinsured,
           type:"POST",
           data:{
               msinumber:msinumber,
               msiprefix:msiprefix,
               msisuggestinsured:msisuggestinsured,
               msisuffix:msisuffix,
               msishare:msishare,
               msisharefrom:msisharefrom,
               msishareto:msishareto,
               msiroute:msiroute,
               msiroutefrom:msiroutefrom,
               msirouteto:msirouteto,
               msicoinsurance:msicoinsurance
           },
           beforeSend: function() { $("body").addClass("loading");  },
           complete: function() {  $("body").removeClass("loading"); },
           success:function(response)
           {
                swal("Good job!", "Insured Marine Update Success", "success")
                console.log(response)
                // $(':input','#formmarineinsured')
                //     .not(':button, :submit, :reset, :hidden')
                //     .val('')
                //     .removeAttr('checked')
                //     .removeAttr('selected');
           },
           error: function (request, status, error) {
                //alert(request.responseText);
                swal("Error!", "Marine Insured Update Error", "Insert Error");
           }
       });

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
        z-index: 999;
        background: rgba(255,255,255,0.8) url("{{url('/')}}/loader.gif") center no-repeat;
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