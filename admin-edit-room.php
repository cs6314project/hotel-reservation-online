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
						$fQuery = "SELECT feature FROM roomfeatures WHERE roomid=$roomid";
						$fResult = mysqli_query($link, $fQuery);
						$features = array();
						while($featureArr = mysqli_fetch_assoc($fResult))
							$features[] = $featureArr["feature"];
			?>
			<div class="row">
				<div class="col-xs-12">
					<form id="editRoomForm" action="api/admin/room.php" method="POST">
						<input type="hidden" name="operation" value="edit">
						<input type="hidden" name="roomid" value="<?=$roomid ?>">
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="roomName">Room Name</label>
								<input type="text" class="form-control" id="roomName" name="room_name" placeholder="Room Name" autofocus="true" value="<?=$row_room_data["name"] ?>" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="imagesInput">Select files to upload:</label>
								<input type="file" id="imagesInput" name="files[]" multiple="multiple">
								<p class="help-block"><span class="label label-info">Note:</span> Please, Select the only images (.jpg, .jpeg, .png, .gif) to upload with the size of 100KB only.</p>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
							<p>Check photos to keep: </p>
							<?php
								$path = "./img/".$row_room_data["img"];
								$files = array_diff(scandir($path), array('.', '..', '.DS_Store'));
								$counter = 1;
								foreach($files as $key => $value) {
							?>
							<div class="checkbox">
								<label>
									<img src="<?=$path."/".$value ?>" width="100" height="100">
									<input type="checkbox" id="img<?=$counter ?>" name="fileList[]" value="<?=$value ?>"> <?=$value ?>
								</label>
							</div>
							<?php
									$counter++;
								}
							?>
							<input name="counterForOriginalFiles" type="hidden" value="<?=($counter-1) ?>">
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
							<input type="checkbox" id="wifi" name="wifi" <?php if(in_array("wifi", $features)) echo 'checked'; ?>/>
								<label for="wifi">Wireless internet</label>
								<br />
								<input type="checkbox" id="tv" name="tv" <?php if(in_array("tv", $features)) echo 'checked'; ?>/>
								<label for="tv">Premium TV channels</label>
								<br />

								<p>Smoking options:</p>
								<input type="radio" name="smoking" value="nosmoking" <?php if(in_array("nosmoking", $features)) echo 'checked'; ?>/>
								<label for="smoking">Non-smoking</label>
								<br />
								<input type="radio" name="smoking" value="smoking" <?php if(in_array("smoking", $features)) echo 'checked'; ?>/>
								<label for="smoking">Smoking</label>
								<br />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="description">Description</label>
								<textarea name="description" id="description" rows="8" class="form-control" required><?=$row_room_data["description"] ?></textarea>
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
