<?php
	session_start();
	
	include "partials/db_connect.php";

    $email = trim($_POST["email"]);

	$password = $_POST["password"];
	
	if(!$email || !$password) {
        session_unset();
        session_destroy(); 
        header("Location: login.php");
        exit();
    } else {
		openDatabaseConnection();

        $sql_users = "SELECT * FROM users WHERE email='".$email."' AND password='".hash("sha512", $password)."'";

		$result_users = mysqli_query($link, $sql_users);
        
        if($result_users->num_rows > 0) {
			while ($row_users = mysqli_fetch_assoc($result_users)) {
				$_SESSION["email"] = $row_users["email"];
				$_SESSION["first_name"] = $row_users["first_name"];
				closeDatabaseConnection();
				header("Location: index.php");
				exit();
			}
        } else {
			closeDatabaseConnection();
            session_unset();
            session_destroy();
			header("Location: login.php");
            exit();
        }
    }
?>
