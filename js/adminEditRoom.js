$(document).ready(function() {
	$("#editRoomForm").ajaxForm( {
		dataType:"json",
		beforeSend:function() {

		},
		uploadProgress:function(event, position, total, percentComplete) {
			var pVel=percentComplete+"%";
			// divProgressBar.width(pVel);
		},
		complete:function(data){
			data = JSON.parse(data.responseText);
			console.log(data);
			if(data.status == 1) {
				window.location.href = "search.php";
			}
		}
	});


});
