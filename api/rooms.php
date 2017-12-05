<?php 
    session_start();
    $admin = false;
    if(isset($_SESSION["is_admin"])) {
        $admin = $_SESSION["is_admin"];
    }

    $start = $_GET["start"];
    $end = $_GET["end"];
    $occ = $_GET["maxoccupants"];
    
    include "../partials/db_connect.php";
    openDatabaseConnection();
    $roomQuery = "SELECT * FROM Room ";
    $queryadditions = " WHERE ";
    $added = false;
    
    if(isset($start) && isset($end) && $start != null && $end != null) {
        if($start > $end) {
            echo '{"isadmin": false, "rooms": []}';
            exit();
        }
        $overlaps = " ('$start' BETWEEN checkin AND checkout) OR ('$end' BETWEEN checkin AND checkout) ";
        $encloses = " ('$start' < checkin AND '$end' > checkout)";
        $queryadditions .= " (SELECT COUNT(1) FROM reservation WHERE roomid = id AND (" . $overlaps . " OR " . $encloses . ")) = 0 ";
        $added = true;
    }
    elseif(isset($start) && $start != null) {
        if($added) $queryadditions .= " AND ";
        $queryadditions .= " (SELECT COUNT(1) FROM reservation WHERE roomid = id AND ('$start' BETWEEN checkin AND checkout)) = 0 ";
        $added = true;
    }
    elseif(isset($end) && $end != null) {
        if($added) $queryadditions .= " AND ";
        $queryadditions .= " (SELECT COUNT(1) FROM reservation WHERE roomid = id AND ('$end' BETWEEN checkin AND checkout)) = 0 ";
        $added = true;
    }
    if(isset($occ) && $occ != null) {
        if($added) $queryadditions .= " AND ";
        $queryadditions .= " maxoccupants >= $occ";
        $added = true;
    }

    if($added) $roomQuery .= $queryadditions;
    $roomQuery .= " ORDER BY price ASC";
    //echo $roomQuery;
    
    $result = mysqli_query($link, $roomQuery);
    $rooms = array();
	while($row = mysqli_fetch_assoc($result)) {
        //*            
        $id = $row['id'];
        $photo = array_diff(scandir("../img/room$id"), array(".", "..", ".DS_Store"));
        $featureQuery = "SELECT feature FROM roomfeatures WHERE roomid = $id;";
        $featureResult = mysqli_query($link, $featureQuery);
        $features = array();
        while($feature = mysqli_fetch_row($featureResult)) {
            $features[] = $feature[0];
        }
        if(isset($_SESSION["email"])) {
            $email = $_SESSION["email"];
            $favoritesQuery = "SELECT * FROM wishlist WHERE email = '$email' AND roomid = $id";
            $favResult = mysqli_query($link, $favoritesQuery);
            $row['favorite'] = (mysqli_num_rows($favResult)>=1);
        }
        $row['features'] = $features;
        $row['photo'] = $photo[2];
        $rooms[] = $row;
        //*/
    }
    $return = array("rooms" => $rooms, "isadmin" => $admin);
    echo json_encode($return);
    closeDatabaseConnection();
?>
