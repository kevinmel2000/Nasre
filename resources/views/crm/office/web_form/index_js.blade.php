<script>
    $(function(){
    'use strict';
    var forms = <?php echo(($webform_ids->content())) ?>;
    for(const id of forms) {
        var btn = `
            <a href="#" onclick="confirmDelete('${id}')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        `;
        console.log(btn);
        $(`#delbtn${id}`).append(btn);
    }
    
    $('#webformsTable').DataTable();
    var added_fields = [];

  });


  $(`#heading`).on('keyup', function(){
    //   fxn called inside
    var heading = '';
    var heading = $(`#heading`).val();
    $('#showheading').empty();
    $('#showheading').append(heading);
    appendFormData();
  });
  $(`#note`).on('keyup', function(){
    //   fxn called inside
    var note = '';
    var note = $(`#note`).val();
    $('#shownote').empty();
    $('#shownote').append(note);
    appendFormData();
  });

  function addField(id) {
    //   is a fxn
    added_fields.push(id);
    $(`#addField${id}`).hide();
    $(`#removeField${id}`).show();

    url=`{{url('api/office/formfield/${id}')}}`;
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
      }
    });
    $.ajax({
      type: 'GET',
      url: url
    })
    .then(function (data) {
        if (data.field.placeholder == null) {
          var placeholder = '';
        }else{
          placeholder = data.field.placeholder;
        }
        if (data.field.required == 'yes') {
          var requiredLable = "<span style='color:red'>*</span>";
          var required = "required='true'";
        }else{
          var requiredLable = '';
          var required = '';
        }
        if (data.field.type == 'submit') {
          var field = `
          <div class="pt-2" id="addedfield${id}">
            <input type='submit' value="${data.field.name}"  class="handleField ${data.field.cssclass}">
          </div> 
          `;
        }else{
          var field = `
            <div style="margin-bottom:5px;" id="addedfield${id}">
              <label>${data.field.name} ${requiredLable}</label>  
              <input type="${data.field.type}" name="${data.field.name}" class="handleField ${data.field.cssclass}" id="${data.field.id}" placeholder="${placeholder}" autocomplete="Mandala" ${required} /> 
            </div> 
          `;
        }
        
      $('#form').append(field);
      appendFormData();  
    });
  }

  function appendFormData(){
    var formdata = $('#form').html();
      $('#formdata').val('');
      $('#formdata').val(formdata);
  }

  function removeField(id){
    const new_fields = added_fields.filter(data => data != id );
    added_fields = new_fields;
    $(`#addField${id}`).show();
    $(`#removeField${id}`).hide();
    $(`#addedfield${id}`).remove();
    appendFormData(); 
  }

  function confirmDelete(id){
      let choice = confirm("{{__('Are You sure, you want to delete this form ?')}}")
      if(choice){
          document.getElementById('delete-web_form-'+id).submit();
      }
  }
</script>