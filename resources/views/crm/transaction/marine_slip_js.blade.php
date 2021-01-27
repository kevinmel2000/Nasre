<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>

<script type="text/javascript">
    
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
</script>

<script type='text/javascript'>
     $('#form-addship').submit(function(e){
        e.preventDefault();

        var shipcode = $('#shipcodetxt').val();
        var shipname = $('#shipnametxt').val();
        var insured_id = $('#insuredIDtxt').val();
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
            success:function(response){
                console.log(response)
                $('#shipdetailTable tbody').prepend('<tr id="sid'+response.id+'"><td>'+shipcode+'</td><td>'+shipname+'</td><td><a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
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
            success:function(response){
                
                $('#sid'+id).remove();
                console.log(response);
            }
        });
    }

    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    // $("#addship-btn").click(function(e){

    //     e.preventDefault();

    //     var shipcode = $('#shipcodetxt').val();
    //     var shipname = $('#shipnametxt').val();
    //     var insured_id = $('#insuredIDtxt').val();
    //     var url = '{{url('store-ship-list')}}';

    //     $.ajax({
    //        url:url,
    //        method:'POST',
    //        data:{
    //               _token": $('#token').val(),
    //               insuredID:insured_id, 
    //               ship_code:shipcode,
    //               ship_name:shipname
    //             },
    //        success:function(response){
    //           if(response.success){
    //             var tr_str = "<tr>"+
    //             "<td align='center'>" + shipcode + "</td>" +
    //             "<td align='center'>" + shipname + "</td>" +
    //             "<td align='center'><a href='#' onclick='"++"'><i class='fas fa-trash text-danger'></i></a></td>"+
    //             "</tr>";
    
    //             $("#shipdetailTable tbody").append(tr_str);
    //               alert(response.message) //Message come from controller
    //           }else{
    //               alert("Error")
    //           }
    //        },
    //        error:function(error){
    //           console.log(error)
    //        }
    //     });
	// });

</script>


<script>
    $(function () {
      "use strict";
  
      var marineslip = <?php echo(($ms_ids->content())) ?>;
      for(const id of marineslip) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#marineSlip").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"Bf>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this product and related data?')}}")
        if(choice){
            document.getElementById('delete-country-'+id).submit();
        }
    }
  
</script>

