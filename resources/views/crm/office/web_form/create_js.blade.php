<script>
  $(function(){
    'use strict';

    let player = document.getElementById("formfields");
    new Sortable(player,{
      handle:'.handleField',
      animation:200
    });

  }); 
  
  var added_fields = [];

$('#submitForm').on('click', ()=>{
  appendFormData();
});

function underscoreToCC(myString){
  var i, frags = myString.split('_');
  for (i=0; i<frags.length; i++) {
    frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1);
  }
  return frags.join(' ');
}

$(`#heading`).on('keyup', function(){
  var heading = '';
  var heading = $(`#heading`).val();
  $('#showheading').empty();
  $('#showheading').append(heading);
  // 
});
$(`#note`).on('keyup', function(){
  var note = '';
  var note = $(`#note`).val();
  $('#shownote').empty();
  $('#shownote').append(note);
});

function addField(id) {
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
      var field_name = underscoreToCC(data.field.name);
      if (data.field.type == 'submit') {
        var field = `
        <div class="pt-2 form-group" id="addedfield${id}">
          <input type='submit' value="${(data.field.name)}"  class="handleField ${data.field.cssclass}">
        </div> 
        `;
      }else{
        var field = `
          <div style="margin-bottom:5px;" id="addedfield${id}" class="form-group">
            <label>${field_name} ${requiredLable}</label>  
            <input type="${data.field.type}" name="${(data.field.name)}" class="handleField ${data.field.cssclass}" id="${data.field.id}" placeholder="${placeholder}" autocomplete="Mandala" ${required} /> 
          </div> 
        `;
      }
      
    $('#formfields').append(field);
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
}

</script>