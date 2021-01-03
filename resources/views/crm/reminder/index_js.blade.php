<script>
   $(function(){
       'use strict';
       var reminders = <?php echo(($reminder_ids->content())) ?>;
        for(const id of reminders) {
            var btn = `
                <a href="#" onclick="confirmDelete('${id}')">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            `;
            $(`#delbtn${id}`).append(btn);
        }
   }); 
    

  $('#remindersTable').DataTable( {
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
                columns: [ 0, 1, 2, 3, 4, 5]
            }
        },
        {
            extend: 'csv',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5]
            }
        },
        {
            extend: 'excel',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5]
            }
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5]
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5]
            }
        },
    ]
  } );	

    $('select').select2({
    width:'100%'
    });
  
    // On update relation in the modal
    function update_relation(reminder_id){
        var relation_val = $(`#relation${reminder_id}`).val();
        if (relation_val == 'Customer') {
            getCustomers(reminder_id);
        } else {
            getLeads(reminder_id);
        }
    }
  
  
  function getLeads(reminder_id){
   var reminder_lead_id = "{{@$reminder->lead_id}}";
   var url="{{url('api/reminder/getLeads')}}";
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
        // Empty previous  options
        $(`#lead_customer_id${reminder_id}`).empty();
       data.leads.forEach(lead => {
         let tmp = `<option value="${lead.id}">${lead.first_name} ${lead.last_name} | ${lead.email}</option>`;
         
         $(`#lead_customer_id${reminder_id}`).append(tmp);
       });
     }
   });    
  }
    function getCustomers(reminder_id){
        var reminder_customer_id = "{{@$reminder->customer_id}}";
        var url="{{url('api/reminder/getCustomers')}}";
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
                // Empty previous  options
                $(`#lead_customer_id${reminder_id}`).empty();
                data.customers.forEach(customer => {
                    let tmp = `<option value="${customer.id}">${customer.username}</option>`;
                $(`#lead_customer_id${reminder_id}`).append(tmp);
                });
            }
        });    
    }
  
    // SECTION Get Customers or Leads as per relation 
    $('.relation').change(() => {
        $('#lead_customer_id').empty();
        var relation = $('.relation').val();
        if (relation == 'Customer') {
            url = "{{url('api/reminder/getCustomers')}}";
        } else {
            url = "{{url('api/reminder/getLeads')}}";
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
                            `<option value="${lead.id}">${lead.first_name} ${lead.last_name} | ${lead.email}</option>`;
                        $('#lead_customer_id').append(tmp);
                    });
                }
            }

        });
    });
  

    // For modal date and time picker
    function dateChange(id){
    $(`#date${id}`).datetimepicker({
        format: 'DD/MM/YYYY'
        });
    }
    function timeChange(id){
    $(`#time${id}`).datetimepicker({
        format: 'LT'
        });
    }

    $(function () {
        $('#date').datetimepicker({
        format: 'DD/MM/YYYY'
        });
        $('#time').datetimepicker({
            format: 'LT',
        });
    });

    function confirmDelete(id) {
        let choice = confirm("{{__('Are you sure, you want to delete this reminder and related data ?')}}")
        if (choice) {
            document.getElementById('delete-reminder-' + id).submit();
        }
    }
  </script>