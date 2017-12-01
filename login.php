<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Login";
			include "partials/header.php";
		?>
	</head>
	<body>
		<?php
			$header_active_link = "";
			include "partials/navbar.php";
		?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center">Login Form</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<form id="loginForm" action="loginProcessing.php" method="POST">
						<div class="row">
							<div class="col-xs-3">
								<label for="name">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-3">
								<label for="password">Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
							</div>
						</div>
						<br>
						<button type="submit" class="btn btn-primary">Login</button>
					</form>
				</div>
			</div>
		</div>		

		<?php
			include "partials/footer.php";
		?>
	</body>
</html>
