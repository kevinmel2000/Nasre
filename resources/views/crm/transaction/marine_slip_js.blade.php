<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>

<script type="text/javascript">
    
</script>

<script type="text/javascript">
     $('#shipcode').change(function(){
        var shipcode = $(this).val();

        if(shipcode){
            $.ajax({
                type:"GET",
                dataType: 'json',
                url:"{{url('get-ship-list')}}?ship_code="+shipcode,
                success:function(response){        
                    if(response){
                        $("#shipname").val(response.shipname);
                    }else{
                        $("#shipname").empty();
                    }
                }
            });
        }else{
            $("#shipname").empty();
        }
    });
</script>

<script type='text/javascript'>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    $(document).ready(function(){
    
      // Fetch records
      fetchRecords();
    
      // Add record
      $('#addship').click(function(){
    
        var shipcode = $('#shipcode').val();
        var shipname = $('#shipname').val();
        var insured_id = $('#insuredID').val();
    
        if(shipcode != '' && shipname != '' && insured_id != ''){
          $.ajax({
            url: "{{url('post-ship-list')}}",
            type: 'post',
            data: {_token: CSRF_TOKEN,insured_id: insured_id,ship_code: shipcode,ship_name: shipname},
            success: function(response){
    
              if(response > 0){
                var id = response;
                var findnorecord = $('#shipdetailTable tr.norecord').length;
    
                // if(findnorecord > 0){
                //   $('#shipdetailTable tr.norecord').remove();
                // }
                var tr_str = "<tr>"+
                "<td align='center'>" + shipcode + "</td>" +
                "<td align='center'>" + shipname + "</td>" +
                "<td align='center'><a href='#' onclick='"+ deleteRecords()+"'><i class='fas fa-trash text-danger'></i></a></td>"+
                "</tr>";
    
                $("#userTable tbody").append(tr_str);
              }else if(response == 0){
                alert('shipname already in use.');
              }else{
                alert(response);
              }
    
              // Empty the input fields
            //   $('#shipcode').val('');
            //   $('#shipname').val('');
            //   $('#insured_id').val('');
            }
          });
        }else{
          alert('Fill all fields');
        }
      });
    
    });
    
    
    // Delete record
    function deleteRecords() {
      var delete_id = $(this).data('id');
      var el = this;
      $.ajax({
        url: 'deleteUser/'+delete_id,
        type: 'get',
        success: function(response){
          $(el).closest( "tr" ).remove();
          alert(response);
        }
      });
    } 
    
    // Fetch records
    function fetchRecords(){
      $.ajax({
        url: 'getUsers',
        type: 'get',
        dataType: 'json',
        success: function(response){
    
          var len = 0;
          $('#userTable tbody tr:not(:first)').empty(); // Empty <tbody>
          if(response['data'] != null){
            len = response['data'].length;
          }
    
          if(len > 0){
            for(var i=0; i<len; i++){
    
              var id = response['data'][i].id;
              var username = response['data'][i].username;
              var name = response['data'][i].name;
              var email = response['data'][i].email;
    
              var tr_str = "<tr>" +
              "<td align='center'><input type='text' value='" + username + "' id='username_"+id+"' disabled></td>" +
              "<td align='center'><input type='text' value='" + name + "' id='name_"+id+"'></td>" + 
              "<td align='center'><input type='email' value='" + email + "' id='email_"+id+"'></td>" +
              "<td align='center'><input type='button' value='Update' class='update' data-id='"+id+"' ><input type='button' value='Delete' class='delete' data-id='"+id+"' ></td>"+
              "</tr>";
    
              $("#userTable tbody").append(tr_str);
    
            }
          }else{
            var tr_str = "<tr class='norecord'>" +
            "<td align='center' colspan='4'>No record found.</td>" +
            "</tr>";
    
            $("#userTable tbody").append(tr_str);
          }
    
        }
      });
    }
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

