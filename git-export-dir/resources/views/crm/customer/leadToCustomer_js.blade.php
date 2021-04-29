<script>

  $(function(){
    "use strict";

    $('#languages').select2({
      width: '100%'
    });
    $('#industries').select2({
      width: '100%'
    });
  
    $('#countries').select2({
      width: '100%'
    }).trigger('change');

    $('#states').select2({
      width: '100%'
    });
  
    $('#cities').select2({
      width: '100%'
    });

  });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      
    }

    //On Country Change
    $('#countries').on('change', function () {
        var id = $('#countries').select2('data')[0].id;
        $('#states').val(null);
        $('#states option').remove();

        var stateSelect = $('#states');
        $.ajax({
            type: 'GET',
            url: "{{url('api/getStates')}}/" + id
        }).then(function (data) {
            // create the option and append to Select2
            for (i = 0; i < data.length; i++) {
                var item = data[i]
                var option = new Option(item.name, item.id, false, false);
                stateSelect.append(option);
            }
            stateSelect.trigger('change');
        });
    })

      //On state Change
      $('#states').on('change', function () {
          var id = $('#states').select2('data')[0].id;
          var citySelect = $('#cities');
          $('#cities').val(null);
          $('#cities option').remove();
          $.ajax({
              type: 'GET',
              url: "{{url('api/getCities')}}/" + id
          }).then(function (data) {
              for (i = 0; i < data.length; i++) {
                  var item = data[i]
                  var option = new Option(item.name, item.id, false, false);
                  citySelect.append(option);
              }
          });
          citySelect.trigger('change');
      });


  });

</script>