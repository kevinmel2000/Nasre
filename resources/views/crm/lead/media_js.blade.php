<script>

	$(function(){
	"use strict";
			var media = <?php echo(($media_ids->content())) ?>;
			for(const id of media) {
					var btn = `
							<a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('${id}')">
									<i class="fas fa-trash"></i> Delete
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
			alert("{{__('Link copied to your clipboard:')}}" + item);
			$temp.remove();
	}

	function confirmDelete(id){
		let choice = confirm("{{__('Are you sure, you want to delete this record?')}}")
		if(choice){
			document.getElementById('delete-item-'+id).submit();
		}
	}
</script>