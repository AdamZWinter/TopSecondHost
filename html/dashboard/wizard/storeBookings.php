<?php
//dashboard/wizard/storeBookings.php

require('/var/www/html/dashboard/authorizePost.php');

if(!($bookings=@$_POST["bookings"])){
    echo '<p>No Calendar ID was entered.</p>';
    $obj->error = $obj->error.'No Calendar ID.';
    echo json_encode($obj);
    exit;
}else {
    $bookings=$_POST["bookings"];
    $query = "UPDATE calendars SET bookings = ?  WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $bookings, $email);
        $stmt->execute();
        if($db ->affected_rows == 1){
                                require('/var/www/gcbookings/common/openChannel.php');
                                if(openChannel::mainFunction($obj, $db, $email, $bookings)){
                                    echo 'Updated';
                                }else{echo 'Failed to open notification channel with Google.';error_log(json_encode($obj), 3, $logFile);}
        }else{
        echo 'Updated';
        exit;
        }
}

?>
