<link href="{{url('/')}}/css/select2.css" rel="stylesheet"/>
<script src="{{url('/')}}/js/select2.js"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>

<script type="text/javascript">
     $('#shipcode').change(function(){
        var id = $(this).val();
        var url = '{{ route("shipDetails", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(response){
                if(response != null){
                    $('#shipname').val(response.shipname);
                }
            }
        });
    });
</script>

<script>
    $(function () {
      "use strict";
  
      var marineslip = <?php echo(($ms_ids->content())) ?>;
      for(const id of marineslip) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }
  
  
      $("#marineSlip").DataTable({
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
      });
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this product and related data?')}}")
        if(choice){
            document.getElementById('delete-country-'+id).submit();
        }
    }
  
</script>

<div class="modal fade" id="ModalAddShip" tabindex="-1" user="dialog" aria-hidden="true">
    <div class="modal-dialog" user="document">
        <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
            <h5 class="modal-title">{{__('Ship Detail')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="POST">
            <div class="modal-body">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-md-12 col-md-12">
                        <div class="form-group">
                            <label for="">{{__('Ship Code')}}</label><br>
                            <select name="shipcode" id="shipcode" class="form-control form-control-sm e1">
                                <option selected disabled>{{__('Select Ship Code')}}</option>
                                @foreach($mlu as $mrnlu)
                                    <option value="{{  $mrnlu->id }}">{{  $mrnlu->code  }} - {{ $mrnlu->shipname }}</option>
                                    {{-- @if($location->country_id  == $cty->id)
                                    <option value="{{ $mrnlu->id }}" selected>{{ $mrnlu->code }} - {{ $mrnlu->shipname }}</option>
                                    @else
                                    <option value="{{  $mrnlu->id }}">{{  $mrnlu->code  }} - {{ $mrnlu->shipname }}</option>
                                    @endif --}}
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-md-12">
                        <div class="form-group">
                        <label for="">{{__('Ship Name')}}</label>
                        <input type="text" name="shipname" id="shipname" class="form-control" value="" required/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <input type="submit" class="btn btn-info" value="Add Ship">
            </div>
        </form>
        </div>
    </div>
</div>