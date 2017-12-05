<?php
	session_start();

	if (!isset($_SESSION['email'])) {
		exit(header("Location:index.php"));
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Order History";
			include "partials/header.php";
		?>
	</head>
	<body>
		<div class="container-fluid">
			<?php include "partials/navbar.php"; ?>
			<div class="col-md-8 col-md-offset-2" id="orders">
				<h3>Your reservation history</h3>
				<?php 
					include "partials/db_connect.php";
					openDatabaseConnection();
					$email = $_SESSION["email"];

					if($email) {
						echo '<table class="table table-striped table-condensed">';
						echo '<tr><th>Room</th><th>Reservation placed</th><th>Stay began</th><th>Stay ended</th><th>Cost</th></tr>';
						$resQuery = "SELECT * FROM reservation WHERE useremail = '$email' ORDER BY timeplaced DESC";
						$resResult = mysqli_query($link, $resQuery);
						while($row = mysqli_fetch_array($resResult)) {
							echo '<tr>';
							$id = $row["roomid"];
							$roomQuery = "SELECT name FROM room WHERE id = $id";
							$roomResult = mysqli_query($link, $roomQuery);
							$roomRow = mysqli_fetch_array($roomResult);
							echo '<td>'.$roomRow["name"].'</td>';
							echo '<td>'.$row["timeplaced"].'</td>';
							echo '<td>'.$row["checkin"].'</td>';
							echo '<td>'.$row["checkout"].'</td>';
							echo '<td>$'.$row["cost"].'</td>';
							echo '</tr>';
						}
						echo '</table>';
					} else {
						echo "<p>You are not logged in</p>";
					}
					
					closeDatabaseConnection();
				?>
			</div>
		</div>
		<?php 
			include "partials/footer.php";
		?>
	</body>
</html>
