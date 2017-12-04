<?php
	
	$errors = array();
	$uploadedFiles = array();
	$extension = array("jpeg","jpg","png","gif");
	$bytes = 1024;
	$KB = 1024;
	$totalBytes = $bytes * $KB;
	$UploadFolder = "img";
	
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
		
		if(file_exists($UploadFolder."/".$name) == true){
			$UploadOk = false;
			array_push($errors, $name." file is already exist.");
		}
		
		if($UploadOk == true){
			move_uploaded_file($temp,$UploadFolder."/".$counter.".".$path_parts['extension']);
			array_push($uploadedFiles, $name);
		}
	}

	$response = array();
	
	if($counter>0){
		if(count($errors)>0)
		{
			$error_array = array();
			foreach($errors as $error)
			{
				array_push($error_array, $error);
			}
			$response["errors"] = $error_array;
			$response["status"] = 0;
			$response["message"] = "Error With File Upload";
		}
		
		if(count($uploadedFiles)>0){
			$arr = array();
			$counter = 1;
			foreach($uploadedFiles as $fileName)
			{
				array_push($arr, $fileName);
			}
			$response["fileNames"] = $arr;
			$response["status"] = 1;
			$response["message"] = "Files Uploaded Successfully";
			$response["count"] = count($uploadedFiles);
		}								
	}

	echo json_encode($response);
?>
