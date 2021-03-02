<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script type="text/javascript">
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); 
       
        
        });
</script>
<link rel="stylesheet" href="{{url('/')}}/css/sweetalert2.min.css">
<script src="{{url('/')}}/js/sweetalert2.all.min.js"></script>

<script type="text/javascript">
    function detailslip(id){
        if(id){
            alert(id);
                
                $.ajax({
                    type:"GET",
                    dataType: 'json',
                    url:'{{ url("/") }}/transaction-data/getmodal-marine-slip/'+id,
                    beforeSend: function() { $("body").addClass("loading");  },
                    complete: function() {  $("body").removeClass("loading"); },
                    success:function(response){  
                        console.log(response)      
                        if(response){
                            $("#slipnumberdetail").val(response.slip_number);
                            $("#slipusernamedetail").val(response.username);
                            $("#slipprodyeardetail").val(response.prod_year);
                            $("#slipuydetail").val(response.uy);
                            $("#slipstatusdetail").val(response.status);
                            $('#slipcedingbrokerdetail').append(' <option value="'+response.cedbrok_id+'" selected>'+response.cedbrok_cn+' - '+response.cedbrok_code+' - '+response.cedbrok+'</option>');
                            // $('#slipcedingdetail').val(response.id);
                            // $('#slipcurrencydetail').val(response.id);
                            // $('#slipcobdetail').val(response.id);
                            // $('#slipkocdetail').val(response.id);
                            // $('#slipoccupacydetail').val(response.id);
                            $('#slipbld_constdetail').val(response.build_const);
                            $('#slipnodetail').val(response.slip_no);
                            $('#slipcndndetail').val(response.cn_dn);
                            $('#slippolicy_nodetail').val(response.policy_no);
                            $('#aid').append('<div class="control-group input-group" id="control-group2" style="margin-top:10px"><a href="{{ asset("files")}}/'+response.attachment_filename+'">'+response.attachment_filename+'</a></div>');
                        }else{
                            swal("Ohh no!", "Data failed to get", "failed")
                        }
                    }
                });
            }else{
                swal("Ohh no!", "Current object failed to get", "failed")
            }
    }
    
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