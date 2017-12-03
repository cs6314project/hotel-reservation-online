<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Wishlist";
			include "partials/header.php";
		?>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script src="https://use.fontawesome.com/5ca19d8c97.js" defer></script>
	</head>
	<body>
		<?php 
			include "partials/navbar.php";
		?>
		<div class="container-fluid">

			<div class="col-md-8 col-md-offset-2">
				<?php
					if(isset($_SESSION["email"]))
						echo '<h3>My Favorites</h3><div id="searchresults"></div><div id="pagebuttons"></div>';
					else
						echo "<p>You are not logged in</p>";
				?>
				
			</div>

		</div>
		<?php
			include "partials/footer.php";
		?>
		<script src="js/favorites.js"></script>
	</body>

</html>
