<?php
	session_start();
	
	include "../partials/db_connect.php";
	include "../partials/functions.php";

    $email = trim($_POST["email"]);

	$password = $_POST["password"];

	$response = array();
	$validate;

	do {
		if (isset($_POST)) {
			$validate = true;
		} else {
			$validate = false;
			$response = createResponse(0, "Invalid");
			break;
		}

		if ($validate && !empty($email) && !empty($password)) {
			$validate = true;
		} else {
			$validate = false;
			$response = createResponse(0, "Required fields are empty");
			break;
		}
	} while (0);
	
	if ($validate) {
		openDatabaseConnection();

        $sql_users = "SELECT * FROM users WHERE email='".$email."' AND password='".hash("sha512", $password)."'";

		$result_users = mysqli_query($link, $sql_users);
        
        if($result_users->num_rows > 0) {
			while ($row_users = mysqli_fetch_assoc($result_users)) {
				$_SESSION["email"] = $row_users["email"];
				$_SESSION["first_name"] = $row_users["first_name"];
				$_SESSION["is_admin"] = $row_users["is_admin"];
				$response = createResponse(1, "Login Successfull");
			}
        } else {
            session_unset();
			session_destroy();
			$response = createResponse(0, "Invalid email or password");
		}

		echo json_encode($response);
		closeDatabaseConnection();
    }
?>
