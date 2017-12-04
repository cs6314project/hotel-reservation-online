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
			include "partials/notifications.php";
		?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center">Sign Up Form</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<form id="signUpForm" action="api/signUp.php" method="POST">
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="firstName">First Name</label>
								<input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" autofocus="true" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="lastName">Last Name</label>
								<input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="password">Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="confirmPassword">Confirm Password</label>
								<input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Password" required>
								<div class="info"></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12 col-md-3">
								<label for="phoneNumber">Phone Numner</label>
								<input type="tel" class="form-control" id="phoneNumber" name="phone_number" placeholder="Phone Number" required>
								<div class="info"></div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Sign Up</button>
					</form>
				</div>
			</div>
		</div>

		<?php
			include "partials/footer.php";
		?>
		<script src="js/signUpPage.js"></script>
	</body>
	<div class="cover"><div id="pageLoading"></div></div>
</html>
