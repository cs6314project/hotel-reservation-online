<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Let's Go!";
			include "partials/header.php";
		?>
	</head>
	<body>
		<?php
			$header_active_link = "about";
			include "partials/navbar.php";
		?>
		<h1>Welcome to the Hotel Reservation</h1>

		<?php
			include "partials/footer.php";
		?>
	</body>
</html>
