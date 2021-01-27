<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>

<style>
.hide {
    display: none;
}
</style>

<script>
$(document).ready(function() { 
        
        $(".e1").select2({ width: '100%' }); 
        
        $("#btn-success2").click(function(){ 
        var html = $(".clone2").html();
        $(".increment2").after(html);
        });

        $("body").on("click","#btn-danger2",function(){ 
        $(this).parents("#control-group2").remove();
        });
        
});
</script>