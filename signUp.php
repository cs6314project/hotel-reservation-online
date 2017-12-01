<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Sign Up";
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
					<h2 class="text-center">Sign Up Form</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<form id="loginForm" action="signUpProcessing.php" method="POST">
						<div class="row">
							<div class="col-xs-3">
								<label for="firstName">First Name</label>
								<input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-3">
								<label for="lastName">Last Name</label>
								<input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-3">
								<label for="email">Email</label>
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
						<div class="row">
							<div class="col-xs-3">
								<label for="phoneNumber">Phone Numner</label>
								<input type="tel" class="form-control" id="phoneNumber" name="phone_number" placeholder="Password">
							</div>
						</div>
						<br>
						<button type="submit" class="btn btn-primary">Sign Up</button>
					</form>
				</div>
			</div>
		</div>

		<?php
			include "partials/footer.php";
		?>
	</body>
</html>
