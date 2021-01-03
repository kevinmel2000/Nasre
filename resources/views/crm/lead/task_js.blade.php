<script>
  $(function(){
    'use strict';
   
    $('#start_date').datetimepicker({
      format: 'L',
      format: 'DD/MM/YYYY'
    });

    $(`#start_time`).datetimepicker({
        format: 'LT'
    });

    function startTimeChange(id){
      $(`#start_time${id}`).datetimepicker({
        format: 'LT'
      });
    }
    function endTimeChange(id){
      $(`#end_time${id}`).datetimepicker({
        format: 'LT'
        });
    }

  });



  // SECTION Get Customers or Leads as per relation 
  $('.relation').change(() => {
    $('#lead_customer_id').empty();
    var relation = $('.relation').val();
    if (relation == 'Customer') {
        var url = "{{url('api/media/getCustomers')}}";
    } else {
        var url = "{{url('api/media/getLeads')}}";
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            
        }
    });
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            relation: relation
        },
        dataType: 'JSON',
        success: function (data) {
            if (relation == 'Customer') {
                data.customers.forEach(customer => {
                    let tmp =
                        `<option value="${customer.id}">${customer.username}</option>`;
                    $('#lead_customer_id').append(tmp);
                });
            } else {
                data.leads.forEach(lead => {
                    let tmp =
                        `<option value="${lead.id}">${lead.first_name} ${lead.last_name} ${lead.email}</option>`;
                    $('#lead_customer_id').append(tmp);
                });
            }
        }

    });
});

// !SECTION GET Customers/Leads Ends
$('select').select2({
  width:'100%'
});

$('#billable').change(() => {
  if ($("#billable").is(":checked")) {
    $('#bill_amount_field').show();
  }else{
    $('#bill_amount_field').hide();
  }
})
function billable_modal(id){
  if ($(`#billable_modal${id}`).is(":checked")) {
    $(`#bill_amount_modal${id}`).show();
  }else{
    $(`#bill_amount_modal${id}`).hide();
  }
}

var repeat_window = `
<div class="card" id="repeat_window">
  <div class="card-body" >
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Repeat Every</label>
          <select name="repeat_every" class="form-control form-control-sm">
            @php
                $repeats = ['week','day', 'month', 'year'];
            @endphp
            <option value="none" selected>None</option>
            @foreach ($repeats as $repeat)
                <option value="{{$repeat}}">{{$repeat}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Repeat on a specific Day of the Month</label>
          <input type="date" name="repeat_day_month" class="form-control form-control-sm">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Ends on</label>
          <input type="date" name="end_date" class="form-control form-control-sm">
        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</div>		
`;

$('#repeat_task').change(() => {
  if (!$("#repeat_task").is(":checked")) {
    $('#repeat_window_show').empty();
  }else{
    $('#repeat_window_show').append(repeat_window);
  }
})

$('#is_all_day').change(() => {
  if ($("#is_all_day").is(":checked")) {
    $('#is_all_day_show').empty();
  }else{
    var tmp = `
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Start Time</label>
            <input type="time" name="start_time" class="form-control form-control-sm">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>End Time</label>
            <input type="time" name="end_time" class="form-control form-control-sm">
          </div>
        </div>
      </div>  
    `;
    $('#is_all_day_show').append(tmp);

  }
})
function confirmDelete(id) {
  let choice = confirm("{{__('Are you sure, You want to Delete this task and related data ?')}}")
  if (choice) {
      document.getElementById('delete-task-' + id).submit();
  }
}
</script>
<script>
// Script for Modal 
function is_all_day_modal(task_id){
if ($(`#is_all_day_modal${task_id}`).is(":checked")) {
$(`#is_all_day_show_modal${task_id}`).empty();
$(`#start_time${task_id}`).remove();
$(`#end_time${task_id}`).remove();
}else{
var tmp = `
<div class="form-group">
          <label>Start Time</label>
          <input type="time" name="start_time" class="form-control form-control-sm">
          </div>
          <div class="form-group">
            <label>End Time</label>
          <input type="time" name="end_time" class="form-control form-control-sm">
        </div>
`;
$(`#is_all_day_show_modal${task_id}`).append(tmp);
}
}

var repeat_window = `
<div class="card" id="repeat_window">
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="">Repeat Every</label>
          <select name="repeat_every" class="form-control form-control-sm">
            @php
                $repeats = ['week','day', 'month', 'year'];
            @endphp
            <option value="none" selected>None</option>
            @foreach ($repeats as $repeat)
                <option value="{{$repeat}}">{{$repeat}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="">Repeat on a specific Day of the Month</label>
          <input type="date" name="repeat_day_month" class="form-control form-control-sm">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="">Ends on</label>
          <input type="date" name="end_date" class="form-control form-control-sm">
        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</div>		
`;
function repeat_task_modal(task_id){
  if (!$(`#repeat_task_modal${task_id}`).is(":checked")) {
      $(`#repeat_window_show_modal${task_id}`).empty();
      $(`#repeat_window_show_modal_pre_valued${task_id}`).empty();
    }else{
      $(`#repeat_window_show_modal${task_id}`).append(repeat_window);
    }			
}

</script>