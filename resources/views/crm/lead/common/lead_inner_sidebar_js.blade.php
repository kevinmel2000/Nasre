<script>
  $('#markAsDeadBtn').on('click',()=>{
    if (confirm('{{__("Are you sure, you want to mark this lead as Dead ?")}}')) {
        $('#markAsDead').submit();
    } else {
        return false;
    }
  });

  $('#markAsPoorfitBtn').on('click',()=>{
    if (confirm('{{__("Are you sure, you want to mark this lead as Poorfit?")}}')) {
        $('#markAsPoorfit').submit();
    } else {
        return false;
    }
  });

  getTitles();
  function getTitles(){
    $('#title_id{{@$lead->id}}').empty();
    var url="{{url('api/contact/getTitles')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      type: 'GET',
      url: url,
      success: function (data) { 
        data.contactTitle.forEach(element => {
          var lead_title_id = "{{@$lead->title_id}}";
          var selected = 'selected';
          if(lead_title_id == element.id){
            var option = (`<option value="${element.id}" ${selected}>${element.name}</option>`);
          }else{
            var option = (`<option value="${element.id}">${element.name}</option>`);
          }
          $('#title_id{{@$lead->id}}').append(option);
        });
      },
      error: function(err){
        console.log(err.responseJSON);
      }
    });

  }
</script>