<?php
	include "config.php";
?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?=$page_title ?></title>

	<?php
		if(strcmp($runtime_environment, "dev") == 0) {
	?>
	<!-- Development Environment Bootstrap CSS -->
	<link rel="stylesheet" href="./css/bootstrap.css">
	<link rel="stylesheet" href="./css/bootstrap-theme.css">

	<?php
		} else {
	?>
	<!-- Production Environment Bootstrap CSS -->
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/bootstrap-theme.min.css">

	<?php
		}
	?>

	<link rel="stylesheet" href="./css/app.css">
