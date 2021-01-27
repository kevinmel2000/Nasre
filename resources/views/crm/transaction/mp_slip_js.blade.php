<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>

<style>
.hide {
    display: none;
}
</style>

<script>
$( "#autocomplete" ).autocomplete({
  source: [
  @foreach (@$costumer as $costumerdata)
   "{{@$costumerdata->company_name }}",
  @endforeach
  ]
});
</script>

<script>
$(document).ready(function(){

 var count = 1;
 $(".e1").select2({ width: '100%' });

    $("#btn-success2").click(function(){ 
    var html = $(".clone2").html();
    $(".increment2").after(html);
    });

    $("body").on("click","#btn-danger2",function(){ 
    $(this).parents("#control-group2").remove();
    });

 dynamic_field(count);

 function dynamic_field(number)
 {
  html = '<tr>';
        html += '<td><input type="text" name="first_name[]" class="form-control" /></td>';
        html += '<td><input type="text" name="last_name[]" class="form-control" /></td>';
        if(number > 1)
        {
            html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
            $('#user_table tbody').append(html);
        }
        else
        {   
            html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
            $('#user_table tbody').html(html);
        }
 }

 $(document).on('click', '#add', function(){
  count++;
  dynamic_field(count);
 });

 $(document).on('click', '.remove', function(){
  count--;
  $(this).closest("tr").remove();
 });

 $('#dynamic_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            method:'post',
            data:$(this).serialize(),
            dataType:'json',
            beforeSend:function(){
                $('#save').attr('disabled','disabled');
            },
            success:function(data)
            {
                if(data.error)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<p>'+data.error[count]+'</p>';
                    }
                    $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                }
                else
                {
                    dynamic_field(1);
                    $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                }
                $('#save').attr('disabled', false);
            }
        })
 });

});
</script>




<script type='text/javascript'>
     $('#form-addlocation').submit(function(e){
        e.preventDefault();

        var lookupcode = $('#lookup_location').val();
        var insured_id = $('#insuredIDtxt').val();
        var token = $('input[name=_token]').val();
        
        $.ajax({
            url:"{{ route('locationlist.store') }}",
            type:"POST",
            data:{
                lookupcode:lookupcode,
                insuredID:insured_id,
                _token:token
            },
            success:function(response){
                console.log(response)
                //alert(response);
                //$('#locRiskTable tbody').prepend('<tr id="sid'+response.id+'"><td>'+shipcode+'</td><td>'+shipname+'</td><td><a href="javascript:void(0)" onclick="deleteshipdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
                
                $('#locRiskTable tbody').prepend('<tr id="sid'+response.id+'"><td>'+response.loc_code+'</td><td>'+response.address+'</td><td>'+response.city_id+'</td><td>'+response.province_id+'</td><td>'+response.latitude+' , '+response.longtitude+'</td><td><a href="javascript:void(0)" onclick="deletelocationdetail('+response.id+')"><i class="fas fa-trash text-danger"></i></a></td></tr>')
                $('#addlocation').modal('toggle');
                $('#form-addlocation')[0].reset();
            }
        });

    });

    
    function deletelocationdetail(id){
        var token = $('input[name=_token]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-sliplocation-list/'+id,
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
</script>