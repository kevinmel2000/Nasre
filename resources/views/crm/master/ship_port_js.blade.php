<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() { 
        
        $(".e1").select2({ width: '100%' }); 
        $("#spstate").attr('disabled','disabled');
        $("#spcity").attr('disabled','disabled');
        $("#statesp").attr('disabled','disabled');
    
    });
</script>


<script type="text/javascript">
    $('#spcountry').change(function(){
        var countryID = $(this).val();  
        //alert(countryID);
        if(countryID){
            $.ajax({
            type:"GET",
            url:"{{url('get-state-list')}}?country_id="+countryID,
            success:function(res){        
                if(res){
                    // $("#state").empty();
                    $("#spstate").removeAttr('disabled');
                    $("#spstate").append('<option selected disabled>Select Province</option>');
                    $.each(res,function(key,value){
                    $("#spstate").append('<option value="'+key+'">'+value+'</option>');
                    });
                
                }else{
                    $("#spstate").empty();
                }
            }});
        }else{
            $("#spstate").empty();
            $("#spcity").empty();
        }   
    });

    $('#spstate').on('change',function(){
        var stateID = $(this).val();  
    //alert(stateID);
        if(stateID){
            $.ajax({
            type:"GET",
            url:"{{url('get-city-list')}}?state_id="+stateID,
            success:function(res){        
            if(res){
                $("#spcity").empty();
                $("#spcity").removeAttr('disabled');
                $("#spcity").append('<option selected disabled>Select City</option>');
                $.each(res,function(key,value){
                $("#spcity").append('<option value="'+key+'">'+value+'</option>');
                });
            
            }else{
                $("#spcity").empty();
            }
            }
            });
        }else{
            $("#spcity").empty();
        }
    
    });
</script>

<script type="text/javascript">
    $('#countrysp').change(function(){
        var countryID = $(this).val();  
        //alert(countryID);
        if(countryID){
            $.ajax({
            type:"GET",
            url:"{{url('get-state-list')}}?country_id="+countryID,
            success:function(res){        
                if(res){
                     console.log(res);

                    // $("#state").empty();
                    $("#statesp").removeAttr('disabled');
                    $("#statesp").append('<option selected disabled>Select Province</option>');
                    $.each(res,function(key,value){
                    $("#statesp").append('<option value="'+key+'">'+value+'</option>');
                    });
                
                }else{
                    $("#statesp").empty();
                }
            }});
        }else{
            $("#spstate").empty();
            $("#citysp").empty();
        }   
    });

    $('#statesp').on('change',function(){
        var stateID = $(this).val();  
    //alert(stateID);
        if(stateID){
            $.ajax({
            type:"GET",
            url:"{{url('get-city-list')}}?state_id="+stateID,
            success:function(res){        
            if(res){
                console.log(res);
                $("#citysp").empty();
                $("#citysp").append('<option selected disabled>Select City</option>');
                $.each(res,function(key,value){
                $("#citysp").append('<option value="'+key+'">'+value+'</option>');
                });
            
            }else{
                $("#citysp").empty();
            }
            }
            });
        }else{
            $("#citysp").empty();
        }
    
    });
</script>


<script>
        // $(document).ready(function() { $(".e1").select2({ width: '100%' }); 
        
        // $.ajax({
        //     type:"GET",
        //     url:"{{url('get-city-all')}},
        //     success:function(res){        
        //         if(res){
        //             $("#spcity").attr('class','e1 form-control form-control-sm')
        //             $("#spcity").append('<option selected disabled>Select City</option>');
        //             $.each(res,function(key,value){
        //             $("#spcity").append('<option value="'+key+'">'+value+'</option>');
        //             });
                
        //         }else{
        //             $("#spcity").empty();
        //         }
        //     }
        // });
        
        
        // });
</script>

<script>
    $(function () {
      "use strict";
  
      var shipport = <?php echo(($shipport_ids->content())) ?>;
      for(const id of shipport) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#shipportTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
        
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this Ship Port and related data?')}}")
        if(choice){
            document.getElementById('delete-shipport-'+id).submit();
        }
    }
  
</script>