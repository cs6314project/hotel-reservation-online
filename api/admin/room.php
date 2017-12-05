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

		$wifi = $_POST["wifi"];
		$tv = $_POST["tv"];
		$smoking = $_POST["smoking"];
	
		$errors = array();
		$uploadedFiles = array();
		$extension = array("jpeg","jpg","png","gif");
		$bytes = 1024;
		$KB = 1024;
		$totalBytes = $bytes * $KB;
		$UploadFolder = "img";

		if($operation == "add") {
			// Add Room
			$sql_add_room = "INSERT INTO room(name, price, numbeds, bedsize, maxoccupants, description) VALUES('$name', $price, $numbeds, '$bedsize', $maxoccupants, '$description')";
		
			$result_add_room = mysqli_query($link, $sql_add_room);
	
			if($result_add_room) {
				// echo "Inserted. ";
	
				$new_insert_id = mysqli_insert_id($link);

				if(isset($wifi) && $wifi=="on")
					mysqli_query($link, "INSERT INTO roomfeatures (roomid, feature) VALUES ($new_insert_id, 'wifi')");
				if(isset($tv) && $tv=="on")
					mysqli_query($link, "INSERT INTO roomfeatures (roomid, feature) VALUES ($new_insert_id, 'tv')");
				
				if(isset($smoking)) {
					if($smoking="smoking") {
						mysqli_query($link, "INSERT INTO roomfeatures (roomid, feature) VALUES ($new_insert_id, 'smoking')");
					} else {
						mysqli_query($link, "INSERT INTO roomfeatures (roomid, feature) VALUES ($new_insert_id, 'nosmoking')");
					}
				}
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

							$counter = 0;

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
		} else if($operation == "edit") {
			$modifiedfileList = $_POST["fileList"];
			if(!$modifiedfileList) $modifiedfileList = array();
			$counterForOriginalFiles = $_POST["counterForOriginalFiles"];

			$roomid = $_POST["roomid"];

			$sql = "UPDATE room SET name='$name', price=$price, numbeds=$numbeds, bedsize='$bedsize', maxoccupants=$maxoccupants, description='$description'  WHERE id=".$roomid;

			$result_update = mysqli_query($link, $sql);

			$wifiQ = "INSERT IGNORE INTO roomfeatures (roomid, feature) VALUES ($roomid, 'wifi')";
			$tvQ = "INSERT IGNORE INTO roomfeatures (roomid, feature) VALUES ($roomid, 'tv')";
			$smQ = "INSERT IGNORE INTO roomfeatures (roomid, feature) VALUES ($roomid, 'smoking')";
			$nsmQ = "INSERT IGNORE INTO roomfeatures (roomid, feature) VALUES ($roomid, 'nosmoking')";

			if(isset($wifi) && $wifi=="on")
				mysqli_query($link, $wifiQ);
			else 
				mysqli_query($link, "DELETE FROM roomfeatures WHERE roomid=$roomid AND feature='wifi'");

			if(isset($tv) && $tv=="on")
				mysqli_query($link, $tvQ);
			else
				mysqli_query($link, "DELETE FROM roomfeatures WHERE roomid=$roomid AND feature='tv'");
		
			if(isset($smoking)) {
				if($smoking=="smoking") {
					mysqli_query($link, $smQ);
					mysqli_query($link, "DELETE FROM roomfeatures WHERE roomid=$roomid AND feature='nosmoking'");
				} else {
					mysqli_query($link, $nsmQ);
					mysqli_query($link, "DELETE FROM roomfeatures WHERE roomid=$roomid AND feature='smoking'");
				}
			}

			if ($result_update) {
				$response = array("status" => 1, "message" => "Updated");
			} else {
				$response = array("status" => 1, "message" => "NOt Updated", "sql" => $sql);
			}

			$folder_name = "room".$roomid;
			$path = "../../img/".$folder_name;

			$files = array_diff(scandir($path), array('.', '..', '.DS_Store'));
			
			$toRemove = array_diff($files, $modifiedfileList);
			
			foreach($toRemove as $key => $value) {
				unlink($path."/".$value);
			}

			$files_counter_calc = array_diff(scandir($path, 1), array('.', '..', '.DS_Store'));

			$counter = explode(".", $files_counter_calc[0])[0];

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

		}

		closeDatabaseConnection();
	}

	echo json_encode($response);
	
?>
