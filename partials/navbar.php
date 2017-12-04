<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#roomNavbar"
				aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Hotel Reservation<span class="sr-only">(current)</span>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="roomNavbar">
			
			<ul class="nav navbar-nav">
				
			</ul>
			<ul class="nav navbar-nav navbar-right">

				<?php if (!isset($_SESSION['email'])) { ?>

				<li class="<?=(strcmp($header_active_link, 'login') == 0) ? 'active' : ''?>">
					<a href="login.php">Login</a>
				</li>
				<li class="<?=(strcmp($header_active_link, 'cart') == 0) ? 'active' : ''?>">
					<a href="signup.php">SignUp</a>
				</li>

				<?php } else { ?>
					
				<li>
					<a>What's Up, <?=$_SESSION["first_name"]?></a>
				</li>
				
				<li class="dropdown">
				

					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="favorites.php">My Favourties</a>
						</li>
						<li>
							<a href="orderhistory.php">My purchase history</a>
						</li>
						<li role="separator" class="divider"></li>
						<li>
							<a href="#" onclick="app.logout();">Logout</a>
						</li>
					</ul>

				</li>
				<?php } ?>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>
