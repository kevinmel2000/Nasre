<script>
    $(function () {
        "use strict";
        var users = <?php echo(($user_ids->content())) ?>;
        for(const id of users) {
            var btn = `
                <a href="#" onclick="confirmDelete('${id}')">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            `;
            $(`#delbtn${id}`).append(btn);
        }

        $('.role_id').select2({
        width:"100%"
        });

        $('#staff_users').DataTable( {
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
                    extend: 'print',
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
            ]
        } );

        
    });

    function confirmDelete(id){
        "use strict";
        let choice = confirm("{{__('Are you sure, you want to delete this record ?')}}")
        if(choice){
            document.getElementById('delete-user-'+id).submit();
        }
    }  
</script>