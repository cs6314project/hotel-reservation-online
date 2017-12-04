<?php
	session_start();

	if (!isset($_SESSION['is_admin'])) {
		exit(header("Location:index.php"));
	}

	include "partials/db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Delete Room";
			include "partials/header.php";
		?>
	</head>
	<body>
		<?php
			$header_active_link = "about";
			include "partials/navbar.php";
		?>
		
		<?php
			$roomid = $_POST["roomid"];

			openDatabaseConnection();

			$sql_update_deleted = "UPDATE room SET deleted=1 WHERE id=$roomid";
			$result_update_deleted = mysqli_query($link, $sql_update_deleted);

			/*$sql_remove_roomfeatures = "DELETE FROM roomfeatures WHERE roomid=$roomid";
			$result_remove_roomfeatures = mysqli_query($link, $sql_remove_roomfeatures);

			if ($result_remove_roomfeatures) {
				$sql_remove_room = "DELETE FROM room WHERE id=$roomid";
				$result_remove_room = mysqli_query($link, $sql_remove_room);

				if ($result_remove_room) {
					echo "<div class='text-center'><h3>Room deletetion successfull</h3><br>";
					echo "<a href='admin-rooms.php'><- Go Back</a></div>";
				} else {
					echo "<h3>could not delete room</h3>";
				}
			} else {
				echo "could not Delete room feature";
			}*/

			if ($result_update_deleted) {
				echo "<div class='text-center'><h3>Room deletetion successfull</h3><br>";
				echo "<a href='search.php'><- Go Back</a></div>";
			} else {
				echo "Could not Delete Room";
			}

			closeDatabaseConnection();
		?>
		
		<?php
			include "partials/footer.php";
		?>
	</body>
</html>
