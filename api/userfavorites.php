<?php 
    session_start();
    
    include "../partials/db_connect.php";
    openDatabaseConnection();
    $roomQuery = "SELECT * FROM Room ";
    if(isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
    }

    $result = mysqli_query($link, $roomQuery);
    $rooms = array();
	while($row = mysqli_fetch_assoc($result)) {          
        $id = $row['id'];
        $photo = array_diff(scandir("../img/room$id"), array(".", "..", ".DS_Store"));
        $isFavorite = false;
        $favoritesQuery = "SELECT * FROM wishlist WHERE email = '$email' AND roomid = $id";
        $favResult = mysqli_query($link, $favoritesQuery);
        $isFavorite = mysqli_num_rows($favResult)>=1;
        $row['favorite'] = $isFavorite;
        if($isFavorite) {
            $featureQuery = "SELECT feature FROM roomfeatures WHERE roomid = $id;";
            $featureResult = mysqli_query($link, $featureQuery);
            $features = array();
            while($feature = mysqli_fetch_row($featureResult)) {
                $features[] = $feature[0];
            }
            $row['features'] = $features;
            $row['photo'] = $photo[2];
            $rooms[] = $row;
        }
    }
    echo json_encode($rooms);
    closeDatabaseConnection();
?>
