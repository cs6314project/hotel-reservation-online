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
			$header_active_link = "";
			include "partials/navbar.php";
		?>
        
        <div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <img class="img-responsive pull-right" src="img/tick.png">
                        <h3 class="panel-title display-td" >Congratulations!</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="cardNumber">Your payment has been made successfully.</label>
                            </div>
                            <button class="btn btn-success btn-lg btn-block" type="submit">Return to the homepage</button>
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