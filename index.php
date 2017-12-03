<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Home";
			include "partials/header.php";
		?>
		<link rel="stylesheet" href="css/datepicker.css">
	</head>
	<body>
		<?php
			$header_active_link = "about";
			include "partials/navbar.php";
			include "partials/searchbar.php";
		?>

		<?php
			include "partials/footer.php";
		?>
		<script src="js/bootstrap-datepicker.js"></script>
		<script>
			$('.input-daterange input').each(function () {
				$(this).datepicker();
			});
		</script>
	</body>
</html>
