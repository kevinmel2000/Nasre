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

	function copyToClipboard(item) {
					var $temp = $("<input>");
					$("body").append($temp);
					$temp.val(item).select();
					document.execCommand("copy");
					alert("{{__('Link copied to your clipboard:')}} " + item);
					$temp.remove();
	}

	function confirmDelete(id){
		let choice = confirm("{{__('Are You sure, You want to delete this record ?')}}")
		if(choice){
			document.getElementById('delete-reminder-'+id).submit();
		}
	}
</script>