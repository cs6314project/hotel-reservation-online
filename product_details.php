<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
			$page_title = "Product Details";
			include "partials/header.php";
		?>
        <link rel='stylesheet' href='css/datepicker.css' />
        </script>
</head>

<body>
    <?php
			$header_active_link = "about";
			include "partials/navbar.php";
			include "partials/db_connect.php";
			openDatabaseConnection();
			$id = $_GET["roomid"];
			if(!$id) {
				header("Location: index.php");
			}
			$query = "SELECT * FROM room WHERE id=$id";
			$result = mysqli_query($link, $query);
			
			$row = mysqli_fetch_assoc($result);
			$features = array();
			
			$featurequery = "SELECT * FROM roomfeatures WHERE roomid=$id";
			$featureresult = mysqli_query($link, $featurequery);
			while($frow = mysqli_fetch_assoc($featureresult)) {
					$features[] = $frow["feature"];
			}
			closeDatabaseConnection();
		?>
        <h1>
            <?=$row["name"] ?>
        </h1>

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src='img/hotel4.jpg'>
                    <div class="carousel-caption">
                        Outdoor Pool View
                    </div>
                </div>
                <div class="item">
                    <img src='img/hotel5.jpg'>
                    <div class="carousel-caption">
                        Estrella Bedrooms
                    </div>
                </div>
                <div class="item">
                    <img src='img/hotel6.jpg'>
                    <div class="carousel-caption">
                        Underwater Rooms
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class='details'>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a>
                </li>
                <li role="presentation">
                    <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Location</a>
                </li>
                <li role="presentation">
                    <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Amenities</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <?php echo $row["description"]; ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="messages">
                    Location details such as address, nearby places, etc.
                </div>
                <div role="tabpanel" class="tab-pane" id="settings">
                    <ul>
                        <?php 
						foreach($features as $feature) {
							echo "<li>$feature</li>";
						}
						?>
                    </ul>
                </div>
            </div>
        </div>
        <div class='bookings'>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <div class="panel panel-default credit-card-box">
                            <div class="panel-heading display-table">
                                <div class="row display-tr">
                                    <?php echo '<h2 class="panel-title display-td">$'.$row["price"].'/night</h2>'?>
                                    <div class="display-td">
                                        <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form role="form" id="payment-form" method='post' action='payment_details.php'>
                                    <input type="hidden" name="roomid" value="<?php echo $id; ?>" />
                                    <input type="hidden" name="cost" id="cost" value="0" />
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label for="cardNumber">CHECK IN</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="checkin" name="checkin" required />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-credit-card"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label for="cardNumber">CHECK OUT</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="checkout" name="checkout" required />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-credit-card"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label for="numbguest">NUMBER OF GUESTS</label>

                                                <select id='numoccupants' class="form-control input-small-num" required>
                                                    <?php
														$num = $row["maxoccupants"];
														for($i = 1; $i <= $num; $i++) {
															echo '<option value = "'.$i.'">'.$i.'</option>';
														}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12" id='display'>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button id="paymentbtn" class="btn btn-success btn-lg btn-block" onclick="getData()" type="submit">Continue to payment</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
			include "partials/footer.php";
		?>
            <script src='js/moment.js'></script>
            <script src='js/bootstrap-datepicker.js'></script>
            <script>
                function findGetParameter(parameterName) {
                    var result = null,
                        tmp = [];
                    location.search
                        .substr(1)
                        .split("&")
                        .forEach(function (item) {
                            tmp = item.split("=");
                            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                        });
                    return result;
                }

                var roomid = findGetParameter("roomid");
                //alert(roomid);

                function sqlDateFormat(date) {
                    if (date) {
                        var arr = date.split("/");
                        return arr[2] + "-" + arr[0] + "-" + arr[1];
                    }
                }

                function updateDisplay(start, end) {
                    if ($("#checkin").val() && $("#checkout").val()) {
                        var days = end.diff(start, "days");
                        //alert(days);
                        if (days <= 0) {
                            $("#display").html("<p>Checkin cannot be before checkout");
                            $('#paymentbtn').prop('disabled', true);
                        } else {
                            start = $("#checkin").val();
                            end = $("#checkout").val();
                            var data = {
                                "start": sqlDateFormat(start),
                                "end": sqlDateFormat(end)
                            };

                            $.getJSON("api/rooms.php", data, function (result) {
                                var roomsphp = result.rooms;
                                var available = false;
                                $.each(roomsphp, function () {
                                    //alert(this.id)
                                    if (this.id == roomid)
                                        available = true;
                                })
                                if (!available) {
                                    $("#display").html("<p>Room is not available for those dates</p>");
                                    $('#paymentbtn').prop('disabled', true);
                                } else {
                                    var totalcost = <?php echo $row["price"]; ?> * days;
                                    $("#cost").val(totalcost);
                                    $("#display").html('<p>Number of days: ' + days + '</p><p>Total cost: $' +
                                        totalcost + '</p>');
                                    $('#paymentbtn').prop('disabled', false);
                                }
                            });
                        }
                    }
                }

                $(document).ready(function () {
                    $("#checkin").val(findGetParameter("checkin"));
                    $("#checkout").val(findGetParameter("checkout"));
                    $("#availability").val(findGetParameter("numoccupants"));
                });

                //for number of days calculation
                $('#checkin').datepicker({
                    autoclose: true
                }).on("changeDate", function (e) {
                    var checkin = $("#checkin").val();
                    var checkoutDate = moment(checkin);
                    checkoutDate = checkoutDate.add(1, "days").format("MM/D/YYYY");
                    var start = moment(checkin);
                    var end = moment(checkoutDate);
                    $('#checkout').datepicker('setStartDate', checkoutDate).datepicker('update', checkoutDate).datepicker(
                        'show');
                    updateDisplay(start, end);
                });

                $('#checkout').datepicker({
                    autoclose: true
                }).on("changeDate", function (e) {
                    var checkin = $("#checkin").val();
                    var checkout = $("#checkout").val();
                    var start = moment(checkin);
                    var end = moment(checkout);
                    updateDisplay(start, end);
                });
            </script>
</body>

</html>