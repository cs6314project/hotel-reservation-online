<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Search";
			include "partials/header.php";
		?>
		<link rel="stylesheet" href="css/datepicker.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script src="https://use.fontawesome.com/5ca19d8c97.js" defer></script>
	</head>
	<body>
		<div class="container-fluid">
			<?php 
				include "partials/navbar.php";
				include "partials/notifications.php";
				include "partials/searchbar.php";
			?>

			<div class="col-md-3">
				<div data-spy="affix" data-offset-top="60" class="sidebar">
					<h4>Search filters</h4>
					<p>Room features:</p>

					<input type="checkbox" id="wifi" name="wifi" />
					<label for="wifi">Wireless internet</label>
					<br />
					<input type="checkbox" id="tv" name="tv" />
					<label for="tv">Premium TV channels</label>
					<br />

					<p>Smoking options:</p>
					<input type="radio" name="smoking" value="nosmoking"/>
					<label for="smoking">Non-smoking</label>
					<br />
					<input type="radio" name="smoking" value="smoking"/>
					<label for="smoking">Smoking</label>
					<br />

					<p>Sort:</p>
					<label>Price:</label>
					<ul>
						<li>
							<input type="radio" name="sort" value="price-asc" />
							<label>Low to high</label>
						</li>
						<li>
							<input type="radio" name="sort" value="price-desc" />
							<label>High to low</label>
						</li>
						<li>
							<label for="price-min price-max">Range:</label>
							<input class="form-control input-sm input-small-num" type="text" name="price-min" id="price-min" />
							<label>to</label>
							<input class="form-control input-sm input-small-num" type="text" name="price-max" id="price-max" />
						</li>
					</ul>

					<button id="apply-filters" class="btn btn-primary">Apply Filters</button>
					<button id="clear-filters" class="btn btn-default">Clear Filters</button>
				</div>
			</div>


			<div class="col-md-9">
				<?php 
					if($_SESSION["admin"]) 
						echo '<form action="addroom.php"><button class="btn btn-primary">Add a room</button></form>';
				?>
				<div id="searchresults"></div>
				<div id="pagebuttons"></div>
			</div>

		</div>

		<?php
			include "partials/footer.php";
		?>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="js/search.js"></script>
	</body>

</html>
