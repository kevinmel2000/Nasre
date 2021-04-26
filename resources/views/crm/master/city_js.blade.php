<link href="{{asset('css/select2.css')}}" rel="stylesheet"/>
<script src="{{asset('js/select2.js')}}"></script>
<script>
        $(document).ready(function() { $(".e1").select2({ width: '100%' }); });
</script>

<script type="text/javascript">
    
    // $(document).ready(function() {
 
    //   $("#cityTable").DataTable({
    //     "order": [[ 0, "desc" ]],
    //     dom: '<"top"fB>rt<"bottom"lip><"clear">',
    //     lengthMenu: [
    //         [ 10, 25, 50,100, -1 ],
    //         [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
    //     ],
    //           serverSide: true,
    //           ajax: {
    //               url: '{{url('emp_list')}}',
    //               data: function (data) {
    //                   data.params = {
    //                       sac: "helo"
    //                   }
    //               }
    //           },
    //           buttons: false,
    //           searching: true,
    //           scrollY: 500,
    //           scrollX: true,
    //           scrollCollapse: true,
    //           columns: [
    //               {data: "user_id", className: 'uid'},
    //               {data: "first_name", className: 'fname'},
    //               {data: "username", className: 'uname'},
    //               {data: "gender", className: 'gender'}
               
    //           ]  
    //     });
 
    // });
 
</script>

<script type="text/javascript">
    $('#example').DataTable( {
        serverSide: true,
        ordering: false,
        searching: false,
        ajax: function ( data, callback, settings ) {
            var out = [];
 
            for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
                out.push( [ i+'-1', i+'-2', i+'-3', i+'-4', i+'-5' ] );
            }
 
            setTimeout( function () {
                callback( {
                    draw: data.draw,
                    data: out,
                    recordsTotal: 5000000,
                    recordsFiltered: 5000000
                } );
            }, 50 );

        },
        scrollY: 200,
        scroller: {
            loadingIndicator: true
        },
    } );
</script>

<script>
    $(function () {
      "use strict";
  
      var cities = <?php echo(($city_ids->content())) ?>;
      for(const id of cities) {
          var btn = `
              <a href="#" onclick="confirmDelete('${id}')">
                  <i class="fas fa-trash text-danger"></i>
              </a>
          `;
          $(`#delbtn${id}`).append(btn);
      }

      $("#cityTable").DataTable({
        "order": [[ 0, "desc" ]],
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ]
        
      });
  
  
    });
  
    function confirmDelete(id){
        let choice = confirm("{{__('Are you sure, you want to delete this City data and related data?')}}")
        if(choice){
            document.getElementById('delete-city-'+id).submit();
        }
    }
  
  </script>