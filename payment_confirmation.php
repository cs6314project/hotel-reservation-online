<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$page_title = "Payment Confirmation";
			include "partials/header.php";
		?>
	</head>
	<body>
        <?php
            function sqldate($date) {
                $arr = explode('/', $date);
                $result = $arr[2].'-'.$arr[0].'-'.$arr[1];
                return $result;
            }

			$header_active_link = "";
            include "partials/navbar.php";
            include "partials/db_connect.php";
            openDatabaseConnection();
            $email = $_SESSION["email"];
            $checkin = sqldate($_POST["checkin"]);
            $checkout = sqldate($_POST["checkout"]);
            $roomid = $_POST["roomid"];
            $cost = $_POST["cost"];
            $query = "INSERT INTO reservation (roomid, useremail, checkin, checkout, timeplaced, cost) VALUES (";
            $query .= "$roomid, '$email', '$checkin', '$checkout', now(), $cost);";
            //echo $query;
            $success = mysqli_query($link, $query);

            closeDatabaseConnection();
		?>
        
        <div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <?php if($success) { ?>
                        <img class="img-responsive pull-right" src="img/tick.png">
                        <h3 class="panel-title display-td" >Congratulations!</h3>
                        <?php } else {?>
                            <h3>Something went wrong.</h3>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <?php if($success) { ?>
                                <label for="cardNumber">Your payment has been made successfully.</label>
                                <?php } ?>
                            </div>
                            <a class="btn btn-success btn-lg btn-block" href="index.php">Return to the homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
		<?php
			include "partials/footer.php";
		?>
	</body>
</html>