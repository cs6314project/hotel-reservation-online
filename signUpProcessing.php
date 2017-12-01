<?php
	include "partials/db_connect.php";

    $first_name = trim($_POST["first_name"]);

	$last_name = trim($_POST["last_name"]);
	
	$email = trim($_POST["email"]);

	$password = hash("sha512", $_POST["password"]);
	
	$phone_number = trim($_POST["phone_number"]);

	openDatabaseConnection();
	
	$sql_insert_users = "INSERT INTO users(first_name, last_name, email, password, phone_number, is_admin) VALUES('$first_name', '$last_name', '$email', '$password', '$phone_number', 0)";

	$result_insert_users = mysqli_query($link, $sql_insert_users);
	
	if($result_insert_users) {
		closeDatabaseConnection();
		header("refresh:5;url=login.php");
		echo "Redirecting to Login in 5 seconds";
	}  else {
		closeDatabaseConnection();
		header("Location: signUp.php");
		exit();
	}
?>
