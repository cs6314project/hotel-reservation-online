<?php
	session_start();

	if (!isset($_SESSION['is_admin'])) {
		exit(header("Location:index.php"));
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Edit Room";
			include "partials/header.php";
		?>
	</head>
	<body>
		<?php
			$header_active_link = "about";
			include "partials/navbar.php";
			include "partials/notifications.php";
			include "partials/db_connect.php";
		?>

		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center">Edit Room</h2>
				</div>
			</div>
			<?php
				openDatabaseConnection();
				$roomid = $_POST["roomid"];
				$sql_room_data = "SELECT * FROM Room WHERE id=$roomid";

				$result_room_data = mysqli_query($link, $sql_room_data);

				if($result_room_data->num_rows > 0) {
					while ($row_room_data = mysqli_fetch_assoc($result_room_data)) {
			?>
			<div class="row">
				<div class="col-xs-12">
					<form id="editRoomForm" action="api/admin/room.php" method="POST">
						<input type="hidden" name="operation" value="edit">
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="roomName">Room Name</label>
								<input type="text" class="form-control" id="roomName" name="room_name" placeholder="Room Name" autofocus="true" value="<?=$row_room_data["name"] ?>" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="price">Price/Night in Dollars($)</label>
								<input type="number" class="form-control" id="price" name="price" placeholder="Price" value="<?=$row_room_data["price"] ?>" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="numbeds">Number of Beds</label>
								<input type="number" class="form-control" id="numbeds" name="numbeds" placeholder="Beds" value="<?=$row_room_data["numbeds"] ?>" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="bedsize">Bed Size</label>
								<select id="bedsize" name="bedsize" class="form-control" value="<?=$row_room_data["bedsize"] ?>">
									<option value="Queen">Queen</option>
									<option value="King">King</option>
									<option value="Full">Full</option>
								</select>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="maxoccupants">Maximum Occupants</label>
								<input type="number" class="form-control" id="maxoccupants" name="maxoccupants" placeholder="Max" value="<?=$row_room_data["maxoccupants"] ?>" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="description">Description</label>
								<textarea name="description" id="description" rows="8" class="form-control" value="<?=$row_room_data["description"] ?>" required></textarea>
								<div class="info"></div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
			<?php
					}
				}
				closeDatabaseConnection();
			?>
		</div>
		
		<?php
			include "partials/footer.php";
		?>
		<script src="js/adminEditRoom.js"></script>
	</body>
</html>
