<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>

<style>
.hide {
    display: none;
}
</style>


<script type="text/javascript">
    $(function() {              
       // Bootstrap DateTimePicker v4
       $('#dateinstallment').datetimepicker({
             format: 'YYYY-MM-DD'
       });
    });      
</script>

<script type="text/javascript">
    $(function() {              
       // Bootstrap DateTimePicker v4
       $('#dateinstallment').datetimepicker({
             format: 'YYYY-MM-DD'
       });
    });      
</script>

<script type="text/javascript">
    $(function() {              
       // Bootstrap DateTimePicker v4
       $('#dateinstallment').datetimepicker({
             format: 'YYYY-MM-DD'
       });

       $('#dateinfrom').datetimepicker({
             format: 'YYYY-MM-DD'
       });

       $('#dateinto').datetimepicker({
             format: 'YYYY-MM-DD'
       });

       $('#daterefrom').datetimepicker({
             format: 'YYYY-MM-DD'
       });

       $('#datereto').datetimepicker({
             format: 'YYYY-MM-DD'
       });
    });      

</script>


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
    $( "#autocomplete2" ).autocomplete({
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


<script type='text/javascript'>
    $('#addinterestinsured-btn').click(function(e){
       e.preventDefault();

       var interest = $('#slipinterestlist').val();
       var amount = $('#slipamount').val();
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajax({
           url:"{{ route('interestlist.store') }}",
           type:"POST",
           data:{
               interest_insured:interest,
               slipamount:amount,
               id_slip:slip_id,
               _token:token2
           },
           success:function(response){
            
               console.log(response)
               $('#interestInsuredTable tbody').prepend('<tr id="iid'+response.id+'" data-name="interestvalue[]"><td data-name="'+response.description+'">'+response.description+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinterestdetail('+response.id+')">delete</a></td></tr>')
               $('#slipamount').val('');
               $('#slipinterestlist').val('');
               var total =  parseFloat($("#sliptotalsum").val());
               var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
               $("#sliptotalsum").val(sum);

               

            //    if($('#sliptotalsum').val(''))
            //         $("#sliptotalsum").val(parseFloat(response.amount));
            //    else
            //    {
            //     var total=isNaN(parseInt($("#sliptotalsum").val() + $("#slipamount").val())) ? 0 :($("#sliptotalsum").val() + $("#slipamount").val());
            //      $("#sliptotalsum").val(total);
                
            //    }
           }
       });

   });
</script>
    
<script  type='text/javascript'>
    
</script>

<script type='text/javascript'>
    function deleteinterestdetail(id){
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-interest-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            success:function(response){
                
                $('#iid'+id).remove();
                console.log(response);
            }
        });
    }
</script>

<script type='text/javascript'>
    
     $('#slipippercentage').keyup(function () {
        var persentage =  parseFloat($('#slipippercentage').val());
        var premiumnr =  parseFloat($('#slipnetprmtonr').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(premiumnr * persentage/100) ? 0 :(premiumnr * persentage/100) ;
        //alert(sum);
        $('#slipipamount').val(sum);
     });

     $('#slipippercentage').change(function () {
        var persentage =  parseFloat($('#slipippercentage').val());
        var premiumnr =  parseFloat($('#slipnetprmtonr').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(premiumnr * persentage/100) ? 0 :(premiumnr * persentage/100) ;
        //alert(sum);
        $('#slipipamount').val(sum);
     });

</script>

<script type='text/javascript'>
    
     $('#slipdppercentage').keyup(function () {
        var persentage =  parseFloat($('#slipdppercentage').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipdpamount').val(sum);
     });

     $('#slipdppercentage').change(function () {
        var persentage =  parseFloat($('#slipdppercentage').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipdpamount').val(sum);
     });

</script>


<script type='text/javascript'>
    
     $('#slipnilaiec').keyup(function () {
        var persentage =  parseFloat($('#slipnilaiec').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipamountec').val(sum);
     });

     $('#slipnilaiec').change(function () {
        var persentage =  parseFloat($('#slipnilaiec').val());
        var sliptotalsum =  parseFloat($('#sliptotalsum').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(sliptotalsum * persentage/100) ? 0 :(sliptotalsum * persentage/100) ;
        //alert(sum);
        $('#slipamountec').val(sum);
     });

</script>


<script type='text/javascript'>
    $('#addinstallmentinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var installmentdate = $('#dateinstallmentdata').val();
       
       var percentage = $('#slipippercentage').val();
       var amount = $('#slipipamount').val();
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('installment.store') }}",
           type:"POST",
           data:{
               installmentdate:installmentdate,
               percentage:percentage,
               slipamount:amount,
               id_slip:slip_id
           },
           success:function(response)
           {
            
               console.log(response)
               $('#installmentPanel tbody').prepend('<tr id="iidinstallment'+response.id+'" data-name="installmentvalue[]"><td data-name="'+response.installment_date+'">'+response.installment_date+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteinstallmentdetail('+response.id+')">delete</a></td></tr>')
               $('#dateinstallment').val('');
               $('#slipippercentage').val('');
               $('#slipipamount').val('');
               
               //var total =  parseFloat($("#sliptotalsum").val());
               //var sum = isNaN(total + parseFloat(response.amount)) ? 0 :(total + parseFloat(response.amount)) ;
               //$("#sliptotalsum").val(sum);

           }
       });

   });
</script>

<script type='text/javascript'>
    function deleteinstallmentdetail(id)
    {
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-installment-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            success:function(response){
                
                $('#iidinstallment'+id).remove();
                console.log(response);
            }
        });
    }
</script>



<script type='text/javascript'>
    $('#adddeductibleinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slipdptype = $('#slipdptype').val();
       var slipdpcurrency = $('#slipdpcurrency').val();
       
       var percentage = $('#slipdppercentage').val();
       var amount = $('#slipdpamount').val();
       var minamount = $('#slipdpminamount').val();
       
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('deductible.store') }}",
           type:"POST",
           data:{
               slipdptype:slipdptype,
               slipdpcurrency:slipdpcurrency,
               percentage:percentage,
               amount:amount,
               minamount:minamount,
               id_slip:slip_id
           },
           success:function(response)
           {
            
               console.log(response)
               $('#deductiblePanel tbody').prepend('<tr id="iiddeductible'+response.id+'" data-name="deductiblevalue[]"><td data-name="'+response.deductibletype+'">'+response.deductibletype+'</td><td data-name="'+response.currencydata+'">'+response.currencydata+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td data-name="'+response.min_claimamount+'">'+response.min_claimamount+'</td><td><a href="javascript:void(0)" onclick="deletedeductibledetail('+response.id+')">delete</a></td></tr>');
               $('#slipdppercentage').val('');
               $('#slipdpamount').val('');
               $('#slipdpminamount').val('');
               
           }
       });

   });
</script>

<script type='text/javascript'>
    function deletedeductibledetail(id)
    {
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-deductible-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            success:function(response){
                
                $('#iiddeductible'+id).remove();
                console.log(response);
            }
        });
    }
</script>


<script type='text/javascript'>
    $('#addextendcoverageinsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var slipcncode = $('#slipcncode').val();
       var percentage = $('#slipnilaiec').val();
       var amount = $('#slipamountec').val();
       
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('extendcoverage.store') }}",
           type:"POST",
           data:{
               slipcncode:slipcncode,
               percentage:percentage,
               amount:amount,
               id_slip:slip_id
           },
           success:function(response)
           {
            
               console.log(response)
               $('#ExtendCoveragePanel tbody').prepend('<tr id="iidextendcoverage'+response.id+'" data-name="extendcoveragevalue[]"><td data-name="'+response.coveragetype+'">'+response.coveragetype+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteextendcoveragedetail('+response.id+')">delete</a></td></tr>');
               $('#slipnilaiec').val('');
               $('#slipamountec').val('');
               
           }
       });

   });
</script>

<script type='text/javascript'>
    function deleteextendcoveragedetail(id)
    {
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-extendcoverage-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            success:function(response){
                
                $('#iidextendcoverage'+id).remove();
                console.log(response);
            }
        });
    }
</script>

<script type='text/javascript'>
    
     $('#sliprppercentage').keyup(function () {
        var persentage =  parseFloat($('#sliprppercentage').val());
        var slipnetprmtonr =  parseFloat($('#slipnetprmtonr').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(slipnetprmtonr * persentage/100) ? 0 :(slipnetprmtonr * persentage/100) ;
        //alert(sum);
        $('#sliprpamount').val(sum);
     });

     $('#sliprppercentage').change(function () {
        var persentage =  parseFloat($('#sliprppercentage').val());
        var slipnetprmtonr =  parseFloat($('#slipnetprmtonr').val());
        //alert(premiumnr);
        //alert(persentage);
        var sum = isNaN(slipnetprmtonr * persentage/100) ? 0 :(slipnetprmtonr * persentage/100) ;
        //alert(sum);
        $('#sliprpamount').val(sum);
     });

</script>


<script type='text/javascript'>
    $('#addretrocessioninsured-btn').click(function(e){
       //alert('masuk');
       e.preventDefault();

       var type = $('#sliprptype').val();
       var contract = $('#sliprpcontract').val();
       var percentage = $('#sliprppercentage').val();
       var amount = $('#sliprpamount').val();
       
       var slip_id = $('#slipnumber').val();
       var token2 = $('input[name=_token2]').val();
       
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

       $.ajax({
           url:"{{ route('retrocession.store') }}",
           type:"POST",
           data:{
               type:type,
               contract:contract,
               percentage:percentage,
               amount:amount,
               id_slip:slip_id
           },
           success:function(response)
           {
            
               console.log(response)
               $('#retrocessionPanel tbody').prepend('<tr id="iidretrocession'+response.id+'" data-name="retrocessionvalue[]"><td data-name="'+response.type+'">'+response.type+'</td><td data-name="'+response.contract+'">'+response.contract+'</td><td data-name="'+response.percentage+'">'+response.percentage+'</td><td data-name="'+response.amount+'">'+response.amount+'</td><td><a href="javascript:void(0)" onclick="deleteretrocessiondetail('+response.id+')">delete</a></td></tr>');
               $('#sliprppercentage').val('');
               $('#sliprpamount').val('');
               
           }
       });

   });
</script>

<script type='text/javascript'>
    function deleteretrocessiondetail(id)
    {
        var token2 = $('input[name=_token2]').val();

        $.ajax({
            url:'{{ url("/") }}/delete-retrocession-list/'+id,
            type:"DELETE",
            data:{
                _token:token2
            },
            success:function(response){
                
                $('#iidretrocession'+id).remove();
                console.log(response);
            }
        });
    }
</script>
