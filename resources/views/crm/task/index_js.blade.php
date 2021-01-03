<script>
  $(function(){
    'use strict';
    var tasks = <?php echo(($task_ids->content())) ?>;
    for(const id of tasks) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }
  });

  function dateChange(id){
    $(`#start_date${id}`).datetimepicker({
        format: 'L',
        format: 'DD/MM/YYYY'
      });
  }
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

$(document).ready(()=>{
  $('#date').datetimepicker({
    format: 'DD/MM/YYYY'
  });

  $('#tasksTable').DataTable( {
    "order": [[ 0, "desc" ]],
    dom: '<"top"Bf>rt<"bottom"lip><"clear">',
    lengthMenu: [
        [ 10, 25, 50,100, -1 ],
        [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
    ],
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6]
            }
        },
        {
            extend: 'csv',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6]
            }
        },
        {
            extend: 'excel',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6]
            }
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6]
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6]
            }
        },
    ]
  } );

  $('#billable').on('change',() => {
    if ($("#billable").is(":checked")) {
      $('#bill_amount_field').show();
    }else{
      $('#bill_amount_field').hide();
    }
  });

  $('#addButton').on('click',()=>{
    $('#new_task_card').show();
    $('#hideButton').show();
    $('#addButton').hide();
  })

  $('#hideButton').on('click',()=>{
    $('#new_task_card').hide();
    $('#hideButton').hide();
    $('#addButton').show();
  })

  $('.relation').on('change',() => {
      $('#lead_customer_id').empty();
      var relation = $('.relation').val();
      if (relation == 'Customer') {
          var url = "{{url('api/task/getCustomers')}}";
      } else {
          var url = "{{url('api/task/getLeads')}}";
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
          /* remind that 'data' is the response of the AjaxController */
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

});



  function billable_modal(id){
    // is a function
      if ($(`#billable_modal${id}`).is(":checked")) {
        $(`#bill_amount_modal${id}`).show();
      }else{
        $(`#bill_amount_modal${id}`).hide();
      }
  }

  $('select').select2({
    width:'100%'
  });

  var repeat_window = `
  <div class="card" id="repeat_window">
    <div class="card-body bgcolor1">
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
  $('#repeat_task').on('change',() => {
      if (!$("#repeat_task").is(":checked")) {
        $('#repeat_window_show').empty();
      }else{
        $('#repeat_window_show').append(repeat_window);
      }
  })
  
  $('#is_all_day').on('change',() => {
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
      let choice = confirm("Are you sure, you want to delete this task and related data ?")
      if (choice) {
          document.getElementById('delete-task-' + id).submit();
      }
  }

function update_relation(task_id){
  var relation = $(`#relation_modal${task_id}`).val();
  if(relation == 'Lead'){
    getLeads(task_id);
  }
  else if(relation == 'Customer'){
      getCustomers(task_id);
  }
}	
function getLeads(task_id){
  var task_lead_id = "{{@$task->lead_id}}";
  var url="{{url('api/task/getLeads')}}";
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      
    }
  });
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'JSON',
    success: function (data) { 
          $(`#lead_customer_id_modal${task_id}`).empty();
      data.leads.forEach(lead => {
        if(task_lead_id == lead.id){
          var selected = 'selected';
        }else{
          var selected = '';
        }
        let tmp = `<option value="${lead.id}" ${selected}>${lead.first_name} ${lead.last_name} ${lead.email}</option>`;
        $(`#lead_customer_id_modal${task_id}`).append(tmp);
      });
    }
  });    
}

function getCustomers(task_id){
  var task_lead_id = "{{@$task->lead_id}}";
  var url="{{url('api/task/getCustomers')}}";
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      
    }
  });
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'JSON',
    success: function (data) { 
          $(`#lead_customer_id_modal${task_id}`).empty();
      data.contacts.forEach(lead => {
        if(task_lead_id == lead.id){
          var selected = 'selected';
        }else{
          var selected = '';
        }
          let tmp = `<option value="${lead.id}" ${selected}>${lead.username} ${lead.email}</option>`;
          $(`#lead_customer_id_modal${task_id}`).append(tmp);
        });
    }
  });    
}

function is_all_day_modal(task_id){
  if ($(`#is_all_day_modal${task_id}`).is(":checked")) {
    $(`#is_all_day_show_modal${task_id}`).empty();
    $(`#start_time${task_id}`).remove();
    $(`#end_time${task_id}`).remove();
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
    $(`#is_all_day_show_modal${task_id}`).append(tmp);
  }
}

var repeat_window = `
  <div class="card" id="repeat_window">
    <div class="card-body bgcolor1">
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