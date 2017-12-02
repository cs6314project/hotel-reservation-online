<?php
	include "../partials/db_connect.php";
	include "../partials/functions.php";

    $first_name = trim($_POST["first_name"]);

	$last_name = trim($_POST["last_name"]);
	
	$email = trim($_POST["email"]);

	$password = $_POST["password"];

	$confirm_password = $_POST["confirm_password"];
	
	$phone_number = trim($_POST["phone_number"]);

	$validate;
	$response = array();

	//General Validation

	do {
		if (isset($_POST)) {
			$validate = true;
		} else {
			$validate = false;
			$response = createResponse(0, "Invalid");
			break;
		}

		//Required fields validation
		if ($validate && !empty($first_name) && !empty($last_name) && !empty($email) && !empty($password) && !empty($confirm_password) && !empty($phone_number)) {
			$validate = true;
		} else {
			$validate = false;
			$response = createResponse(0, "Required fields are empty");
			break;
		}

		//Email validation
		if ($validate && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$validate = true;
		} else {
			$validate = false;
			$response = createResponse(0, "Invalid email address");
			break;
		}

		//Validate password length
		if (strlen($password) > 7 && strlen($password) < 17) {
			$validate = true;
		} else {
			$validate = false;
			$response = createResponse(0, "Password length should be between 8 to 16 characters");
			break;
		}

		//Validate confirm password and password
		if ($password == $confirm_password) {
			$validate = true;
		} else {
			$validate = false;
			$response = createResponse(0, "Password and confirm password are not similar");
			break;
		}

	} while (0);

	openDatabaseConnection();

	if ($validate) {
		do {
			//Check if mail ID is already registered or not
			$sql_check_user_email = "SELECT * FROM users WHERE email= '" . $email . "';";

			$result_users = mysqli_query($link, $sql_check_user_email);

			if($result_users->num_rows > 0) {
				$validate = false;
				$response = createResponse(0, "This Mail ID is already registered");
				break;
			} else {
				$validate = true;
			}
		} while (0);
	}

	if($validate) {
		$hashed_password = hash("sha512", $password);
		$sql_insert_users = "INSERT INTO users(first_name, last_name, email, password, phone_number, is_admin) VALUES('$first_name', '$last_name', '$email', '$hashed_password', '$phone_number', 0)";
		
		$result_insert_users = mysqli_query($link, $sql_insert_users);
		
		if($result_insert_users) {
			$validate = true;
            $response = createResponse(1, "Your account has been created");
		}  else {
			$validate = false;
            $response = createResponse(0, "Account could not be created");
		}
	}

	echo json_encode($response);
	closeDatabaseConnection();
?>
