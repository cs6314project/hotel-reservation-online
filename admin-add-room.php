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
			$page_title = "Add Room";
			include "partials/header.php";
		?>
	</head>

	<body>
		<?php
			$header_active_link = "about";
			include "partials/navbar.php";
			include "partials/notifications.php";
		?>

			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="text-center">Add Room</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<form id="addRoomForm" action="api/admin/room.php" method="POST">
							<input type="hidden" name="operation" value="add">
							<div class="row form-group">
								<div class="col-xs-12 col-md-3">
									<label for="imagesInput">Select files to upload:</label>
									<input type="file" id="imagesInput" name="files[]" multiple="multiple">
									<p class="help-block">
										<span class="label label-info">Note:</span> Please, Select the only images (.jpg, .jpeg, .png, .gif) to upload with the size of 100KB only.</p>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-12 col-md-3">
									<label for="roomName">Room Name</label>
									<input type="text" class="form-control" id="roomName" name="room_name" placeholder="Room Name" autofocus="true" required>
									<div class="info"></div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-12 col-md-3">
									<label for="price">Price/Night in Dollars($)</label>
									<input type="number" class="form-control" id="price" name="price" placeholder="Price" required>
									<div class="info"></div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-12 col-md-3">
									<label for="numbeds">Number of Beds</label>
									<input type="number" class="form-control" id="numbeds" name="numbeds" placeholder="Beds" required>
									<div class="info"></div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-12 col-md-3">
									<label for="bedsize">Bed Size</label>
									<select id="bedsize" name="bedsize" class="form-control">
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
									<input type="number" class="form-control" id="maxoccupants" name="maxoccupants" placeholder="Max" required>
									<div class="info"></div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-12 col-md-3">
									<p>Room options:</p>
									<input type="checkbox" id="wifi" name="wifi" />
									<label for="wifi">Wireless internet</label>
									<br />
									<input type="checkbox" id="tv" name="tv" />
									<label for="tv">Premium TV channels</label>
									<br />

									<p>Smoking options:</p>
									<input type="radio" name="smoking" value="nosmoking" />
									<label for="smoking">Non-smoking</label>
									<br />
									<input type="radio" name="smoking" value="smoking" />
									<label for="smoking">Smoking</label>
									<br />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-xs-12 col-md-3">
									<label for="description">Description</label>
									<textarea name="description" id="description" rows="8" class="form-control" required></textarea>
									<div class="info"></div>
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Add Room</button>
						</form>
					</div>
				</div>
			</div>

			<!-- Image Modal -->
			<div class='modal fade' id='accountProfilePictureModal' tabindex='-1' role='dialog' aria-labelledby='accountProfilePictureModal'
			    aria-hidden='true' data-backdrop='static'>
				<div class='modal-dialog modal-md'>
					<div class='modal-content'>

						<form class='form-horizontal' method='POST' action='api/admin/uploadImage.php' enctype='multipart/form-data' id='accountProfilePictureForm'>

							<div class='modal-header'>

								<div class='btn-group pull-left'>
									<a class='btn btn-danger' data-dismiss='modal'>
										<span class='glyphicon glyphicon-remove'></span>

									</a>
								</div>

								<div class='btn-group pull-right'>
									<button type='submit' class='btn btn-success'>
										<span class='glyphicon glyphicon-ok'></span>

									</button>
								</div>

								<h4 class='modal-title text-center'>
									Edit Image
								</h4>
							</div>

							<div class='modal-body'>
								<input type='text' class='hidden' name='mode' id='accountPhotoId' value='A' />

								<div class='form-group row account-img-modal'>
									<center>
										<div class='col-sm-12 col-md-12'>
											<div class='col-lg-6 col-md-6 col-sm-5'>
												<label class='control-label'>Select Image</label>
												<br>
												<br>
												<div class='input-group'>
													<input id='accountImgInputPath' name='accountImgInputPath' class='form-control' placeholder='Choose File' disabled='disabled'
													/>
													<div class='input-group-btn'>
														<div class='fileUpload btn btn-primary'>
															<span>Upload</span>
															<input type='file' id='accountProfileImgInput' name='fileToUpload' class='upload' style='padding-bottom:10px;' required />
														</div>
													</div>
												</div>
												<p id='accountProfileImageErrorMsg' class='info'></p>

												<div class='delete-btn-padding'>
													<button type='button' class='btn btn-danger' id='accountProfileDeleteImageBtn' onclick='app.deleteAccountProfilePicture();'>
														Delete Image
													</button>
												</div>
											</div>
											<div class='col-lg-6 col-md-6 col-sm-4'>
												<label class='control-label'>Image Preview</label>
												<br>
												<br>
												<img id='accountProfileImagePreview' class='addImage'>
											</div>
										</div>
									</center>
								</div>
							</div>
						</form>
						<div class='progress hidden' id='navbarProgress'>
							<div class='progress-bar' id='navbarProgressBar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'
							    style='width: 0%;'>
								<span class='sr-only' id='navbarProgressValue'>0% Complete</span>
							</div>
						</div>
					</div>
					<!--modal-content-->
				</div>
			</div>
			<!--modal-->

			<?php
			include "partials/footer.php";
		?>
				<script src="js/adminAddRoom.js"></script>
	</body>

	</html>