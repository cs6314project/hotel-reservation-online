<?php
	session_start();

	if (isset($_SESSION['email'])) {

		include "../partials/db_connect.php";
		include "../partials/functions.php";

		$roomid = $_POST["roomid"];
		$email = $_SESSION['email'];
		
		// Need to check if room_id is in the wishlist table for the Email id in the session
		// IF it is not then add it
			// Send response code of addtion
		// IF it is there then remove it
			// Send response code of removal

		// Response Codes

		// 0 - Could not add to wish list

		// 1 - Added to wish list

		// 2 - removed from wishlist

		// is in wishlist

		// add to wishlist

		// remove from wishlist

		$response = array();

		openDatabaseConnection();

		// if($roomid == null) {
		// 	// Get all wishlist items for the current user
		// 	$sql_wishlist = "SELECT roomid FROM wishlist WHERE email='".$email."'";
		// 	$result_wishlist = mysqli_query($link, $sql_wishlist);

		// 	if($result_wishlist->num_rows > 0) {

		// 		$sql_get_room_details = "SELECT * FROM room WHERE id IN (";
		// 		$sql_get_room_features = "SELECT feature FROM roomfeatures WHERE";
		// 		$counter = 1;

		// 		while ($row_wishlist = mysqli_fetch_assoc($result_wishlist)) {
		// 			if($counter < $result_wishlist->num_rows) {
		// 				$sql_get_room_details .= $row_wishlist["roomid"].",";
		// 			} else {
		// 				$sql_get_room_details .= $row_wishlist["roomid"].")";
		// 			}

		// 			$counter++;
		// 		}
		// 		echo $sql_get_room_details;
		// 		// Fetch Room_details for the current user

		// 		$result_room_details = mysqli_query($link, $sql_get_room_details);

		// 		while($row_room_details = mysqli_fetch_assoc($result_room_details)) {

		// 			$sql_get_room_features;
		// 		}
		// 	}
		// }
		if($roomid) {
			// Add or Remove Wishlist item

			$sql_wishlist = "SELECT * FROM wishlist WHERE email='".$email."' AND roomid='".$roomid."'";
			
			$result_wishlist = mysqli_query($link, $sql_wishlist);
			
			if($result_wishlist->num_rows > 0) {
				// The item is in the wishlist
				// Remove it
				$sql_remove_wish = "DELETE FROM wishlist WHERE email='".$email."' AND roomid='".$roomid."'";
				$result_remove_wish = mysqli_query($link, $sql_remove_wish);
	
				if ($result_remove_wish) {
					$response = createResponse(1, "Wishlist Item Deleted Successfully");
				} else {
					$response = createResponse(0, "Wishlist Item could not be Deleted");
				}
			} else {
				// The item is not in the wishlist
				// Add it
				$sql_add_wish = "INSERT INTO wishlist(email, roomid) VALUES('$email', $roomid)";
				$result_add_wish = mysqli_query($link, $sql_add_wish);
	
				if ($result_add_wish) {
					$response = createResponse(3, "Wishlist Item Added Successfully");
				} else {
					$response = createResponse(2, "Wishlist Item could not be Added");
				}
			}
		}

		closeDatabaseConnection();

		echo json_encode($response);
	}
?>
