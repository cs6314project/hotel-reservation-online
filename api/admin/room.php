<?php
	session_start();

	$operation = $_POST["operation"];
	$response = array();

	if (isset($_SESSION['is_admin'])) {
		include "../../partials/db_connect.php";
		openDatabaseConnection();

		$name = $_POST["room_name"];
		$price = $_POST["price"];
		$numbeds = $_POST["numbeds"];
		$bedsize = $_POST["bedsize"];
		$maxoccupants = $_POST["maxoccupants"];
		$description = $_POST["description"];
	
		$errors = array();
		$uploadedFiles = array();
		$extension = array("jpeg","jpg","png","gif");
		$bytes = 1024;
		$KB = 1024;
		$totalBytes = $bytes * $KB;
		$UploadFolder = "img";

		$counter = 0;

		if($operation == "add") {
			// Add Room
			$sql_add_room = "INSERT INTO room(name, price, numbeds, bedsize, maxoccupants, description) VALUES('$name', $price, $numbeds, '$bedsize', $maxoccupants, '$description')";
		
			$result_add_room = mysqli_query($link, $sql_add_room);
	
			if($result_add_room) {
				// echo "Inserted. ";
	
				$new_insert_id = mysqli_insert_id($link);
				// printf ("New Record has id %d.\n", $new_insert_id);
	
				// Create a folder in img
	
				// on success update the image_folder
				// echo "<br>";
				$folder_name = "room".$new_insert_id;
				$path = "../../img/".$folder_name;
				
				// echo $path;
	
				if(!file_exists($path)){
					if(mkdir($path)){
						$sql_update_img_folder = "UPDATE room SET img='$folder_name' WHERE id=$new_insert_id";
						
						$result_update_img_folder = mysqli_query($link, $sql_update_img_folder);
						
						if($result_update_img_folder) {
							// echo "<br>Updated. ";
							$response = array("status" => 1, "message" => "Updated");

							foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
								$temp = $_FILES["files"]["tmp_name"][$key];
								$name = $_FILES["files"]["name"][$key];
						
								$path_parts = pathinfo($name);
								
								if(empty($temp))
								{
									break;
								}
								
								$counter++;
								$UploadOk = true;
								
								if($_FILES["files"]["size"][$key] > $totalBytes)
								{
									$UploadOk = false;
									array_push($errors, $name." file size is larger than the 1 MB.");
								}
								
								$ext = pathinfo($name, PATHINFO_EXTENSION);
								if(in_array($ext, $extension) == false){
									$UploadOk = false;
									array_push($errors, $name." is invalid file type.");
								}
								
								if(file_exists($path."/".$counter.".".$path_parts['extension']) == true){
									$UploadOk = false;
									array_push($errors, $name." file is already exist.");
								}
								
								if($UploadOk == true){
									move_uploaded_file($temp,$path."/".$counter.".".$path_parts['extension']);
									array_push($uploadedFiles, $name);
								}
							}
						} else {
							echo "<br>Could not update";
						}
					} else {
						echo "<br>Could not create directory";					
					}
				} else {
					echo "<br>Directory exists";
				}
			} else {
				echo "<br>Could not insert";
			}
		}

		// Delete Room

		// Edit Room

		// Get All Rooms
	// } else {
		// Get Rooms
		closeDatabaseConnection();
	}

	echo json_encode($response);
	
?>
