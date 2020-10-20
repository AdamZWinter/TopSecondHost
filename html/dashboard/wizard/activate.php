<?php
//dashboar wizard activate.php

require('/var/www/html/dashboard/authorizePost.php');  //session, conf, db, obj, email, and datetime is included here already.  Also checks authorization and exits if not
require('/var/www/gcbookings/refreshNotification.php');

if(refreshNotification::mainFunction($email)){
    $active='yes';                                                                 
    $query = 'UPDATE calendars SET active = ? WHERE email = ?';
    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $active, $email);
    $stmt->execute();
    echo 'true';
}else{
    error_log('refreshNotification::mainFunction failed at activation wizard');
    echo 'false';
}


?>

