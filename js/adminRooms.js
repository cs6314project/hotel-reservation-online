var pageAdminRooms = {
	openDeleteModal: function(id, name) {
		$("#deleteModalRoomName").html(name);
		$("#deleteModalRoomId").val(id);

		$("#deleteModal").modal("show");
	}
};

// Modal to delete room
