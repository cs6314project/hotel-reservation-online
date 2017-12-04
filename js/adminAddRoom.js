var adminAddRoomPage = {

};

$(document).ready(function() {
	$("#addRoomForm").ajaxForm( {
		dataType:"json",
		beforeSend:function() {

		},
		uploadProgress:function(event, position, total, percentComplete) {
			var pVel=percentComplete+"%";
			// divProgressBar.width(pVel);
		},
		complete:function(data){
			data = JSON.parse(data.responseText);
			if(data.status == 1) {
				window.location.href = "search.php";
			}
		}
	});


});
