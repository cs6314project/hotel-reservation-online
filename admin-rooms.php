<?php
	session_start();

	if (!isset($_SESSION['is_admin'])) {
		exit(header("Location:index.php"));
	}

	include "partials/db_connect.php";
	include "partials/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Rooms";
			include "partials/header.php";
		?>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script src="https://use.fontawesome.com/5ca19d8c97.js" defer></script>
	</head>
	<body>
		<?php
			$header_active_link = "about";
			include "partials/navbar.php";
		?>
		<div class="container-fluid">
			<div class="col-md-8 col-md-offset-2">
				<?php
					openDatabaseConnection();
					$sql_rooms = "SELECT * FROM Room WHERE deleted=0";

					$result_rooms = mysqli_query($link, $sql_rooms);

					if($result_rooms->num_rows > 0) {
						while ($row_rooms = mysqli_fetch_assoc($result_rooms)) {
				?>
				<div class="row room center-block">
					<img src="img/room<?=$row_rooms["id"] ?>/1.jpg" alt="<?=$row_rooms["name"] ?>">
					<div class="book-form">
						<p>$<?=$row_rooms["price"] ?>/night</p>
						<a href="editRoom.php?roomid=<?=$row_rooms["id"] ?>" class="btn btn-primary">Edit Room</a><br><br>
						<button onclick="pageAdminRooms.openDeleteModal(<?=$row_rooms["id"] ?>, '<?=$row_rooms["name"] ?>');" class="btn btn-danger">Delete Room</button>
					</div>
					<h3><?=$row_rooms["name"] ?></h3>
					<p><?=$row_rooms["numbeds"] ?> <?=$row_rooms["bedsize"] ?> size beds, up to <?=$row_rooms["maxoccupants"] ?> occupants</p>
					<ul>
						<li>
							<i class="material-icons md-18">smoking_rooms</i>Allows Smoking
						</li>
						<li>
							<i class="material-icons md-18">tv</i>Premium TV channels
						</li>
						<li>
							<i class="material-icons md-18">wifi</i>Free Wireless Internet
						</li>
					</ul>
				</div>
				
				<?php
						}
					} else {
						echo "<h3 class='text-center'>No Rooms in the Database</h3>";
					}
				?>
			</div>
		</div>

		<a id="stickyBtnAddRoom" href="admin-add-room.php" class="btn btn-success btn-lg">
			<i class="glyphicon glyphicon-plus"></i> Add Room
		</a>

		<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="deleteModalTitle">Delete Room?</h4>
					</div>
					<form action="admin-delete-room.php" method="POST">
						<div class="modal-body">
							<p>Do you want to delete the Room named, <span id="deleteModalRoomName"></span>?</p>
							<input type="hidden" id="deleteModalRoomId" name="roomid">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-danger">Delete Room</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<?php

			closeDatabaseConnection();
			include "partials/footer.php";
		?>
		<script src="js/adminRooms.js"></script>
	</body>
</html>
