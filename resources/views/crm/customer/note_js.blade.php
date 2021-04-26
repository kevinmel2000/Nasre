<script>
  $(function(){
    "use strict";

    var notes = <?php echo(($note_ids->content())) ?>;
    for(const id of notes) {
        var btn = `
            <a href="#" class="btn btn-danger btn-sm text-light"  onclick="deleteNote('${id}')">
                <i class="fas fa-trash"></i> Delete
            </a>
        `;
        $(`#delbtn${id}`).append(btn);
    }

    $('#addNewNote').on('click',()=>{
      var field = `<div class=''>
        <div class='form-group'>
          <textarea name='note' class='form-control' id='note' rows="7" placeholder='Enter new note here'></textarea>
        </div>
        <div class='form-group'>
          <button type="button" id="note_submit" onclick='postNote()' class="btn btn-primary btn-sm">Add Note</button>
        </div>
        </div>`;
      $('#noteField').append(field).focusin();
    })
  });

  function postNote(){
    var note = $('#note').val();
    var customer = "{{@$customer->id}}"
    $('#noteField').empty();

    var url="{{url('api/customer/note')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      data: {note:note, customer_id:customer},
      dataType: 'JSON',
      success: function (data) { 
        if (data.status == 'error') {
          return toastr.error(data.message);
        }else{
          var created_at = data.note.created_at;
          var newNote = 
          `
          <div class="card" id='noteCard${data.note.id}'>
            <div>
              <div class="card-item">
                <p class="card-header">Added By- ${data.user} 
                <span class="float-right">
                  ${created_at}
                </span>
                </p>
                <div class="card-body">
                  ${data.note.note}
                </div>
                <div class="card-footer">
                  <a class="btn btn-danger btn-sm text-light" onclick="deleteNote(${data.note.id})">Delete</a>
                </div>
              </div>
            </div>
          </div> 
          `;
          $('#newNotes').prepend(newNote);
          return toastr.success(data.message);
        }
      },
      error: function(err){
        return toastr.error(err.responseJSON.message);
      }
    });

  }

  function deleteNote(note_id){
    var _confirm = confirm('Are you sure, you want to delete this note?');
    if(_confirm){
      var url="{{url('api/customer/note')}}" +"/"+ note_id;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      });
      $.ajax({
        url: url,
        type: 'DELETE',
        dataType: 'JSON',
        success: function (data) { 
          $('#noteCard'+note_id).remove();
          return toastr.success(data.message);
        },
        error: function(err){
          return toastr.error(err.responseJSON.message);
        }
      });
    }else{
      return false;
    }
  }

</script>