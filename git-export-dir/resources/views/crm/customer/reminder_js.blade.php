<script>

	$(function(){
		"use strict";

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

	function confirmDelete(id){
		let choice = confirm("Are you sure, you want to delete this record ?")
		if(choice){
			document.getElementById('delete-item-'+id).submit();
		}
	}
</script>