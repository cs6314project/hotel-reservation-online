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
	<body id="index">
		<?php
			$header_active_link = "about";
			include "partials/navbar.php";
		?>
		<div id="search-section">
			<div id="index-searchbar">
			<?php
			include "partials/searchbar.php";
			?>
			</div>
		</div>

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
